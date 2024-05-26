@extends('layout.base')

@section('title')
    Teacher Dashboard
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')

    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>My Students</h3>
                        </div>
                    </div>
                    <div class="table-box-wrap">
                        <div class="table-responsive student-table-box">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Parents</th>
                                    <th>Fee Bal</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                   @if(\Auth::user()->class(getYear()))
                                       @foreach(\Auth::user()->class(getYear())->student as $student )
                                           <tr>
                                               <td>{{$student->name}}</td>
                                               <td>{{$student->gender}}</td>
                                               <td>{{$student->parent()?$student->parent()->name:''}}</td>
                                               <td>{{$student->dept(getYear())}}</td>
                                               <td> <a class="btn btn-success text-white" href="{{route('result.session',$student->slug)}}">View Result</a></td>
                                           </tr>
                                       @endforeach
                                   @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
@endsection

