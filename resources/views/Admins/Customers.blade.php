@extends('Admins.Layouts.Main')
@section('title')
    {{ 'All Customers' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if ($view == 'List')
                <div class="card">
                    <h5 class="card-header">Customers rows</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Pictuer</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">


                                @foreach ($list as $lists)
                                    <tr>
                                        <td class="text-center"> <img style="max-height: 45px;"
                                                src="{{ $lists->UserExtra->pic }}" alt="Avatar" class="rounded-circle" />
                                        </td>
                                        <td class="text-center fw-bold">{{ $lists->name }}</td>
                                        <td class="text-center">

                                            {{ $lists->email }}


                                        </td>
                                        <td class="text-center">
                                            @if ($lists->phone_verified_at == null)
                                                <span class="badge bg-label-warning me-1">Unverified</span>
                                            @else
                                                <span class="badge bg-label-success me-1">Verified</span>
                                            @endif
                                        </td>
                                        {{-- <td class="text-center">
                                            <i class="fa-solid fa-ban text-danger"></i>
                                        </td> --}}
                                        <td class="text-center">
                                            <a href="{{ route('CustomeDetails', ['id' => $lists->id]) }}">
                                                <i class="fa-regular fa-eye text-primary" style="font-size:20px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif ($view == 'details')
                <div class="row">
                    <div class="col-md-12">
                        {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                        Account</a>
                                </li>
                               
                            </ul> --}}
                        <div class="card mb-4">
                            <h5 class="card-header">Profile Details</h5>
                            <!-- Account -->
                            <div class="card-body">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ $data->UserExtra->pic }}" alt="user-avatar" class="d-block rounded"
                                        height="100" width="100" id="uploadedAvatar" />
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="This Feture Will Available On Next Update">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input" hidden
                                                accept="image/png, image/jpeg" disabled />
                                        </label>
                                        <button type="button" class="btn btn-outline-secondary btn-info mb-4"
                                            data-bs-toggle="modal" data-bs-target="#backDropModal">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">View Address</span>
                                        </button>








                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form id="formAccountSettings" method="POST" onsubmit="return false">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="firstName" class="form-label">Full Name</label>
                                            <input class="form-control" type="text" value="{{ $data->name }}"
                                                id="firstName" name="Name" value="John" autofocus readonly />
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input class="form-control" type="text" id="email" name="email"
                                                value="{{ $data->email }}" placeholder="john.doe@example.com" readonly />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="phoneNumber">Phone Number</label>
                                            <div class="input-group input-group-merge">
                                                <input class="form-control" type="text" id="phoneNumber" name="phone"
                                                    value="{{ $data->phone }}" placeholder="9102938182" readonly />
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="organization" class="form-label">Registered At</label>
                                            <input type="text" class="form-control" id="organization" name="organization"
                                                value="{{ $data->created_at->format('d-m-Y') }}" readonly />
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="Gender" class="form-label">Gender</label>
                                            <input type="text" class="form-control"
                                                value="@if ($data->UserExtra->gender == null) Not Set @else {{ $data->UserExtra->gender }} @endif"
                                                id="Gender" name="address" placeholder="Gender" readonly />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="dob" class="form-label">Date Of Birth</label>
                                            <input class="form-control" type="text"
                                                value="@if ($data->UserExtra->dob == null) Not Set @else {{ $data->UserExtra->dob }} @endif"
                                                id="dob" name="dob" placeholder="dd/mm/YY" readonly />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="Student" class="form-label">Student</label>
                                            <input type="text" class="form-control"
                                                value="@if ($data->UserExtra->student == null) Not Set @elseif($data->UserExtra->student == 'true') Yes @else No @endif"
                                                id="Student" name="Student" placeholder="Yes or No" readonly />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="Occupation" class="form-label">Occupation</label>
                                            <input type="text" class="form-control"
                                                value="@if ($data->UserExtra->occupation == null) Not Set @else {{ $data->UserExtra->occupation }} @endif"
                                                id="Occupation" name="Occupation" placeholder="Yes or No" readonly />
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="Collage" class="form-label">Collage name</label>
                                            <input type="text" class="form-control"
                                                value="@if ($data->UserExtra->Collage_Name == null) Not Set @else {{ $data->UserExtra->Collage_Name }} @endif"
                                                id="Collage" name="Collage" placeholder="Yes or No" readonly />
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="Course" class="form-label">Course</label>
                                            <input type="text" class="form-control"
                                                value="@if ($data->UserExtra->Course == null) Not Set @else {{ $data->UserExtra->Course }} @endif"
                                                id="Course" name="Course" placeholder="Yes or No" readonly />
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="Year" class="form-label">Year</label>
                                            <input type="text" class="form-control"
                                                value="@if ($data->UserExtra->Year == null) Not Set @else {{ $data->UserExtra->Year }} @endif"
                                                id="Year" name="Year" placeholder="Yes or No" readonly />
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="Semester" class="form-label">Semester</label>
                                            <input type="text" class="form-control"
                                                value="@if ($data->UserExtra->Semester == null) Not Set @else {{ $data->UserExtra->Semester }} @endif"
                                                id="Semester" name="Semester" placeholder="Yes or No" readonly />
                                        </div>

                                    </div>
                                    {{-- <div class="mt-2">
                                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                    </div> --}}
                                </form>
                            </div>
                            <!-- /Account -->
                        </div>
                        <div class="card">
                            <h5 class="card-header">Deactive Account</h5>
                            <div class="card-body">

                                @if ($data->UserBlocked()->exists())
                                    <div class="mb-3 col-12 mb-0">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to Activation
                                                This
                                                account?</h6>
                                            <p class="mb-0">Once you Active This account, They Can Login Again</p>
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="accountActivation"
                                            id="accountActivation" required />

                                        <label class="form-check-label" for="accountActivation">I confirm account
                                            Activation</label>
                                    </div>
                                    <a href="{{ route('Customerblocked', ['Action' => 'Active', 'id' => $data->id]) }}">
                                        <button type="submit" class="btn btn-success deactivate-account">Activate
                                            Account</button></a>
                                @else
                                    <div class="mb-3 col-12 mb-0">
                                        <div class="alert alert-warning">
                                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to Deactivation
                                                This
                                                account?</h6>
                                            <p class="mb-0">Once you Deactive This account, They Can't Login Again</p>
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">

                                        <input class="form-check-input" type="checkbox" name="accountActivation"
                                            id="accountActivation" required />
                                        <label class="form-check-label" for="accountActivation">I confirm account
                                            deactivation</label>
                                    </div>
                                    <a href="{{ route('Customerblocked', ['Action' => 'Deactive', 'id' => $data->id]) }}">
                                        <button type="submit" class="btn btn-danger deactivate-account">Deactivate
                                            Account</button></a>
                                @endif
                                {{-- start modal --}}
                                <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="backDropModalTitle">User Address</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row row-cols-2">
                                                    @foreach ($data->UserAddress as $list)
                                                        <div class="col">
                                                            <div
                                                                class="card shadow-none bg-transparent border border-primary mb-3">
                                                                <div class="card-body">
                                                                    <h5 class="card-title mb-0">{{ $data->name }}</h5>
                                                                    <p class="card-text">
                                                                        <br>
                                                                        {{ $list->Landmark }},<br>
                                                                        {{ $list->Address_1 }},<br>
                                                                        {{ $list->Address_2 }},<br>
                                                                        {{ $list->City }},<br>
                                                                        {{ $list->State }},{{ $list->PinCode }},
                                                                        <hr>
                                                                        </hr>
                                                                        <label for="">Phone Number</label>
                                                                        {{ $data->phone }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- end modal --}}
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        @endif


    </div>
@endsection
