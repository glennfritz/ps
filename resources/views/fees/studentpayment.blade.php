@extends('layout.base')

@section('title')
    Fee Reciept
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('public/assets/css')}}/jquery.dataTables.min.css">
@endsection

@section('section')
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>{{$student->name}} Fee Payment</h3>
                    <div class="dropdown">
                        <a class="text-dark text-left btn btn-fill-md w-100 bg-ash text-14" href="#" role="button" data-toggle="dropdown"
                           aria-expanded="false">{{\App\Session::find($q['year'])->name}}</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @foreach(\App\Session::get() as $session)
                                <a class="dropdown-item" href="{{route('fee.print' ,['student'=>$q['student'],'action'=>$q['action'],'year'=>$session->id])}}">{{$session->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="table-responsive">
                <table class="table data-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Collector</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($student->feePayment()->where('year_id', $year)->get() as $payment)
                        @php
                            $fee = $payment;
                            $year = $payment->session->id;
                        @endphp

                        <tr>
                            <td>{{$payment->user->name}}</td>
                            <td>{{($payment->created_at->diffForHumans())}}</td>
                            <td>{{$payment->amount}}</td>
                            <td>
                                <button onclick="print('hello{{$payment->id}}')"  class="btn btn-primary" ><i class="fas fa-print"></i>Print</button>
                                <div class="d-none">
                                    <div id="hello{{$payment->id}}" class="eachrec">
                                                <div style="height:120px; width:95% " >
                                                    <img src="{{asset('public/assets/img')}}/header.png" />
                                                </div>
                                                <div style=" float:left; width:550px; margin-top:17px;TEXT-ALIGN:CENTER;  height:34px;font-size:24px; ">
                                                    CASH RECEIPT
                                                </div>
                                                <div style=" float:left; width:140px; margin-top:17px;TEXT-ALIGN:CENTER;  height:34px;font-size:18px; ">
                                                    N<SUP>0</SUP> 00{{$fee->id}}
                                                </div>
                                                <div style=" float:left; width:720px; margin-top:0px;TEXT-ALIGN:CENTER; font-family:arial; height:300px;font-size:13px; ">
                                                    <div style=" float:left; width:170px; height:25px;font-size:17px;"> Name :</div>
                                                    <div style=" float:left; width:500px;border-bottom:1px solid #000;font-weight:normal; height:25px;font-size:17px;">
                                                        <div style=" float:left; width:300px;margin-top:3px;">
                                                            {{$fee->student->name}}
                                                        </div>
                                                        <div style=" float:left; width:200px;  height:25px;margin-top:3px;">

                                                        </div>
                                                    </div>
                                                    <div style=" float:left; width:170px; height:25px;font-size:17px;"> Purpose :</div>
                                                    <div style=" float:left; width:500px;border-bottom:1px solid #000;font-weight:normal; height:25px;font-size:17px;">
                                                        <div style=" float:left; width:500px;margin-top:3px;">
                                                            {{$fee->type->name}}
                                                        </div>
                                                        <div style=" float:left; width:200px;  height:25px;margin-top:3px;"></div>
                                                    </div>

                                                    <div style=" float:left; width:170px; height:25px;font-size:17px;"> Academic year:</div>
                                                    <div style=" float:left; width:500px;border-bottom:1px solid #000;font-weight:normal; height:25px;font-size:17px;">
                                                        <div style=" float:left; width:300px;margin-top:3px;">
                                                            {{\App\Session::find($year)->name}}
                                                        </div>
                                                        <div style=" float:left; width:200px;  height:25px;margin-top:3px;"></div>
                                                    </div>
                                                    <div style=" float:left; width:700px;margin-top:3px;TEXT-ALIGN:CENTER; font-family:arial; height:300px; font-size:13px; ">
                                                        <div style=" float:left; width:170px; height:25px;font-size:17px;"> Amount in Figure</div>
                                                        <div style=" float:left; width:500px; height:25px;font-size:17px;">
                                                            <div style=" float:left; width:200px;border:1px solid #000;margin-top:3px;">
                                                                XAF {{$fee->amount}}
                                                            </div>
                                                            <div style=" float:left; width:100px;margin-top:3px;">
                                                                DATE
                                                            </div>
                                                            <div style=" float:left; border-bottom:1px solid #000;margin-top:3px;">
                                                                {{$fee->updated_at->format('d/m/Y')}}
                                                            </div>
                                                        </div>
                                                        <div style=" float:left; width:700px;margin-top:3px;TEXT-ALIGN:CENTER; font-family:arial; height:30px; BORDER-BOTTOM:none; font-size:13px; ">
                                                            <div style=" float:left; width:170px; height:25px;font-size:17px;"> <i>Amount in Words</i></div>
                                                            <div style=" float:left; width:500px; height:25px; border-bottom:none; font-size:16px; font-family:Chaparral Pro Light; border-bottom:1PX dashed#000"><i>{{numToWord($fee->amount)}}</i></div>
                                                        </div>
                                                        <div style=" float:left; width:700px;margin-top:3px;TEXT-ALIGN:CENTER; font-family:arial; height:30px; BORDER-BOTTOM:none; font-size:13px; ">
                                                            <div style=" float:left; width:170px; height:25px;font-size:17px;"> <i>Balance Due</i></div>
                                                            <div style=" float:left; width:500px; height:25px; border-bottom:none; font-size:16px; font-family:Chaparral Pro Light; border-bottom:1PX dashed#000"><i>{{getBal($fee, $year)}}</i></div>
                                                        </div>
                                                        <div style=" clear:both; height:30px"></div>

                                                        <div style="float:left; margin:10px 30px; height:30px; ">
                                                            ___________________<br /><br />Bursar Signature
                                                        </div>

                                                        <div style="float:right; margin:10px 30px; height:30px;">
                                                            ___________________<br /><br />Student Signature
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                </div>
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
    <script src="{{asset('public/assets/js')}}/jquery.dataTables.min.js"></script>

@endsection
