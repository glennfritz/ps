@extends('layout.base')

@section('title')
    Fee
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <!-- Breadcubs Area End Here -->
    <!-- Fees Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All Fees Collection</h3>
                </div>
                <div class="dropdown">
                    <a href="{{route('fee.collect')}}" class="fw-btn-fill btn-gradient-yellow">Collect Fee</a>
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
                                <td>{{$fee->user->first_name}} {{$fee->user->last_name}}</td>
                                <td>{{$fee->session->name}}</td>
                                <td>{{$fee->created_at->format('d/m/Y')}}</td>
                                <td>
                                    <a onclick="event.preventDefault();
												document.getElementById('delete').submit();" class=" btn text-white btn-danger"><i
                                            class="fas"></i> Delete</a>


                                    <form id="delete" action="{{route('fee.delete', $fee->id)}}" method="POST" style="display: none;">
                                        @method('DELETE')
                                        {{ csrf_field() }}
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
@endsection
