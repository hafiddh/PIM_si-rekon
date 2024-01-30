@extends('opd/opd_temp')
@section('judul', 'Data ASN')
@section('side_asn', 'active')
@section('side_asn2', 'show')
@section('side_daasn', 'active')
@section('judul2', 'Data Pegawai Negeri Sipil')

@section('tambah_css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endsection

@section('isi')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="container form-group">
                    <form id="pegawai_pindah" action="{{ route('opd.tambah.pegawai') }}" method="post">
                        {{ csrf_field() }}
                        <label class="form-control-label " for=""></label>
                        <select class="cari form-control" style="width:500px;" name="id_peg" id="id_peg" required></select>

                        <div class="modal fade pt-5" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Nomor SK</label>
                                            <input type="email" class="form-control" name="no_sk" id="no_sk"
                                                aria-describedby="emailHelp" placeholder="Masukkan nomor SK" required>

                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="exampleDatepicker">Tanggal SK</label>
                                            <input class="form-control datepicker2" placeholder="Pilih tanggal SK"
                                                name="tgl_sk" id="tgl_sk" type="text" value="" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-center">
                                        <button type="button" id="tambah_peg" class="btn btn-primary "><i
                                                class="fa fa-plus">
                                            </i> Tambah pegawai</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center my-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i
                                    class="fa fa-plus">
                                </i> Tambah pegawai</button>
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
                    @php
                        $nama = auth()->user()->name;
                    @endphp
                    <h3 class="mb-0">DATA PEGAWAI {{ ucwords($nama) }}</h3>

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
                            @foreach ($data_pegawai as $item)
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Data Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post" id="editForm"
                    onsubmit="return confirm('Data akan di Update, Pastikan data sudah benar?!');" class="d-inline">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="modal-body">

                        <input class="form-control" name="id" id="id" value="" hidden>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label form-control-label">Nama pegawai</label>
                            <div class="col-md-10">
                                <input class="form-control" name="nama" id="nama" type="text" value="" disabled>
                                <input class="form-control" name="nama2" id="nama2" type="text" value="" hidden>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label form-control-label">NIP</label>
                            <div class="col-md-10">
                                <input class="form-control" name="nip" id="nip" type="text" value="" disabled>
                                <input class="form-control" name="nip2" id="nip2" type="text" value="" hidden>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label form-control-label">NIK</label>
                            <div class="col-md-10">
                                <input class="form-control" name="nik" id="nik" type="number" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label form-control-label">No NPWP</label>
                            <div class="col-md-10">
                                <input class="form-control" name="no_npwp" id="no_npwp" type="text" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label form-control-label">No HP</label>
                            <div class="col-md-10">
                                <input class="form-control" name="no_hp" id="no_hp" type="number" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label form-control-label">Jabatan</label>
                            <div class="col-md-10">
                                <input class="form-control" name="jabatan" id="jabatan" type="text" value="">
                            </div>
                        </div>

                        <hr style="border-top: 3px solid black;">

                        <div class="form-group first">
                            <label class="form-control-label">Nama Ayah</label>
                            <input class="form-control" name="nama_ayah" id="nama_ayah" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Tanggal Lahir Ayah</label>
                            <input class="form-control" name="tl_ayah" id="tl_ayah" type="date" value="">
                        </div>

                        <div class="form-group first">
                            <label class="form-control-label">Nama Ibu</label>
                            <input class="form-control" name="nama_ibu" id="nama_ibu" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Tanggal Lahir Ibu</label>
                            <input class="form-control" name="tl_ibu" id="tl_ibu" type="date" value="">
                        </div>


                        <hr style="border-top: 3px solid black;">

                        <div class="form-group first">
                            <label class="form-control-label">Status Nikah</label>
                            <select class="form-control" name="status_nikah" id="status_nikah" value="">
                                <option value="b_nikah">Belum Menikah</option>
                                <option value="nikah">Menikah</option>
                                <option value="cerai">Cerai</option>
                            </select>
                        </div>
                        <small class="text-muted">Kosongkan form dibawah Jika <b>Belum Menikah / Cerai</b></small>
                        <div class="form-group first"><br>
                            <label class="form-control-label">Nama Suami/Istri</label>
                            <input class="form-control" name="nama_p" id="nama_p" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">NIP Suami/Istri</label>
                            <input class="form-control" name="nip_p" id="nip_p" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Tanggal Lahir Suami/Istri</label>
                            <input class="form-control" name="tl_p" id="tl_p" type="date" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">No Buku Nikah</label>
                            <input class="form-control" name="no_b_nikah" id="no_b_nikah" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Tanggal Buku Nikah</label>
                            <input class="form-control" name="tl_b_nikah" id="tl_b_nikah" type="date" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Pekerjaan Suami/Istri</label>
                            <input class="form-control" name="pekerjaan_p" id="pekerjaan_p" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Status dalam daftar gaji</label>
                            <input class="form-control" name="status_gaji" id="status_gaji" type="text" value="">
                        </div>

                        <hr style="border-top: 3px solid black;">

                        <small class="text-muted">Kosongkan form dibawah jika tidak memiliki anak</small>
                        <div class="form-group first"><br>
                            <label class="form-control-label">Nama Anak 1</label>
                            <input class="form-control" name="nama_anak_1" id="nama_anak_1" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Tanggal Lahir Anak 1</label>
                            <input class="form-control" name="tl_anak_1" id="tl_anak_1" type="date" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Pekerjaan Anak 1</label>
                            <input class="form-control" name="p_anak_1" id="p_anak_1" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Umur Anak 1</label>
                            <input class="form-control" name="umur_anak_1" id="umur_anak_1" type="number" value="">
                        </div>

                        <div class="form-group first">
                            <label class="form-control-label">Nama Anak 2</label>
                            <input class="form-control" name="nama_anak_2" id="nama_anak_2" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Tanggal Lahir Anak 2</label>
                            <input class="form-control" name="tl_anak_2" id="tl_anak_2" type="date" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Pekerjaan Anak 2</label>
                            <input class="form-control" name="p_anak_2" id="p_anak_2" type="text" value="">
                        </div>
                        <div class="form-group first">
                            <label class="form-control-label">Umur Anak 2</label>
                            <input class="form-control" name="umur_anak_2" id="umur_anak_2" type="number" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('kon') == 0)
        <div id="alert"></div>
    @endif
    {{-- <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="mb-0" style="padding-top: 8px">Data Pegawai Negeri Sipil</h3>
                        </div>
                        <div class="col-6">
                            <form class="navbar-search navbar-search-light form-inline mr-sm-3 float-right" id="navbar-search-main">
                                <div class="form-group mb-0">
                                  <div class="input-group input-group-alternative input-group-merge">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Cari berdasarkan NIK" type="text">
                                  </div>
                                </div>
                                <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                              </form>
                        </div>
                    </div>
                </div>
                <div class="container py-3">
                    <div class="row">
                        <div class="col-4">
                            <h5>Nama</h5>
                        </div>
                        <div class="col-8">
                            <h5>Hafid DH, S.T</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <h5>NIP</h5>
                        </div>
                        <div class="col-8">
                            <h5>1231231231</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <h5>No. KTP</h5>
                        </div>
                        <div class="col-8">
                            <h5>74710101080002</h5>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-4">
                            <h5>No. HP</h5>
                        </div>
                        <div class="col-8">
                            <h5>082293313797</h5>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-4">
                            <h5>No. NPWP</h5>
                        </div>
                        <div class="col-8">
                            <h5>7317823791739</h5>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-4">
                            <h5>Pangkat/Golongan</h5>
                        </div>
                        <div class="col-8">
                            <h5>Pembina, IV/a</h5>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-4">
                            <h5>Jabatan</h5>
                        </div>
                        <div class="col-8">
                            <h5>Fungsional</h5>
                        </div>
                    </div>   
                    <hr/> 
                </div>
            </div>
        </div>
    </div> --}}
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
    <script src="{{ asset('') }}vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/sweet.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('#datatable33').DataTable({
                paging: true,
                "info": true,
                searching: true

            });
        });
    </script>

    <script type="text/javascript">
        $('.datepicker2').datepicker({
            locale: 'id',
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy'

        });
    </script>

    <script type="text/javascript">
        function edit_pegawai(id) {
            $.get('/opd/id_pegawai/' + id, function(pegawai) {
                $('#id').val(pegawai.id_pegawai);
                $('#nama').val(pegawai.nama_pegawai);
                $('#nama2').val(pegawai.nama_pegawai);
                $('#status_nikah').val(pegawai.stat_nikah);
                $('#nip').val(pegawai.nip_baru);
                $('#nip2').val(pegawai.nip_baru);
                $('#nik').val(pegawai.nik);
                $('#no_npwp').val(pegawai.npwp);
                $('#no_hp').val(pegawai.no_hp);
                $('#jabatan').val(pegawai.jabatan);
                $('#nama_ayah').val(pegawai.nama_ayah);
                $('#tl_ayah').val(pegawai.tgl_lhr_ayah);
                $('#nama_ibu').val(pegawai.nama_ibu);
                $('#tl_ibu').val(pegawai.tgl_lhr_ibu);
                $('#nama_p').val(pegawai.nama_p);
                $('#nip_p').val(pegawai.nip_p);
                $('#tl_p').val(pegawai.tgl_lhr_p);
                $('#no_b_nikah').val(pegawai.no_b_nikah);
                $('#tl_b_nikah').val(pegawai.tgl_b_nikah);
                $('#pekerjaan_p').val(pegawai.pekerjaan_p);
                $('#status_gaji').val(pegawai.status_p);
                $('#nama_anak_1').val(pegawai.nama_a_1);
                $('#tl_anak_1').val(pegawai.tgl_lhr_a_1);
                $('#p_anak_1').val(pegawai.kerja_a_1);
                $('#umur_anak_1').val(pegawai.usia_a_1);
                $('#nama_anak_2').val(pegawai.nama_a_2);
                $('#tl_anak_2').val(pegawai.tgl_lhr_a_2);
                $('#p_anak_2').val(pegawai.kerja_a_2);
                $('#umur_anak_2').val(pegawai.usia_a_2);

                $('#exampleModalCenter').modal("toggle");
            });
        }

        $('#editForm').submit(function(e) {
            e.preventDefault();
            var id = $('#id').val();
            var nama_pegawai = $('#nama2').val();
            var nip_baru = $('#nip2').val();
            var nik = $('#nik').val();
            var npwp = $('#no_npwp').val();
            var no_hp = $('#no_hp').val();
            var stat_nikah = $('#status_nikah').val();
            var jabatan = $('#jabatan').val();
            var nama_ayah = $('#nama_ayah').val();
            var tgl_lhr_ayah = $('#tl_ayah').val();
            var nama_ibu = $('#nama_ibu').val();
            var tgl_lhr_ibu = $('#tl_ibu').val();
            var nama_p = $('#nama_p').val();
            var nip_p = $('#nip_p').val();
            var tgl_lhr_p = $('#tl_p').val();
            var no_b_nikah = $('#no_b_nikah').val();
            var tgl_b_nikah = $('#tl_b_nikah').val();
            var pekerjaan_p = $('#pekerjaan_p').val();
            var status_p = $('#status_gaji').val();
            var nama_a_1 = $('#nama_anak_1').val();
            var tgl_lhr_a_1 = $('#tl_anak_1').val();
            var kerja_a_1 = $('#p_anak_1').val();
            var usia_a_1 = $('#umur_anak_1').val();
            var nama_a_2 = $('#nama_anak_2').val();
            var tgl_lhr_a_2 = $('#tl_anak_2').val();
            var kerja_a_2 = $('#p_anak_2').val();
            var usia_a_2 = $('#umur_anak_2').val();
            var _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('pegawai.up') }}",
                type: 'PUT',
                data: {
                    id_pegawai: id,
                    nama_pegawai: nama_pegawai,
                    nip_baru: nip_baru,
                    nik: nik,
                    npwp: npwp,
                    no_hp: no_hp,
                    jabatan: jabatan,
                    stat_nikah: stat_nikah,
                    nama_ayah: nama_ayah,
                    tgl_lhr_ayah: tgl_lhr_ayah,
                    nama_ibu: nama_ibu,
                    tgl_lhr_ibu: tgl_lhr_ibu,
                    nama_p: nama_p,
                    nip_p: nip_p,
                    tgl_lhr_p: tgl_lhr_p,
                    no_b_nikah: no_b_nikah,
                    tgl_b_nikah: tgl_b_nikah,
                    pekerjaan_p: pekerjaan_p,
                    status_p: status_p,
                    nama_a_1: nama_a_1,
                    tgl_lhr_a_1: tgl_lhr_a_1,
                    kerja_a_1: kerja_a_1,
                    usia_a_1: usia_a_1,
                    nama_a_2: nama_a_2,
                    tgl_lhr_a_2: tgl_lhr_a_2,
                    kerja_a_2: kerja_a_2,
                    usia_a_2: usia_a_2,
                    _token: _token
                },
                success: function(response) {
                    swal("Data Berhasil di-Update", {
                        icon: "success",
                    });
                    $('#exampleModalCenter').modal("toggle");
                    $('#editForm')[0].reset();
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                    swal("Data gagal di Update", {
                        icon: "danger",
                    });
                }
            });

        });
    </script>

    <script type="text/javascript">
        $('.cari').select2({
            placeholder: 'Cari berdasarkan Nama atau NIP ...',
            ajax: {
                url: '/opd/get_pegawai',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: '' + item.nama_pegawai + ' (' + item.nip_baru + ')',
                                id: item.id_pegawai
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>

    <script>
        $("#tambah_peg").click(function() {
            var a = $('#id_peg').val();
            var b = $('#no_sk').val();
            var c = $('#tgl_sk').val();
            swal({
                    title: "Pegawai akan ditambahkan?!",
                    text: "Pegawai yang dipilih akan dipindahkan ke {{ auth()->user()->name }} sesuai dengan tanggal dan nomor SK yang dimasukkan!\n Pastikan data sudah sesuai.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                })
                .then((willDelete) => {
                    if (willDelete) {
                        if (a == null || b == null || c == null) {
                            swal("Pastikan untuk memilih pegawai, memasukkan nomor SK dan Tanggal SK", {
                                icon: "error",
                            });
                        } else {
                            $('#pegawai_pindah').submit()
                        }
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


    <?php
    Session::forget('kon');
    Session::forget('status');
    ?>
@endsection
