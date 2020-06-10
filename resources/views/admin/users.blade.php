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
                    Users
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Users</li>
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
                    @error('email')
                    {{ $message }}
                    <br>
                    @enderror
                    @error('firstname')
                    {{ $message }}
                    <br>
                    @enderror
                    @error('lastname')
                    {{ $message }}
                    <br>
                    @enderror
                    @error('password')
                    {{ $message }}
                    <br>
                    @enderror
                    @error('photo')
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
                                        <th>Photo</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Date Added</th>
                                        <th>Tools</th>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <img src="{{ $user->getAvatar() }}" height='30px' width='30px'>
                                                <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id="{{ $user->id }}"><i class='fa fa-edit'></i></a></span>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
                                            <td>
                                                @if($user->isAdmin())
                                                <span class="label label-primary">Admin</span>
                                                @else
                                                <span class="label label-success">User</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->getUserCreatedDate() }}</td>
                                            <td>
                                                <a href="/admin/users/{{ $user->id }}/cart" class='btn btn-info btn-sm'><i class='fa fa-search'></i> Cart</a>
                                                <button class='btn btn-success btn-sm edit' data-id="{{ $user->id }}"><i class='fa fa-edit'></i> Edit</button>
                                                <button class='btn btn-danger btn-sm delete' data-id="{{ $user->id }}"><i class='fa fa-trash'></i> Delete</button>
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
        @include('admin.includes.users_modal')

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

            $(document).on('click', '.status', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                getRow(id);
            });

        });

        function getRow(id) {
            $.ajax({
                type: 'POST'
                , url: '/admin/users/detail'
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , id: id
                }
                , dataType: 'json'
                , success: function(response) {
                    $('.userid').val(response.id);
                    $('#edit_email').val(response.email);
                    $('#edit_password').val(response.password);
                    $('#edit_firstname').val(response.firstname);
                    $('#edit_lastname').val(response.lastname);
                    $('#edit_address').val(response.address);
                    $('#edit_contact').val(response.contact_info);
                    $('.fullname').html(response.firstname + ' ' + response.lastname);
                }
            });
        }

    </script>
</body>
</html>
