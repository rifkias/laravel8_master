@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@push('script')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    // Date range filter
        minDateFilter = "";
        maxDateFilter = "";

        var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
            var dateStart = parseDateValue(minDateFilter);
            var dateEnd = parseDateValue(maxDateFilter);
            //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
            //nama depan = 0
            //nama belakang = 1
            //tanggal terdaftar =2
            var evalDate = parseDateValue(aData[3]);
            if ( ( isNaN( dateStart ) && isNaN( dateEnd ) ) ||
                ( isNaN( dateStart ) && evalDate <= dateEnd ) ||
                ( dateStart <= evalDate && isNaN( dateEnd ) ) ||
                ( dateStart <= evalDate && evalDate <= dateEnd ) )
            {
                return true;
            }
            return false;
        });
        function parseDateValue(rawDate) {
            console.log(rawDate);
            var dateArray= rawDate.split("-");
            var parsedDate= new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);  // -1 because months are from 0 to 11
            return parsedDate;
        }
    $(document).ready(function() {
        aTable = $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            lengthChange:false,
            searching:true,
            ajax: {
                url:'/dashboard/profile/login-history',
                data: function(d){
                    // d.ip = $('#filter_ip').val(),
                    // d.loc = $('#filter_loc').val(),
                    d.login_time = $('#filter_login_time').val(),
                    d.login_success = $('#filter_login_success').find(":selected").val()
                }
            },
            columnDefs: [
                { className: "text-center",targets:'_all'}
            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex',autoWidth: true },
                { data: 'ip_address', name: 'ip_address',autoWidth: true },
                { data: "location.city",autoWidth: true },
                { data: 'login_at', name: 'login_at',autoWidth: true, render: function (data, type, row) {//data
                    return moment(row.login_at).format('DD-MM-YYYY');
                } },
                { data: 'login_successful', name: 'login_successful',autoWidth: true },
                { data: 'logout_at', name: 'logout_at',autoWidth: true,render: function (data, type, row) {//data
                    // console.log(row);
                    var date = moment(row.logout_at).format('DD-MM-YYYY');
                    if(date !== 'Invalid date'){
                        return date;
                    }else{
                        return '-';
                    }
                    // return date;
                }}
            ]
        });
        $('#filter_login_time').daterangepicker({
            opens:'left',
            autoUpdateInput:false,
        });
        $('#filter_login_time').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            minDateFilter=picker.startDate.format('DD/MM/YYYY');
            maxDateFilter=picker.endDate.format('DD/MM/YYYY');
            aTable.draw();
        });
        $('#filter_login_time').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            minDateFilter='';
            maxDateFilter='';
            aTable.draw();
        });
        // Datatable Debugger
        // (function() {
        //     var url = 'https://debug.datatables.net/bookmarklet/DT_Debug.js';
        //     if (typeof DT_Debug != 'undefined') {
        //         if (DT_Debug.instance !== null) {
        //             DT_Debug.close();
        //         } else {
        //             new DT_Debug();
        //         }
        //     } else {
        //         var n = document.createElement('script');
        //         n.setAttribute('language', 'JavaScript');
        //         n.setAttribute('src', url + '?rand=' + new Date().getTime());
        //         document.body.appendChild(n);
        //     }
        // })();
    });
    // Search Script
    $('#filter_ip').on('keyup',function(event){
        // console.log($(this).val());
        if(event.keyCode === 13){
            aTable.columns(1).search($(this).val()).draw();
        }
        // aTable.draw();
        // aTable.search($(this).val()).draw();

    });
    $('#filter_loc').on('keyup',function(event){
        // console.log($(this).val());
        if(event.keyCode === 13){
            aTable.columns(2).search($(this).val()).draw();
        }
        // aTable.search($(this).val()).draw();

    });
    $('#filter_loc').on('keyup',function(event){
        // console.log($(this).val());
        if(event.keyCode === 13){
            aTable.columns(2).search($(this).val()).draw();
        }
        // aTable.search($(this).val()).draw();

    });
    $('#filter_login_success').on('keyup',function(event){
        // console.log($(this).val());
        if(event.keyCode === 13){
            aTable.columns(4).search($(this).val()).draw();
        }
        // aTable.search($(this).val()).draw();

    });
    $('#filter_login_success').on('change',function(event){
        aTable.draw();
    });
    function isBlank(str){
        return (!str || str.length === 0 );
    }
    </script>
@endpush
@section('content')
<div class="mdk-drawer-layout__content page">
    @php
        $breadcrumb = [
            'firstPage' => 'Dashboard',
            'pages' => [
                'users' => '/dashboard/users',
                'History' => '/dashboard/users/history'
            ],
            'nested' => true,
            'currentPage' => 'User Log',
            'setting' => false,
        ];
    @endphp
    @include('layouts._breadcrumb',$breadcrumb)

    <div class="container-fluid page__container">

        <div class="card card-form d-flex flex-column flex-sm-row">
            <div class="card-form__body card-body-form-group flex">
                <div class="row">
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_ip">Ip Address</label>
                            <input id="filter_ip" type="text" class="form-control" name="filter_ip" placeholder="Search by Ip Address">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_loc">Location</label>
                            <input id="filter_loc" type="text" class="form-control" name="filter_loc" placeholder="Search by Location">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_login_time">Login At</label>
                            <input id="filter_login_time" type="text" class="form-control" name="filter_login_time">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_login_success">Login Success</label>
                            <select id="filter_login_success" type="text" class="custom-select" name="filter_login_success">
                                <option selected value=""></option>
                                <option value="true">True</option>
                                <option value="false">False</option>
                            </select>
                            {{-- <input id="filter_login_success" type="text" class="form-control" name="filter_login_success" placeholder="Search by Location"> --}}
                        </div>
                    </div>

                    {{-- <div class="col-sm-auto">
                        <div class="form-group" style="width: 200px;">
                            <label for="filter_date">Login At</label>
                            <input id="filter_date" type="text" class="form-control" placeholder="Select date ..." value="13/03/2018 to 20/03/2018" data-toggle="flatpickr" data-flatpickr-mode="range" data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                        </div>
                    </div> --}}
                </div>
            </div>
            <button class="btn bg-white border-left border-top border-top-sm-0 rounded-top-0 rounded-top-sm rounded-left-sm-0"><i class="material-icons text-primary icon-20pt">refresh</i></button>
        </div>


        <div class="card">


            <div class="table-responsive" style="margin-bottom: 20px;margin-top:10px;">

                <table class="table mb-0 thead-border-top-0 table-striped" id="dataTables">
                    <thead>
                        <tr>

                            {{-- <th style="width: 18px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#companies" id="customCheckAll">
                                    <label class="custom-control-label" for="customCheckAll"><span class="text-hide">Toggle all</span></label>
                                </div>
                            </th> --}}

                            <th class="text-center">No</th>
                            <th>Ip Address</th>
                            <th class="text-center">Location</th>
                            <th class="text-center">Login At</th>
                            <th class="text-center">Login Successfully</th>
                            <th>Logout At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
