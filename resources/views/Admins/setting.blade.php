@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Area Control' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Set And Control Area</h5>
                        <!-- Account -->

                        <hr class="my-0" />
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br />
                                    @endforeach
                                </div>
                            @endif
                            <form id="formAccountSettings" method="POST" action="{{ route('admin.setaddress.post') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="Pin" class="form-label">Pin Code</label>
                                        <input class="form-control @error('pin') is-invalid @enderror" type="number"
                                            value="{{ old('pin') }}" id="pin" name="pin"
                                            placeholder="Enter area Pin Code" autofocus />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="State" class="form-label">State</label>
                                        <input class="form-control" type="text"
                                            id="state" name="state" disabled />
                                    </div>


                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2" id="pnsbmt" disabled>Add</button>
                                    <a href="{{ url()->previous() }}"> <button type="button"
                                            class="btn btn-outline-secondary">Cancel</button></a>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>

                </div>
            </div>
            {{-- table --}}

            <div class="row">
                <div class="col">
                    <div class="card">
                        <h5 class="card-header">Active Area Pin Codes</h5>
                        <div class="table table">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pin Code</th>
                                        <th>State</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>1</td>
                                        <td>732138</td>
                                        <td>West Bengal</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>732138</td>
                                        <td>West Bengal</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>732138</td>
                                        <td>West Bengal</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <h5 class="card-header">Top Requested Pin Code</h5>
                        <div class="table table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Pin Code</th>
                                        <th class="text-center">State</th>
                                        <th class="text-center">Count</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">732138</td>
                                        <td class="text-center">Bihar</td>
                                        <td class="fw-bold text-center">56</td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

            <script>
                $(document).ready(function() {
                   
                    $('#pin').on('keyup', function() {
                        if ($(this).val().length == 6) {
                           
                            $.post("http://127.0.0.1:8000/api/profile/Address/Fetch", {
                                    pincode: $("#pin").val(),
                                },
                                function(data, status) {
                                    if (status === "success") {
                                        if (data.status == 'true') {
                                            console.log(data);
                                            $("#state").val(data.state);
                                            $("#pnsbmt").prop('disabled',false);
                                        }else{
                                            console.log(data);
                                            $("#pnsbmt").prop('disabled',true);
                                            $("#state").val("");
                                            alert("Invalid Pin Code");
                                        }
                                    }
                                },
                                "json")

                        }else{
                            $("#pnsbmt").prop('disabled',true);
                        }
                    });

                });
            </script>
        </div>
    </div>
@endsection
