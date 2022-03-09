@extends('layouts.main')
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
                            <label for="filter_name">Name</label>
                            <input id="filter_name" type="text" class="form-control" placeholder="Search by name">
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_category">Industry</label><br>
                            <select id="filter_category" class="custom-select" style="width: 200px;">
                                <option value="all">Any</option>
                                <option value="all">Software</option>
                                <option value="all">Production of Goods</option>
                                <option value="all">Health</option>
                                <option value="all">Sports</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group">
                            <label for="filter_stock">Has Sales</label>
                            <div class="custom-control custom-checkbox mt-sm-2">
                                <input type="checkbox" class="custom-control-input" id="filter_stock" checked="">
                                <label class="custom-control-label" for="filter_stock">Yes</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="form-group" style="width: 200px;">
                            <label for="filter_date">Created Date</label>
                            <input id="filter_date" type="text" class="form-control" placeholder="Select date ..." value="13/03/2018 to 20/03/2018" data-toggle="flatpickr" data-flatpickr-mode="range" data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn bg-white border-left border-top border-top-sm-0 rounded-top-0 rounded-top-sm rounded-left-sm-0"><i class="material-icons text-primary icon-20pt">refresh</i></button>
        </div>


        <div class="card">


            <div class="table-responsive" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>

                <table class="table mb-0 thead-border-top-0 table-striped">
                    <thead>
                        <tr>

                            {{-- <th style="width: 18px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#companies" id="customCheckAll">
                                    <label class="custom-control-label" for="customCheckAll"><span class="text-hide">Toggle all</span></label>
                                </div>
                            </th> --}}

                            <th style="width: 30px;" class="text-center">No</th>
                            <th>Ip Address</th>
                            <th class="text-center">Location</th>
                            <th class="text-center">Login At</th>
                            <th class="text-center">Login Successfully</th>
                            <th style="width: 50px;">Logout At</th>
                            {{-- <th style="width: 120px;" class="text-right">Total Sales</th> --}}
                            <th style="width: 50px;">
                                <div class="dropdown pull-right">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Action</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0)" class="dropdown-item"><i class="material-icons  mr-1">work</i> Update Status</a>
                                        <a href="javascript:void(0)" class="dropdown-item"><i class="material-icons  mr-1">pin_drop</i> Add Location</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0)" class="dropdown-item"><i class="material-icons  mr-1">archive</i> Archive</a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="list" id="companies">



                        <tr>

                            {{-- <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck1_20">
                                    <label class="custom-control-label" for="customCheck1_20"><span class="text-hide">Check</span></label>
                                </div>
                            </td> --}}
                            <td>
                                <div class="badge badge-light">#29177</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">


                                    <div class="d-flex align-items-center">
                                        <i class="material-icons icon-16pt mr-1 text-primary">business</i>
                                        <a href="#">Hexio Enterprise</a>
                                    </div>

                                </div>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted"><i class="material-icons icon-16pt mr-1">pin_drop</i> Miami, Florida, USA</small>
                                </div>
                            </td>
                            <td style="width: 140px;"><i class="material-icons icon-16pt text-muted-light mr-1">today</i> 05-05-2019</td>
                            <td style="width:80px" class="text-center">


                                <i class="material-icons icon-16pt text-muted mr-1">account_circle</i> <a href="#">20</a>

                            </td>
                            <td class="text-center">31% <i class="material-icons icon-16pt text-success">arrow_upward</i></td>
                            <td class="text-center">20</td>
                            <td><a href="#" class="btn btn-sm btn-link"><i class="material-icons icon-16pt">arrow_forward</i></a> </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="card-body text-right">
                15 <span class="text-muted">of 1,430</span> <a href="#" class="text-muted-light"><i class="material-icons ml-1">arrow_forward</i></a>
            </div>


        </div>
    </div>
</div>
@endsection
