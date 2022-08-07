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
 <!-- Dropzone -->
 <script src="{{asset('template/vendor/dropzone.min.js')}}"></script>
 <script src="{{asset('template/js/dropzone.js')}}"></script>
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
            // bfilter:false,
            // pageLeght
            ajax: {
                url:'/dashboard/administrator/users/get-users',
                data: function(d){
                //     // d.ip = $('#filter_ip').val(),
                //     // d.loc = $('#filter_loc').val(),
                //     // d.login_time = $('#filter_login_time').val(),
                    d.filter_role = $('#filter_role').find(":selected").val()
                }
            },
            columnDefs: [
                { className: "text-center",targets:'_all'}
            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex',autoWidth: true,orderable:false,searchable:false},
                { data: 'name', name: 'name',autoWidth: true },
                { data: 'email', name: 'email',autoWidth: true },
                { data: 'role', name: 'role',autoWidth: true },
                { data: 'company', name: 'company',autoWidth: true },
                { data: 'status', name: 'status',autoWidth: true },
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
    $('#filter_email').on('keyup',function(event){
        if(event.keyCode === 13){
            aTable.columns(2).search($(this).val()).draw();
        }
    });
    $('#filter_perpage').on('change',function(event){
        aTable.page.len(parseInt($(this).find(":selected").val())).draw();
    });
    $('#filter_role').on('change',function(event){
        aTable.columns(3).search($(this).val()).draw();
    });
    $('#filter_status').on('change',function(event){
        aTable.columns(5).search($(this).val()).draw();
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
        $('#filter_role').val('').change();
        $('#filter_status').val('').change();
        $('#filter_email').val('');
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
        $('#mainId').val('');
        $('#email').val('').attr('disabled',false);
        $('#password').val("").attr('required',false);
        $('#name').val('').attr('disabled',false);
        $('#company').val('').change();
        $('#gender').val('').change();
        $('#status').val('').change();
        $('#mobile').val('').attr('disabled',false);
        $('#phone').val('').attr('disabled',false);
        $('#role').val('').change();
    }
    function ShowDetail(data) {
        $('#mainId').val(data.id);
        $('#email').val(data.email).attr('disabled',false);
        $('#password').val("").attr('required',false);
        $('#name').val(data.name).attr('disabled',false);
        $('#company').val(data.company_id).change();
        $('#gender').val(data.gender).change();
        $('#status').val(data.status).change();
        $('#mobile').val(data.mobile).attr('disabled',false);
        $('#phone').val(data.phone_number).attr('disabled',false);
        if(data.roles[0]){
            $('#role').val(data.roles[0].name).change();
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
    function fileInput(){
        var fieldVal = $('#picture').val();
        console.log(fieldVal);
        fieldVal = fieldVal.replace("C:\\fakepath\\", "");
        if (fieldVal != undefined || fieldVal != "") {
            $(".custom-file-label").attr('data-content', fieldVal);
            $(".custom-file-label").text(fieldVal);
        }
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
                    <form id="formData" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="mainId" id="mainId">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" required class="form-control" id="name" placeholder="" name="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" required class="form-control" id="email" placeholder="" name="email">
                            </div>
                            <div class="form-group" id="password_field">
                                <label for="password">Password</label>
                                <input type="password" required class="form-control" id="password" placeholder="" name="password">
                            </div>
                            <div class="form-group" id="gender_field">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" selected>Select Gender Option</option>
                                    <option value="laki - laki" selected>Laki - Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group" id="phone_field">
                                <label for="phone">Phone Number</label>
                                <input type="text" maxlength="13" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" id="phone" placeholder="" name="phone">
                            </div>
                            <div class="form-group" id="mobile_field">
                                <label for="mobile">Mobile</label>
                                <input type="text" maxlength="13" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" id="mobile" placeholder="" name="mobile">
                            </div>
                            <div class="form-group" id="role_field">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="" selected>Select Role Option</option>
                                    @foreach ($role as $item)
                                        <option value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="status_field">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" selected>Select Status Option</option>
                                    <option value="active">Active</option>
                                    <option value="deactive">Deactive</option>
                                </select>
                            </div>
                            <div class="form-group" id="picture_field">
                                <label for="picture">Picture</label>
                                <div class="custom-file">
                                    <input type="file" onchange="fileInput()" class="custom-file-input" id="picture" name="picture">
                                    <label class="custom-file-label" for="picture">Choose file</label>
                                  </div>
                            </div>
                            @if(Auth::user()->company->company_shortname == 'SAS')
                            <div class="form-group">
                                <label for="company">Company</label>
                                <select name="company" id="company" class="form-control">
                                    <option value="">Assign User To Company</option>
                                    @foreach ($company as $item)
                                        <option value="{{$item->id}}">{{$item->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div style="max-height:200px;overflow-y:scroll;">
                                <div class="list-group">

                                </div>
                            </div>
                    </form>
                </div> <!-- // END .modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning">Reset</button>
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
                'Users' => '/dashboard/administrator/users'
            ],
            'nested' => true,
            'currentPage' => 'Users',
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
                            <input id="filter_name" type="text" class="form-control" name="filter_name" placeholder="Search by User Name">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_email">Email</label>
                            <input id="filter_email" type="text" class="form-control" name="filter_email" placeholder="Search by User Email">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_role">Role</label>
                            <select name="filter_role" id="filter_role" class="form-control">
                                <option value="">Search By Role</option>
                                @foreach ($role as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            {{-- <input id="filter_role" type="text" class="form-control" name="filter_role" placeholder="Search by Role"> --}}
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_status">Status</label>
                            <select name="filter_status" id="filter_status" class="form-control">
                                <option value="">Search By Status</option>
                                <option value="active">Active</option>
                                <option value="deactive">Deactive</option>
                            </select>
                            {{-- <input id="filter_role" type="text" class="form-control" name="filter_role" placeholder="Search by Role"> --}}
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
                            <th>Email</th>
                            <th>Role</th>
                            <th>Company</th>
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
