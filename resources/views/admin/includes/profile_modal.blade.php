{{-- Not needed --}}
<!-- Update -->
<div class="modal fade" id="profile">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Admin Profile</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="/admin/update/profile" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" value="{{ auth()->user()->password }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname" value="{{ auth()->user()->firstname }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastname" name="lastname" value="{{ auth()->user()->lastname }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Photo:</label>

                        <div class="col-sm-9">
                            <input type="file" id="photo" name="photo">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="curr_password" class="col-sm-3 control-label">Current Password:</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="curr_password" name="curr_password" placeholder="input current password to save changes" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success" name="save"><i class="fa fa-check-square-o"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
