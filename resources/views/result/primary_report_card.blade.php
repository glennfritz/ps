@extends('layout.base')

@section('title')
    Student Result
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
    <style>
        th{
            border: 1px solid #ccc;
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
                    <form class="mg-b-20" method="post" action="{{route('result.session.post',$student->slug)}}">
                        @csrf
                        <div class="row gutters-8 justify-content-between">
                            <div class="col-lg-6 col-12 form-group">
                                <select name="year" class="select2">
                                    @foreach(\App\Session::all() as $session)
                                        <option {{($year->id== $session->id)?'selected':''}} value="{{$session->id}}">{{$session->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">Get</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="layout" class="table-responsive pb-5">
                <table class="table my-3">
                    <tbody>
                    <tr>
                        <th rowspan="2">Subjects</th>
                        @foreach(\App\Terms::get() as $term)
                            <th colspan="{{$term->sequence->count()}}">{{$term->byLocale()->name}}</th>
                            <th rowspan="2" style="width: 50px">Total Mark</th>
                            <th rowspan="2" style="width: 50px">Appr</th>
                        @endforeach
                    </tr>

                    <tr>
                        @foreach(\App\Terms::get() as $term)
                            @foreach($term->sequence as $sequence)
                                <th>{{substr($sequence->byLocale()->name,0,3)}} Month</th>
                            @endforeach
                        @endforeach
                    </tr>
                    @foreach(\App\Section::find($section)->subjects as $subject)
                        <tr>
                            <th style="width: 160px;">{{$subject->byLocale()->name}}</th>
                            @foreach(\App\Terms::get() as $term)
                                @foreach($term->sequence as $sequence)
                                    <th>{{$student->mark($subject->id, $year->id, $sequence->id)}}</th>
                                @endforeach
                                    <th>{{$student->termMark($subject->id, $year->id, $term->id)}}</th>
                                    <th></th>
                            @endforeach
                        </tr>
                    @endforeach

                    <tr>
                        <th class="font-bold" style="width: 160px;">Total</th>
                        @foreach(\App\Terms::get() as $term)
                            @foreach($term->sequence as $sequence)
                                <th>{{$student->total($year->id, $sequence->id)}}</th>
                            @endforeach
                            <th>{{$student->termTotal($year->id, $term->id)}}</th>
                            <th></th>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="font-bold" style="width: 160px;">Average</th>
                        @foreach(\App\Terms::get() as $term)
                            @foreach($term->sequence as $sequence)
                                <th>-</th>
                            @endforeach
                            <th>-</th>
                            <th>-</th>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="font-bold" style="width: 160px;">Position</th>
                        @foreach(\App\Terms::get() as $term)
                            @foreach($term->sequence as $sequence)
                                <th>-</th>
                            @endforeach
                            <th>-</th>
                            <th>-</th>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
    <script>
        function print() {
            var printContents = $('#layout').html();
            w = window.open();
            w.document.write('<html><head>');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/normalize.css" type="text/css" />');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/main.css" type="text/css" />');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/bootstrap.min.css" type="text/css" />');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/all.min.css" type="text/css" />');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/fonts')}}/flaticon.css" type="text/css" />');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/style.css" type="text/css" />');
            w.document.write('</head><body>');
            w.document.write(printContents);
            w.document.write('</body>');
            w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');
            w.document.write('</html>');
            w.document.close();
            w.focus();
            return true;
        }
    </script>
@endsection
