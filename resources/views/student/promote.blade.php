@extends('layout.base')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/select2.min.css">
    <link rel="stylesheet" href="{{asset('assets/css')}}/datepicker.min.css">
@endsection

@section('section')
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Promote Student</h3>
                </div>
            </div>
            <form class="new-added-form" method="get"  action="{{route('student.promote')}}">
                <div class="row">
                    <div class="col-12 form-group">
                        <label>Select Class</label>
                        <select class="select2" name="class" required>
                            @foreach(\App\Classes::get() as $class)
                                <option {{request('class') == $class->id?'selected':''}} value="{{$class->id}}">{{$class->section->name}} - {{$class->byLocale()->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-12 form-group">
                        <label>Academic Year</label>
                        <select class="select2"  name="year" required>
                            @foreach(\App\Session::get() as $class)
                                <option {{request('year') == $class->id?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-12 form-group">
                        <label>Next Academic Year</label>
                        <select class="select2" name="next_year" required>
                            @foreach(\App\Session::get() as $class)
                                <option {{request('next_year') == $class->id?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Check Student to promote </h3>
                </div>
            </div>
            @if(request('class') && request('year') && request('next_year')  && count($students) != 0)

                <form class="table-responsive"  method="post"  action="{{route('student.promote')}}">
                    @csrf
                    <input type="hidden" value="{{request('year')}}" name="year">
                    <input type="hidden" value="{{request('next_year')}}" name="next_year">
                    <input type="hidden" value="{{request('class')}}" name="class">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Student Matricule</th>
                            <th>Student Name</th>
                        </tr>
                        </thead>
                        <tr id="body">
                        @foreach($students as $student)
                            <tr>
                                <th>
                                    <input type="checkbox" value="{{$student->id}}" id="student{{$student->id}}" name="students[]">
                                </th>
                                <th>{{$student->matricule}}</th>
                                <th>{{$student->name}}</th>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>

                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Promote</button>
                    </div>
                </form>

            @endif
        </div>
    </div>


@endsection
@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/js')}}/select2.min.js"></script>
    <script src="{{asset('assets/js')}}/datepicker.min.js"></script>
@endsection
