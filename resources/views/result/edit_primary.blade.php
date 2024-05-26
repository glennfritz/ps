@extends('layout.base')

@section('title')
    Edit Result
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
    <style>
        th{
            border: 1px solid #ccc;
            padding: 0px !important;
        }
    </style>
@endsection

@section('section')
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title d-flex-column w-100">
                    <h5 class="mb-0"> {{$student->name}}</h5>
                    <h5 class="mb-0"> {{$student->class($year->id)->name}}</h5>
                    <form  method="get" action="{{route('result.edit',$student->slug)}}" class="mg-b-20 my-4" >
                        @csrf
                        <div class="row gutters-8">
                            <div class="form-group">
                                <select name="year" class="select2">
                                    @foreach(\App\Session::all() as $session)
                                        @if($session->id == getYear())
                                            <option {{($student->class($year->id)->id == $session->id)?'selected':''}} value="{{$session->id}}">{{$session->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mx-md-4">
                                <select name="sequence" class="select2">
                                    @if(\Auth::user()->hasRole('admin'))
                                        @foreach(\App\Sequence::all() as $session)
                                            <option {{(getYear() == $session->id)?'selected':''}}  value="{{$session->id}}">{{$session->name}}</option>
                                        @endforeach
                                    @else
                                        @php
                                            $term = \App\Sequence::find(getTerm())
                                        @endphp
                                        <option value="{{$term->id}}">{{$term->byLocale()->name}}</option>
                                    @endif
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <form  method="post" action="{{route('result.edit',$student->slug)}}"  method="post" action="{{route('result.edit',$student->slug)}}" class="table-responsive pb-5">
                @csrf
                <input type="hidden" name="year" value="{{$year->id}}">
                <input type="hidden" name="sequence" value="{{$seq->id}}">
                <input type="hidden" name="student" value="{{$student->id}}">
                <table class="table my-3">
                    <thead>
                    <tr>
                        <td>Subject</td>
                        <td>Mark</td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Section::find($section)->subjects as $subject)
                            <tr class="form-group">
                                <th class="px-3">{{$subject->byLocale()->name}}</th>
                                <th><input type="text" required placeholder="Enter {{$subject->byLocale()->name}} mark" class="form-control" value="{{$student->mark($subject->id, $year->id, $seq->id)}}" name="mark{{$subject->id}}"></th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex  justify-content-end align-items-end">
                    <button type="submit" class="btn-fill-sm bg-success text-white btn-gradient-yellow">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
@endsection
