@extends('plantshop.includes.main')
@section('title', 'Plant Shop | Cart')
@section('content-body')
<div class="callout" id="callout" style="display: none">
    <button type="button" class="close">
        <span aria-hidden="true">&times;</span>
    </button>
    <span class="message"></span>
</div>
<h1 class="page-header">YOUR CART</h1>
<div class="box box-solid box-success">
    <div class="box-body">
        <table class="table table-bordered">
            <thead>
                <th>Photo</th>
                <th>Name</th>
                <th>Price</th>
                <th width="20%">Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
</div>
@if(auth()->check())
<button class='btn btn-info pull-right' id='checkout'>Checkout</button>
@else
<h4>You need to <a href='{{ route('login_page') }}'>Login</a> to checkout.</h4>
@endif
@endsection

@section('script')
<script>
    $('#checkout').click(function(event) {
        event.preventDefault();
        if (confirm('Are you sure want to checkout?')) {
            $.ajax({
                type: 'POST'
                , url: '/cart/checkout'
                , data: {
                    "_token": "{{ csrf_token() }}"
                }
                , dataType: 'json'
                , success: function(response) {
                    $('#callout').show();
                    $('.message').html(response.message);
                    if (response.error) {
                        $('#callout').removeClass('callout-success').addClass('callout-danger');
                    }
                    if (!response.error) {
                        $('#callout').removeClass('callout-danger').addClass('callout-success');
                        getDetails();
                        getCart();
                        getTotal();
                    }
                }
            });
        }
    });

</script>

<script>
    var total = 0;
    $(function() {
        $(document).on('click', '.cart_delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: 'POST'
                , url: '/cart/delete'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                }
                , dataType: 'json'
                , success: function(response) {
                    if (!response.error) {
                        getDetails();
                        getCart();
                        getTotal();
                    }
                }
            });
        });

        $(document).on('click', '.minus', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var qty = $('#qty_' + id).val();
            if (qty > 1) {
                qty--;
            }
            $('#qty_' + id).val(qty);
            $.ajax({
                type: 'POST'
                , url: '/cart/update'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                    , qty: qty
                , }
                , dataType: 'json'
                , success: function(response) {
                    if (!response.error) {
                        getDetails();
                        getCart();
                        getTotal();
                    }
                }
            });
        });

        $(document).on('click', '.add', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var qty = $('#qty_' + id).val();
            qty++;
            $('#qty_' + id).val(qty);
            $.ajax({
                type: 'POST'
                , url: '/cart/update'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                    , qty: qty
                , }
                , dataType: 'json'
                , success: function(response) {
                    if (!response.error) {
                        getDetails();
                        getCart();
                        getTotal();
                    }
                }
            });
        });

        getDetails();
        getTotal();

    });

    function getDetails() {
        $.ajax({
            type: 'POST'
            , url: '/cart/detail'
            , data: {
                "_token": "{{ csrf_token() }}"
            }
            , dataType: 'json'
            , success: function(response) {
                $('#tbody').html(response);
                getCart();
            }
        });
    }

    function getTotal() {
        $.ajax({
            type: 'POST'
            , url: '/cart/total'
            , data: {
                "_token": "{{ csrf_token() }}"
            }
            , dataType: 'json'
            , success: function(response) {
                total = response;
            }
        });
    }

</script>
@endsection
