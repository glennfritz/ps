@extends('layout.base')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <div id="layout" class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All @if(request('action')=='scholarship' || request('action') =='giftscholarship') {{"Scholarships"}}  @elseif(request('action')=='owing') {{"UnCompleted Fee"}}  @else  {{"Completed Fee"}}   @endif  for {{\App\Session::find($year)->name}}</h3>
                </div>

                <button onclick="print()">print</button>
            </div>

            <form class="mg-b-20"  method="get" action="">
                <input type="hidden" name="action" value="{{request('action')}}">
                <div class="row gutters-8">
                    <div class="col-lg-3  mt-1">
                        <div class="dropdown">
                            <a class="text-dark text-left btn btn-fill-md w-100 bg-ash text-14" href="#" role="button" data-toggle="dropdown"
                               aria-expanded="false">@if(request('action')=='scholarship') {{"Scholarships"}}  @elseif(request('action')=='owing') {{"UnCompleted Fee"}}  @else  {{"Completed Fee"}}   @endif</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{route('fee.student',['action'=>'owing','year'=>$q['year']])}}">UnCompleted Fee</a>
                                <a class="dropdown-item" href="{{route('fee.student',['action'=>'scholarship','year'=>$q['year']])}}">Scholarships</a>
                                <a class="dropdown-item" href="{{route('fee.student',['action'=>'completed','year'=>$q['year']])}}">Completed Fee</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3  mt-1">
                        <div class="dropdown">
                            <a class="text-dark text-left btn btn-fill-md w-100 bg-ash text-14" href="#" role="button" data-toggle="dropdown"
                               aria-expanded="false">{{\App\Session::find($q['year'])->name}}</a>
                            <div class="dropdown-menu dropdown-menu-right">
                               @foreach(\App\Session::get() as $session)
                                    <a class="dropdown-item" href="{{route('fee.student' ,['action'=>$q['action'],'year'=>$session->id])}}">{{$session->name}}</a>
                               @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="table-responsive">
                <table  class="table data-table text-nowrap">
                    <thead>
                    <tr>
                        @php($i =1)
                        <th>#</th>
                        <th>Name</th>
                         <th>Class</th>
                        <th>year</th>
                        <th>Amount<br/>Paid</th>
                        <th>Amount<br/>Owing</th>
                        <th>Scholarship</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{$i++}} </td>
                                <td>{{$student->name}}</td>
                                <td>{{($student->sClass())?$student->sClass()->class->byLocale()->name:''}}</td>
                                <td>{{\App\Session::find($student->sClass()->year_id)->name}}</td>
                                <td>{{$student->totalPaid($year) < 0?0:$student->totalPaid($year)}}</td>
                                <td class="{{$student->dept($year) >0?'text-red':''}}">{{$student->dept($year)}}</td>
                                <td>{{$student->scholarship($year)}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{route('fee.print')}}?student={{$student->slug}}&action=print"><i class="fas fa-print"></i> View receipt </a>
                                    <a class="btn btn-primary" href="{{route('fee.collect')}}?student={{$student->slug}}"><i class="fas fa-plus"></i> Collect Fee</a>
                                    @if(request('action')=='scholarship' || request('action') =='giftscholarship')
                                        <a class="btn btn-primary" href="{{route('fee.scholarship')}}?student={{$student->slug}}"><i class="fas fa-edit"></i> Scholarship</a>
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
    <script>
        function print() {
            var printContents = $('#layout').html();
            var title = $('#title').html();
            w = window.open();
            w.document.write('<html><head>');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/bootstrap.min.css" type="text/css" />');
            w.document.write('<style>');
            w.document.write('#DataTables_Table_0_filter{display: none;} button {display: none ;}input {display: none; } .btn{display :none;}a{display: none;}');
            w.document.write('</style>');
            w.document.write('</head><body>');
            w.document.write('<img class="image-fluid" src="{{asset('assets/img')}}/header.png" />');
            w.document.write('<table>');
            w.document.write(printContents);
            w.document.write('</table>');
            w.document.write('</body>');
           // w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');
            w.document.write('</html>');
            w.document.close();
            w.focus();
            return true;
        }
    </script>
@endsection
