<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Surat Jalan</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

{{-- <body class="min-h-screen flex items-center justify-center bg-center bg-no-repeat bg-contain sm:bg-cover p-4"
    style="background-image: url('{{ asset('images/background-1.jpeg') }}'); filter: brightness(1.10);"> --}}

   <body class="bg-gray-200 p-4 sm:p-6">


    <!-- Verified Popup (muncul maksimal 5 kali) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let count = parseInt(localStorage.getItem('verifiedCount') || '0', 10);
            if (count < 100) {
                Swal.fire({
                    title: '<span class="text-2xl font-bold text-green-700">Data Verified</span>',
                    html: '',
                    icon: 'success',
                    iconColor: '#16a34a',
                    background: '#ecfdf5',
                    backdrop: 'rgba(16, 185, 129, 0.4)',
                    customClass: {
                        popup: 'rounded-xl shadow-2xl border-4 border-green-200',
                        confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg'
                    },
                    confirmButtonText: 'OK',
                }).then(() => {
                    localStorage.setItem('verifiedCount', count + 1);
                });
            }
        });
    </script>
    <div class="max-w-5xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-lg">
        <div class="w-full px-4">
            <!-- Header Gambar -->
            <div class="flex justify-between items-center mb-6">
                <img src="{{ asset('images/logo-kiri-penawaran.png') }}" alt="Logo Kiri" class="w-28 s1m:w-32">
                <img src="{{ asset('images/logo-kanan-penawaran.png') }}" alt="Logo Kanan" class="w-28 sm:w-32">
            </div>

            <!-- Judul -->
           <div class="text-center font-bold text-xl mb-4 bg-green-200 rounded-lg h-[60px] flex items-center justify-center">
                SURAT JALAN / TANDA TERIMA
            </div>
            <!-- Konten -->
            <div class="text-[14px] space-y-8">
                <?php
                $tempal = str_replace(["KABUPATEN ", "KOTA "], "", $data->nama_kab);
                $alamat = $data->alamat_survey . " " . $tempal . " " . $data->nama_prov;
                $picust = json_decode($data->picustomer, true);
                ?>

                <!-- NO SPJ / LO / DO -->
                <div class="text-center space-y-1">
                    <h4 class="font-bold underline text-lg">NO : {{ $data->no_spj }}</h4>
                    <h4 class="font-bold underline text-lg">NO LO : {{ $data->nomor_lo_pr }}</h4>
                    <h4 class="font-bold underline text-lg">
                        NO DO : {{ $data->no_do_acurate ? $data->no_do_acurate : '-' }}
                    </h4>
                </div>

                <!-- Info Mobil -->
                <div class="mt-6">
                    <table class="w-full">
                        <tr>
                            <td class="w-[40%]">No. Polisi</td>
                            <td class="w-[2%]">:</td>
                            <td>{{ $data->nomor_plat }}</td>
                        </tr>
                        <tr>
                            <td class="w-[40%]">Nama Pengemudi</td>
                            <td class="w-[2%]">:</td>
                            <td>{{$data->nama_sopir}} </td>
                        </tr>
                    </table>
                </div>

                <!-- Data Tujuan -->
                <div class="mt-6">
                    <span class="font-bold block mb-2">Data Tujuan Pengiriman Barang</span>
                    <table class="w-full">
                        <tr>
                            <td class="w-[40%]">Nama</td>
                            <td class="w-[2%]">:</td>
                            <td>{{$data->nama_customer}} </td>
                        </tr>
                        <tr>
                            <td valign="w-[40%]">Alamat</td>
                            <td valign="w-[2%]">:</td>
                            <td>{{$alamat}} </td>
                        </tr>
                        <tr>
                            <td valign="w-[40%]">PIC</td>
                            <td valign="w-[2%]">:</td>
                            <td>
                                @if (count($picust) > 0) 
                                    @foreach($picust as $row)
                                        {{$row['nama'] . ' - ' . html_entity_decode($row['telepon'])}}<br>
                                    @endforeach
                                @else
                                    &nbsp;
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Spesifikasi BBM -->
                <div class="mt-6">
                    <span class="font-bold block mb-2">Spesifikasi BBM</span>
                    <table class="w-full">
                        <tr>
                            <td class="w-[40%]">Jenis</td>
                            <td class="w-[2%]">:</td>
                            <td>{{$data->produk}} </td>
                        </tr>
                        <tr>
                            <td>Volume</td>
                            <td>:</td>
                            <td>{{number_format($data->volume_po, 0, '', '.')}}  Liter</td>
                        </tr>
                        <tr>
                            <td>Terbilang</td>
                            <td>:</td>
                            {{-- <td>{{terbilang($data->volume_po)}} Liter</td> --}}
                        </tr>
                    </table>
                </div>

                <hr class="my-8 border-gray-400">
            </div>
        </div>
    </div>
  

</body>

</html>
