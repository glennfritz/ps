@extends('layout.base')

@section('title')
    Admin Dashboard
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/select2.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/datepicker.min.css">
@endsection

@section('section')
    <div class="row">
    <div class="col-12">
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{$title}}</h3>
                    </div>
                    <div class="dropdown">
                       @if(\Auth::user()->can('create_subject'))
                            <a href="{{route('subject.create')}}" class="fw-btn-fill btn-gradient-yellow">Add Subject</a>
                       @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                           <th>S/N</th>
                            <th>Subject Name</th>
                            <th>Subject Code</th>
                            <th>Section</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 1)
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$subject->byLocale()->name}}</td>
                                    <td>{{$subject->id}}</td>
                                    <td>{{$subject->section->byLocale()->name}}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{route('subject.edit', $subject->slug)}}"><i
                                                class="fas fa-edit"></i> Edit</a>

                                        <a onclick="event.preventDefault();
                                            document.getElementById('delete{{$subject->id}}').submit();" class=" btn text-white btn-danger"><i
                                                class="fas"></i> Delete</a>
                                        <form id="delete{{$subject->id}}" action="{{route('subject.destroy', $subject->slug)}}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/js')}}/select2.min.js"></script>
    <script src="{{asset('assets/js')}}/datepicker.min.js"></script>
@endsection
