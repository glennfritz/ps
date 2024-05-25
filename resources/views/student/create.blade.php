@extends('layout.base')

@section('section')
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add New Students</h3>
                </div>
            </div>
            <form class="new-added-form" method="post"   action="{{route('student.store')}}">
                @csrf
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Name *</label>
                        <input type="text" value="{{old('name')}}" name="name" required class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Gender *</label>
                        <select class="select2" name="gender" required>
                            <option value="">Please Select Gender *</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date Of Birth *</label>
                        <input type="text" placeholder="dd/mm/yyyy"  value="{{old('dob')}}"  required name="dob" class="form-control air-datepicker"
                               data-position='bottom right'>
                        <i class="far fa-calendar-alt"></i>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Address</label>
                        <input name="address" type="text"  value="{{old('address')}}"  required placeholder="" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>E-Mail</label>
                        <input type="email" name="email"  value="{{old('email')}}"  class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Class *</label>
                        <select class="select2"  value="{{old('class')}}"  name="class" required>
                            <option  value="">Please Select Class *</option>
                            @foreach(\App\Section::all() as $section)
                                @foreach($section->class as $class)
                                    <option value="{{$class->id}}">{{$section->name}} - {{$class->byLocale()->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Admission Year</label>
                        <select class="select2"  value="{{old('admission_year')}}"  required name="admission_year">
                            <option>Please Select Admission Year</option>
                            @foreach(\App\Session::all() as $class)
                                <option {{($class->id == getYear())?'selected':''}} value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Phone</label>
                        <input type="text" name="phone"  value="{{old('phone')}}"  placeholder="" class="form-control">
                    </div>
                    <div class="col-lg-6 col-12 form-group mg-t-30">
                        <label class="text-dark-medium">Upload Student Photo (150px X 150px)</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
