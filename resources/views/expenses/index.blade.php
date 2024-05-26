@extends('layout.base')

@section('title')
    @if(request('daterange'))
        Expenses between {{request('daterange')}}
    @else
        Todays Expenses
    @endif
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <!-- Breadcubs Area End Here -->
    <!-- Fees Table Area Start Here -->
    <div  id="layout"  class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
            <div></div>
                <div class="d-flex justify-content-between">
                    <button onclick="print()" class="text-white float-right btn-fill-md mx-2 bg-primary">Print</button>
                    <a href="{{route('expenses.collect')}}" class="btn-fill-md btn-gradient-yellow">Add Expense</a>
                </div>
            </div>
            <form class="mg-b-20"  method="get" action="">
                <input type="hidden" name="action" value="{{request('action')}}">
                <div id="query" class="row gutters-8 form-group">
                    <div class=" text-center pr-3 mt-1">
                        <label class="text-center">Select Date Range</label>
                    </div>
                    <div class="flex-grow-1 mt-1">
                        <input type="text" class="form-control" name="daterange" required value="{{request('daterange')}}" />
                    </div>
                    <div class="col-lg-2 mt-1">
                        <button type="submit" class="text-white float-right btn-fill-md btn bg-success btn-success">Search</button>
                    </div>
                </div>
            </form>

            <div  class="table-responsive">
                <table  class="table data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <td>Motive</td>
                        <td>Expense</td>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $expense)
                        <tr>
                            <td>{{$expense->created_at->format('d/m/Y')}}</td>
                            <td>{{$expense->user->name}}</td>
                            <td>{{$expense->motive}}</td>
                            <td>{{$expense->category->name}}</td>
                            <td>XAF {{$expense->amount}}</td>
                            <td>
                                <a class="btn btn-success" href="{{route('expenses.edit', $expense->id)}}"><i
                                        class="fas fa-edit"></i> View</a>

                                <a onclick="event.preventDefault();
												document.getElementById('delete').submit();" class=" btn text-white btn-danger"><i
                                        class="fas"></i> Delete</a>


                                <form id="delete" action="{{route('expenses.destroy')}}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$expense->id}}" name="id">
                                </form>
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
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
            });

            $('.dt-buttons .buttons-print').addClass('d-none')
        });

        function print() {
            var printContents = $('#layout').html();
            var title = $('#title').html();
            w = window.open();
            w.document.write('<html><head>');
            w.document.write('<link rel="stylesheet" href="{{asset('assets/css')}}/bootstrap.min.css" type="text/css" />');
            w.document.write('<style>');
            w.document.write('#DataTables_Table_0_filter{display: none;} #query {display: none ;} form {display: none ;} button {display: none ;}input {display: none; } .btn{display :none;}a{display: none;}');
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
