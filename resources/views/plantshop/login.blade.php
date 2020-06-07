@extends('plantshop.includes.header')
@section('title', 'Plant Shop | Login')
@section('body')
<body class="hold-transition login-page bg-green-gradient">
    <div class="login-box center">
        @if(session('success'))
        <div class='callout callout-success text-center'>
            <p>{{ session('success') }}</p>
        </div>
        @endif
        @if(session('error'))
        <div class='callout callout-danger text-center'>
            <p>{{ session('error') }}</p>
        </div>
        @endif
        <div class="login-box-body box-no-hover">
            <h2 class="login-box-msg">Login</h2>

            <form action="{{ route('post_login') }}" method="POST">
                @csrf
                <div class="form-group has-feedback">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-info btn-block" name="login"><i class="fa fa-sign-in"></i> Login</button>
                    </div>
                </div>
            </form>
            <br>
            <p>Not have account ? <a href="{{ route('register_page') }}" class="text-center">Register here...</a></p><br>
            <a href="/"><i class="fa fa-home"></i> Home</a>
        </div>
    </div>

    @include('plantshop.includes.scripts')
</body>
</html>
@endsection
