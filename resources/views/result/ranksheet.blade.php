@extends('layout.base')

@section('title')
    Rank Sheet
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('public/assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')

    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title w-100 align-items-center d-flex">
                            <form class="ml-4 w-100" method="get" action="">
                                @csrf
                                <div class="row d-flex gutters-8 justify-content-between">
                                    <div class="col-md-4 col-12 form-group">
                                        <select name="year" class="select2">
                                            @foreach(\App\Session::all() as $session)
                                                <option {{(request('year',getYear()) == $session->id)?'selected':''}} value="{{$session->id}}">{{$session->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 col-12 form-group">
                                        <select name="sequence" class="select2">
                                            @foreach(\App\Sequence::all() as $session)
                                                <option {{(request('sequence',getTerm()) == $session->id)?'selected':''}} value="{{$session->id}}">{{$session->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4  form-group">
                                        <button type="submit" class="fw-btn-fill btn-gradient-yellow">Get</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-box-wrap">
                        <div class="table-responsive student-table-box">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Average</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach($students as $k=>$student )
                                       <tr>
                                           <td>{{$k+1 }}</td>
                                           <td>{{$student->name}}</td>
                                           <td>{{$student->total_mark/$student->total * 20}}</td>
                                      </tr>
                                   @endforeach
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
    <script src="{{asset('public/assets/js')}}/jquery.dataTables.min.js"></script>
@endsection

