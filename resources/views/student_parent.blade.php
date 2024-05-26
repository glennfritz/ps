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
    <div id="layout" class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3 id="title">Student Parent</h3>
                    <div class="dropdown">
                        <a class="text-dark text-left btn btn-fill-md w-100 bg-ash text-14" href="#" role="button" data-toggle="dropdown"
                           aria-expanded="false">{{\App\Session::find($year)->name}}</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @foreach(\App\Session::get() as $session)
                                <a class="dropdown-item" href="{{route('pupil.parent' ,['year'=>$session->id])}}">{{$session->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button onclick="print()">print</button>
            </div>

            <div  class="table-responsive">
                <table  class="table display data-table text-nowrap">
                    <thead>
                    @php($i =1)
                    <tr>
                        <th>#</th>
                        <th>Matricule</th>
                        <th>Name</th>
                        <th>CLass</th>
                        <th>Parent</th>
                        <th>Contact</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{$i++}} </td>
                                <td>{{$student->matricule}} </td>
                                <td>{{$student->name}} </td>
                                <td>{{($student->sClass())?$student->sClass()->class->section->name:''}} {{($student->sClass())?$student->sClass()->class->byLocale()->name:''}}</td>
                                <td>{{($student->parent() != null)?$student->parent()->name:''}} {{($student->parent() != null)?$student->parent()->last_name:''}}</td>
                                <td>{{(($student->parent() != null)?$student->parent()->phone:'')==''?$student->phone:$student->parent()->phone}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Student Table Area End Here -->
@endsection
@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/js')}}/select2.min.js"></script>
    <script src="{{asset('assets/js')}}/datepicker.min.js"></script>
@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
    <script>
        function print() {
            var printContents = $('#layout').html();
            var title = $('#title').html();
            w = window.open();
            w.document.write('<html><head>');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/normalize.css" type="text/css" />');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/bootstrap.min.css" type="text/css" />');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/style.css" type="text/css" />');
            w.document.write('<style>');
            w.document.write('#DataTables_Table_0_filter{display: none;} button {display: none ;}input {display: none; } .btn{display :none;}a{display: none;}');
            w.document.write('</style>');
            w.document.write('</head><body>');
            w.document.write('<img class="image-fluid" src="{{asset('assets/img')}}/header.png" />');
            w.document.write('<table>');
            w.document.write(printContents);
            w.document.write('</table>');
            w.document.write('</body>');
            w.document.write('<scr' + 'ipt src="{{asset('assets/js')}}/jquery-3.3.1.min.js" type="text/javascript">' + '</sc' + 'ript>');
            w.document.write('<scr' + 'ipt src="{{asset('assets/js')}}/bootstrap.min.js" type="text/javascript">' +'</sc' + 'ript>');
            //w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');
            w.document.write('</html>');
            w.document.close();
            w.focus();
            return true;
        }
    </script>
@endsection

@endsection
