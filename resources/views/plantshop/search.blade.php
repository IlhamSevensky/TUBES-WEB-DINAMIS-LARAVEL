@extends('plantshop.includes.main')
@section('title', 'Plant Shop | Search')
@section('content-body')
@if($products->isEmpty())
<h1 class="page-header">No results found for <i>{{ $keyword }}</i></h1>
@else
<h1 class="page-header">Search results for <i>{{ $keyword }}</i></h1>
@endif
@foreach($products as $product)
<div class='col-sm-4'>
    <div class='box box-solid box-success'>
        <div class='box-body prod-body'>
            <img src="{{ $product->image() }}" width='100%' height='230px' style='border-radius: 5px;'>

            <h4><a href="/product/{{ $product->slug }}">{!! $product->name !!}</a></h4>
        </div>
        <div class='box-footer bg-green'>
            <h4><b>Rp. {{ $product->number_format_price() }}</b></h4>
        </div>
    </div>
</div>
@endforeach
@endsection
