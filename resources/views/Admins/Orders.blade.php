@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Orders' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if($view == 'list')
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

                            <tr>
                                <td class="text-center">
                                    1
                                </td>
                                <td class="text-center">
                                    <img style="max-height: 45px;" src="{{ url('AdminAssets/Source/assets/img/pdf.jpg') }}"
                                        alt="Avatar" />
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('CustomeDetails', ['id' => '1']) }}">Sudipto Bain</a>
                                </td>
                                <td class="text-center fw-bold">
                                    #SSTPRNT0912555
                                </td>
                                <td class="text-center fw-bold">
                                    ₹1500
                                      
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-warning me-1">Pending</span>
                                      
                                </td>
                                <td class="text-center">
                                   <a href="{{ route('orders.details',(['id'=>1])) }}"> <i class="fa-regular fa-eye text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="View And Manage Order" style="font-size:20px;"></i></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @elseif($view == 'details')
        
        
        @endif



    </div>
@endsection
