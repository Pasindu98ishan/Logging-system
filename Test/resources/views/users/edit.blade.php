<html>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-header">Preview {{ $user->name }}</div>
                            <div class="card-body">
                            <form action="{{ route('users.update', $user->id) }}" method="PATCH" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    @method("PATCH")
                                    <input type="hidden" name="id" value="{{ $user->id }}" />
                                    <label>User Name:</label><br>
                                    <input type="text" name="user_name" value="{{ $user->user_name }}" class="form-control"><br>
                                    <label>Name:</label><br>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control"><br>
                                    <label>Email:</label><br>
                                    <input type="text" name="email" value="{{ $user->email }}" class="form-control"><br>
                                    <label>User Type:</label><br>
                                    <select name="user_type" class="form-control">
                                    <option value="super_admin" {{ $user->user_type === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="admin" {{ $user->user_type === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="guest" {{ $user->user_type === 'guest' ? 'selected' : '' }}>Guest</option>
                                    </select>
                                    <label>User Status:</label><br>
                                   <select name="status" class="form-control">
                                   <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                   <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                   </select>
                                    <br>
                                    <input type="submit" value="Update" class="btn btn-success"><br>
                            </form>
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>
