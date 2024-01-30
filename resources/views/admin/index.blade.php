@extends('admin/temp_admin')
@section('judul', 'Admin Dashboard')
@section('side_dash', 'active')


@section('tambah_css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection


@section('index_head')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Pegawai</h5>
                            <span class="h2 font-weight-bold mb-0">
                                <?php
                                $wid1 = DB::select('SELECT
                                                                                                                                                                                                  COUNT(id_pegawai) as jumlah_pegawai
                                                                                                                                                                                                  FROM data_pegawai');
                                echo $wid1[0]->jumlah_pegawai;
                                ?>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-single-02"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Jumlah OPD</h5>
                            <span class="h2 font-weight-bold mb-0">
                                <?php
                                $wid2 = DB::select('SELECT
                                                                                                                                                                                                  COUNT(id_opd) as jum_opd
                                                                                                                                                                                                  FROM data_opd');
                                echo $wid2[0]->jum_opd;
                                ?>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-badge"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Data Revisi</h5>
                            <span class="h2 font-weight-bold mb-0">
                                <?php
                                $wid3 = DB::table('rekon_id')
                                    ->where('status_rev', '=', '3')
                                    ->count();
                                echo $wid3;
                                ?>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-single-copy-04"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Data Valid</h5>
                            <span class="h2 font-weight-bold mb-0">
                                <?php
                                $wid4 = DB::table('rekon_id')
                                    ->where('status_rev', '=', '2')
                                    ->count();
                                echo $wid4;
                                ?>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-email-83"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('isi')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    @php
                        $nama = auth()->user()->name;
                        
                        function b_indo($tanggal3)
                        {
                            $bulan3 = [1 => 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari'];
                            $split = explode('-', $tanggal3);
                            return $bulan3[(int) $split[1]] . ' ' . $split[0];
                        }
                        $ini3 = date('Y-m-d');
                    @endphp

                    <h3 class="mb-0">Daftar Rekon OPD bulan {{ b_indo($ini3) }}</h3>

                </div>
                <div class="table-responsive py-4">
                    @php
                        $opd = DB::table('data_opd')->get();
                    @endphp
                    <table class="table table-flush" id="datatable33">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>OPD</th>
                                <th class="text-center" style="width: 20%">Status Rekon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                function bul($x)
                                {
                                    $bula = [1 => 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari'];
                                    $split = explode('-', $x);
                                    return $bula[(int) $split[1]];
                                }
                                
                                function tah($x)
                                {
                                    $bulan3 = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    $split = explode('-', $x);
                                    return $split[0];
                                }
                            @endphp
                            @foreach ($opd as $opd)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $opd->nama_opd }}</td>
                                    <td class="text-center">
                                        @php
                                            
                                            $ini4 = date('Y-m-d');
                                            $bul = bul($ini4);
                                            $tah = tah($ini4);
                                            // dd($tah, $bul);
                                            $stat = DB::table('rekon_id')
                                                ->where('kode_opd', $opd->id_opd)
                                                ->where('status_rev', '=', '2')
                                                ->where('tahun', $tah)
                                                ->where('bulan', $bul)
                                                ->count();
                                        @endphp

                                        @if ($stat == 1)
                                            <i class="fa fa-check btn btn-success btn-sm"></i>
                                        @else
                                            <i class="fa fa-times btn btn-danger btn-sm"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="row">
                

                <div class="col-12">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Batas Rekon</h5>
                                    <span class="h3 font-weight-bold mb-0">
                                        @php
                                            function bulan_indo($tanggal2)
                                            {
                                                $bulan2 = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                $split = explode('-', $tanggal2);
                                                return $bulan2[(int) $split[1]] . ' ' . $split[0];
                                            }
                                            $ini2 = date('Y-m-d');
                                        @endphp

                                        24 {{ bulan_indo($ini2) }}, 23:59:59 WITA
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('tambah_js')
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#datatable33').DataTable({
                paging: true,
                "info": true,
                searching: true,
                autoWidth: true,
                "language": {
                    "emptyTable": "Tidak ada rekon masuk"
                }
            });
        });
    </script>
@endsection
