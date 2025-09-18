<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Surat Penawaran {{ $data->nama_customer }}</title>
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


<div class="max-w-3xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-lg">
        <!-- Verified Icon (pojok kanan atas) -->
        <div class="absolute top-4 right-4 bg-green-100 p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
            </svg>
        </div>
                <div class="flex justify-between items-center mb-6">
                <img src="{{ asset('images/logo-kiri-penawaran.png') }}" alt="Logo Kiri" class="w-28 sm:w-32">
                <img src="{{ asset('images/logo-kanan-penawaran.png') }}" alt="Logo Kanan" class="w-28 sm:w-32">
            </div>


            <div class="text-xs sm:text-sm text-gray-700 mb-4">
                <div class="flex justify-between">
                        <span>No. Ref <strong>{{ $data->nomor_surat }}</strong></span>
                        <span>{{ $data->nama_cabang }}, {{ \Carbon\Carbon::now()->format('d F Y') }}</span>
                    </div>
                </div>

               <div class="mb-6 text-xs sm:text-sm text-black">
                    <p >Kepada Yth:</p>
                    <p><strong>{{ $data->nama_customer }}</strong></p>
                    <p class="max-w-xs">{{ $data->alamat_up }}</p>
                    
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-1 text-xs sm:text-sm text-gray-900">
              
                    <!-- Kiri: UP & Jabatan -->
                    <div>
                        <p class="font-bold">UP. <u>{{ $data->gelar }} {{ $data->nama_up }}</u></p>
                        <p>{{ $data->jabatan_up }}</p>
                    </div>

                    <!-- Kanan: Telp & Fax -->
                    <div class="sm:text-right">
                        <p>Telp: {{ $data->telp_up }}</p>
                        <p>Fax: {{ $data->fax_up }}</p>
                    </div>
                </div>
                {{-- <div class="text-sm leading-relaxed text-gray-800 space-y-4">
                </div> --}}
                        <p class="text-justify text-xs sm:text-sm mt-5">Dengan Hormat, </p>
                        <p class="text-center text-xs sm:text-sm mt-5">Hal : Penawaran Harga {{ $data->merk_dagang }}</p>
                        <p class="text-justify text-xs sm:text-sm mt-5">Bersama surat ini, perkenankan kepada kami untuk memperkenalkan, bahwa kami dari PT. Pro Energi sebagai Badan Usaha Berbadan Hukum dan memiliki Izin Niaga BBM dari ESDM, yang bergerak di bidang Bahan Bakar Minyak.</p>
                        <p class="text-justify text-xs sm:text-sm mt-5 mb-5">Dengan pengalaman, jaminan produk, sumber daya, serta sarana, kami percaya mampu untuk memenuhi kebutuhan BBM untuk {{ $data->nama_customer }}.
                            Oleh karena itu, kami ingin menawarkan kepada perusahaan {{ $data->gelar }}:</p>

                    <div class="overflow-hidden rounded-lg border border-gray-500 p-3">
                        <table class="w-full text-xs sm:text-sm bg-white">
                            <tbody>
                                <tr>
                                    <td class=" w-4 text-center ">1.</td>
                                    <td class="pl-5 w-1/3 align-top">Produk</td>
                                    <td>: <strong>{{ $data->merk_dagang }}</strong></td>
                                </tr>
                                <tr >
                                    <td class=" text-right ">2. </td>
                                    <td class="pl-5 font-bold">Sulphur Content (Maks.) </td>
                                    <td>: <strong>0,25%</strong></td>
                                </tr>
                                <tr >
                                    <td class="text-right align-top">3. </td>
                                    <td class="pl-5 align-top">Harga per Liter </td>
                                    <td class="align-top">
                                        <div class="flex items-start">
                                            <span class="mr-1">:</span>
                                            <table class="w-full ">
                                                @foreach($rincian as $item)
                                                    @if(!empty($item['rinci']) && !empty($item['biaya']))
                                                        <tr>
                                                            <td class="min-w-[120px]">{{ $item['rincian'] }}</td>
                                                            <td class="w-16 text-right">
                                                                {{ $item['nilai'] ? $item['nilai'] . ' %' : '' }}
                                                            </td>
                                                            <td class="w-12 text-right">Rp.</td>
                                                            <td class="w-28 text-right">
                                                                {{ number_format($item['biaya'], 2, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            
                                                <tr class="font-bold border-t border-gray-300">
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td class="text-right">Rp.</td>
                                                    <td class="text-right">
                                                        {{ number_format(collect($rincian)->sum('biaya'), 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class=" text-right ">4. </td>
                                    <td class="pl-5">Metode Pembayaran</td>
                                    <td>: <strong>{{ $arrPayment[$data->jenis_payment] }}</strong></td>
                                </tr>
                                <tr>
                                    <td class=" text-right ">5. </td>
                                    <td class="pl-5">Metode Pemesanan</td>
                                    <td>: PO paling lambat <strong>{{ $data->method_order }} hari</strong> sebelum pengiriman</td>
                                </tr>
                                <tr>
                                    <td class=" text-right ">6. </td>
                                    <td class="pl-5">Metode Pengiriman</td>
                                    <td>: Produk akan dikirim setelah mendapatkan konfirmasi PO</div>
                                </tr>
                                <tr>
                                    <td class=" text-right ">7. </td>
                                    <td class="pl-5">Masa Berlaku Harga</td>
                                    <td>: <strong>  {{ \Carbon\Carbon::parse($data->masa_awal)->format('d-m-Y') . " s/d " . \Carbon\Carbon::parse($data->masa_akhir)->format('d-m-Y')}}</div></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-right">8. </td>
                                    <td class="pl-5">Toleransi</td>
                                    <td>: {{ $data->tol_susut }} % dari total jumlah pengiriman</div></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                 
                        <p class="text-justify mt-5 mb-5 text-xs sm:text-sm" >Demikian surat penawaran, kami berharap dapat diberikan kesempatan dan kepercayaan kepada kami untuk dapat berbisnis dengan perusahaan
                            {{ strtolower($data->gelar) }}. Atas perhatian dan kerjasamanya, kami ucapkan terimakasih.</p><br />

                          <div class="flex">
                            <div class="ml-auto w-max sm:w-1/2 text-xs sm:text-sm border border-black p-3">
                                <p>Kontak Person :</p>
                                <p class="pb-5"><strong>{{ $data->fullname }}</strong></p>
                                <p><strong><?php echo ($data->mobile_user ? $data->mobile_user : '&nbsp;'); ?></strong></p>
                                <p><strong>{{ ($data->email_user ? $data->email_user : '&nbsp;') }}</strong></p>
                            </div>
                        </div>
                        <footer class="mt-10">
                            {{-- <div style="margin:0 0 3px; text-align:right;margin-right:110px;"> --}}
                            
                                <!-- <div align="center" style="text-align:center; padding-top:50px;margin-left:-120px;"> -->
                                    <!-- Cetak satu QR per halaman, absolute centered -->
                                    {{-- <barcode
                                        code="$barcod"
                                        type="QR"
                                        size="1"
                                        height="1"
                                        class="qr-center" /> --}}
                                    <!-- </div> -->
                            {{-- </div> --}}
                            {{-- <p style="margin:0 0 5px; padding:0 15px 5px; text-align:right; font-size:9pt;"><i>(This form is valid with sign by computerized system)</i></p> --}}
                            <div class="mx-10 border-t border-black text-center text-xs sm:text-sm p-1">
                                <b>PT. Pro Energi, </b>
                                <span style="font-size:9pt;">&bull; Gedung Graha Irama Lantai 6 unit G, Jln. HR Rasuna Said Blok X1 Kav 1-2.<br />
                                    &bull; Telp. +021 5289 2321, &bull; fax +021 5289 2310 &bull; <span style="color:#0000FF;">www.proenergi.com </span></span>
                            </div>
                            {{-- <p style="margin:0; padding:5px 0 0; text-align:right; font-size:7pt;">Printed by {{ $printe }}</p> --}}
                        </footer>
                    </div>
     
    </div>
</body>

</html>
