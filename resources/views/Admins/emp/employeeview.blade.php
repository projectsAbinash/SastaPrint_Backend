@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Employee Lists' }}
@endsection
@section('main-container')
@if($view == 'list')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <h5 class="card-header">Employee Details</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Pictuer</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($emp as $data)
                                <tr>
                                    <td class="text-center"> <img style="max-height: 45px;" src="{{ $data->Eprofile->profile_pic }}" alt="Avatar"
                                            class="rounded-circle" />
                                    </td>
                                    <td class="text-center fw-bold">{{ $data->name }}</td>
                                    <td class="text-center">
                                        {{ $data->phone }}
                                    </td>
                                    <td class="text-center">
                                        @if($data->phone_verified_at =! null)
                                        <span class="badge bg-label-success me-1">Verified</span>
                                       @else
                                       <span class="badge bg-label-success me-1">Unverified</span>
                                        @endif
                                    </td>
                                    {{-- <td class="text-center">
                                        <i class="fa-solid fa-ban text-danger"></i>
                                    </td> --}}
                                    <td class="text-center">
                                        <a href="{{ route('admin.emp.get',(['id' => $data->id])) }}">
                                        <i class="bx bx-line-chart text-success"  style="font-size:23px;"></i>
                                    </a>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @elseif($view == 'details')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
           
        </div>
    </div>
    @endif
@endsection
