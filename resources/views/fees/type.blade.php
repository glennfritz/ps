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
                    <h3>All Fees Types</h3>
                </div>
                <div class="dropdown">
                    <button onclick="showAddModal()" class="fw-btn-fill btn-gradient-yellow">Add Type</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\FeeType::get() as $type)
                            <tr>
                                <td>{{$type->byLocale()->name}}</td>
                                <td>{{$type->byLocale()->description}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addModal"  role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <form method="post" class="modal-content" action="{{route('fee.type.post')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Fee Type</h5>
                </div>
                <div class="modal-body">
                    <div class="col-12 form-group">
                        <label>Type Name</label>
                        <input type="text" name="name" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-gradient-yellow text-white">Save</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('script')
    <script src="{{asset('assets/js')}}/jquery.dataTables.min.js"></script>
    <script>
        function  showAddModal() {
            $('#addModal').modal().show()
        }
    </script>
@endsection
