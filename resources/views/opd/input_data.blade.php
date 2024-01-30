@extends('opd/opd_temp')
@section('judul', 'Data Rekon Pegawai')
@section('side_kel', 'active')
@section('side_kel2', 'show')
@section('side_dama', 'active')
@section('judul2', 'Data Rekon Pegawai')
@section('tambah_css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/fixedHeader.dataTables.min.css') }}">
@endsection



@section('isi')

<div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Buat data rekon baru</h3>
                </div>
                <!-- Card header -->
                <div class="card-header">
                    <form id="fcari" action="{{ url('/opd/buat_data') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row px-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="">OPD</label>
                                    <select disabled class="form-control" data-toggle="select" required>
                                        <option value="">{{ auth()->user()->name }}</option>
                                    </select>
                                    <input type="text" name="odp" value="{{ auth()->user()->id }}" hidden>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Bulan</label>
                                            @php
                                                function bulan_indo($tanggal)
                                                {
                                                    $bulan = [1 => 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari'];
                                                    $split = explode('-', $tanggal);
                                                    return $bulan[(int) $split[1]];
                                                }
                                                $ini = date('Y-m');
                                                // echo tanggal_indo($ini);
                                                // dd(bulan_indo($ini));
                                            @endphp
                                            <select disabled class="form-control" data-toggle="select" required>
                                                <option value="">{{ bulan_indo($ini) }}</option>
                                            </select>
                                            <input type="text" value="{{ bulan_indo($ini) }}" name="bulan" hidden>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="">Tahun</label>
                                            @php
                                                function tahun_indo($tanggal)
                                                {
                                                    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                    $split = explode('-', $tanggal);
                                                    return $split[0];
                                                }
                                                $ini2 = date('Y-m');
                                                // echo tanggal_indo($ini);
                                                // dd(bulan_indo($ini));
                                            @endphp
                                            <select disabled class="form-control" data-toggle="select" required>
                                                <option value="">{{ tahun_indo($ini2) }}</option>
                                            </select>

                                            <input type="text" value="{{ tahun_indo($ini2) }}" name="tahun" hidden>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-4 float-right align-items-center">
                                        <button type="submit" class="btn btn-primary">Buat Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Lihat data rekon</h3>

                </div>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable33">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>OPD</th>
                                <th>Bulan/Tahun</th>
                                <th>Tanggal Buat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>Data Rekonsiliasi PNS OPD {{ $item->opd }}</td>
                                    <td>{{ $item->bulan . ' ' . $item->tahun }}</td>
                                    <td>
                                        <?php
                                        $originalDate = $item->waktu_up;
                                        $waktu = date('d-m-Y', strtotime($originalDate));
                                        echo $waktu;
                                        ?>
                                    </td>
                                    <td>

                                        @if ($item->status_rev < '1' || $item->status_rev > '2')
                                            
                                                <a href="{{ url('opd/input_data/edit_rekon/' . $item->id) }}"
                                                    class="btn btn-success btn-sm"> <i class="fa fa-pen" title="Edit"></i></a>
                                                <form action="{{ url('opd/input_data/hapus_rekon/' . $item->id) }}"
                                                    method="post"
                                                    onsubmit="return confirm('Apakah anda ingin menghapus data REKON? \nData yang dihapus tidak dapat dikembalikan!?');"
                                                    class="d-inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" id="sub" class="btn btn-danger btn-sm"><i
                                                            title="Hapus" class="fa fa-trash"></i></button>
                                                </form>
                                            
                                        @elseif ($item->status_rev == '2')
                                            
                                                <a href="{{ url('opd/input_data/edit_rekon/' . $item->id) }}"
                                                    class="btn btn-success btn-sm"> <i class="fa fa-check"
                                                        title="Edit / Detail"></i></a>
                                                    
                                            
                                        @else
                                            
                                                <a href="{{ url('opd/input_data/edit_rekon/' . $item->id) }}"
                                                    class="btn btn-warning btn-sm"> <i class="fa fa-list"
                                                        title="Edit / Detail"></i></a>
                                                    
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div id="alert"></div>
    @endif
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
    <script src="{{ asset('vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/nouislider/distribute/nouislider.min.js') }}"></script>
    <script src="{{ asset('vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/sweet.min.js') }}"></script>

    <script src="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatable33').DataTable({
                paging: false,
                "info": true,
                searching: true,
                autoWidth: false
            });
        });
    </script>

    <script>
        if ($('#alert').length > 0) {
            if ({{ session('kon') }} == "1") {
                swal("{{ session('status') }}", {
                    icon: "warning",
                });
            } else {
                swal("{{ session('status') }}", {
                    icon: "success",
                });
            }

        }
    </script>



    <?php Session::forget('kon'); ?>
@endsection
