@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Dashboard' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color: #eefbe7;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/user.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Total Customers</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $data['user']->count() }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color: #FFA50033">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/sitemap.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Total Orders</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $data['order']->count() }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color:#FF149333;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/rupee-sign.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Total Revenue</span>
                            <h3 class="card-title text-nowrap mb-1">₹{{ $data['order']->where('status','delivered')->sum('amount') }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color:#1E90FF33;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/clock.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Awaiting Orders</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $data['order']->where('status','placed')->count() }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color: #8A2BE233;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/truck.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Shipped</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $data['order']->where('status','shipped')->count() }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color:#2BE28D33;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/parcel.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Delivered</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $data['order']->where('status','delivered')->count() }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color:#FF211433;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/desktop.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Employees</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $data['employee'] }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection
