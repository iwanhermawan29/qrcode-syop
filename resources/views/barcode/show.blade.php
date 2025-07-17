<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pengiriman #{{ $data->customer_address }}</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-center bg-no-repeat bg-contain sm:bg-cover p-4"
    style="background-image: url('{{ asset('images/background-1.jpeg') }}'); filter: brightness(1.10);">

    <!-- Prepare Nomor Segel -->
    @php
        $segAw = $data->nomor_segel_awal ? str_pad($data->nomor_segel_awal, 4, '0', STR_PAD_LEFT) : '';
        $segAk = $data->nomor_segel_akhir ? str_pad($data->nomor_segel_akhir, 4, '0', STR_PAD_LEFT) : '';
        if ($data->jumlah_segel == 1) {
            $nomorSegel = $data->pre_segel . '-' . $segAw;
        } elseif ($data->jumlah_segel == 2) {
            $nomorSegel = $data->pre_segel . '-' . $segAw . ' & ' . $data->pre_segel . '-' . $segAk;
        } elseif ($data->jumlah_segel > 2) {
            $nomorSegel = $data->pre_segel . '-' . $segAw . ' s/d ' . $data->pre_segel . '-' . $segAk;
        } else {
            $nomorSegel = '';
        }
    @endphp

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

    <!-- Card Container -->
    <div
        class="relative w-full max-w-md sm:max-w-lg bg-white bg-opacity-90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden mx-auto">
        <!-- Verified Icon (pojok kanan atas) -->
        <div class="absolute top-4 right-4 bg-green-100 p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
            </svg>
        </div>

        <!-- Header -->
        <div class="relative flex items-center bg-gradient-to-r from-orange-400 to-orange-600 p-4 sm:p-6">
            <!-- Logo -->
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-14 sm:h-14 mr-4 hidden sm:block">
            <!-- Centered Title -->
            <h4 class="absolute left-1/2 transform -translate-x-1/2 text-md sm:text-1xl font-bold text-primary">
                NO-SPJ : {{ $data->no_spj }}
            </h4>
        </div>

        <!-- Body -->
        <div class="p-4 sm:p-6 space-y-4 text-sm sm:text-base">
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <span class="font-medium text-gray-700">No Segel:</span>
                <span class="mt-1 sm:mt-0 text-gray-900 font-semibold">{{ $nomorSegel }} </span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <span class="font-medium text-gray-700">Nama Driver:</span>
                <span class="mt-1 sm:mt-0 text-gray-900 font-semibold">{{ $data->nama_sopir }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <span class="font-medium text-gray-700">Nama Customer:</span>
                <span class="mt-1 sm:mt-0 text-gray-900 font-semibold">{{ $data->customer_address }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <span class="font-medium text-gray-700">Alamat : </span>
                <span class="mt-1 sm:mt-0 text-gray-900 font-semibold">{{ $data->alamat_survey }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <span class="font-medium text-gray-700">Nopol:</span>
                <span class="mt-1 sm:mt-0 text-gray-900 font-semibold">{{ $data->nomor_plat }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <span class="font-medium text-gray-700">QTY:</span>
                <span class="mt-1 sm:mt-0 text-gray-900 font-semibold">{{ number_format($data->qty) }} Liter</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 bg-opacity-90 p-4 text-center text-xs sm:text-sm text-gray-600">
            <p class="font-semibold">PT Pro Energi</p>
            <p>Gedung Graha Irama, Lt. 6 unit G, Jl. HR. Rasuna Said Blok X1 </p>
            <p> Kav 1-2, Jakarta 12950 DKI Jakarta -
                Indonesia</p>
            <p>Telp: (021) 52892321 | info@proenergi.com</p>
        </div>
    </div>

</body>

</html>
