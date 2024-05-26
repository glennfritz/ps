@extends('layout.base')

@section('title')
    Fee
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Fee Report</h3>
                </div>
                <div class="dropdown">
                    <a href="{{route('fee.income')}}?action=print" class="fw-btn-fill btn-gradient-yellow">Print</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Fee Type</b></td>
                            <td><b>Amount</b></td>
                            <td></td>
                        </tr>
                        @foreach(\App\FeeType::get() as $type)
                            <tr>
                                <td>{{$type->name}}</td>
                                <td>XAF  {{$type->total(getYear())}}</td>
                                <td></td>
                            </tr>
                        @endforeach

                        <tr>
                            <td><b>Payment Method</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach(\App\PaymentMethod::get() as $type)
                            <tr>
                                <td>{{$type->name}}</td>
                                <td>XAF  {{$type->total(getYear())}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><b>Scholarships</b></td>
                            <td><b>XAF {{getTotalScholarship(getYear())}}</b></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><b>Total Fee Payed</b></td>
                            <td><b>XAF  {{getFeePayed(getYear())}}</b></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><b>Total Expenses</b></td>
                            <td><b>XAF  {{getExpenses(getYear())}}</b></td>
                            <td></td>
                        </tr>
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

