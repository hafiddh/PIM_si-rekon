@extends('opd/opd_temp')
@section('judul', 'Admin OPD')
@section('side_dash', 'active')
@section('tambah_css')
    {{--  --}}
@endsection

@section('tambah_js')
    <script src="{{ asset('vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/dist/Chart.extension.js') }}"></script>
    {{--  --}}
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
                                @php
                                    $wid1 = DB::table('data_pegawai')
                                        ->where('kode_opd', auth()->user()->id)
                                        ->count();
                                    echo $wid1;
                                @endphp
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-user-run"></i>
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
                            <h5 class="card-title text-uppercase text-muted mb-0">Data Rekon Terbuat</h5>
                            <span class="h2 font-weight-bold mb-0">
                                <?php
                                $wid2 = DB::table('rekon_id')
                                    ->where('kode_opd', auth()->user()->id)
                                    ->count();
                                echo $wid2;
                                ?>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-collection"></i>
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
                                    ->where('kode_opd', auth()->user()->id)
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
                            <h5 class="card-title text-uppercase text-muted mb-0">Data Tervalidasi</h5>
                            <span class="h2 font-weight-bold mb-0">
                                @php
                                    $wid4 = DB::table('rekon_id')
                                        ->where('status_rev', '=', '2')
                                        ->where('kode_opd', auth()->user()->id)
                                        ->count();
                                    echo $wid4;
                                @endphp
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
        <div class="col-6">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    @php
                        $nama = auth()->user()->name;
                    @endphp
                    <h3 class="mb-0">Daftar Rekon</h3>

                </div>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable33">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($data_pegawai as $item)
                                <tr id="sid{{ $item->id_pegawai }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nip_baru }}</td>
                                    <td>{{ $item->nama_pegawai }}</td>
                                    <td>
                                        <button id="{{ $item->id_pegawai }}" class="btn btn-success btn-sm"
                                            onClick="edit_pegawai(this.id)"><i class="fa fa-eye"
                                                title="Edit / Detail"></i>&nbsp;<i class="fa fa-edit"
                                                title="Edit / Detail"></i></button>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h4 class="card-title text-uppercase mt-3"><b>Rekon Bulan Ini</b></h4>
                                    <span class="h2 font-weight-bold mb-0">
                                        @php
                                            // dd(date('m-Y'));
                                            function tanggal_indo($tanggal)
                                            {
                                                $bulan = [1 => 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari'];
                                                $split = explode('-', $tanggal);
                                                return $bulan[(int) $split[1]];
                                            }
                                            $ini = date('Y-m-d');
                                            $wid4 = DB::table('rekon_id')
                                                ->where('bulan', '=', tanggal_indo($ini))
                                                ->where('tahun', '=', date('Y'))
                                                ->where('status_rev', '=', '2')
                                                ->where('kode_opd', auth()->user()->id)
                                                ->count();                                            
                                        @endphp
                                    </span>
                                </div>
                                <div class="col-auto">
                                    @php                                        
                                        if ($wid4 == 0) {
                                                echo '<div class="mt-1 icon icon-shape bg-gradient-danger text-white rounded-circle shadow"><i class="fa fa-times"></i></div>';
                                        }else{
                                            echo '<div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow"><i class="fa fa-check"></i></div>';
                                        }
                                    @endphp                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12">
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
                                            return $bulan2[(int) $split[1]]  . ' ' . $split[0];
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
