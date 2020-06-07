@extends('plantshop.includes.header')
@section('title', 'Plant Shop | Register')
@section('body')
<body class="hold-transition register-page bg-green-gradient">
    <div class="register-box">
        @if(session('success'))
        <div class='callout callout-success text-center'>
            <p>{{ session('success') }}</p>
        </div>
        @endif
        <div class="register-box-body box-no-hover">
            <h2 class="login-box-msg">Register</h2>

            <form action="{{ route('post_register') }}" method="POST">
                @csrf
                <div class="form-group has-feedback @error('firstname') has-error @enderror">
                    <input type="text" class="form-control" value="{{ old('firstname') }}" name="firstname" placeholder="Firstname" value="<?php echo (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '' ?>">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @error('firstname')
                    <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('lastname') has-error @enderror">
                    <input type="text" class="form-control" value="{{ old('lastname') }}" name="lastname" placeholder="Lastname" value="<?php echo (isset($_SESSION['lastname'])) ? $_SESSION['lastname'] : '' ?>">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @error('lastname')
                    <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('email') has-error @enderror">
                    <input type="email" class="form-control " value="{{ old('email') }}" name="email" placeholder="Email" value="<?php echo (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                    <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @error('password')
                    <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="repassword" placeholder="Retype password">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-info btn-block" name="signup"><i class="fa fa-pencil"></i> Sign Up</button>
                    </div>
                </div>
            </form>
            <br>
            <p>Already have account?<a href="{{ route('login_page') }}"> Please login here...</a></p><br>
            <a href="/"><i class="fa fa-home"></i> Home</a>
        </div>
    </div>
    @include('plantshop.includes.scripts')
</body>
</html>
@endsection
