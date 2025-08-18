<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\AesHelper;

class BarcodeController extends Controller
{
    public function show(string $encrypted)
    {
        // 1) Dekripsi untuk dapatkan id_ds
        $idDs = AesHelper::paramDecrypt($encrypted);
        
        // 2) Query Builder: join tiga tabel sekaligus
        $data = DB::table('pro_po_ds as pod')
            ->leftJoin('pro_po_ds_detail as d', 'pod.id_ds', '=', 'd.id_ds')
            ->leftJoin('pro_po_detail as pd', 'd.id_pod',  '=', 'pd.id_pod')
            ->leftJoin('pro_master_transportir_sopir as ms', 'pd.sopir_po',  '=', 'ms.id_master')
            ->leftJoin('pro_master_transportir_mobil as mm', 'pd.mobil_po',  '=', 'mm.id_master')
            ->leftJoin('pro_po_customer_plan as cp', 'd.id_plan',  '=', 'cp.id_plan')
            ->leftJoin('pro_customer_lcr as cl', 'cp.id_lcr',  '=', 'cl.id_lcr')
            ->select([
                'pod.id_ds',
                'd.sold_to as customer_address',
                'pd.volume_po as qty',
                'ms.nama_sopir',
                'mm.nomor_plat',
                'd.nomor_segel_awal',
                'd.nomor_segel_akhir',
                'd.jumlah_segel',
                'd.pre_segel',
                'cl.alamat_survey',
                'pd.no_spj',

            ])
            ->where('d.id_dsd', $idDs)
            // kalau ada beberapa detail, ambil yang pertama saja:
            ->first();

        if (! $data) {
            abort(404);
        }

        // 3) Kirim object $data ke view
        return view('barcode.show', compact('data'));
    }


    public function showPo(string $encrypted)
    {

        session()->flash('status', 'Data verified');
        // // Dekripsi untuk dapatkan id_po_supplier
        $idPo = AesHelper::paramDecrypt($encrypted);

        // Query data PO Supplier
        $po = DB::table('new_pro_inventory_vendor_po as p')
            ->leftJoin('pro_master_vendor as s', 'p.id_vendor', '=', 's.id_master')
            ->leftJoin('pro_master_produk as t', 'p.id_produk', '=', 't.id_master')
            ->select([
                'p.nomor_po',
                's.nama_vendor',
                'p.tanggal_inven',
                'p.subtotal',
                'p.ppn_11',
                'p.pph_22',
                'p.pbbkb',
                'p.total_order',
                'p.keterangan',
                't.jenis_produk',
                't.merk_dagang',
                'p.volume_po',
                'p.harga_tebus',
                'p.kd_tax',


            ])
            ->where('p.id_master', $idPo)
            ->first();

        if (!$po) {
            abort(404, 'Data PO Supplier tidak ditemukan');
        }



        // 3) Kirim object $data ke view
        return view('barcode.po.show', compact('po'));
    }

    public function showPenawaran(string $encrypted)
    {

        $idPen = AesHelper::paramDecrypt($encrypted);
        $ids= explode(",",$idPen);
        
        session()->flash('status', $encrypted);
        // // Dekripsi untuk dapatkan id_po_supplier

        // Query data PO Supplier
        $data = DB::table('pro_penawaran as a')
            ->join('pro_customer as b', 'a.id_customer', '=', 'b.id_customer')
            ->join('acl_user as c', 'b.id_marketing', '=', 'c.id_user')
            ->join('pro_master_cabang as d', 'a.id_cabang', '=', 'd.id_master')
            ->join('pro_master_produk as e', 'a.produk_tawar', '=', 'e.id_master')
            ->join('pro_master_provinsi as f', 'b.prov_customer', '=', 'f.id_prov')
            ->join('pro_master_kabupaten as g', 'b.kab_customer', '=', 'g.id_kab')
            ->leftJoin('acl_user as h', 'a.pic_approval', '=', 'h.id_user')
            ->leftJoin('acl_role as i', 'h.id_role', '=', 'i.id_role')
            ->select([
            'a.*',
			'b.nama_customer',
			'b.alamat_customer',
			'b.telp_customer',
			'b.fax_customer',
			'c.fullname',
			'c.mobile_user',
			'c.email_user',
			'd.nama_cabang',
			'e.jenis_produk',
			'e.merk_dagang',
			'f.nama_prov',
			'g.nama_kab',
			'h.fullname as picname',
			'i.role_name',
			'd.kode_barcode',

            ])
            ->where([['a.id_customer', $ids[0]],['a.id_penawaran', $ids[1]]])
            ->first();
        
        $jenis_net	= $data->jenis_net;
        $rincian = json_decode($data->detail_rincian, true);
        $arrKondInd	= array(0 => '', 1 => "Setelah Invoice diterima", "Setelah pengiriman", "Setelah Loading");
        $arrPayment = array("CREDIT" => "CREDIT " . $data->jangka_waktu . " Hari " . $arrKondInd[$jenis_net], "CBD" => "CBD (Cash Before Delivery)", "COD" => "COD (Cash On Delivery)");
        $rincian = json_decode($data->detail_rincian, true);
        if ($data->perhitungan == 1) {
            $breakdown = false;
            foreach ($rincian as $temp) {
                $breakdown = $breakdown || $temp["rinci"];
            }
        }
        if (!$data) {
            abort(404, 'Data PO Supplier tidak ditemukan');
        }



        // 3) Kirim object $data ke view
        return view('barcode.show_penawaran', compact('data','arrPayment','breakdown','rincian'));
    }
}
