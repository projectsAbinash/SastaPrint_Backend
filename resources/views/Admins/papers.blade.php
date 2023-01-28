@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Manage Papers' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="card">
                <h5 class="card-header">Papers Management</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Order ID</th>

                                    <th>Paper Quantity</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th colspan="2" class="text-center">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getrow as $item)
                                    <tr>
                                        <td>1</td>
                                        <td><a href="#">
                                            </a>{{ $item->Getemp->name }}</td>
                                        <td>{{ $item->order_id }}</td>
                                        <td><strong>{{ $item->quantity }}</strong></td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-label-info me-1">Pending</span>
                                            @elseif($item->status == 'approved')
                                                <span class="badge bg-label-success me-1">Approved</span>
                                            @elseif($item->status == 'rejected')
                                                <span class="badge bg-label-danger me-1">Rejected</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-danger text-center fs-5">
                                            <a href="{{ route('Admin.employee.rejectpaper',(['id' => $item->id])) }}" onclick="return confirm('Are you sure you want to Reject this Request')"><i class="uil uil-ban text-danger"></i></a>
                                        </td>
                                        <td class="text-success text-center fs-5">
                                            <i class="uil uil-check-circle" id="accept"
                                                onclick="check($(this).attr('orderid'))" orderid={{ $item->order_id }}></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function check(orderid) {
            console.log(orderid);
            swal("Enter MPIN To Accept This Request:", {
                    content: "input",
                })
                .then((value) => {

                    $.post("{{ route('Admin.employee.Papersapprove') }}", {
                            order_id: orderid,
                            mpin: value,
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
        };
    </script>
@endsection
