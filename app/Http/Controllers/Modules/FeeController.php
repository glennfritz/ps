<?php


namespace App\Http\Controllers\Modules;

use anlutro\LaravelSettings\ArrayUtil;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DateTime;

class FeeController extends Controller{
    protected $q = [
        'action' => 'completed',
        'student' => null,
        'year' => 4
    ];

    public function index(Request $request){
        $data['fees'] = \App\StudentFeePayment::whereDate('created_at', \Carbon\Carbon::today())->get();
        return view('fees.index')->with($data);
    }

    public function show(Request $request, $slug){
        return view('fees.show');
    }

    public function edit(Request $request, $slug){
        return view('fees.edit');
    }

    public function collect(Request $request){
        $data['student'] = \App\Student::whereSlug($request->student)->first();
        $data['year'] = $data['student']->sClass()?$data['student']->sClass()->year_id:getYear();

        if(!$data['student']){
            abort(404);
        }
        return view('fees.create')->with($data);
    }

    public function collectSubmit(Request $request){
        return view('welcome');
    }

    public function update(Request $request){
        $fee = \App\StudentFeePayment::findOrFail($request->fee);
        if ($request->user()->can('create_fee')) {
            $fee->delete();
            $request->session()->flash('success',"Fee Deleted Successfully");
            return redirect(route('fee'));
        }else{
            return redirect()->back()->with(['error'=>'Not allowed to perform this action']);
            return redirect(route('fee'));
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->can('create_fee')) {
            $this->validate($request, [
                'student' => 'required',
                'amount' => 'required|integer',
                'reference' => 'required',
                'method' =>'required',
                'year'=>'required',
                'type'=>'required',
            ]);


            $student = \App\Student::find($request->student);
            if($request->amount > $student->dept(getYear())){
                $request->session()->flash('error', "Negative Balance");
                return redirect()->back()->withInput($request->all());
            }else{
                \Auth::user()->collectFee($request);
                $request->session()->flash('success',"Fee Collected Successfully");
            }

            return redirect(route('fee'));
        }else{
            return redirect()->back()->with(['error'=>'Not allowed to perform this action']);
        }

    }
    public function destroy(Request $request, $id)
    {
        if ($request->user()->can('delete-tasks')) {
        }
        return redirect()->to(route('roles.index'))->with(['success'=>'Roles Created Successfully']);
    }
    public function classFee(Request $request){
        return view('fees.class');
    }
    public function classFeeUpdate(Request $request){
        $this->validate($request, [
            'class' => 'required',
        ]);
        foreach ($request->class as $id){
            $class = \App\Classes::find($id);
            foreach(\App\FeeType::get() as $t){
                $amount = $request->get("fee_".$id."_".$t->id, 0);
                $class->setFee($amount, $t->id);
            }
        }
        $request->session()->flash('success',"Successful");
        return redirect()->back();
    }
    public function type(){
        return view('fees.type');
    }

    public function typePost(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $type = \App\FeeType::create($request->all());
        $request->session()->flash('success',"Successful");
        return redirect()->back();
    }

    public function monthlyReport(Request $request){

       $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $year = Carbon::now()->year;

        if($request->month){
            $month = $request->month;
        }

        $data['day'] = $day;
        $data['month'] = $month;
        $data['year'] = $year;


        return view('fees.month')->with($data);
    }

    public function owing(){
        $students = [];
        foreach(\App\Classes::get() as $class){
            foreach( $class->students(getYear()) as $student){
                if($student->dept(getYear()) > 0){
                    array_push($students, $student);
                }
            }
        }
        $data['students'] = $students;
        return view('fees.owing_student')->with($data);
    }

