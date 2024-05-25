@extends('layout.base')
@section('style')
    <link rel="stylesheet" href="{{asset('public/assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <div id="layout" class="card height-auto">
        <div class="card-body">
            <div class="item-title">
                <div class=" mt-1">
                    <h3> Fee Collected on {{getMonthName($month)}} , {{$year}}</h3>
                    <div class="row">
                        <div class="col-sm-6 p-3">
                            <div class="dropdown">
                                <a class="text-dark text-left btn btn-fill-md w-100 bg-ash text-14" href="#" role="button" data-toggle="dropdown"
                                   aria-expanded="false">{{getMonthName($month)}}</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'1', 'year'=>$year])}}">January</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'2','year'=>$year])}}">February</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'3','year'=>$year])}}">March</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'4','year'=>$year])}}">April</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'5','year'=>$year])}}">May</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'6','year'=>$year])}}">June</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'7','year'=>$year])}}">July</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'8','year'=>$year])}}">August</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'9','year'=>$year])}}">September</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'10','year'=>$year])}}">October</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'11','year'=>$year])}}">November</a>
                                    <a class="dropdown-item" href="{{route('fee.monthly.receipt',['month'=>'12','year'=>$year])}}">December</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 p-3">
                            <div class="dropdown">
                                <a class="text-dark text-left btn btn-fill-md w-100 bg-ash text-14" href="#" role="button" data-toggle="dropdown"
                                   aria-expanded="false">{{$year}}</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach(\App\Session::all() as $k=>$session)
                                        <a class="dropdown-item" href="{{route('fee.monthly.receipt',['year'=>(\Carbon\Carbon::now()->year - $k), 'month'=>$month])}}">{{\Carbon\Carbon::now()->year - $k }}</a>
                                    @endforeach
                                        <a class="dropdown-item" href="{{route('fee.monthly.receipt',['year'=>(\Carbon\Carbon::now()->year - $k - 1),'month'=>$month])}}">{{\Carbon\Carbon::now()->year - $k-1 }}</a>
                                </div>
                            </div>
                        </div>



                    </div>
                    <button onclick="print()">print</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Amount</th>
                        <th>Collected By</th>
                        <th>Academic Year</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($fees as $fee)
                        <tr>
                            <td>{{$fee->student->name}}</td>
                            <td>{{($fee->student->class($fee->session->id))?$fee->student->class($fee->session->id)->byLocale()->name:''}}</td>
                            <td>{{$fee->amount}}</td>
                            <td>{{$fee->user->name}}</td>
                            <td>{{$fee->session->name}}</td>
                            <td>{{$fee->created_at->format('d/m/Y')}}</td>
                            <td>

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
    <script src="{{asset('public/assets/js')}}/jquery.dataTables.min.js"></script>
    <script>
        function print() {
            var printContents = $('#layout').html();
            var title = $('#title').html();
            w = window.open();
            w.document.write('<html><head>');
            w.document.write('<link rel="stylesheet" href="{{asset('public/assets/css')}}/bootstrap.min.css" type="text/css" />');
            w.document.write('<style>');
            w.document.write('#DataTables_Table_0_filter{display: none;} button {display: none ;}input {display: none; } .btn{display :none;}a{display: none;}');
            w.document.write('</style>');
            w.document.write('</head><body>');
            w.document.write('<img class="image-fluid" src="{{asset('public/assets/img')}}/header.png" />');
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
