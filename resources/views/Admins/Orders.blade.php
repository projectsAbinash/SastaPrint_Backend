@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Orders' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if ($view == 'list')
                <div class="card">
                    <h5 class="card-header">Orders List</h5>
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
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="text-center">
                                            1
                                        </td>
                                        <td class="text-center">
                                            <img style="max-height: 45px;"
                                                src="{{ url('AdminAssets/Source/assets/img/pdf.jpg') }}" alt="Avatar" />
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('CustomeDetails', ['id' => $item->Getuser->id]) }}">{{ $item->Getuser->name }}</a>
                                        </td>
                                        <td class="text-center fw-bold">
                                            #{{ $item->order_id }}
                                        </td>
                                        <td class="text-center fw-bold">
                                            ₹{{ $item->amount }}

                                        </td>
                                       
                                        <td class="text-center">
                                            @if($item->status == 'placed')
                                            <span class="badge bg-label-info me-1">Placed</span>
                                            @elseif($item->status == 'shipped')
                                            <span class="badge bg-label-warning me-1">Shippted</span>
                                            @elseif($item->status == 'deliverd')
                                            <span class="badge bg-label-success me-1">Delivred</span>

                                            @else
                                            <span class="badge bg-label-danger me-1">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('orders.details', ['id' => 1]) }}"> <i
                                                    class="fa-regular fa-eye text-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View And Manage Order"
                                                    style="font-size:20px;"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    @elseif($view == 'details')
        @endif



    </div>
@endsection
