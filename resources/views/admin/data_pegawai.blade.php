@extends('admin/temp_admin')
@section('judul', 'Data ASN')
@section('side_asn', 'active')
@section('side_asn2', 'show')
@section('side_daasn', 'active')
@section('judul2', 'Data Pegawai Negeri Sipil')

@section('tambah_css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('isi')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            {{-- <h3 class="mb-0" style="padding-top: 8px">Data Pegawai Negeri Sipil</h3> --}}
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-flush" id="datatable1" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>OPD</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                        </table>
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
            $('#datatable1').DataTable({
                // paging: true,
                // "info": true,
                // searching: true,
                // autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/data_pegawai/get_data') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'id_pegawai',
                        // "visible": false,
                        "searchable": false
                    },
                    {
                        data: 'nip_baru'
                    },
                    {
                        data: 'nama_pegawai'
                    },
                    {
                        data: 'nama_opd'
                    }
                    // {
                    //     data: null,
                    //     render: function(data, type, row) {
                    //         return '<button id="' + data.id_pegawai +
                    //             '" onclick="getvalue(this);">Delete</button>'
                    //     }
                    // },
                ],
                order: [
                    [0, 'asc']
                ]
            });
        });

        function getvalue(obj) {
            var rowID = $(obj).attr('nip');
            var data = $(obj).closest('tr').find('td:first').html();
            console.log(data);
            $.ajax({
                url: "{{ url('admin/edit_pegawai') }}",
                data: {
                    'id': data
                },
                type: 'get',
                datatype: 'JSON',
                success: function(response) {
                    console.log(response);
                    alert(response);
                },
                error: function(response) {
                    console.log('F');
                }
            });
        }
    </script>

@endsection
