@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Create Employee Panels' }}
@endsection
@section('main-container')

    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/css/pages/page-auth.css">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="" class="app-brand-link gap-2">

                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">OTP Verification 💬</h4>
                    <p class="text-start mb-4">
                        We sent a verification code to your mobile. Enter the code from the mobile in the field below.
                        <span class="fw-bold d-block mt-2">{{ $data->phone }}</span>
                    </p>
                    <p class="mb-0 fw-semibold">Type your 6 digit security code</p>
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
                    <form id="twoStepsForm" action="{{ route('emp.admin.otpverify') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div
                                class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper">
                                <input type="text"
                                    class="form-control auth-input h-px-50 text-center numeral-mask text-center h-px-50 mx-1 my-2"
                                    maxlength="6" autofocus name="otp">

                            </div>
                            <!-- Create a hidden field which is combined by 3 fields above -->
                            <input type="hidden" name="user_id" value="{{ $data->id }}" />
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                            Verify my account
                        </button>
                        <div class="text-center">Didn't get the code?
                                <a href="{{ route('emp.resend.otp',(['id' => $data->id])) }}">
                                    Resend
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
