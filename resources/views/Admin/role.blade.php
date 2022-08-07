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
        var link = '/dashboard/administrator/users';

    $(document).ready(function() {
        aTable = $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            lengthChange:false,
            searching:true,
            bfilter:false,
            // pageLeght
            ajax: {
                url:'/dashboard/administrator/role/get-role',
                data: function(d){
                    d.login_time = $('#filter_login_time').val(),
                    d.login_success = $('#filter_login_success').find(":selected").val()
                }
            },
            columnDefs: [
                { className: "text-center",targets:'_all'}
            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex',autoWidth: true,orderable:false,searchable:false},
                { data: 'name', name: 'name',autoWidth: true },
                { data: 'created_at', name: 'created_at',autoWidth: true, render: function (data, type, row) {//data
                    return moment(row.created_at).format('DD-MM-YYYY H:m:s');
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
    function CheckedAll(){
        if($('#checkAll').is(':checked') == true){
            $(".permissionCheck").prop('checked', true);
        }else{
            $(".permissionCheck").prop('checked', false);
        }
        // console.log($("#checkAll:checked").length);
    }
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
        $('#roleName').val('').attr('disabled',false);
        $(".permissionCheck").prop('checked', false);
    }
    function ShowDetail(data) {
        const arr = [];
        for (let index = 0; index < data.permissions.length; index++) {
            arr.push(data.permissions[index].name);
        }
        $('#mainId').val(data.id);
        $('#roleName').val(data.name).attr('disabled',false);
        $('.permissionCheck').each(function(e){
            if(arr.includes($(this).val())){
                $(this).prop('checked', true);
            }
        })
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
                                <label for="roleName">Role Name</label>
                                <input type="text" required class="form-control" id="roleName" placeholder="" name="roleName">
                            </div>
                            <div class="form-group">
                                <div class="flex">
                                    <label for="checkAll">Assign Permission</label><br>
                                    <label for="checkAll" class="mb-0">Uncheck All</label>
                                    <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                        <input type="checkbox" id="checkAll" onchange="CheckedAll()" value="true" name="checkAll" class="custom-control-input">
                                        <label class="custom-control-label" for="checkAll">Yes</label>
                                    </div>
                                    <label for="checkAll" class="mb-0">Check All</label>
                                </div>
                            </div>
                            <div style="max-height:200px;overflow-y:scroll;">
                                <div class="list-group">
                                    @foreach ($permission as $item)
                                        <label class="list-group-item" style="padding-top:10px;padding-bottom:10px;padding-left:30px;">
                                            <input class="form-check-input me-1 permissionCheck" name="permission[]" type="checkbox" value="{{$item->name}}">
                                            {{$item->name}}
                                        </label>
                                    @endforeach
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
                'Role' => '/dashboard/administrator/role'
            ],
            'nested' => true,
            'currentPage' => 'Role',
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
                            <th>Name</th>
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
