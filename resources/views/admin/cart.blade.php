{{-- <?php include 'includes/session.php'; ?> --}}
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
                    {{ $user->firstname . ' ' . $user->lastname }}`s Cart
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Users</li>
                    <li class="active">Cart</li>
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
                @if(session('errors') || session('error'))
                <div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-warning'></i> Error!</h4>
                    {{ session('error') }}
                    @error('quantity')
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
                                <a href="#addnew" data-toggle="modal" id="add" data-id="{{ $user->id }}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> New</a>
                                <a href="/admin/users" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Users</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Tools</th>
                                    </thead>
                                    <tbody>
                                        @foreach($cart_items as $item)
                                        <tr>
                                            <td>{{ $item['product_name'] }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>
                                                <button class='btn btn-success btn-sm edit' data-id="{{ $item['cart_id'] }}"><i class='fa fa-edit'></i> Edit Quantity</button>
                                                <button class='btn btn-danger btn-sm delete' data-id={{ $item['cart_id'] }}><i class='fa fa-trash'></i> Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{-- <?php
                                          $conn = $pdo->open();

                                          try{
                                            $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
                                            $stmt->execute(['user_id'=>$user['id']]);
                                            foreach($stmt as $row){
                                              echo "
                                                <tr>
                                                  <td>".$row['name']."</td>
                                                  <td>".$row['quantity']."</td>
                                                  <td>
                                                    <button class='btn btn-success btn-sm edit' data-id='".$row['cartid']."'><i class='fa fa-edit'></i> Edit Quantity</button>
                                                    <button class='btn btn-danger btn-sm delete' data-id='".$row['cartid']."'><i class='fa fa-trash'></i> Delete</button>
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
        @include('admin.includes.cart_modal')

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

            $('#add').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                getProducts(id);
            });

            $("#addnew").on("hidden.bs.modal", function() {
                $('.append_items').remove();
            });

        });

        function getProducts(id) {
            $.ajax({
                type: 'POST'
                , url: '/admin/users/cart/product'
                , data: {
                    "_token": "{{ csrf_token() }}"
                }
                , dataType: 'json'
                , success: function(response) {
                    $('#product').append(response);
                    $('.userid').val(id);
                }
            });
        }

        function getRow(id) {
            $.ajax({
                type: 'POST'
                , url: '/admin/users/cart/detail'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                }
                , dataType: 'json'
                , success: function(response) {
                    $('.cartid').val(response.cart_id);
                    $('.userid').val(response.user_id);
                    $('.productname').html(response.product_name);
                    $('#edit_quantity').val(response.quantity);
                }
            });
        }

    </script>
</body>
</html>
