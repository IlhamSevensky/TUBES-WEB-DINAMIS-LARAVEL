@include('admin.includes.header')
<body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">

        @include('admin.includes.navbar')
        @include('admin.includes.menubar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Sales History
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Sales</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th class="hidden"></th>
                                        <th>Date</th>
                                        <th>Buyer Name</th>
                                        <th>Transaction#</th>
                                        <th>Amount</th>
                                        <th>Full Details</th>
                                    </thead>
                                    <tbody>
                                        @foreach($transaction_data as $transaction)
                                        <tr>
                                            <td class='hidden'></td>
                                            <td>{{ $transaction['sale_date'] }}</td>
                                            <td>{{ $transaction['sale_buyer_firstname'] . ' ' . $transaction['sale_buyer_lastname']}}</td>
                                            <td>{{ $transaction['pay_id'] }}</td>
                                            <td>Rp. {{ $transaction['total_sale'] }}</td>
                                            <td><button type='button' class='btn btn-info btn-sm transact' data-id="{{ $transaction['sale_id'] }}"><i class='fa fa-search'></i> View</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        @include('admin.includes.footer')
        @include('admin.includes.transaction_detail_modal')

    </div>
    <!-- ./wrapper -->

    @include('admin.includes.scripts')
    <!-- Date Picker -->
    <script>
        $(function() {
            //Date picker
            $('#datepicker_add').datepicker({
                autoclose: true
                , format: 'yyyy-mm-dd'
            })
            $('#datepicker_edit').datepicker({
                autoclose: true
                , format: 'yyyy-mm-dd'
            })

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true
                , timePickerIncrement: 30
                , format: 'MM/DD/YYYY h:mm A'
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()]
                        , 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')]
                        , 'Last 7 Days': [moment().subtract(6, 'days'), moment()]
                        , 'Last 30 Days': [moment().subtract(29, 'days'), moment()]
                        , 'This Month': [moment().startOf('month'), moment().endOf('month')]
                        , 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                    , startDate: moment().subtract(29, 'days')
                    , endDate: moment()
                }
                , function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

        });

    </script>
    <script>
        $(function() {
            $(document).on('click', '.transact', function(e) {
                e.preventDefault();
                $('#transaction').modal('show');
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST'
                    , url: '/admin/transaction/detail'
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
                    }
                });
            });

            $("#transaction").on("hidden.bs.modal", function() {
                $('.prepend_items').remove();
            });
        });

    </script>
</body>
</html>
