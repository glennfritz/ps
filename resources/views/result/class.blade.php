@extends('layout.base')

@section('title')
   Result
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Choose Class</h3>
                </div>
            </div>
            <div class="row px-2">
                    <div class="col-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                @foreach(\App\Section::get() as $val)
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>{{$val->name}}</h3>
                                        </div>
                                    </div>
                                    <div class="row my-5">
                                        @foreach(\App\Classes::where('section_id',$val->id)->get() as $class)
                                            <div class="col-md-3 card">
                                                <a class="text-dark" href="{{route('result.class.sub', $class->id)}}">
                                                    <div class="card-body d-flex justify-content-center align-items-center">
                                                        {{$class->byLocale()->name}}
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
@endsection
