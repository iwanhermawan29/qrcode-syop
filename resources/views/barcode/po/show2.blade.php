{{-- resources/views/po/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Order #{{ $po->nomor_po }}</title>

    <!-- Bootstrap CSS (no SRI to avoid integrity mismatch) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: url("{{ asset('images/bg.png') }}") no-repeat center center fixed;
            background-size: cover;
            background-color: #f8f9fa;
        }

        .po-wrapper {
            border: 2px solid #FF9900;
            border-radius: .5rem;
            padding: 1rem;
            background: #fff;
        }

        .po-header h2 {
            /* color: #FF9900; */
            font-weight: bold
        }

        .bg-orange thead th {
            background-color: #FF9900 !important;
            color: #fff;
        }

        .text-orange {
            color: #FF9900 !important;
        }

        @media (max-width: 576px) {
            .po-wrapper {
                padding: .5rem;
            }

            .po-header h2 {
                font-size: 1.25rem;
            }

            .table th,
            .table td {
                padding: .25rem .5rem;
                font-size: .75rem;
            }
        }
    </style>
</head>

<body>

    {{-- Toast “Data verified” --}}
    @if (session('status'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index:1200">
            <div id="verifiedToast" class="toast align-items-center text-white border-0" role="alert"
                aria-live="assertive" aria-atomic="true" style="background-color: #15e877">
                {{-- aria-live="assertive" aria-atomic="true" style="background-color: #FF9900;"> --}}
                <div class="d-flex align-items-center">
                    <!-- Ikon centang -->

                    <!-- Pesan toast -->
                    <div class="toast-body flex">
                  
                             <span class="d-flex align-items-center"><i class="bi bi-check-circle-fill fs-4 me-2"></i> {{ session('status') }}</span>
                       
                    </div>


                    <!-- Tombol close -->
                    <button type="button" class="btn-close btn-close-white ms-auto me-2" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid py-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="po-wrapper mx-auto position-relative">

               <div class="position-absolute top-50 start-50 text-uppercase fw-bold"
                    style=" font-size: clamp(4rem, 20vw, 9rem); pointer-events: none; z-index: 0;
                            transform: translate(-50%, -50%) rotate(-25deg);
                            color: rgba(84, 84, 84, 0.1); 
                            ">
                    VERIFIED
                </div>



                    {{-- Header --}}
                    <div class="row align-items-center po-header">
                        <div class="col-12 col-md-6 d-flex align-items-center">
                            <img src="{{ asset('images/Logo.png') }}" alt="Logo" height="60">
                            <div class="ms-3">
                                <h5 class="mb-0">ProEnergi</h5>
                                <small class="text-muted">
                                    Gedung Graha Irama, Lt.6 Unit G, Jl. HR. Rasuna Said Blok X1<br>
                                    P: (021) 52892321 &nbsp; F: (021) 52892310<br>
                                    W: <a href="https://proenergi.com">proenergi.com</a>
                                </small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 text-md-end mt-3 mt-md-0">
                            <h2 class="mb-1">PURCHASE ORDER</h2>
                            <p class="mb-0">
                                <strong>PO Date :</strong>
                                {{ \Carbon\Carbon::parse($po->tanggal_inven)->format('d F Y') }}
                            </p>
                            <p class="mb-0">
                                <strong>PO Number :</strong> {{ $po->nomor_po }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-2">

                    {{-- Vendor & Ship To --}}
                    <div class="row mb-4">
                        <div class="col-12 col-md-6">
                            <h6 class="text-orange text-uppercase mb-2">ProEnergi (Ship To)</h6>
                            <p class="mb-1"><strong>Graha Irama Building Lt.6 Unit G</strong></p>
                            <p class="small mb-0">
                                Jl. HR. Rasuna Said Blok X1, Kuningan Timur,<br>
                                Jakarta Selatan
                            </p>
                        </div>
                        <div class="col-12 col-md-6 mt-3 mt-md-0">
                            <h6 class="text-orange text-uppercase mb-2">Vendor</h6>
                            <p class="mb-1"><strong>{{ $po->nama_vendor }}</strong></p>
                            <p class="small mb-0">
                                {{ $po->nama_vendor ?? '-' }}<br>

                            </p>
                        </div>
                    </div>

                    {{-- Items Table --}}
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-striped mb-0">
                            <thead class="bg-orange text-center">
                                <tr>
                                    <th style="width: 5%;">No.</th>
                                    <th style="width: 5%;">Item</th>
                                    <th>Description</th>
                                    <th style="width: 5%;">Qty (L)</th>
                                    <th style="width: 5%;">Tax </th>
                                    <th style="width: 15%;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center" style="width: 5%;">1</td>
                                    <td align="center" style="width: 2%;">{{ $po->jenis_produk }}</td>
                                    <td align="center" style="width: 5%;">{{ $po->merk_dagang }}</td>
                                    <td align="center" style="width: 5%;">
                                        {{ number_format($po->volume_po, 0, ',', '.') }}</td>
                                    <td align="center" style="width: 5%;">{{ $po->kd_tax }}</td>
                                    <td align="right" style="width: 15%;">
                                        IDR {{ number_format($po->volume_po * $harga_dasar, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @if($po->kategori_oa == 2)
                                    
                                <tr>
                                    <td align="center" style="width: 5%;">2</td>
                                    <td align="center" style="width: 2%;">Ongkos Angkut</td>
                                    <td align="center" style="width: 5%;">{{ $po->merk_dagang }}</td>
                                    <td align="center" style="width: 5%;">
                                        {{ number_format($po->volume_po, 0, ',', '.') }}</td>
                                    <td align="center" style="width: 5%;">{{ $po->kd_tax }}</td>
                                    <td align="right" style="width: 15%;">
                                        IDR {{ number_format($po->volume_po * $po->ongkos_angkut, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                                @if($po->iuran_migas == 1)
                                <tr>
                                    <td align="center" style="width: 5%;">3</td>
                                    <td align="center" style="width: 2%;">Iuran Migas</td>
                                    <td align="center" style="width: 5%;">{{ $po->merk_dagang }}</td>
                                    <td align="center" style="width: 5%;">
                                        {{ number_format($po->volume_po, 0, ',', '.') }}</td>
                                    <td align="center" style="width: 5%;">{{ $po->kd_tax }}</td>
                                    <td align="right" style="width: 15%;">
                                        IDR {{ number_format($po->volume_po * $po->iuran_migas, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Ringkasan Harga --}}
                    <div class="row mb-3">
                        <!-- kolom kiri kosong, mengambil 8/12 lebar -->
                        <div class="col-12 col-md-8"></div>

                        <!-- kolom kanan 4/12, summary table akan di sini -->
                        <div class="col-12 col-md-4">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th class="text-muted">Subtotal</th>
                                        <td class="text-end">
                                            Rp {{ number_format($po->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">DPP Nilai Lain</th>
                                        <td class="text-end">
                                            {{-- Rp {{ number_format(($po->dpp_11_12), 0, ',', '.') }} --}}
                                            Rp {{ number_format((($po->subtotal*11)/12), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">PPN</th>
                                        <td class="text-end">
                                            Rp {{ number_format($po->ppn_11, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">PPH 22</th>
                                        <td class="text-end">
                                            Rp {{ number_format($po->pph_22, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">PBBKB</th>
                                        <td class="text-end">
                                            Rp {{ number_format($po->pbbkb, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr class="bg-orange text-white">
                                        <th>Total Order</th>
                                        <td class="text-end">
                                            Rp {{ number_format($po->total_order, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- Notes --}}
                    @if (!empty($po->keterangan))
                        <div class="mt-3">
                            <h6 class="text-orange">Note:</h6>
                            <p class="small mb-0">{{ $po->keterangan }}</p>
                        </div>
                    @endif

                    {{-- Footer --}}
                    <div class="text-center text-muted small mt-4">
                        If you have any questions about this purchase order, please contact:<br>
                        customer.service@proenergi.com | (021) 5289 2321
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (no SRI) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Initialize Toast --}}
    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.getElementById('verifiedToast');
                if (toastEl) {
                    new bootstrap.Toast(toastEl, {
                        delay: 3000
                    }).show();
                }
            });
        </script>
    @endif

</body>

</html>
