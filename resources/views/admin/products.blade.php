{{-- <?php
  $where = '';
  if(isset($_GET['category'])){
    $catid = $_GET['category'];
    $where = 'WHERE category_id ='.$catid;
  }

?> --}}
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
                    Product List
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Products</li>
                    <li class="active">Product List</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                @if(session('success'))
                <div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-check'></i> Success!</h4>
                    {{ session('success') }}
                </div>
                @endif
                @if(session('errors') || session('error') )
                <div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-warning'></i> Error!</h4>
                    @error('name')
                    {{ $message }}
                    <br>
                    @enderror
                    @error('price')
                    {{ $message }}
                    <br>
                    @enderror
                    @error('description')
                    {{ $message }}
                    <br>
                    @enderror
                </div>
                @endif
                {{-- <?php
                  if(isset($_SESSION['error'])){
                    echo "
                      <div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa fa-warning'></i> Error!</h4>
                        ".$_SESSION['error']."
                      </div>
                    ";
                    unset($_SESSION['error']);
                  }
                  if(isset($_SESSION['success'])){
                    echo "
                      <div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4><i class='icon fa fa-check'></i> Success!</h4>
                        ".$_SESSION['success']."
                      </div>
                    ";
                    unset($_SESSION['success']);
                  }
                ?> --}}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <a href="#addnew" data-toggle="modal" class="btn btn-info btn-sm" id="addproduct"><i class="fa fa-plus"></i> New</a>
                                <div class="pull-right">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label>Category: </label>
                                            <select class="form-control input-sm" id="select_category">
                                                <option value="all">All</option>
                                                @foreach($list_category as $category)
                                                <option value="{{ $category->cat_slug }}" @if($cat_slug==$category->cat_slug) selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Views Today</th>
                                        <th>Tools</th>
                                    </thead>
                                    <tbody>
                                        @foreach($list_product as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                <img src="{{ $product->image() }}" height='30px' width='30px'>
                                                <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id="{{ $product->id }}"><i class='fa fa-edit'></i></a></span>
                                            </td>
                                            <td><a href='#description' data-toggle='modal' class='btn btn-info btn-sm desc' data-id="{{ $product->id }}"><i class='fa fa-search'></i> View</a></td>
                                            <td>Rp. {{ $product->number_format_price() }}</td>
                                            <td>{{ $product->counter_now() }}</td>
                                            <td>
                                                <button class='btn btn-success btn-sm edit' data-id="{{ $product->id }}"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm delete' data-id="{{ $product->id }}"><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{-- <?php
                                          $conn = $pdo->open();

                                          try{
                                            $now = date('Y-m-d');
                                            $stmt = $conn->prepare("SELECT * FROM products $where");
                                            $stmt->execute();
                                            foreach($stmt as $row){
                                              $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                                              $counter = ($row['date_view'] == $now) ? $row['counter'] : 0;
                                              echo "
                                                <tr>
                                                  <td>".$row['name']."</td>
                                                  <td>
                                                    <img src='".$image."' height='30px' width='30px'>
                                                    <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='".$row['id']."'><i class='fa fa-edit'></i></a></span>
                                                  </td>
                                                  <td><a href='#description' data-toggle='modal' class='btn btn-info btn-sm desc' data-id='".$row['id']."'><i class='fa fa-search'></i> View</a></td>
                                                  <td>Rp. ".number_format($row['price'])."</td>
                                                  <td>".$counter."</td>
                                                  <td>
                                                    <button class='btn btn-success btn-sm edit' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                                                    <button class='btn btn-danger btn-sm delete' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                                                  </td>
                                                </tr>
                                              ";
                                            }
                                          }
                                          catch(PDOException $e){
                                            echo $e->getMessage();
                                          }

                                          $pdo->close();
                                        ?> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        @include('admin.includes.footer')
        @include('admin.includes.products_modal')
        @include('admin.includes.products_modal2')

    </div>
    <!-- ./wrapper -->

    @include('admin.includes.scripts')
    <script>
        $(function() {
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                $('#edit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                $('#delete').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $(document).on('click', '.photo', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                getRow(id);
            });

            $(document).on('click', '.desc', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                getRow(id);
            });

            $('#select_category').change(function() {
                var val = $(this).val();
                if (val == 'all') {
                    window.location = '/admin/products/all';
                } else {
                    window.location = '/admin/products/' + val;
                }
            });

            $('#addproduct').click(function(e) {
                e.preventDefault();
                getCategory();
            });

            $("#addnew").on("hidden.bs.modal", function() {
                $('.append_items').remove();
            });

            $("#edit").on("hidden.bs.modal", function() {
                $('.append_items').remove();
            });

        });

        function getRow(id) {
            $.ajax({
                type: 'POST'
                , url: '/admin/products/detail'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                }
                , dataType: 'json'
                , success: function(response) {
                    $('#desc').html(response.description);
                    $('.name').html(response.prodname);
                    $('.prodid').val(response.prodid);
                    $('#edit_name').val(response.prodname);
                    $('#catselected').val(response.category_id).html(response.catname);
                    $('#edit_price').val(response.price);
                    CKEDITOR.instances["editor2"].setData(response.description);
                    getCategory();
                }
            });
        }

        function getCategory() {
            $.ajax({
                type: 'POST'
                , url: '/admin/products/category/fetch'
                , data: {
                    "_token": "{{ csrf_token() }}"
                }
                , dataType: 'json'
                , success: function(response) {
                    $('#category').append(response);
                    $('#edit_category').append(response);
                }
            });
        }

    </script>
</body>
</html>
