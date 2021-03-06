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
                    Dashboard
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>Rp. {{ number_format($total_sales) }}</h3>
                                <p>Total Sales</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <a href="/admin/sales" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{ $number_of_product }}</h3>
                                <p>Number of Products</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-barcode"></i>
                            </div>
                            <a href="/admin/products/all" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{ $number_of_user }}</h3>
                                <p>Number of Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="/admin/users" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>Rp. {{ number_format($today_total_sales) }}</h3>
                                <p>Sales Today</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money"></i>
                            </div>
                            <a href="#" class="small-box-footer">{{ $date_now }}</i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Monthly Sales Report</h3>
                                <div class="box-tools pull-right">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label>Select Year: </label>
                                            <select class="form-control input-sm" id="select_year">
                                                @for($i = 2015; $i <= 2065; $i++) <option value="{{ $i }}" @if($i==$year) selected @endif> {{ $i }} </option> @endfor
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <br>
                                    <div id="legend" class="text-center"></div>
                                    <canvas id="barChart" style="height:350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- right col -->
        </div>
        @include('admin.includes.footer')


    </div>
    <!-- ./wrapper -->

    <!-- Chart Data -->
    {{-- <?php
      $months = array();
      $sales = array();
      for( $m = 1; $m <= 12; $m++ ) {
        try{
          // Mengambil semua data dari tabel details, tabel sales dan tabel product dimana ID di tabel sales sama dengan SALES_ID di tabel details serta ID di tabel product sama dengan PRODUCT ID di tabel details yang bulan dan tahunnya sesuai dengan inputan
          $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date)=:month AND YEAR(sales_date)=:year");
          $stmt->execute(['month'=>$m, 'year'=>$year]);
          $total = 0;
          foreach($stmt as $srow){
            
            $subtotal = $srow['price']*$srow['quantity'];
            $total += $subtotal;    
          }
          // totalnya dibulatkan
          array_push($sales, round($total, 2));
        }
        catch(PDOException $e){
          echo $e->getMessage();
        }

        $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
        $month =  date('M', mktime(0, 0, 0, $m, 1));
        array_push($months, $month);
      }

      $months = json_encode($months);
      $sales = json_encode($sales);

    ?> --}}
    <!-- End Chart Data -->

    {{-- <?php $pdo->close(); ?> --}}
    @include('admin.includes.scripts')
    <script>
        $(function() {
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChart = new Chart(barChartCanvas)
            var barChartData = {
                labels: @json($month_name_data)
                , datasets: [{
                    label: 'SALES'
                    , fillColor: 'rgba(60,141,188,0.9)'
                    , strokeColor: 'rgba(60,141,188,0.8)'
                    , pointColor: '#3b8bba'
                    , pointStrokeColor: 'rgba(60,141,188,1)'
                    , pointHighlightFill: '#fff'
                    , pointHighlightStroke: 'rgba(60,141,188,1)'
                    , data: @json($monthly_total_sales)
                }]
            }
            //barChartData.datasets[1].fillColor   = '#00a65a'
            //barChartData.datasets[1].strokeColor = '#00a65a'
            //barChartData.datasets[1].pointColor  = '#00a65a'
            var barChartOptions = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: 'rgba(0,0,0,.05)',
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
                //String - A legend template
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                //Boolean - whether to make the chart responsive
                responsive: true
                , maintainAspectRatio: true
            }

            barChartOptions.datasetFill = false
            var myChart = barChart.Bar(barChartData, barChartOptions)
            document.getElementById('legend').innerHTML = myChart.generateLegend();
        });

    </script>
    <script>
        $(function() {
            $('#select_year').change(function() {
                window.location.href = '/admin/month/' + $(this).val();
            });
        });

    </script>
</body>
</html>
