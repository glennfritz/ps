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
        <div  class="card-body">
            <div class="heading-layout1">
                <div class="item-title d-flex-column w-100">
                    <h5 class="mb-0"> {{$student->name}} </h5>
                    <h5 class="mb-0"> {{$student->class($year->id)->name}}</h5>
                    <form class="mg-b-20" method="post" action="{{route('result.session.post',$student->slug)}}">
                        @csrf
                        <div class="row gutters-8 justify-content-between">
                            <div class="col-lg-6 col-12 form-group">
                                <select name="year" class="select2">
                                    @foreach(\App\Session::all() as $session)
                                        <option {{($year->id == $session->id)?'selected':''}} value="{{$session->id}}">{{$session->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">Get</button>
                            </div>

                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button onclick="print()"  class="fw-btn-fill btn-gradient-yellow">Print</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="layout" class="table-responsive pb-5">
                <table class="table my-3">
                    <thead>
                    <tr>
                        <th></th>
                        @foreach(\App\Sequence::get() as $sequence)
                            <th>{{$sequence->byLocale()->name}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Subjects</th>
                        @foreach(\App\Sequence::get() as $sequence)
                            <th><p class="mb-0">Appreciation</p>
                                <div class="d-flex w-100">
                                    <div class=" d-flex flex-nowrap w-100 justify-content-center text-center">
                                        <div class="border h-100 flex-grow-1">1</div>
                                        <div class="border h-100 flex-grow-1">2</div>
                                        <div class="border h-100 flex-grow-1">3</div>
                                        <div class="border h-100 flex-grow-1">4</div>
                                        <div class="border h-100 flex-grow-1">5</div>
                                    </div>
                                </div></th>
                        @endforeach
                    </tr>
                    @foreach(\App\Section::find($section)->subjects as $subject)
                       <tr>
                           <th style="width: 160px;">{{$subject->byLocale()->name}}</th>
                           @foreach(\App\Sequence::get() as $sequence)
                               <th align="center"><x-rate :value="$student->mark($subject->id, $year->id, $sequence->id)"/></th>
                           @endforeach
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
