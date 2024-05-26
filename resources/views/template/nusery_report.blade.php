        <div style="height:120px; width:95% " >
            <img src="{{asset('assets/img')}}/header.png" />
        </div>
        <h3>{{$title}}</h3>
            <div class="heading-layout1">
                <div class="item-title d-flex-column w-100">
                    <h5 class="mb-0"> {{$student->name}}</h5>
                    <h5 class="mb-0"> {{$student->class($year->id)->name}}</h5>
                </div>
            </div>
            <div class="table-responsive pb-5">
                <table class="table my-3">
                    <thead>
                    <tr>
                        <th></th>
                        @foreach(\App\Sequence::get() as $sequence)
                            <th>{{$sequence->byLocale()->name}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Subjects</th>
                        @foreach(\App\Sequence::get() as $sequence)
                            <th><p class="mb-0">Appreciation</p>
                                <div class="d-flex w-100">
                                    <div class=" d-flex flex-nowrap w-100 justify-content-center text-center">
                                        <div class="border h-100 flex-grow-1">1</div>
                                        <div class="border h-100 flex-grow-1">2</div>
                                        <div class="border h-100 flex-grow-1">3</div>
                                        <div class="border h-100 flex-grow-1">4</div>
                                        <div class="border h-100 flex-grow-1">5</div>
                                    </div>
                                </div></th>
                        @endforeach
                    </tr>
                    @foreach(\App\Section::find(1)->subjects as $subject)
                        <tr>
                            <th style="width: 160px;">{{$subject->byLocale()->name}}</th>
                            @foreach(\App\Sequence::get() as $sequence)
                                <th align="center"><x-rate :value="$student->mark($subject->id, $year->id, $sequence->id)"/></th>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
