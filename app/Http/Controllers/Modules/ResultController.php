<?php


namespace App\Http\Controllers\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultController extends Controller{
    public function student(Request $request, $id){
        $data = [];
        $data['id'] = $id;
        if(\Auth::user()->hasRole('parent') || $id == 'mine'){
            $data['class'] = null;
            $data['students'] = \Auth::user()->students;
        }elseif(\Auth::user()->hasRole('teacher')){
            $subClass = \Auth::user()->class(getYear());
            if($subClass == null){
                $request->session()->flash('error',"You have Being assigned to no class, contact admin");
                return redirect()->back()->with($data);
            }else{
                $data['class'] = $subClass;
                $data['students'] = $subClass->student;
            }
        }else{
            $subClass = \App\AnnualClass::find($id);
            if($subClass == null){
                abort(404);
            }
            $data['class'] = $subClass;
            $data['students'] = $subClass->student;
        }
        return view('result.student')->with($data);
    }
    public function class(Request $request){
        $data['classes'] = \App\Classes::all();
        return view('result.class')->with($data);
    }
    public function subClass(Request $request, $id){
        $data = [];
        if(\Auth::user()->hasRole('teacher')){
            $data['classes'] = \Auth::user()->class(getYear());
        }else{
            $class = \App\Classes::find($id);
            $data['classes'] = $class->subClass($request->year?$request->year:getYear());
        }
        $data['year'] = $request->year?$request->year:getYear();
        return view('result.subclass')->with($data);
    }
    public function result(Request $request, $slug){
        $student = \App\Student::whereSlug($slug)->first();
        if($student == null){
            $request->session()->flash('error',"Invalid URL");
            return redirect()->back();
        }

        $class = $student->aClass(getYear());
        if($class == null){
            $request->session()->flash('error',"Student was not part of this session");
            return redirect()->back();
        }
        $class = $class->class;
        $data['student'] = $student;
        $data['section'] = $class->section->id;
        $data['year'] = \App\Session::find(getYear());
        $data['class'] = $class;
        if($request->action == 'print'){
            $data['title'] = $student->name.' Result';
            $data['section'] = $class->section->id;
            if($class->section->id <= 2){
                $pdf = \PDF::loadView('template.nusery_report', $data);
               // return view('template.nusery_report')->with($data);
                return $pdf->download($student->name.'_result.pdf');
            }else{
                $pdf = \PDF::loadView('template.primary_report', $data);
                return view('template.primary_report')->with($data);
              // return $pdf->download($student->name.'_result.pdf');
            }
        }else{
            $data['section'] = $class->section->id;
            if($class->section->id <= 2){
                return view('result.nusery_report_card')->with($data);
            }else{
                return view('result.primary_report_card')->with($data);
            }
        }
    }

    public function resultPost(Request $request, $slug){
        $student = \App\Student::whereSlug($slug)->first();
        if($student == null){
            $request->session()->flash('error',"Invalid URL");
            return redirect()->back();
        }

        $class = $student->aClass($request->get('year'));

        if($class == null){
            $request->session()->flash('error',"Student was not part of this session");
            return redirect()->back();
        }

        $data['student'] = $student;
        $data['section'] = $class->class->section->id;
        $data['year'] = \App\Session::find($request->get('year'));
        $data['class'] = $class->class;

        if($class->class->section->id <= 2){
            return view('result.nusery_report_card')->with($data);
        }else{
            return view('result.primary_report_card')->with($data);
        }
    }

