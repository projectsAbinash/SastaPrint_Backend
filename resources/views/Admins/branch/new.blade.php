@extends('Admins.Layouts.Main')
@section('title')
    {{ 'Create New' }}
@endsection
@section('main-container')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
                <h5 class="card-header">Create A New Branch</h5>
                <!-- Account -->

                <hr class="my-0" />
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="formAccountSettings" method="POST" action="{{ route('BranchSubmit') }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('branch_name') }}
                            </div>

                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('adress_line_1') }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('adress_line_2') }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('pincode', '', ['onkeyup' => 'set_pin(this.value)']) }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('district', '', ['id' => 'district', 'readonly']) }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('state', '', ['id' => 'state', 'readonly']) }}
                            </div>
                            <div class="mb-3 col-md-6">
                                {{ Form::wtextbox('contact_number') }}
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2" id="savebtn" disabled>Save</button>
                            <a href="{{ url()->previous() }}"> <button type="button"
                                    class="btn btn-outline-secondary">Cancel</button></a>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
@section('footer_scripts')
    <script>
        function set_pin(data) {

           
                $("#savebtn").prop('disabled', true);
                $.ajax({
                    url: '{{ route('api.fetchpin') }}',
                    type: 'post',
                    data: {
                        pincode: data,

                    },
                    success: function(response) {
                        var returnedData = JSON.parse(JSON.stringify(response));
                        $("#district").val(returnedData.district);
                        $("#state").val(returnedData.state);
                        $("#savebtn").prop('disabled', false);
                    },
                    error: function() {
                        $("#savebtn").prop('disabled', true);
                    }
                });
            
           
        }
    </script>
@endsection

@endsection
