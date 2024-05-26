@extends('layout.base')

@section('title')
    Admin Dashboard
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <!-- Breadcubs Area End Here -->
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All Messages</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i = 1)
                        @foreach(\App\SMS::orderBy('id','DESC')->get() as $message)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$message->title}}</td>
                                <td>{{$message->sender->name}}</td>
                                <td>{{$message->created_at->diffForHumans()}}</td>
                                <td>
                                    <a class="btn btn-outline-primary" href="#">View</a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Teacher Table Area End Here -->
@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
@endsection
