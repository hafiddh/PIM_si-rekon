@extends('keuangan/keu_temp')
@section('judul', 'Upload SPUM Gaji')
@section('side_kel3', 'active')
@section('side_kel4', 'show')
@section('side_spum', 'active')
@section('judul2', 'Upload SPUM Gaji')

@section('tambah_css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endsection

@section('isi')
    <div class="row">
        <div class="col">
            <div class="card pb-2">
                <!-- Card header -->
                {{-- <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0" style="padding-top: 8px">Data Pegawai Negeri Sipil</h3>
                        </div>
                        <div class="col-6">
                            <form class="navbar-search navbar-search-light form-inline mr-sm-3 float-right"
                                id="navbar-search-main">
                                <div class="form-group mb-0">
                                    <div class="input-group input-group-alternative input-group-merge">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Cari berdasarkan NIK" type="text">
                                    </div>
                                </div>
                                <button type="button" class="close" data-action="search-close"
                                    data-target="#navbar-search-main" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <div class="px-3 py-3">
                    @if (session('status'))
                        <div id="alert"></div>
                        {{-- <div class="row">
                            <div class="col-4">
                            </div>
                            <div class="col-4">
                                <div class="alert alert-success text-center" role="alert" id="alert">
                                    {{ session('status') }}
                                </div>
                            </div>
                            <div class="col-4">
                            </div>
                        </div> --}}
                    @endif
                    <form id="uplo" action="{{ url('keuangan/import') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="">ODP</label>
                                    <select name="odp" class="form-control" data-toggle="select">
                                        @foreach ($data as $opd)
                                            <option value="{{ $opd->id_opd }}">{{ $opd->nama_opd }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Bulan</label>
                                    <select name="bulan" class="form-control" data-toggle="select">
                                        <option>Januari</option>
                                        <option>Februari</option>
                                        <option>Maret</option>
                                        <option>April</option>
                                        <option>Mei</option>
                                        <option>Juni</option>
                                        <option>Juli</option>
                                        <option>Agustus</option>
                                        <option>September</option>
                                        <option>Oktober</option>
                                        <option>November</option>
                                        <option>Desember</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Tahun</label>
                                    <select name="tahun" class="form-control" data-toggle="select">
                                        @for ($x = 2021; $x <= 2050; $x++)
                                            <option>{{ $x }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="custom-file">
                                    <label id="file_up" for="file-upload" class="custom-file-label">Upload File</label>
                                    <input required id="file-upload" type="file" name="file" class="custom-file-input"
                                        accept=".xlsx,.xls,.crv">
                                </div>
                            </div>
                            <div class="col-6">
                                <button id="sub" type="button" value="Upload Data" class="btn btn-primary">Upload
                                    Data</button>
                            </div>
                        </div>
                    </form>
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

    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/nouislider/distribute/nouislider.min.js') }}"></script>
    <script src="{{ asset('vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/sweet.min.js') }}"></script>

    <script src="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <script type="text/javascript">
        $('#file-upload').change(function() {
            var i = $(this).prev('label').clone();
            var file = $('#file-upload')[0].files[0].name;
            $(this).prev('label').text(file);
            $('#file_up').text(label_text.replace("()", text(file)));
        });

        $("#alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#alert").slideUp(500);
        });

    </script>

    <script>
        $("#sub").click(function() {
            swal({
                    title: "Apakah anda yakin?",
                    text: "Pastikan data SPUM yang anda upload sudah benar!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('form#uplo').submit();
                    } else {
                        // swal("Your imaginary file is safe!");
                    }
                });
        });

    </script>

    <script>
        if ($('#alert').length > 0) {
            if ({{ session('kon') }} == "1") {
                swal("{{ session('status') }}", {
                    icon: "error",
                });
            } else {
                swal("{{ session('status') }}", {
                    icon: "success",
                });
            }
        }

    </script>
@endsection
