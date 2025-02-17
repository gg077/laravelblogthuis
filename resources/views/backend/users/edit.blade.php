@extends('layouts.backend')
@section('title')
    Edit a User
@endsection
@section('charts')
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div>
            @include('layouts.partials.form_error')
        </div>
        <form action="{{action('\App\Http\Controllers\UserController@store')}}"
              method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{old('name')}}"
                >
                @error('name')
                <p class="text-danger text-sm">{{$message}}</p>
                @enderror()
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input
                    type="text"
                    name="email"
                    id="email"
                    class="form-control"
                    value="{{old('email')}}"
                >
            </div>
            <div class="form-group">
                <label for="role_id">Select Role: (ctrl+click multiple)</label>
                <select name="role_id[]" id="role_id" class="form-control" multiple>
                    <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Select a role</option>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ collect(old('role_id', []))->contains($id) ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="role_id">Select Status:</label>
                <select class="form-select" name="is_active" id="is_active">
                    <option value="1" {{old('is_active')=="1" ? 'selected': ""}}>Active</option>
                    <option value="0" {{old('is_active')=="0" ? 'selected': ""}}>Not Active</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control">
            </div>
            <div class="form-group">
                <label for="photo_id">Image:
                </label>
                <input
                    type="file"
                    name="photo_id"
                    id="photo_id"
                    class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-1">Create User</button>
            </div>
        </form>
    </div>
@endsection
