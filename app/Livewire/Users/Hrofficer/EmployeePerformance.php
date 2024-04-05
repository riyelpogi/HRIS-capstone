<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\Evaluation;
use App\Models\EvaluationQuestion;
use App\Models\User;
use App\Notifications\EvaluationForEmployee;
use App\Notifications\EvaluationNotificationForHeads;
use DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EmployeePerformance extends Component
{

    public $addEvaluationQuestionsModal = false;

    #[Rule('required')]
    public $month;
    #[Rule('required')]
    public $year;
    
    #[Rule('max:1000')]
    public $qOne;
    #[Rule('max:1000')]
    public $qTwo;
    #[Rule('max:1000')]
    public $qThree;
    #[Rule('max:1000')]
    public $qFour;
    #[Rule('max:1000')]
    public $qFive;
    #[Rule('max:1000')]
    public $qSix;
    #[Rule('max:1000')]
    public $qSeven;
    #[Rule('max:1000')]
    public $qEight;
    #[Rule('max:1000')]
    public $qNine;
    #[Rule('max:1000')]
    public $qTen;

    #[Rule('max:1000')]
    public $qone;
    #[Rule('max:1000')]
    public $qtwo;
    #[Rule('max:1000')]
    public $qthree;
    #[Rule('max:1000')]
    public $qfour;
    #[Rule('max:1000')]
    public $qfive;
    #[Rule('max:1000')]
    public $qsix;
    #[Rule('max:1000')]
    public $qseven;
    #[Rule('max:1000')]
    public $qeight;
    #[Rule('max:1000')]
    public $qnine;
    #[Rule('max:1000')]
    public $qten;
    #[Rule('max:1000')]
    public $recommendation;
    public $evalutaionQuestionModal = false;
    public $evaluation_questions;
    public $show_evaluation;
    public $department_employee_ratings;
    public $ratingsModal = false;
    public $ratings_month;
    public $ratings_yr;
    public $departmentHeadsModal = false;
    public $heads = [];
    public $heads_employee_id = [];
    public $vltn;
    public $employee;
    public $evaluationModal = false;
    public $department_heads;
    public $ratings_content;
    public $eval_id;

    public function downloadAceDepartmentHeads($eval_id)
    {
        $questions = EvaluationQuestion::find($eval_id);
        $arr = [];
        $heads = Evaluation::where('month', $questions->month)
                            ->where('year', $questions->year)
                            ->where('dep_employee', '!=', null)
                            ->orderBy('grade', 'desc')->get();
        
        if($heads != null){
            $count = 1;
                for ($i=0; $i < count($heads); $i++) { 
                    $a = [];
                    if($i == 0){
                        $a = [
                            'id' => $heads[$i]->id,
                            'profile_photo_pat' => $heads[$i]->user->profile_photo_pat,
                            'name' => $heads[$i]->user->name,
                            'department' => $heads[$i]->user->department,
                            'grade' => $heads[$i]->grade
                        ];
                       $arr[$count] = [$a];
                        $count++;
                    }else{
                        if($heads[$i]->grade == $heads[$i - 1]->grade){
                            $a = [
                                'id' => $heads[$i]->id,
                                'profile_photo_pat' => $heads[$i]->user->profile_photo_pat,
                                'name' => $heads[$i]->user->name,
                                'department' => $heads[$i]->user->department,
                                'grade' => $heads[$i]->grade
                            ];
                            array_push($arr[$count - 1], $a);
                        }else{
                            $a = [
                                'id' => $heads[$i]->id,
                                'profile_photo_pat' => $heads[$i]->user->profile_photo_pat,
                                'name' => $heads[$i]->user->name,
                                'department' => $heads[$i]->user->department,
                                'grade' => $heads[$i]->grade
                            ];
                            $arr[$count] = [$a];
                            $count++;
                        }   
                    }

                    if($count == 11){
                        foreach ($arr[10] as $key => $value) {
                           $same_grades =  Evaluation::where('month', $questions->month)
                                                    ->where('year', $questions->year)
                                                    ->where('dep_employee', '!=', null)
                                                    ->where('grade', $value['grade'])->get();
                                    foreach ($same_grades as $key => $same_grade) {
                                        $a = [
                                            'id' => $heads[$i]->id,
                                            'profile_photo_pat' => $heads[$i]->user->profile_photo_pat,
                                            'name' => $heads[$i]->user->name,
                                            'department' => $heads[$i]->user->department,
                                            'grade' => $heads[$i]->grade
                                        ];
                                        if($value['id'] != $same_grade->id){
                                            array_push($arr[10], $a);
                                        }
                                    }
                            
                        }
                        break;
                    }
                }
            
            if($arr != null){
                $phpWord = new \PhpOffice\PhpWord\PhpWord();
                $section = $phpWord->addSection();
                $font = new \PhpOffice\PhpWord\Style\Font();
                $font->setBold(true);
                $m = $questions->month;
                $date = DateTime::createFromFormat('!m', $m);
                $month = $date->format('F');
                $header = $section->addText("TOP 10 DEPARTMENT HEADS FOR THE MONTH OF " . $month);
                $header->setFontStyle($font);
                // dd($arr);
                    foreach($arr as $a => $val){
                        foreach ($val as $key => $value) {
                            $name = $a .'. '. $value['name'] .'       '. $value['grade'] . '       (' .$value['department'] .')';
                            $section->addText('     '. $name); 
                        }
                    }
                $word = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $word->save('Top 10 Department Heads for the month of ' .$month.'.docx');
                if($word){
                    if(File::exists(public_path('Top 10 Department Heads for the month of ' .$month.'.docx'))){
                        return response()->download(public_path('Top 10 Department Heads for the month of ' .$month.'.docx'));
                    }
                }
            }
        }
    }
        

    public function downloadAceEmployees($eval_id)
    {
        $questions = EvaluationQuestion::find($eval_id);
         if($questions != null){
            $ace_employees = Evaluation::where('month', $questions->month)
                                        ->where('grade', 'A+')
                                        ->where('dep_employee', null)
                                        ->where('year', $questions->year)
                                        ->get();
            $month = $questions->month;
            $obj = DateTime::createFromFormat('!m', $month);
            $m_name = $obj->format('F');
            if($ace_employees != null){
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $font = new \PhpOffice\PhpWord\Style\Font();
                    $font->setBold(true);
                    $header = $section->addText('A+ EMPLOYEES FOR THE MONTH OF ' . $m_name);
                    $header->setFontStyle($font);
                    foreach($ace_employees as $key => $ace_employee){
                        $name = $ace_employee->user->name ." " . $ace_employee->grade . ' (' . $ace_employee->user->department . ')';
                        $section->addText("            ".$name);
                    }

               
                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save('Ace Employees for the Month of ' . $m_name .'.docx');
                    if($objWriter){
                            if(File::exists(public_path('Ace Employees for the Month of ' . $m_name. '.docx'))){
                                return response()->download(public_path('Ace Employees for the Month of ' . $m_name. '.docx'));
                            }else{
                            session()->flash('failed', 'Failed, please try again later.');

                            }
                    }else{
                        session()->flash('failed', 'Failed, please try again later.');
                    }
            }                            
         }else{
            session()->flash('failed', 'Failed, please try again later.');

         }
    }

    public function submitEvaluation()
    {
        $this->validate([
            'qone' => 'required',
            'qtwo' => 'required',
            'qthree' => 'required',
            'qfour' => 'required',
            'qfive' => 'required',
            'qsix' => 'required',
            'qseven' => 'required',
            'qeight' => 'required',
            'qnine' => 'required',
            'qten' => 'required',
            'recommendation' => 'required',
        ]);

        if(Gate::allows('admin')){
                $total = $this->qone + $this->qtwo + $this->qthree + $this->qfour + $this->qfive + $this->qsix + $this->qseven + $this->qeight + $this->qnine + $this->qten;
                
                $grade = '';
                
                if($total <= 50 && $total >= 47 ){
                    $grade = 'A+';
                }else if($total <= 46 && $total >= 43){
                    $grade = 'A';
                }else if($total <= 42 && $total >= 39){
                    $grade = 'A-';
                }else if($total <= 38 && $total >= 35){
                    $grade = 'B+';
                }else if($total <= 34 && $total >= 31){
                    $grade = 'B';
                }else if($total <= 30 && $total >= 27){
                    $grade = 'B-';
                }else if($total <= 26){
                    $grade = 'C';
                }

                $evaluation = Evaluation::create([
                    'evaluation_question_id' => $this->vltn->id,
                    'evaluated' => $this->employee->employee_id,
                    'evaluator' => auth()->user()->employee_id,
                    'qone' => $this->qone,
                    'qtwo' => $this->qtwo,
                    'qthree' => $this->qthree,
                    'qfour' => $this->qfour,
                    'qfive' => $this->qfive,
                    'qsix' => $this->qsix,
                    'qseven' => $this->qseven,
                    'qeight' => $this->qeight,
                    'qnine' => $this->qnine,
                    'qten' => $this->qten,
                    'total' => $total,
                    'recommendation' => $this->recommendation,
                    'month' => $this->vltn->month,
                    'year' => $this->vltn->year,
                    'grade' => $grade,

                ]);

                if($evaluation != null){
                    $employee = User::where('employee_id', $evaluation->evaluated)->first();
                    $route_name = 'employee.performance';
                    $content = 'PERFORMANCE';
                    $month = $evaluation->month;
                    $employee->notify(new EvaluationForEmployee($employee->employee_id, $month, $content, $route_name));
                    session()->flash('success', 'Submit successful');
                }else{
                    session()->flash('failed', 'Failed, please try again later.');
                }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }

        $this->reset('employee');
        $this->reset('recommendation');
        $this->reset('qone');
        $this->reset('qthree');
        $this->reset('qfour');
        $this->reset('qtwo');
        $this->reset('qfive');
        $this->reset('qseven');
        $this->reset('qsix');
        $this->reset('qeight');
        $this->reset('qten');
        $this->reset('qnine');
        $this->reset('vltn');
        $this->reset('evaluationModal');
    }

    public function evaluateEmployee($employee_id)
    {   
        $this->employee = User::where('employee_id', $employee_id)->first();
        $this->departmentHeadsModal = false;
        $this->evaluationModal = true;
    }
    public function showDepartmentHeads($id)
    {
        $this->vltn = EvaluationQuestion::find($id);
        if ($this->vltn != null) {
        //  $users = User::get();
        //    foreach ($users as $key => $value) {
        //         if(in_array($value->employee_id, $this->heads_employee_id)){
        //                 if(!in_array($value->employee_id, $this->heads)){
        //                     $this->heads["$value->employee_id"] = [
        //                         'name' => $value->name,
        //                         'profile' => $value->profile_photo_path,
        //                         'position' => $value->position,
        //                         'employee_id' => $value->employee_id,
        //                         'department' => $value->department,
        //                     ];
        //                 }
                        
        //         }
        //    }

        $this->heads = User::where('position', 'LIKE', '%Head%')->orderBy('name', 'asc')->get();
            $this->departmentHeadsModal = true;
        }
    }
    public function departmentEmployeesRatings()
    {
        $this->ratings_content = 'DEPARTMENTEMPLOYEES';
    }
    public function departmentHeadsRatings($id)
    {
        $evaluation_question = EvaluationQuestion::find($id);
        $this->department_heads = Evaluation::where('evaluation_question_id', $id)
                                            ->where('month', $evaluation_question->month)
                                            ->where('year', $evaluation_question->year)
                                            ->where('dep_employee', '!=', null)
                                            ->orderBy('grade', 'desc')->get();
        $this->ratings_content = 'DEPARTMENTHEADS';
    }
    public function showRatings($id)
    {
        $evaluation_question = EvaluationQuestion::find($id);
        $this->eval_id = $id;

        if($evaluation_question != null){
            $this->department_employee_ratings = Evaluation::where('evaluation_question_id', $id)
                                        ->where('month', $evaluation_question->month)
                                        ->where('year', $evaluation_question->year)
                                        ->where('dep_employee', null)
                                        ->orderBy('created_at', 'desc')->get();


            if($this->ratings_content == null){
                $this->ratings_content = 'DEPARTMENTEMPLOYEES';
            }                            
            $this->ratings_month = $evaluation_question->month;
            $this->ratings_yr = $evaluation_question->year;
            $this->ratingsModal = true;                            
        }
    }


    public function closeEvaluation($id)
    {
        $evaluation = EvaluationQuestion::find($id);
        if(Gate::allows('admin')){
            if($evaluation != null){
                $evaluation->status = 'closed';
                $evaluation->save();
                session()->flash('success', 'Evaluation closed successful.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }

    public function openEvaluation($id)
    {
        $evaluation = EvaluationQuestion::find($id);
        if(Gate::allows('admin')){
            if($evaluation != null){
                $evaluation->status = 'open';
                $evaluation->save();
                session()->flash('success', 'Evaluation open successful.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }

    public function showEvaluation($id)
    {
        $this->show_evaluation = $id;
    }
    public function hideEvaluation($id)
    {
        $this->show_evaluation = null;
    }
    
    public function saveQuestions()
    {
        $this->validate([
            'qOne' => 'max:1000',
            'qTwo' => 'max:1000',
            'qThree' => 'max:1000',
            'qFour' => 'max:1000',
            'qFive' => 'max:1000',
            'qSix' => 'max:1000',
            'qSeven' => 'max:1000',
            'qEight' => 'max:1000',
            'qNine' => 'max:1000',
            'qTen' => 'max:1000',
        ]);

        if(Gate::allows('admin')){
            $questions = EvaluationQuestion::create([
                'qone' => $this->qOne,
                'qtwo' => $this->qTwo,
                'qthree' => $this->qThree,
                'qfour' => $this->qFour,
                'qfive' => $this->qFive,
                'qsix' => $this->qSix,
                'qseven' => $this->qSeven,
                'qeight' => $this->qEight,
                'qnine' => $this->qNine,
                'qten' => $this->qTen,
                'month' => $this->month,
                'year' => $this->year,
            ]);
            if($questions){
                session()->flash('success', 'Evaluation questions uploaded.');
                $heads = User::where('position', 'LIKE', '%Head%')->get();
                $month = $this->month;
                $date = DateTime::createFromFormat('!m',$month);
                $route_name = 'employee.performance';
                $content = "EVALUATE";
                foreach ($heads as $key => $head) {
                    $head->notify(new EvaluationNotificationForHeads($questions->id, $date->format('F'), $content, $route_name));
                }
                
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');

        }
        
        $this->reset('qOne');
        $this->reset('qTwo');
        $this->reset('qFour');
        $this->reset('qFive');
        $this->reset('qThree');
        $this->reset('qSix');
        $this->reset('qSeven');
        $this->reset('qNine');
        $this->reset('qEight');
        $this->reset('qTen');
        $this->reset('month');
        $this->reset('year');
        $this->reset('evalutaionQuestionModal');

    }

    public function setMonthForEvaluationQuestion()
    {
        $this->validate([
            'month' => 'required',
            'year' => 'required',
        ]);
        $this->addEvaluationQuestionsModal = false;
        $this->evalutaionQuestionModal = true;

    }
    public function showAddEvaluationQuestionsModal()
    {
        $this->addEvaluationQuestionsModal = true;
    }
    public function render()
    {

        $users = User::where('role', 1)->get()->toArray();
        for ($i=0; $i < count($users); $i++) { 
            $position = explode(' ', $users[$i]['position']);

            if(in_array('Head', $position)){
                if(in_array($users[$i]['employee_id'],$this->heads_employee_id)){
                }else{
                    array_push($this->heads_employee_id,$users[$i]['employee_id']);
                }
            }

        }
        
        if($this->month == null){
            $this->month = date('n',time());
        }

        if($this->year == null){
            $this->year = date('Y',time());
        }

        if($this->departmentHeadsModal == false){
            $this->reset('heads');
        }

        $this->evaluation_questions = EvaluationQuestion::where('year', date('Y',time()))->orderBy('created_at', 'desc')->get();

        

        return view('livewire.users.hrofficer.employee-performance');
    }
}
