@extends('layout.base')

@section('title')
    Admin Dashboard
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All System Users</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>E-mail</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-center"><img src="{{route('image.render', $user->photo?$user->photo:' ')}}" width="30"></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->gender}}</td>
                            <td>{{$user->roles->first()->name}}</td>
                            <td>{{$user->address}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if(request('type') == 'assign_parent')
                                    <a class="btn btn-primary" href="{{route('parent.assign',$user->slug)}}"><i
                                            class="fas fa-cogs"></i> Assign Student</a>
                                @elseif(request('action') == 'password')
                                    <a class="btn btn-danger text-white" href="{{route('user.password.change',$user->slug)}}"><i
                                            class="fas fa-lock"></i> Change Password</a>
                                @else
                                    <a class="btn btn-primary" href="{{route('roles.assign')}}?user={{$user->slug}}"><i
                                            class="fas fa-cogs text-dark-pastel-green"></i> Edit</a>
                                    <a class="btn btn-success" href="{{route('user.show',$user->slug)}}"><i
                                            class="fa fa-eye text-orange-peel"></i> View</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
@endsection