    public function edit(Request $request, $slug){
        $student = \App\Student::whereSlug($slug)->first();
        if($student == null){
            $request->session()->flash('error',"Invalid URL");
            return redirect()->back();
        }
        $data['student'] = $student;
        if($request->sequence && $request->year){
            $class = $student->class($request->year);
            if($class == null){
                $request->session()->flash('error',"Student was not part of this session");
                return redirect()->back();
            }
            $data['year'] = \App\Session::find($request->year);
            $data['seq'] = \App\Sequence::find($request->sequence);
            $data['class'] = $class;

        }else{
            $class = $student->class(getYear());
            if($class == null){
                $request->session()->flash('error',"Student was not part of this session");
                return redirect()->back();
            }
            $data['year'] = \App\Session::find(getYear());
            $data['seq'] = \App\Sequence::get()->first();
            $data['class'] = $class;
        }
        $data['section'] = $class->section->id;
        if($class->section->id <= 2){
            return view('result.edit_nusery')->with($data);
        }else{
            return view('result.edit_primary')->with($data);
        }
    }
    public function editPost(Request $request, $slug){
        $this->validate($request, [
            'year' => 'required',
            'sequence' => 'required',
            'student' => 'required',
        ]);

        $student = \App\Student::find($request->student);
        if($student == null){
            $request->session()->flash('error',"Invalid URL");
            return redirect()->back();
        }

        $class = $student->class($request->get('year'));
        if($class == null){
            $request->session()->flash('error',"Student was not part of this session");
            return redirect()->back();
        }

        foreach(\App\Section::find($class->section->id)->subjects as $subject) {
            $student->saveResult($request->year, $request->sequence,$subject->id, $request->get('mark'.$subject->id), $subject->score);
        }


        $request->session()->flash('success',"Result Inserted Successfully");
        return redirect(route('result.session', $student->slug));
    }
    public function feeControl(Request $request){
        $sections = [];
        if($request->year != null && $request->class  != null){
           if($request->class == "0"){
               $sections = \Auth::user()->classes(getYear());
               if($sections->count() == 0){
                   $request->session()->flash('error',"No class assign to you");
                   return redirect(route('dashboard'));
               }
           }else{
               $sections = \App\Classes::find($request->class)->subClass($request->year);
               if($sections->count() == 0){
                   $request->session()->flash('error',"No sub section found for this class");
               }
           }
        }
        $data['students'] = [];
        $data['sections'] = $sections;
        return view('result.fee_controle')->with($data);
    }
    public function feeControlPost(Request $request){
        $this->validate($request, [
            'year' => 'required',
            'class' => 'required',
            'section' => 'required',
            'amount' => 'required',
        ]);


        $sections = [];
        if($request->year && $request->class){
            $sections = \App\Classes::find($request->class)->subClass($request->year);
            if($sections->count() == 0){
                $request->session()->flash('error',"No sub section found for this class");
            }
        }
        $sec = \App\AnnualClass::find($request->section);
        $students = [];
        foreach ($sec->student as $student){
            if($student->dept($request->year) < $request->amount){
                $content['student'] = $student;
                $content['section'] = $sec->class->section->id;
                $content['year'] = \App\Session::find($request->get('year'));
                $content['class'] = $sec->class;
                $content['title'] = $student->name.' '.$content['year']->name.' Report Card';
                if($sec->class->section->id <= 2){
                    array_push($students, view('template.nusery_report')->with($content));
                }else{
                    array_push($students, view('template.primary_report')->with($content));
                }
            }
        }
        $data['students'] = $students;
        $data['sections'] = $sections;
        return view('result.fee_controle')->with($data);
    }

    public function ranksheet(Request $request){
        $student = \Auth::user()->class(request('year',getYear()))->student()->Join('results',['students.id'=>'results.student_id'])
            ->selectRaw('students.id, students.name, COALESCE(sum(results.mark),0) total_mark, COALESCE(sum(results.total),0) total')
            ->where(['results.year_id'=>request('year',getYear()), 'results.sequence_id'=>request('sequence',1)])
            ->groupBy('students.id', 'students.name','students_classes.class_id','students_classes.student_id')
            ->orderBy('total_mark', 'DESC')
            ->get();

        if($student->count() > 0){
            $data['students'] = $student;
        }else{
            $data['students'] = [];
        }
        return view('result.ranksheet')->with($data);
    }
}
