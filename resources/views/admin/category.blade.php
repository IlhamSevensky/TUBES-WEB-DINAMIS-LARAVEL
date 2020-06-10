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
                    Category
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Products</li>
                    <li class="active">Category</li>
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
                    @error('name')
                    {{ $message }}
                    <br>
                    @enderror
                </div>
                @endif
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <a href="#addnew" data-toggle="modal" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> New</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Category Name</th>
                                        <th>Tools</th>
                                    </thead>
                                    <tbody>
                                        @foreach($list_category as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <button class='btn btn-success btn-sm edit' data-id={{ $category->id }}><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm delete' data-id={{ $category->id }}><i class='fa fa-trash'></i> Delete</button>
                                            </td>
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
        @include('admin.includes.category_modal')

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

        });

        function getRow(id) {
            $.ajax({
                type: 'POST'
                , url: '/admin/category/fetch'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                }
                , dataType: 'json'
                , success: function(response) {
                    $('.catid').val(response.id);
                    $('#edit_name').val(response.name);
                    $('.catname').html(response.name);
                }
            });
        }

    </script>
</body>
</html>
