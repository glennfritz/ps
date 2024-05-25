
@extends('layout.base')



@section('section')
    <!-- Breadcubs Area End Here -->
    <!-- Add Expense Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add New Expense</h3>
                </div>
            </div>
            <form class="new-added-form" method="post" action="{{route('expenses.collect.submit')}}">
                @csrf
                <div class="row">
                    <div class="col-3 form-group">
                        <label>Amount</label>
                        <input type="number"  value="{{old('amount')}}"  name="amount" placeholder="" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Expense</label>
                        <select name="expense_id" class="select2">
                            <option value="">Please Select</option>
                            @foreach( \App\ExpenceType::get() as $expense)
                                <option value="{{$expense->id}}">{{$expense->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Status</label>
                        <select name="status" class="select2">
                            <option value="">Please Select</option>
                            @foreach( config('constants.EXPENSE_STATUS') as $name)
                                <option value="{{$name}}">{{$name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date</label>
                        <input name="date"  type="text" placeholder="dd/mm/yy" class="form-control air-datepicker" data-position="bottom right">
                    </div>
                    <div class="col-12 form-group">
                        <label>Motive</label>
                        <textarea class="textarea form-control"  value="{{old('motive')}}" name="motive" id="form-message" rows="3"> {{old('motive')}}</textarea>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                          </div>
                </div>
            </form>
        </div>
    </div>

@endsection



