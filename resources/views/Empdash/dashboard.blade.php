@extends('Empdash.Layouts.Main')
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
                                    style="background-color: #FFA50033">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/sitemap.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Total Orders</span>
                            <h3 class="card-title text-nowrap mb-1">0</h3>
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
                            <h3 class="card-title text-nowrap mb-1">₹0</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>


                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color:#FF141433;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/notebooks.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Available Papers</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $dash['available_papers'] }}</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color:#0DD2E033;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/copy.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Used Paper</span>
                            <h3 class="card-title text-nowrap mb-1">0</h3>
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
                            <span>Available Orders</span>
                            <h3 class="card-title text-nowrap mb-1">0</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">

                                <div class="avatar card d-flex aligns-items-center justify-content-center p-2"
                                    style="background-color:#3CB97133;">
                                    <img src="{{ url('AdminAssets/Source/assets/img/icons/unicons/print.svg') }}"
                                        alt="chart success" class="rounded" />
                                </div>

                            </div>
                            <span>Ongoing Orders</span>
                            <h3 class="card-title text-nowrap mb-1">0</h3>
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
                            <h3 class="card-title text-nowrap mb-1">0</h3>
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
                            <h3 class="card-title text-nowrap mb-1">0</h3>
                            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +100.00%</small>
                        </div>
                    </div>
                </div>

                

            </div>
        </div>


    </div>


@endsection
