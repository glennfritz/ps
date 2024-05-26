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
                    <h3>All Student Scholarship</h3>
                </div>
                <div class="dropdown">
                    <a href="{{route('fee.scholarship.report')}}?action=print" class="fw-btn-fill btn-gradient-yellow">Print</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Amount</th>
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
                                <td>{{$fee->created_at->format('d/m/Y')}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{route('fee.scholarship')}}?student={{$fee->student->slug}}"><i class="fas fa-edit"></i> Scholarship</a>
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
@endsection
