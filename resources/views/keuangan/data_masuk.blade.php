@extends('keuangan/keu_temp')
@section('judul', 'Data Masuk')
@section('side_kel', 'active')
@section('side_kel2', 'show')
@section('side_dama', 'active')
@section('judul2', 'Data Masuk')

@section('tambah_css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection


@section('isi')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="table-responsive mt-3 py-4">
                    <table class="table table-flush" id="datatable_val">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>OPD</th>
                                <th>Bulan/Tahun</th>
                                <th>Tanggal Buat OPD</th>
                                <th>Tanggal Validasi BKPSDMD</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($data) }} --}}
                            @foreach ($data as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item->opd }}</td>
                                    <td>{{ $item->bulan . ' ' . $item->tahun }}</td>
                                    <td>
                                        <?php
                                        $originalDate = $item->waktu_up;
                                        $waktu = date('d-m-Y', strtotime($originalDate));
                                        echo $waktu;
                                        ?>
                                    </td>
                                    <td>
                                        @php
                                            $originalDate2 = $item->updated_at;
                                            $waktu2 = date('d-m-Y', strtotime($originalDate2));
                                            echo $waktu2;
                                        @endphp
                                    </td>
                                    <td>
                                        <a href="{{ url('keuangan/detail_valid/' . $item->id) }}"
                                            class="btn btn-success btn-sm"> <i class="fa fa-list" title="Detail"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col">
            <div class="card">
                
                <div class="card-header">
                    <h3 class="mb-0">Arsip Rekon</h3>
                </div>
                <div class="table-responsive mt-3 py-4">
                    <table class="table table-flush" id="datatable_val2">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>OPD</th>
                                <th>Bulan/Tahun</th>
                                <th>Tanggal Buat OPD</th>
                                <th>Tanggal Validasi BKPSDMD</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($data) }} --}}
                            @foreach ($data2 as $item2)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item2->opd }}</td>
                                    <td>{{ $item2->bulan . ' ' . $item->tahun }}</td>
                                    <td>
                                        <?php
                                        $originalDate = $item2->waktu_up;
                                        $waktu = date('d-m-Y', strtotime($originalDate));
                                        echo $waktu;
                                        ?>
                                    </td>
                                    <td>
                                        @php
                                            $originalDate2 = $item2->updated_at;
                                            $waktu2 = date('d-m-Y', strtotime($originalDate2));
                                            echo $waktu2;
                                        @endphp
                                    </td>
                                    <td>
                                        <a href="{{ url('keuangan/detail_valid/' . $item2->id) }}"
                                            class="btn btn-success btn-sm"> <i class="fa fa-list" title="Detail"></i></a>
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
    <script src="{{ asset('js/sweet.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#hide_1").hide();
            $("#hide_2").hide();
            $("#hide_3").hide();

            $('#datatable_val').DataTable({
                paging: true,
                "info": true,
                searching: true,
                autoWidth: true

            });

            $('#datatable_val2').DataTable({
                paging: true,
                "info": true,
                searching: true,
                autoWidth: true

            });
        });
    </script>


    <script>
        if ($('#alert').length > 0) {
            if ({{ session('kon') }} == "1") {
                swal("{{ session('status') }}", {
                    icon: "error",
                });
            } else if ({{ session('kon') }} == "2") {
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
    <script>
        $(document).ready(function() {
            $('#datatable_spum').DataTable({
                paging: false,
                "info": false,
                searching: false,
                responsive: false,
                autoWidth: false
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#datatable_rekon').DataTable({
                paging: false,
                "info": false,
                searching: false,
                responsive: false,
                autoWidth: false
            });
        });
    </script>

    <script>
        function printData() {
            var divToPrint = document.getElementById("data_rekon");
            var htmlToPrint = '' +
                '<style type="text/css">' +
                'table th, table td {' +
                'border: 1px solid black;' +
                'padding:0.5em;' +
                '}' +
                '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        }

        $('#print_rekon_b').on('click', function() {
            $("#hide_2").show();
            printData();
            $("#hide_2").hide();
        })
    </script>

    <script>
        function printData2() {
            var divToPrint = document.getElementById("data_spum");
            var htmlToPrint = '' +
                '<style type="text/css">' +
                'table th, table td {' +
                'border: 1px solid black;' +
                'padding:0.5em;' +
                '}' +
                '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        }

        $('#print_spum_b').on('click', function() {
            $("#hide_1").show();
            printData2();
            $("#hide_1").hide();
        })
    </script>



    <script>
        function printData3() {
            var divToPrint = document.getElementById("data_rekomendasi");
            var htmlToPrint = '';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
        }

        $('#print_rekomendasi').on('click', function() {
            $("#hide_3").show();
            printData3();
            $("#hide_3").hide();
        })
    </script>

    <?php
    Session::forget('kon');
    Session::forget('stats');
    Session::forget('status');
    ?>
@endsection
