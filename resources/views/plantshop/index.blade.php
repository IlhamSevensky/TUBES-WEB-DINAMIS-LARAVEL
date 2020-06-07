@extends('plantshop.includes.main')
@section('content-body')
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            <img src="{{ asset('assets/images/banners/banner1.png') }}" alt="First slide">
        </div>
        <div class="item">
            <img src="{{ asset('assets/images/banners/banner2.png') }}" alt="Second slide">
        </div>
        <div class="item">
            <img src="{{ asset('assets/images/banners/banner3.png') }}" alt="Third slide">
        </div>
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="fa fa-angle-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="fa fa-angle-right"></span>
    </a>
</div>
<h2>Latest Product</h2>
@foreach($latest_product as $product)
<div class='col-sm-4'>
    <div class='box box-solid box-success'>
        <div class='box-body prod-body'>

            <img src="{{ $product->image() }}" width='100%' height='230px' style='border-radius: 5px;'>

            <h4><a href="/product/{{ $product->slug }}">{{ $product->name }}</a></h4>
        </div>
        <div class='box-footer bg-green'>
            <h4><b>Rp. {{ $product->number_format_price() }}</b></h4>
        </div>
    </div>
</div>
@endforeach
@endsection
