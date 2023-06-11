@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Create Employee Panels' }}
@endsection
@section('main-container')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="content-wrapper">
        <form action="{{ route('Admin.employee.register') }}" method="POST" enctype="multipart/form-data">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card mb-4">
                    <h5 class="card-header">Create Employees</h5>
                    <!-- Account -->

                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ url('AdminAssets/Source/assets/img/pngwing.com.png') }}" alt="user-avatar"
                                class="d-block rounded" height="100" width="100" id="imgPreview" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" name="profile" />
                                </label>

                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-0" />
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br />
                                @endforeach
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Full Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    value="{{ old('name') }}" id="firstName" name="name" autofocus />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="Phone" class="form-label">Phone Number</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="number"
                                    value="{{ old('phone') }}" id="Phone" name="phone" autofocus />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="Aadhar" class="form-label">Aadhar Number</label>
                                <input class="form-control @error('aadhar') is-invalid @enderror" type="text"
                                    value="{{ old('aadhar') }}" id="iban" name="aadhar" autofocus />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="Password" class="form-label">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="text"
                                    id="iban" name="password" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="fside" class="form-label">Aadhar Front Side</label>
                                <input class="form-control dropify" type="file" id="fside" name="faadhar"
                                    autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bside" class="form-label">Aadhar Back Side</label>
                                <input class="form-control dropify" type="file" id="bside" name="baadhar"
                                    autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="exampleFormControlSelect1" class="form-label">Select Branch</label>
                                <select class="form-select" name="branch" id="exampleFormControlSelect1"
                                    aria-label="Default select example">
                                    <option selected>Choose Branch</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Register</button>
                            <a href="{{ route('DashboardIndex') }}"><button type="button"
                                    class="btn btn-outline-secondary">Cancel</button></a>
                        </div>
        </form>
    </div>
    <!-- /Account -->
    </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"
        integrity="sha512-hJsxoiLoVRkwHNvA5alz/GVA+eWtVxdQ48iy4sFRQLpDrBPn6BFZeUcW4R4kU+Rj2ljM9wHwekwVtsb0RY/46Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(() => {
            $("#upload").change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $("#imgPreview")
                            .attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
        $('.dropify').dropify({
            messages: {
                'default': 'Click To Upload',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
    </script>



@endsection
