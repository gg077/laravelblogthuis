@extends('layouts.backend')
@section('content')
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif
    <h1>Users</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Photo</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Role</th>
            <th>Active</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>
        @if($users)
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>
                        @if($user->photo && file_exists(public_path('assets/img/'.$user->photo->path)))
                            <img
                                src="{{asset('assets/img/'.$user->photo->path)}}"
                                alt="{{$user->photo->alternate_text ?? $user->name}}"
                                class="img-fluid rounded object-fit-cover" style="width: 40px; height: 40px;"
                            >
                        @else
                            <img
                                src="https://placehold.co/40"
                                alt="No Image"
                                class="img-fluid rounded object-fit-cover" style="width: 40px; height: 40px;"
                            >
                        @endif

                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <div>
                            @foreach($user->roles as $role)
                                <span class="badge rounded-pill bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td>{{$user->is_active == 1 ? 'Active':'Not Active'}}</td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>{{$user->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
@endsection
