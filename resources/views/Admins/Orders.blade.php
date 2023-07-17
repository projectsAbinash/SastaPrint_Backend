@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Orders' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if ($view == 'list')
                <div class="card">
                    <div class="row m-3">
                        <div class="col">
                            <h5 class="card-header">Orders List</h5>
                        </div>
                        <div class="col mt-1">
                            <form action="{{ route('Admin.orders', ['status' => 'search']) }}">

                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="basic-addon-search31"><i
                                            class="bx bx-search"></i></span>
                                    <input class="form-control @error('search') is-invalid @enderror" type="text"
                                        value="{{ request()->input('search') }}" id="search" name="search"
                                        placeholder="#SSTPRNT03927467" autofocus />
                                </div>


                            </form>
                        </div>
                        <div class="col">
                            <div class="me-3 d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('Admin.orders', ['status' => 'All']) }}"><button type="button"
                                            class="btn btn-success m-1">All</button></a>
                                    <a href="{{ route('Admin.orders', ['status' => 'placed']) }}"><button type="button"
                                            class="btn m-1 text-white" style="background-color: coral">Placed</button></a>
                                            <a href="{{ route('Admin.orders', ['status' => 'printed']) }}"><button type="button"
                                                class="btn btn-info m-1">Printed</button></a>
                                    <a href="{{ route('Admin.orders', ['status' => 'Dispatched']) }}"><button type="button"
                                            class="btn btn-warning m-1">Dispatched</button></a>
                                    <a href="{{ route('Admin.orders', ['status' => 'Delivered']) }}"><button type="button"
                                            class="btn btn-success m-1">Delivered</button></a>
                                    <a href="{{ route('Admin.orders', ['status' => 'cancelled']) }}"><button type="button"
                                            class="btn btn-secondary m-1">Cancelled</button></a>
                                    <a href="{{ route('Admin.orders', ['status' => 'Unpaid']) }}"><button type="button"
                                            class="btn btn-danger m-1">Unpaid</button></a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Customer name</th>
                                    <th class="text-center">Order Id</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($data as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            {{ $i }}
                                        </td>
                                        <td class="text-center">
                                            <img style="max-height: 45px;"
                                                src="{{ url('AdminAssets/Source/assets/img/pdf.jpg') }}" alt="Avatar" />
                                        </td>
                                        <td class="text-center">
                                            <a
                                                href="{{ route('CustomeDetails', ['id' => $item->Getuser->id]) }}">{{ $item->Getuser->name }}</a>
                                        </td>
                                        <td class="text-center fw-bold">
                                            #{{ $item->order_id }}
                                        </td>
                                        <td class="text-center fw-bold">
                                            ₹{{ $item->amount }}

                                        </td>

                                        <td class="text-center">
                                            @if ($item->status == 'placed')
                                                <span class="badge bg-label-info me-1">Placed</span>
                                            @elseif($item->status == 'dispatched')
                                                <span class="badge bg-label-warning me-1">Dispatched</span>
                                            @elseif($item->status == 'deliverd')
                                                <span class="badge bg-label-success me-1">Delivered</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('orders.details', ['id' => $item->id]) }}"> <i
                                                    class="fa-regular fa-eye text-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View And Manage Order"
                                                    style="font-size:20px;"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center m-4">
                            {!! $data->links() !!}
                        </div>
                    </div>
                </div>
            @elseif($view == 'details')
                <div class="row">
                    <div class="col-md-12">

                        <div class="card mb-4">
                            <h5 class="card-header">Manage Order</h5>
                            <!-- Account -->

                            <hr class="my-0" />
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form id="formAccountSettings" method="POST" onsubmit="return false">

                                    <div class="">
                                        <div class="row">
                                            <div class="col">
                                                <table class="table table-bordered mb-4">

                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Date
                                                            </td>
                                                            <td> <strong>{{ $data->created_at->format('d-m-Y') }}</strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Order ID
                                                            </td>
                                                            <td> <strong>{{ $data->order_id }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Customer Name
                                                            </td>
                                                            <td> <a
                                                                    href="{{ route('CustomeDetails', ['id' => $data->Getuser->id]) }}"><strong>{{ $data->Getuser->name }}</strong></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Customer Phone
                                                            </td>
                                                            <td> <strong>{{ $data->Getuser->phone }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Address
                                                            </td>
                                                            @php
                                                                $string_aaddress = json_decode($data->full_address, true);
                                                            @endphp

                                                            <td> <strong> {{ $string_aaddress['landmark'] }},<br>
                                                                    {{ $string_aaddress['address_2'] }},<br>
                                                                    {{ $string_aaddress['address_2'] }},<br>
                                                                    {{ $string_aaddress['city'] }},<br>
                                                                    {{ $string_aaddress['state'] }},{{ $string_aaddress['pincode'] }},<br>
                                                                    {{ $string_aaddress['alternate_number'] }}</strong>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col">
                                                <table class="table table-bordered">

                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Payment Method
                                                            </td>
                                                            <td> <strong>RazorPay</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Status
                                                            </td>
                                                            <td> <span
                                                                    class="badge bg-label-info me-1">{{ $data->status }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Amount (inc: Delivery Charge)
                                                            </td>
                                                            <td> <strong>₹{{ $data->amount }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Delivery Charges
                                                            </td>
                                                            <td> <strong>₹{{ $data->delivery_charge }}</strong></td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                Assigned Employee
                                                            </td>
                                                            <td>
                                                                @if ($data->assigned_emp != null)
                                                                            {{ $data->Getemp->name }}
                                                                        @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Tracking Link
                                                            </td>
                                                            <td>
                                                                @if ($data->tracking_link == null)
                                                                    <strong>Not Dispatched Yet</strong>
                                                                @else
                                                                    <a href="{{ $data->tracking_link }}"><button
                                                                            type="button" class="btn btn-success"><i
                                                                                class="fas fa-shipping-fast"></i>&nbsp;Track</button></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                    <hr class="mt-2" />

                                    <div class="card">
                                        <h5 class="card-header">Order Items </h5>
                                        <div class="table table-responsive">
                                            <table class="table  table-bordered">
                                                <thead class="table-primary">
                                                    <tr>

                                                        <th>Doc Name</th>

                                                        <th>Instructions</th>
                                                        <th>Total Pages</th>

                                                        <th>Print Config</th>
                                                        <th>Page Config</th>
                                                        <th>Binding Config</th>
                                                        <th>Total Copies</th>
                                                        <th>Download</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0" id="part_body">
                                                    @foreach ($data->Userdocs as $items)
                                                        <tr class="item particularrow">
                                                            <td><strong>{{ $items->doc_name }}</strong></td>

                                                            <td><strong>{{ $items->instructions }}</strong></td>
                                                            <td><strong>{{ $items->total_pages }}</strong></td>
                                                            <td><strong>{{ ucwords(str_replace('_', ' ', $items->print_config)) }}</strong>
                                                            </td>
                                                            <td><strong>{{ ucwords(str_replace('_', ' ', $items->page_config)) }}</strong>
                                                            </td>
                                                            <td><strong>{{ ucwords(str_replace('_', ' ', $items->binding_config)) }}</strong>
                                                            </td>
                                                            <td><strong>{{ $items->copies_count }}</strong></td>
                                                            <td class="text-center"> <a
                                                                    href="{{ route('orders.doc.download', ['id' => $items->id]) }}"><button
                                                                        type="button" id="addmore"
                                                                        class="btn btn-icon btn-success">
                                                                        <i class="fa-solid fa-download"></i>
                                                                    </button></a></td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                                <div class="d-flex justify-content-end gap-2">

                                    <a href="{{ route('DashboardIndex') }}"> <button type="button"
                                            class="btn btn-secondary">Back</button></a>

                                    @if ($data->status == 'placed')
                                        <button type="button" class="btn btn-success" id="accept"
                                            onclick="accept($(this).attr('orderid'))"
                                            orderid={{ $data->order_id }}>Accept</button>


                                    @elseif($data->status == 'processing')
                                        <button type="button" class="btn btn-success"
                                            onclick="printed($(this).attr('orderid'))" id="printed"
                                            orderid={{ $data->order_id }}>Click To Update
                                            Printed Status</button>

                                    @elseif($data->status == 'printed')
                                    <button type="button" class="btn btn-success"
                                    onclick="shipped($(this).attr('orderid'))" id="shipped"
                                    orderid={{ $data->order_id }}>Click To Update
                                    Dispatched Status</button>

                                    @elseif($data->status == 'dispatched')
                                    <button type="button" class="btn btn-success"
                                    onclick="deliverd($(this).attr('orderid'))" id="delivered"
                                    orderid={{ $data->order_id }}>Click To Update Staus To Delivered</button>
                                    @endif
                                </div>

                                    {{-- Order Activity Section --}}
                                    <div class="conatiner">
                                        <h6 class="">Order Activities</h6>
                                        <div class="table-responsive text-nowrap">
                                            <table class="table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Log</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($data['activity'] as $item)
                                                        <tr>
                                                            <td><strong>{{ $i++ }}</strong></td>
                                                            <td>{{ $item->log_message }}</td>

                                                            <td><span
                                                                    class="badge bg-label-primary me-1">{{ $item->created_at->format('d-M-Y, h:i:s A') }}</span>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                            <!-- /Account -->
                        </div>

                    </div>
                </div>
                <script>
                    function accept(orderid) {
                        swal({
                                title: "Are you sure?",
                                text: "You Want To Accept This Order!",
                                icon: "info",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
    
                                if (willDelete) {
                                    $.post("{{ route('admin.order.accept') }}", {
                                            order_id: orderid,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        function(data, status) {
                                            if (data.status == 'true') {
                                                swal("Good job!", data.message, "success").then((value) => {
                                                    location.reload();
                                                });
    
                                            } else
                                                swal("Invalid", data.message, "error");
                                        },
                                        "json")
                                }
    
                            });
                    }
    
    
                    function shipped(orderid) {
                        swal("Kindly Provide Traking Link To Us", {
                                content: "input",
                            })
                            .then((value) => {
                                $.post("{{ route('admin.order.shipped') }}", {
                                        order_id: orderid,
                                        link: value,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    function(data, status) {
                                        if (data.status == 'true') {
                                            swal("Good job!", data.message, "success").then((value) => {
                                                location.reload();
                                            });
    
                                        } else
                                            swal("Invalid", data.message, "error");
                                    },
                                    "json")
                            });
                    }
    
    
    
                    function deliverd(orderid) {
                        swal({
                                title: "Are you sure?",
                                text: "You Want To Set Deliverd Status For This Order!",
                                icon: "info",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
    
                                if (willDelete) {
                                    $.post("{{ route('admin.order.deliverd') }}", {
                                            order_id: orderid,
                                            _token: '{{ csrf_token() }}'
                                        },
                                        function(data, status) {
                                            if (data.status == 'true') {
                                                swal("Good job!", data.message, "success").then((value) => {
                                                    location.reload();
                                                });
    
                                            } else
                                                swal("Invalid", data.message, "error");
                                        },
                                        "json")
                                }
    
                            });
                    }
                    function printed(orderid) {
                        swal("Kindly Provide The Number Of Waste Papers", {
                                content: "input",
                            })
                            .then((value) => {
                                $.post("{{ route('admin.order.printed') }}", {
                                        order_id: orderid,
                                        waste_paper: value,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    function(data, status) {
                                        if (data.status == 'true') {
                                            swal("Good job!", data.message, "success").then((value) => {
                                                location.reload();
                                            });
    
                                        } else
                                            swal("Invalid", data.message, "error");
                                    },
                                    "json")
                            });
                    }
    
                </script>
            @endif
        </div>
    </div>
@endsection
