@extends('plantshop.includes.main')
@section('title', 'Plant Shop | ' . $detail_product->name)
@section('content-body')
<div class="callout" id="callout" style="display: none">
    <button type="button" class="close">
        <span aria-hidden="true">&times;</span>
    </button>
    <span class="message"></span>
</div>
<div class="row box box-solid box-success" style="padding: 40px; border-radius: 5px;">
    <div class="col-sm-6">
        <img src="{{ $detail_product->image() }}" width="100%" style="border-radius: 5px;" class="zoom">
        <br><br>
    </div>
    <div class="col-sm-6">
        <h1 class="page-header">{{ $detail_product->name }}</h1>
        <h3><b>Rp. {{ $detail_product->number_format_price() }}</b></h3>
        <p><b>Category:</b> <a href="/category/{{ $detail_product->category->cat_slug }}">{{ $detail_product->category->name }}</a></p>
        <form class="form-inline" action="#" id="productForm">
            @csrf
            <div class="form-group">
                <div class="input-group col-sm-5">

                    <span class="input-group-btn">
                        <button type="button" id="minus" class="btn btn-default btn-lg"><i class="fa fa-minus"></i></button>
                    </span>
                    <input type="text" name="quantity" id="quantity" class="form-control input-lg" value="1">
                    <span class="input-group-btn">
                        <button type="button" id="add" class="btn btn-default btn-lg"><i class="fa fa-plus"></i>
                        </button>
                    </span>
                    <input type="hidden" value="{{ $detail_product->id }}" name="product_id">
                </div>
                <button type="submit" class="btn btn-info btn-lg"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
            </div>
        </form>
        <br>
        <p><b>Description:</b></p>
        <p>{!! $detail_product->description !!}</p>
    </div>

</div>
<br>
@endsection

@section('script')
<script>
    $(function() {
        $('#add').click(function(e) {
            e.preventDefault();
            var quantity = $('#quantity').val();
            quantity++;
            $('#quantity').val(quantity);
        });
        $('#minus').click(function(e) {
            e.preventDefault();
            var quantity = $('#quantity').val();
            if (quantity > 1) {
                quantity--;
            }
            $('#quantity').val(quantity);
        });

    });

</script>
@endsection