    public function student(Request $request){
        $student = [];
        $year = $request->year?$request->year:getYear();
        $data['year'] = $year;

        $q = $this->q;

        if ($request->get('action')) {
            $q['action'] = $request->get('action');
        }

        $q['year'] = $year;

        $data['q'] = $q;
        if($request->action == 'scholarship'){
            $students = \App\Student::where('admission_year',0)->orderBy('created_at','DESC')->get();
            foreach(\App\Classes::get() as $clas){
                foreach ($clas->subClass($year) as $class){
                    if($request->class == 0){
                        foreach( $class->student as $student){
                            if($student->scholarship($year) > 0){
                                $students->push($student);
                            }
                        }
                    }else{
                        if($request->class == $class->id){
                            foreach( $class->student as $student){
                                if($student->scholarship($year) > 0){
                                    $students->push($student);
                                }
                            }
                        }
                    }
                }
            }
            $data['students'] = $students;
        }else if($request->action == 'completed'){
            $students = \App\Student::where('admission_year',0)->orderBy('created_at','DESC')->get();
            foreach(\App\Classes::get() as $clas){
                foreach ($clas->subClass($year) as $class) {
                    if ($request->class == 0) {
                        foreach ($class->student as $student) {
                            if ($student->dept($year) == 0) {
                                $students->push($student);
                            }
                        }
                    } else {
                        if ($request->class == $class->id) {
                            foreach ($class->students($year) as $student) {
                                if ($student->dept($year) == 0) {
                                    $students->push($student);
                                }
                            }
                        }
                    }
                }
            }
            $data['students'] = $students;
        }elseif($request->action == 'owing') {
            $students = \App\Student::where('admission_year',0)->orderBy('created_at','DESC')->get();
            foreach(\App\Classes::get() as $clas){
                foreach ($clas->subClass($year) as $class) {
                    if ($request->class == 0) {
                        foreach ($class->student as $student) {
                            if ($student->dept($year) > 0) {
                                $students->push($student);
                            }
                        }
                    } else {
                        if ($request->class == $class->id) {
                            foreach ($class->students($year) as $student) {
                                if ($student->dept($year) > 0) {
                                    $students->push($student);
                                }
                            }
                        }
                    }
                }
            }
            $data['students'] = $students;
        }elseif($request->action == 'giftscholarship'){
            $students = \App\Student::where('admission_year',0)->orderBy('created_at','DESC')->get();
            foreach(\App\Classes::get() as $clas){
                foreach ($clas->subClass($year) as $class) {
                    if ($request->class == 0) {
                        foreach ($class->student as $student) {
                            $students->push($student);
                        }
                    } else {
                        if ($request->class == $class->id) {
                            foreach ($class->students($year) as $student) {
                                $students->push($student);
                            }
                        }
                    }
                }
            }
            $data['students'] = $students;
        }else{
            $students = \App\Student::where('admission_year',0)->orderBy('created_at','DESC')->get();
            foreach(\App\Classes::get() as $clas){
                foreach ($clas->subClass($year) as $class) {
                    if ($request->class == 0) {
                        foreach ($class->student as $student) {
                            if ($student->dept($year) > 0) {
                                $students->push($student);
                            }
                        }
                    } else {
                        if ($request->class == $class->id) {
                            foreach ($class->students($year) as $student) {
                                if ($student->dept($year) > 0) {
                                    $students->push($student);
                                }
                            }
                        }
                    }
                }
            }
            $data['students'] = $students;
        }
        return view('fees.student')->with($data);
    }

    public function print(Request $request){
        $year = $request->year?$request->year:getYear();
        $q = $this->q;

        if ($request->get('action')) {
            $q['action'] = $request->get('action');
        }

        if ($request->get('student')) {
            $q['student'] = $request->get('student');
        }

        $q['year'] = $year;

        $data['q'] = $q;

        $data['year'] = $year;
        if($request->action == 'print'){
            $student = \App\Student::whereSlug($request->student)->first();
            $data['title'] = $student->name."'s Fee Reciept for ".\App\Session::find($year)->name;
            $data['student'] = $student;
            $data['year'] = $year;
            return view('fees.studentpayment')->with($data);
        }else{
            $students = \App\Student::orderBy('created_at','DESC')->get();
            foreach(\App\Classes::get() as $class){
                foreach($class->students($year) as $student){
                    if($student->feePayment->count() > 0){
                       if(!$students->contains($student)){
                           $students->push($student);
                       }
                    }
                }
            }
            $data['students'] = $students;
            return view('fees.student')->with($data);
        }
    }

    public function report(Request $request){
        if($request->action == 'print') {
            $data['title'] = "Fee Report";
            $data['fees'] = \App\StudentFeePayment::all();
            $pdf = \PDF::loadView('template.income', $data);
        }else{
            $data['fees'] = \App\StudentFeePayment::all();
            return view('fees.report')->with($data);
        }
    }

    public function scholarship(Request $request){
        $data['student'] = \App\Student::whereSlug($request->student)->first();
        if(!$data['student']){
            abort(404);
        }
        return view('fees.scholarship')->with($data);

    }

    public function scholarshipSave(Request $request){
        if ($request->user()->can('create_fee')) {
            $this->validate($request, [
                'student' => 'required',
                'year' => 'required',
                'amount' => 'required|integer',
            ]);
            \App\Student::find($request->student)->setScholarShip($request);
           if($request->amount < 0){
                $request->session()->flash('success',"Dept saved successfully");
           }else{
                $request->session()->flash('success',"Scholarship Saved Successfully");
           }
            return redirect(route('fee.student')."?action=scholarship");
        }else{
            return redirect()->back()->with(['error'=>'Not allowed to perform this action']);
        }
    }

    public function scholarshipReport (Request $request){
        $year = $request->year?$request->year:getYear();
        $data['year'] = $year;
        $data['fees'] =   \App\StudentDiscount::where('year_id', $year)->get();
        $data['title'] =   "Scholarships";
        if($request->action == 'print'){
            $pdf = \PDF::loadView('template.scholarship', $data);
            return $pdf->download('Scholarship.pdf');
        }else {
            return view('fees.scholarship_report')->with($data);
        }
    }
    public function income(Request $request){
        $data['title'] =   "Income Statement";
        if($request->action == 'print'){
            $pdf = \PDF::loadView('template.income', $data);
            return $pdf->download('Income_report.pdf');

        }else {
            return view('fees.income')->with($data);
        }
    }

    public function monthlyReceipt(Request $request){

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        if($request->month){
            $month = $request->month;
        }

        if($request->year){
            $year = $request->year;
        }

        $data['month'] = $month;
        $data['year'] = $year;


        $data['fees'] = \App\StudentFeePayment::whereMonth('created_at', '=', $month)->whereYear('created_at','=', $year)->get();

       // dd($data['fees']);
        return view('fees.month_report')->with($data);
    }

}
