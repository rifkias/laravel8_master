@extends('layouts.main')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">IP Address</th>
                            <th scope="col">Location</th>
                            <th scope="col">Login at</th>
                            <th scope="col">Login Successfully</th>
                            <th scope="col">Logout at</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $item)
                            <tr>
                                <th scope="row">{{ ++$key }}</th>
                                <td>{{ $item['ip_address'] }}</td>
                                <td>{{ $item->location['city'] }}</td>
                                <td>{{ Carbon\Carbon::parse($item['login_at'])->isoFormat('D MMMM YYYY h:mm A') }}</td>
                                <td>{{ $item['login_successful']  === true ? 'Yes' : 'No' }}</td>
                                <td>{{ $item['logout_at'] === NULL ? '-' : Carbon\Carbon::parse($item->logout_at)->isoFormat('D MMMM YYYY h:mm A') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="mdk-drawer-layout__content page">
    @php
        $breadcrumb = [
            'firstPage' => 'Dashboard',
            'currentPage' => 'Dashboard',
            'setting' => false,
        ];
    @endphp
    @include('layouts._breadcrumb',$breadcrumb)


    <div class="container-fluid page__container">
        <div class="row card-group-row">
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center bg-primary">
                                <i class="material-icons text-white icon-18pt">business</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Companies</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center">
                                <i class="material-icons text-white icon-18pt">person_add</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Create New User</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center bg-success">
                                <i class="material-icons text-white icon-18pt">receipt</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Manage Invoices</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center bg-info">
                                <i class="material-icons text-white icon-18pt">monetization_on</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Earnings</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center bg-purple">
                                <i class="material-icons text-white icon-18pt">shop</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Products</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center bg-warning">
                                <i class="material-icons text-white icon-18pt">account_balance</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Account Balance</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center bg-primary">
                                <i class="material-icons text-white icon-18pt">assignment</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Assignments</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 card-group-row__col">
                <div class="card card-group-row__card">
                    <div class="p-2 d-flex flex-row align-items-center">
                        <div class="avatar avatar-xs mr-2">
                            <span class="avatar-title rounded-circle text-center bg-danger">
                                <i class="material-icons text-white icon-18pt">phone</i>
                            </span>
                        </div>
                        <a href="#" class="text-dark">
                            <strong>Calls</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header card-header-large bg-white">
                        <h4 class="card-header__title">Top Companies</h4>
                    </div>

                    <table class="table table-striped border-bottom mb-0">

                        <tr>
                            <td style="width: 40px;">1.</td>
                            <td>
                                <div>
                                    <a href="#" class="text-15pt d-flex align-items-center"><i class="material-icons icon-16pt mr-1">business</i> <strong>Moon Ltd</strong></a>
                                </div>
                                <small class="text-muted">(2 invoices)</small>
                            </td>
                            <td>

                            </td>
                            <td class="text-right" style="width: 100px">
                                3% <i class="material-icons icon-16pt text-success">arrow_upward</i>
                            </td>
                            <td class="text-right" style="width: 60px">
                                <div class="badge badge-success">PAID</div>
                            </td>
                            <td class="text-right" style="width: 80px">
                                $32,124
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 40px;">2.</td>
                            <td>
                                <div>
                                    <a href="#" class="text-15pt d-flex align-items-center"><i class="material-icons icon-16pt mr-1">business</i> <strong>Blue Space Ltd</strong></a>
                                </div>
                                <small class="text-muted">(3 invoices)</small>
                            </td>
                            <td>

                            </td>
                            <td class="text-right" style="width: 100px">
                                5% <i class="material-icons icon-16pt text-success">arrow_upward</i>
                            </td>
                            <td class="text-right" style="width: 60px">
                                <div class="badge badge-success">PAID</div>
                            </td>
                            <td class="text-right" style="width: 80px">
                                $13,593
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 40px;">3.</td>
                            <td>
                                <div>
                                    <a href="#" class="text-15pt d-flex align-items-center"><i class="material-icons icon-16pt mr-1">business</i> <strong>Visual Design</strong></a>
                                </div>
                                <small class="text-muted">(4 invoices)</small>
                            </td>
                            <td>

                            </td>
                            <td class="text-right" style="width: 100px">
                                12% <i class="material-icons icon-16pt text-success">arrow_upward</i>
                            </td>
                            <td class="text-right" style="width: 60px">
                                <div class="badge badge-danger">DUE</div>
                            </td>
                            <td class="text-right" style="width: 80px">
                                $2,229
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 40px;">4.</td>
                            <td>
                                <div>
                                    <a href="#" class="text-15pt d-flex align-items-center"><i class="material-icons icon-16pt mr-1">business</i> <strong>Fox Technologies</strong></a>
                                </div>
                                <small class="text-muted">(5 invoices)</small>
                            </td>
                            <td>

                            </td>
                            <td class="text-right" style="width: 100px">
                                54% <i class="material-icons icon-16pt text-success">arrow_upward</i>
                            </td>
                            <td class="text-right" style="width: 60px">
                                <div class="badge badge-success">PAID</div>
                            </td>
                            <td class="text-right" style="width: 80px">
                                $41,139
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 40px;">5.</td>
                            <td>
                                <div>
                                    <a href="#" class="text-15pt d-flex align-items-center"><i class="material-icons icon-16pt mr-1">business</i> <strong>JMS Ltd</strong></a>
                                </div>
                                <small class="text-muted">(6 invoices)</small>
                            </td>
                            <td>

                            </td>
                            <td class="text-right" style="width: 100px">
                                5% <i class="material-icons icon-16pt text-success">arrow_upward</i>
                            </td>
                            <td class="text-right" style="width: 60px">
                                <div class="badge badge-danger">DUE</div>
                            </td>
                            <td class="text-right" style="width: 80px">
                                $3,002
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 40px;">6.</td>
                            <td>
                                <div>
                                    <a href="#" class="text-15pt d-flex align-items-center"><i class="material-icons icon-16pt mr-1">business</i> <strong>Langston Corp</strong></a>
                                </div>
                                <small class="text-muted">(7 invoices)</small>
                            </td>
                            <td>

                            </td>
                            <td class="text-right" style="width: 100px">
                                9% <i class="material-icons icon-16pt text-success">arrow_upward</i>
                            </td>
                            <td class="text-right" style="width: 60px">
                                <div class="badge badge-success">PAID</div>
                            </td>
                            <td class="text-right" style="width: 80px">
                                $2,884
                            </td>
                        </tr>


                        <tr>
                            <td style="width: 40px;">7.</td>
                            <td>
                                <div>
                                    <a href="#" class="text-15pt d-flex align-items-center"><i class="material-icons icon-16pt mr-1">business</i> <strong>Compare Solutions</strong></a>
                                </div>
                                <small class="text-muted">(8 invoices)</small>
                            </td>
                            <td>

                            </td>
                            <td class="text-right" style="width: 100px">
                                3% <i class="material-icons icon-16pt text-success">arrow_upward</i>
                            </td>
                            <td class="text-right" style="width: 60px">
                                <div class="badge badge-success">PAID</div>
                            </td>
                            <td class="text-right" style="width: 80px">
                                $15,844
                            </td>
                        </tr>


                    </table>

                    <div class="card-footer text-center border-0">
                        <a class="text-muted" href="">View All (391)</a>
                    </div>

                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header card-header-large bg-white d-flex align-items-center">
                        <h4 class="card-header__title flex m-0">Recent Activity</h4>
                        <div data-toggle="flatpickr" data-flatpickr-wrap="true" data-flatpickr-static="true" data-flatpickr-mode="range" data-flatpickr-alt-format="d/m/Y" data-flatpickr-date-format="d/m/Y">
                            <a href="javascript:void(0)" class="link-date" data-toggle>13/03/2018 <span class="text-muted mx-1">to</span> 20/03/2018</a>
                            <input class="d-none" type="hidden" value="13/03/2018 to 20/03/2018" data-input>
                        </div>
                    </div>
                    <div class="card-header card-header-tabs-basic nav" role="tablist">
                        <a href="#activity_all" class="active" data-toggle="tab" role="tab" aria-controls="activity_all" aria-selected="true">All</a>
                        <a href="#activity_purchases" data-toggle="tab" role="tab" aria-controls="activity_purchases" aria-selected="false">Purchases</a>
                        <a href="#activity_emails" data-toggle="tab" role="tab" aria-controls="activity_emails" aria-selected="false">Emails</a>
                        <a href="#activity_quotes" data-toggle="tab" role="tab" aria-controls="activity_quotes" aria-selected="false">Quotes</a>
                    </div>
                    <div class="list-group tab-content list-group-flush">
                        <div class="tab-pane active show fade" id="activity_all">


                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-purple">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>


                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_rsz_1andy-lee-642320-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>


                                        <strong class="text-15pt mr-1">Jenell D. Matney</strong>
                                    </div>
                                    <small class="text-muted">4 days ago</small>
                                </div>
                                <div>$573</div>


                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-teal">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>


                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>


                                        <strong class="text-15pt mr-1">Sherri J. Cardenas</strong>
                                    </div>
                                    <small>Improve spacings on Projects page</small>
                                </div>
                                <small class="text-muted">3 days ago</small>


                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center  bg-light ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  ">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>


                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_jeremy-banks-798787-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>


                                        <strong class="text-15pt mr-1">Joseph S. Ferland</strong>
                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <div>$244</div>


                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center  bg-light ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  ">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>


                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_joao-silas-636453-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>


                                        <strong class="text-15pt mr-1">Bryan K. Davis</strong>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div>$664</div>


                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center  bg-light ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  ">
                                        <i class="material-icons">description</i>
                                    </span>
                                </div>


                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_luke-porter-261779-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>


                                        <strong class="text-15pt mr-1">Kaci M. Langston</strong>
                                    </div>
                                    <small class="text-muted">just now</small>
                                </div>
                                <div>$631</div>


                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="card-footer text-center border-0">
                                <a class="text-muted" href="">View All (54)</a>
                            </div>
                        </div>
                        <div class="tab-pane" id="activity_purchases">

                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-purple">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_rsz_1andy-lee-642320-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Sherri J. Cardenas</strong>

                                    </div>
                                    <small class="text-muted">4 days ago</small>
                                </div>
                                <div>$573</div>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-purple">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Joseph S. Ferland</strong>

                                    </div>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                                <div>$612</div>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-purple">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_jeremy-banks-798787-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Bryan K. Davis</strong>

                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <div>$244</div>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center  bg-light ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle ">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_joao-silas-636453-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Kaci M. Langston</strong>

                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div>$664</div>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center  bg-light ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle ">
                                        <i class="material-icons">monetization_on</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_michael-dam-258165-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1"></strong>

                                    </div>
                                    <small class="text-muted">just now</small>
                                </div>
                                <div>$631</div>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                        </div>
                        <div class="tab-pane" id="activity_emails">

                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-teal">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_rsz_1andy-lee-642320-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Jenell D. Matney</strong>

                                    </div>
                                    <small>Confirmation required for design</small>
                                </div>
                                <small class="text-muted">4 days ago</small>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-teal">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Sherri J. Cardenas</strong>

                                    </div>
                                    <small>Improve spacings on Projects page</small>
                                </div>
                                <small class="text-muted">3 days ago</small>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle  bg-teal">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_jeremy-banks-798787-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Joseph S. Ferland</strong>

                                    </div>
                                    <small>You unlocked a new Badge</small>
                                </div>
                                <small class="text-muted">2 days ago</small>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center  bg-light ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle ">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_joao-silas-636453-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Bryan K. Davis</strong>

                                    </div>
                                    <small>Meeting on Friday</small>
                                </div>
                                <small class="text-muted">1 day ago</small>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex align-items-center  bg-light ">
                                <div class="avatar avatar-xs mr-3">
                                    <span class="avatar-title rounded-circle ">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>

                                <div class="flex">
                                    <div class="d-flex align-items-middle">
                                        <div class="avatar avatar-xxs mr-1">
                                            <img src="assets/images/256_luke-porter-261779-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
                                        </div>
                                        <strong class="text-15pt mr-1">Kaci M. Langston</strong>

                                    </div>
                                    <small>Design a new Brochure</small>
                                </div>
                                <small class="text-muted">just now</small>
                                <i class="material-icons icon-muted ml-3">arrow_forward</i>
                            </div>

                        </div>
                        <div class="tab-pane" id="activity_quotes"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- // END drawer-layout__content -->
@endsection
