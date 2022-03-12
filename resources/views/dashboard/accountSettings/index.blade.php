@extends('layouts.dashboard')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Basic Information</h3>
                </div>
                <form method="post" action="{{ route('dashboard.account.update-basic') }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="national_id">National ID</label>
                            <input type="text" class="form-control" id="national_id" name="national_id" value="{{ $user->national_id }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Birth Date</label>
                            <input type="date" class="form-control" id="birthdate" name="birth_date" value="{{ $user->birth_date }}" placeholder="Enter Your Birth Date">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control custom-select" name="gender" id="gender">
                                <option {{ $user->gender == "male" ? "selected" : "" }} value="male">Male</option>
                                <option {{ $user->gender == "female" ? "selected" : "" }} value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <img id="imgPreview" class="img-fluid" style="max-height: 15rem" src="{{ Auth::user()->avatar }}" alt="">
                        </div>
                        <div class="form-group">
                            <label for="avatar">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                    <label class="custom-file-label" for="avatar">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <form method="post" action="{{ route('dashboard.account.update-password') }}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Password Confirmation</label>
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Password Confirmation">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('select a file to see preview');
                $('#imgPreview').attr('src', '');
            }
        }

        $("#avatar").change(function() {
            readURL(this);
        });

        flatpickr("#birthdate", {
            maxDate: "today",
        });

    </script>
    <script>
        $('.custom-file input').change(function (e) {
            e.target.files.length && $(this).next('.custom-file-label').html(e.target.files[0].name);
        });
    </script>
@endsection
