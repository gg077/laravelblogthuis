@extends('layouts.backend')

@section('title')
    Edit User
@endsection

@section('cards')
@endsection

@section('charts')
@endsection

@section('content')
    <div class="container-fluid px-4">

        <form method="POST" action="{{ action('App\Http\Controllers\UserController@update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <!-- Linkerkant: User Details in een card -->
                <div class="col-md-8 d-flex">
                    <div class="card w-100 h-100">
                        <div class="card-header">
                            User Details
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">Name:</label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control"
                                       value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">E-mail:</label>
                                <input type="text"
                                       name="email"
                                       id="email"
                                       class="form-control"
                                       value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="role_id">Select roles:</label>
                                <select name="role_id[]" id="role_id" class="form-control" multiple>
                                    <option value="" disabled>Select a role</option>
                                    @foreach($roles as $id => $role)
                                        <option value="{{ $id }}" {{ collect(old('role_id', $user->roles->pluck('id')->toArray()))->contains($id) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="is_active">Select status:</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Not Active</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password (leave blank to keep current password):</label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </div>
                </div>
                <!-- Rechterkant: Foto en Bestandsdetails in een card -->
                <div class="col-md-4 d-flex">
                    <div class="card w-100 h-100">
                        <div class="card-header">
                            Profile Photo
                        </div>
                        <div class="card-body text-center">
                            @if($user->photo && $photoDetails['exists'])
                                <img src="{{ asset('assets/img/' . $user->photo->path) }}"
                                     alt="{{ $user->photo->alternate_text ?? $user->name }}"
                                     class="img-fluid rounded object-fit-cover mb-2"
                                     style="width: 100%; max-width: 300px; height: auto;">
                                <div class="mt-2">
                                    <small>
                                        File size: {{ $photoDetails['filesize'] }} KB<br>
                                        Resolution: {{ $photoDetails['width'] }}x{{ $photoDetails['height'] }}<br>
                                        Extension: {{ $photoDetails['extension'] }}
                                    </small>
                                </div>
                            @else
                                <img src="https://placehold.co/300x300"
                                     alt="No Image"
                                     class="img-fluid rounded object-fit-cover mb-2"
                                     style="width: 100%; max-width: 300px; height: auto;">
                                <div class="mt-2">
                                    <small>No photo available</small>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <label for="photo_id">Upload New Image:</label>
                                <input type="file"
                                       name="photo_id"
                                       id="photo_id"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @include('layouts.partials.form_error')
    </div>
@endsection
