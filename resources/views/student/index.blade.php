@extends('layout.base')

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
                   @if(request('class'))
                        <h3 id="title">{{ "All Student in ". \App\AnnualClass::find(request('class'))->class->byLocale()->name }} {{$class?$class->section_id:''}}</h3>
                    @else
                        <h3 id="title">All Students Data</h3>
                   @endif
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
                        <th>Gender</th>
                        <th>Section</th>
                        <th>Class</th>
                        <th>Parents</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{$i++}} </td>
                                <td>{{$student->matricule}} </td>
                                <td>{{$student->name}} </td>
                                <td>{{$student->gender}}</td>
                                <td>{{($student->sClass())?$student->sClass()->class->section->name:''}}</td>
                                <td>{{($student->sClass())?$student->sClass()->class->byLocale()->name:''}}</td>
                                <td>{{($student->parent() != null)?$student->parent()->name:''}} {{($student->parent() != null)?$student->parent()->last_name:''}}</td>
                                <td>
                                     <a class="btn btn-primary" href="{{route('student.show', $student->slug)}}"><i
                                                    class="fas fa-eye"></i> View</a>
                                    @if(\Auth::user()->hasRole('admin'))
                                        <a class="btn btn-success" href="{{route('student.edit', $student->slug)}}"><i
                                                class="fas fa-edit"></i> Edit</a>

                                        <a onclick="event.preventDefault();
												document.getElementById('delete{{$student->id}}').submit();" class=" btn text-white btn-danger"><i
                                                class="fas"></i> Delete</a>
                                        <form id="delete{{$student->id}}" action="{{route('student.destroy', $student->slug)}}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                </td>
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
