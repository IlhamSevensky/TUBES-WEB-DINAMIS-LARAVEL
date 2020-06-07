@extends('plantshop.includes.main')
@section('title', 'Plant Shop | Profile')
@section('content-body')
<div class="box box-solid box-success">
    <div class="box-body">
        <div class="col-sm-3">
            <img src="{{ auth()->user()->getAvatar() }}" width="100%">
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-3">
                    <h4>Name:</h4>
                    <h4>Email:</h4>
                    <h4>Contact Info:</h4>
                    <h4>Address:</h4>
                    <h4>Member Since:</h4>
                </div>
                <div class="col-sm-9">
                    <h4>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}
                        <span class="pull-right">
                            <a href="#edit" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
                        </span>
                    </h4>
                    <h4>{{ auth()->user()->email }}</h4>
                    <h4>{{ auth()->user()->getContact() }}</h4>
                    <h4>{{ auth()->user()->getAddress() }}</h4>
                    <h4>{{ date('M d, Y', strtotime(auth()->user()->created_at)) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-solid box-success">
    <div class="box-header with-border">
        <h4 class="box-title"><i class="fa fa-calendar"></i> <b>Transaction History</b></h4>
    </div>
    <div class="box-body">
        <table class="table table-bordered" id="example1">
            <thead>
                <th class="hidden"></th>
                <th>Date</th>
                <th>Transaction#</th>
                <th>Amount</th>
                <th>Full Details</th>
            </thead>
            <tbody>
                @foreach($transactions as $item)
                <tr>
                    <td class='hidden'></td>
                    <td>{{ $item['sales_date'] }}</td>
                    <td>{{ $item['pay_id'] }}</td>
                    <td>Rp. {{ $item['total_price'] }}</td>
                    <td><button class='btn btn-sm btn-info transact' data-id='{{ $item['sales_id'] }}'><i class='fa fa-search'></i> View</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('plantshop.includes.profile_modal')
@endsection
@section('script')
<script>
    $(function() {
        $(document).on('click', '.transact', function(e) {
            e.preventDefault();
            $('#transaction').modal('show');
            var id = $(this).data('id');
            $.ajax({
                type: 'POST'
                , url: '/profile/transaction/detail'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                }
                , dataType: 'json'
                , success: function(response) {
                    $('#date').html(response.date);
                    $('#transid').html(response.transaction);
                    $('#detail').prepend(response.list);
                    $('#total').html(response.total);
                    console.log(response);
                }
            });
        });

        $("#transaction").on("hidden.bs.modal", function() {
            $('.prepend_items').remove();
        });
    });

</script>
@if(count($errors) > 0))
<script type="text/javascript">
    $(window).on('load', function() {
        $('#edit').modal('show');
    });

</script>
@endif
@endsection
