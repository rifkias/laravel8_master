@extends('layouts.main')
@section('content')
<div class="mdk-drawer-layout__content page">
    @php
        $breadcrumb = [
            'firstPage' => 'Dashboard',
            'pages' => [
                'users' => '/dashboard/users',
                'Profile' => '/dashboard/users/profile'
            ],
            'nested' => true,
            'currentPage' => 'Profile',
            'setting' => false,
        ];
    @endphp
    @include('layouts._breadcrumb',$breadcrumb)

    <div class="container-fluid page__container">
        <form action="/dashboard/profile/edit" method="POST">
            @csrf
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">Basic Information</strong></p>
                    <p class="text-muted">Edit your account details and settings.</p>
                </div>
                <div class="col-lg-8 card-form__body card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" required type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Your First Name" value="{{Auth::user()->name ?: old('name')}}">
                                @error('name')
                                <small class="invalid-feedback">{{$message}}.</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" placeholder="exmaple@email.com" disabled value="{{Auth::user()->email ?: old('email')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">Update Your Password</strong></p>
                    <p class="text-muted">Change your password.</p>
                </div>
                <div class="col-lg-8 card-form__body card-body">
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input style="width: 270px;" id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Old password" name="old_password">
                        @error('old_password')
                        <small class="invalid-feedback">{{$message}}.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input style="width: 270px;" id="password" placeholder="New Password" type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <small class="invalid-feedback">{{$message}}.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input style="width: 270px;" id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password">
                        @error('password_confirmation')
                        <small class="invalid-feedback">{{$message}}.</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">Profile Settings</strong></p>
                    <p class="text-muted">Update your public profile with relevant and meaningful information.</p>
                </div>
                <div class="col-lg-8 card-form__body card-body">
                    <div class="form-group">
                        <label>Avatar</label>
                        <div class="dz-clickable media align-items-center" data-toggle="dropzone" data-dropzone-url="http://" data-dropzone-clickable=".dz-clickable" data-dropzone-files='["assets/images/account-add-photo.svg"]'>
                            <div class="dz-preview dz-file-preview dz-clickable mr-3">
                                <div class="avatar" style="width: 80px; height: 80px;">
                                    <img src="assets/images/account-add-photo.svg" class="avatar-img rounded" alt="..." data-dz-thumbnail>
                                </div>
                            </div>
                            <div class="media-body">
                                <button class="btn btn-sm btn-primary dz-clickable">Choose photo</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc2">Description</label>
                        <textarea id="desc2" rows="4" class="form-control" placeholder="Description ..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="social1">Social links</label>
                        <div class="input-group input-group-merge mb-2" style="width: 270px;">
                            <input id="social1" type="text" class="form-control form-control-prepended" placeholder="Facebook">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-facebook"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group input-group-merge mb-2" style="width: 270px;">
                            <input id="social2" type="text" class="form-control form-control-prepended" placeholder="Twitter">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-twitter"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group input-group-merge mb-2" style="width: 270px;">
                            <input id="social3" type="text" class="form-control form-control-prepended" placeholder="Instagram">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fab fa-instagram"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customCheck1">Available for freelance?</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                            <label class="custom-control-label" for="customCheck1">Yes, show me as available for freelance!</label>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="text-right mb-5">
            <button type="submit" href="" class="btn btn-success">Save</button>
        </div>
    </form>
    </div>
</div>
@endsection
