@extends('layout.base')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>{{$class?$class->class->name:''}}  {{$class?$class->section_id:''}} Student Result</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Fee Bal</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{$student->name}}</td>
                                <td class="text-capitalize">{{$student->gender}}</td>
                                <td>{{$student->dept(getYear())}}</td>
                                <td>
                                   @if(request('action') == 'recordmarks')
                                        <a class="btn btn-danger text-white" href="{{route('result.edit',$student->slug)}}">Edit Result</a>
                                    @elseif(request('action') == 'print')
                                        <a class="btn btn-success text-white" href="{{route('result.session',$student->slug)}}?action=print">Print</a>
                                    @endif
                                    @if(\Auth::user()->hasRole('admin') && $id != 'mine')
                                           <a class="btn btn-danger text-white" href="{{route('result.edit',$student->slug)}}">Edit Result</a>
                                           <a class="btn btn-success text-white" href="{{route('result.session',$student->slug)}}">View Result</a>
                                   @endif

                                   @if($id == 'mine')
                                       <a class="btn btn-success text-white" href="{{route('result.session',$student->slug)}}">View Result</a>
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
