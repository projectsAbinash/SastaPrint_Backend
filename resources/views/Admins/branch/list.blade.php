@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Branch List' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="row">
                    <div class="col">
                        <h5 class="card-header">List Of Branch</h5>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <a href="{{ route('BranchCreate') }}"><button class="btn btn-primary m-3">Create New</button></a>
                    </div>
                </div>
                @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                <div class="table table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Created AT</th>
                                <th class="text-center">Action</th>
                               
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                
$i = 1;
                            @endphp
                           @foreach ($data as $item)
                            
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-center fw-bold">{{ $item->name }}</td>
                                   
                                    <td class="text-center">
                                        {{ json_decode($item->address,true)['contact_number'] }}
                                     </td>
                                    <td class="text-center">
                                       {{ $item->created_at->format('d-m-Y') }}
                                    </td>

                                    <td class="text-center">
                                        <i class="uil uil-edit fs-5 text-success"></i>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="p-3">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
