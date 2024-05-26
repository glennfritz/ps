@extends('layout.base')

@section('title')
  Result - Bulk Print
@endsection

@section('section')
    @if(request('class') != null && request('year') != null && count($sections) > 0)

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                </div>
                <form action="" method="post" class="new-added-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label>Section</label>
                            <select class="select2" required name="section">
                                @foreach($sections as $section)
                                    <option value="{{$section->id}}">{{$section->class->name}} {{$section->section_id}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class=" col-12 form-group">
                            <label>Amount</label>
                            <input type="number" name="amount"  value="{{old('amount')}}"  class="form-control">
                        </div>

                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                </div>
                <form method="get" class="new-added-form">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label>Academic Year</label>
                            <select class="select2"    required name="year">
                                @foreach(\App\Session::all() as $class)
                                    <option {{($class->id == old('year',getYear()))?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 form-group">
                            <label>Class *</label>
                            <select class="select2"  value="{{old('class')}}"  name="class" required>
                                @foreach(\App\Section::all() as $section)
                                    @foreach($section->class as $class)
                                        <option value="{{$class->id}}">{{$section->name}} - {{$class->byLocale()->name}}</option>
                                    @endforeach
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
    @endif

   <div class="d-none">
       @php($i = 0)
       @foreach($students as $student)
           <div id="layout{{$i++}}">{{$student}}</div>
       @endforeach
   </div>
@endsection

@section('script')
<script>
    @php($i = 0)
    @foreach($students as $student)
    var printContents = $('#layout{{$i++}}').html();
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
   // w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');
    w.document.write('</html>');
    w.document.close();
    w.focus();
    @endforeach
</script>
@endsection
