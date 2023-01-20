@extends('Empdash.Layouts.Main')
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
            <div class="card" style="background-color: #696cff33;">

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 style="color:#696cff;">Available Papers</h5>
                            <h4 class="fw-bold" style="color:#696cff;"><img
                                    src="{{ url('AdminAssets/Source/assets/img/icons/unicons/wallet.svg') }}"
                                    alt="chart success" style="height: 30px;" class="rounded" />
                                {{ $data->available_papers }}</h4>
                        </div>
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#basicModal"
                                    class="btn btn-primary mt-4"><i class="uil uil-plus"></i> Request For
                                    Papers</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <h5 class="card-header">Papers Request History</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Order ID</th>
                                    <th>Paper Quantity</th>
                                    <th>Date</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $id = 0;
                                @endphp
                                @foreach ($data->PaperRequ as $item)
                                    @php
                                        $id++;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $id }}
                                        </td>
                                        <td>
                                            {{ $item->order_id }}
                                        </td>
                                        <td class="fw-bold">
                                            {{ $item->quantity }}
                                        </td>
                                        <td>
                                            {{ $item->created_at->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-label-info me-1">Pending</span>
                                            @elseif($item->status == 'approved')
                                                <span class="badge bg-label-success me-1">Approved</span>
                                            @elseif($item->status == 'rejected')
                                                <span class="badge bg-label-danger me-1">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            <!-- Modal -->
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Request For Papers</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <form action="{{ route('mngpaper.request') }}" method="post">
                                        @csrf
                                        <label for="nameBasic" class="form-label">Quantity</label>

                                        <h5 class="card-header">Basic Radio</h5>
                                        
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Request</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
