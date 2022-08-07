@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .dataTables_filter{
        display: none;
    }
    .dataTables_info{
        padding-left:10px !important;
    }
</style>
@endpush
@push('script')
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script>
    // Date range filter
        minDateFilter = "";
        maxDateFilter = "";
        var link = '/dashboard/administrator/company';

    $(document).ready(function() {
        aTable = $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            lengthChange:false,
            searching:true,
            // bfilter:false,
            // pageLeght
            ajax: {
                url:link+'/get-company',
                // data: function(d){
                //     // d.ip = $('#filter_ip').val(),
                //     // d.loc = $('#filter_loc').val(),
                //     // d.login_time = $('#filter_login_time').val(),
                //     // d.login_success = $('#filter_login_success').find(":selected").val()
                // }
            },
            columnDefs: [
                { className: "text-center",targets:'_all'}
            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex',autoWidth: true,orderable:false,searchable:false},
                { data: 'company_name', name: 'company_name',autoWidth: true },
                { data: 'company_shortname', name: 'company_shortname',autoWidth: true },
                { data: 'status', name: 'status',autoWidth: true },
                // { data: 'created_at', name: 'created_at',autoWidth: true },
                // { data: 'role', name: 'role',autoWidth: true },
                // { data: 'name', name: 'name',autoWidth: true },
                { data: 'created_at', name: 'created_at',autoWidth: true, render: function (data, type, row) {//data
                    return moment(row.created_at).format('DD-MM-YYYY HH:mm:ss');
                } },
                {data:'action',name:'action',orderable:false,searchable:false},
            ],
        });
    });
    // Search Script
    $('#filter_name').on('keyup',function(event){
        if(event.keyCode === 13){
            aTable.columns(1).search($(this).val()).draw();
        }
    });
    $('#filter_perpage').on('change',function(event){
        aTable.page.len(parseInt($(this).find(":selected").val())).draw();
    });
    function isBlank(str){
        return (!str || str.length === 0 );
    }
    function addData() {
        $('#formData').attr('action',this.link+'/add');
        ClearForm();
        $('#modal-form').modal("show");
    }
    function resetSearch(){
        $('#filter_name').val('');
        aTable.search('').columns().search('').draw();
    }
    function submitForm() {
        var form =document.getElementById('formData');
        var a = form.checkValidity();
        if(a){
            form.submit();
        }else{
            form.reportValidity();
        }
    }
    function ClearForm() {
        $('#formTitle').text('Create Data');
        $('#company_name').val('').attr('disabled',false);
        $('#divStatus').hide();
        $('#company_shortname').val('').attr('disabled',false);
    }
    function ShowDetail(data) {

        $('#mainId').val(data.id);
        $('#company_name').val(data.company_name).attr('disabled',false);
        $('#company_shortname').val(data.company_shortname).attr('disabled',false);
        $('#divStatus').show();
        if(data.status == 'active'){
            $('#status').prop('checked',true);
        }else{
            $('#status').prop('checked',false);
        }
        $('#formData').attr('action',this.link+'/update');
        $('#formTitle').text('Update Data');
        $('#modal-form').modal("show");
    }
    // Ajax CRUD
    function Delete(params) {
        Swal.fire({
            title: "Kamu yakin ?",
            text: "Data Tidak akan bisa dikembalikan jika sudah dihapus!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Iya, Lanjut !",
            cancelButtonText: "Tidak, Kembali !",
        }).then((Deleted) => {
            if(Deleted.value == true){
                $.ajax({
                    url : this.link+'/delete',
                    type : 'POST',
                    data : {'id':params},
                    cache: false,
                    success:function(data) {
                        if(data.status == 200){
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Berhasil Dihapus',
                                icon: 'success',
                                confirmButtonText: 'Close'
                            });
                            aTable.ajax.reload();
                            // location.reload();
                        }else{
                            Swal.fire({
                                title: 'Error!',
                                text: 'Delete Failed Please Contact Administrator',
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                        }
                    }
                });
            }
        });
    }
    function Edit(id) {
        $.ajax({
            url : this.link+'/show',
            type : 'POST',
            data : {'id':id},
            cache: false,
            beforeSend:function(){
                // $('.preloader').show();
            },
            success:function(datas) {
                console.log(datas);
                ClearForm();
                if(datas.status == 200){
                   ShowDetail(datas.data);
                }else{
                    toastr.error('Ada Kesalahan Sistem, silakan hubungi pengembang sistem');
                }
            },
            error:function(){
                // $('.preloader').hide();
                toastr.error('Ada Kesalahan Sistem, silakan hubungi pengembang sistem');
            }
        });
    }
</script>
@endpush
@push('modal')
      <!-- Sign Up Modal -->
      <div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formTitle">Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formData" method="POST">
                        @csrf
                        <input type="hidden" name="mainId" id="mainId">
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" required class="form-control" id="company_name" placeholder="" name="company_name">
                            </div>
                            <div class="form-group">
                                <label for="company_shortname">Company Username</label>
                                <input type="text" required class="form-control" id="company_shortname" placeholder="" name="company_shortname">
                            </div>
                            <div class="form-group" id="divStatus">
                                <div class="flex">
                                    <label for="status">Status</label><br>
                                    <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                        <input type="checkbox" id="status" value="active" name="status" class="custom-control-input">
                                        <label class="custom-control-label" for="status">Active</label>
                                    </div>
                                    <label for="status" class="mb-0">Yes</label>
                                </div>
                            </div>
                    </form>
                </div> <!-- // END .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Save changes</button>
                </div>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div> <!-- // END .modal -->
@endpush
@section('content')
<div class="mdk-drawer-layout__content page">
    @php
        $breadcrumb = [
            'firstPage' => 'Dashboard',
            'pages' => [
                'Administrator' => '/dashboard/administrator',
                'Company' => '/dashboard/administrator/company'
            ],
            'nested' => true,
            'currentPage' => 'Company',
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
                            <label for="filter_name">Name</label>
                            <input id="filter_name" type="text" class="form-control" name="filter_name" placeholder="Search by Role Name">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_perpage">PerPage</label>
                            <select id="filter_perpage" type="text" class="custom-select" name="filter_perpage">
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="-1">All</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="resetSearch()" class="btn bg-white border-left border-top border-top-sm-0 rounded-top-0 rounded-top-sm rounded-left-sm-0"><i class="material-icons text-primary icon-20pt">refresh</i></button>
            <button onclick="addData()" class="btn bg-white border-left border-top border-top-sm-0 rounded-top-0 rounded-top-sm rounded-left-sm-0"><i class="material-icons text-primary icon-20pt">add</i></button>
        </div>


        <div class="card">

            <div class="table-responsive" style="margin-bottom: 20px;margin-top:10px;">

                <table class="table mb-0 thead-border-top-0 table-striped" id="dataTables">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Company Name</th>
                            <th>Company ShortName</th>
                            <th>Status</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
