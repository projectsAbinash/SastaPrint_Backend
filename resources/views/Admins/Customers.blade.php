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
                                    <th colspan="2" class="text-center">Actions</th>
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
                                        <td class="text-center">
                                            <i class="fa-solid fa-ban text-danger"></i>
                                        </td>
                                        <td class="text-center">
                                            <i class="fa-regular fa-eye text-primary"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
