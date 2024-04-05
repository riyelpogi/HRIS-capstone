<?php

namespace App\Livewire\Users\Employee;

use App\Models\Evaluation;
use App\Models\EvaluationQuestion;
use App\Models\User;
use App\Notifications\EvaluationForEmployee;
use DateTime;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Performance extends Component
{

    public $head;
    public $evaluations;
    public $show_evaluation;
    public $department_employees;
    public $vltn;
    public $evaluationsModal = false;
    public $employee;
    public $evaluationQuestion = false;

    #[Rule("required")]
    public $qone;
    #[Rule("required")]
    public $qtwo;
    #[Rule("required")]
    public $qthree;
    #[Rule("required")]
    public $qfour;
    #[Rule("required")]
    public $qfive;
    #[Rule("required")]
    public $qsix;
    #[Rule("required")]
    public $qseven;
    #[Rule("required")]
    public $qeight;
    #[Rule("required")]
    public $qten;
    #[Rule("required")]
    public $qnine;
    #[Rule("required")]
    public $recommendation;
    public $content;
    public $month = '';
    public $my_evaluations;
    public $parameter_id;
    public $showEvaluateHead = false;
    public $department_head;
    public $department_head_evaluations;

    public function showEvaluateHeadModal($id, $month, $year)
    {
        $evaluation = Evaluation::where('evaluation_question_id', $id)
                                    ->where('evaluated', $this->department_head->employee_id)
                                    ->where('month', $month)
                                    ->where('year', $year)->first();
        if($evaluation != null){
            if(in_array(auth()->user()->employee_id, explode('-', $evaluation->evaluator))){
                session()->flash('failed', 'You already evaluate your department head');
            } else{
                $this->employee = User::where('employee_id', $this->department_head->employee_id)->first();
                $this->vltn = EvaluationQuestion::find($id);
                $this->evaluationQuestion = true;
                $this->evaluationsModal = false;
            }  
        }else{
            $this->employee = User::where('employee_id', $this->department_head->employee_id)->first();
            $this->vltn = EvaluationQuestion::find($id);
            $this->evaluationQuestion = true;
            $this->evaluationsModal = false;
        }                      
    }
    
    public function mount($id, $content, $month)
    {
        $department = auth()->user()->department;
        $position = auth()->user()->position;
        $position_aray = explode(' ', $position);

        if(strpos(auth()->user()->position, 'Head') || strpos(auth()->user()->position, 'head')){
            $this->head = true;
        }else{
            $this->head = false;
        }
        
        if($this->content == null){
            $this->content = 'PERFORMANCE';
        }

        if($id != null){
            $this->parameter_id = $id;
        }

        if($content != null){
            $this->content = $content;
        }

        if($month != null){
            $this->month = $month;
        }


        $this->evaluations = EvaluationQuestion::where('year', date('Y', time()))
                                                ->where('status', 'open')->get();

        $this->department_employees = User::where('role', 1)
                                        ->orderBy('name', 'asc')
                                        ->where('department', $department)->get();
        $department_head = User::where('role', 1)
                            ->where('department', auth()->user()->department)
                            ->orderBy('name', 'asc')->get();
        foreach ($department_head as $key => $head) {
            if(strpos($head->position, 'Head')){
                $this->department_head = $head;
            }
        }                    

    }

    public function performance()
    {
        $this->content = 'PERFORMANCE';
    }

    public function evaluate()
    {
        $this->content = 'EVALUATE';
    }
    public function submitEvluation()
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

                if(strpos($this->employee->position, 'Head') || strpos($this->employee->position, 'head')){
                    $dep_employee = User::where('role', 1)
                    ->where('department', auth()->user()->department)
                    ->where('employee_id', '!=', auth()->user()->employee_id)->get();

                    $evaluation = Evaluation::where('evaluation_question_id', $this->vltn->id)
                                        ->where('evaluated', $this->employee->employee_id)
                                        ->where('month', $this->vltn->month)
                                        ->where('year', $this->vltn->year)->first();

                   if($evaluation != null){
                        
                        $employee = explode('/',$evaluation->dep_employee);
                        $evaluation->qone += $this->qone;
                        $evaluation->evaluator .= auth()->user()->employee_id .'-';
                        $evaluation->qtwo += $this->qtwo;
                        $evaluation->qthree += $this->qthree;
                        $evaluation->qfour += $this->qfour;
                        $evaluation->qfive += $this->qfive;
                        $evaluation->qsix += $this->qsix;
                        $evaluation->qseven += $this->qseven;
                        $evaluation->qeight += $this->qeight;
                        $evaluation->qnine += $this->qnine;
                        $evaluation->qten += $this->qten;
                        $evaluation->recommendation .= ", ".$this->recommendation;
                        $evaluation->save();
                        $a = $evaluation->qone + $evaluation->qtwo + $evaluation->qthree + $evaluation->qfour + $evaluation->qfive + $evaluation->qsix + $evaluation->qseven + $evaluation->qeight + $evaluation->qnine + $evaluation->qten;
                        $grade = ($a / (50 * count($dep_employee)) * 100);
                        $evaluation->grade = $grade . '%';
                        $evaluation->total = $a;
                        $evaluation->dep_employee = $employee[0] + 1 .'/'. count($dep_employee);
                        $evaluation->save();

                   }else{
                    $grade = ($total / (50 * count($dep_employee))) * 100;
                        $evaluation = Evaluation::create([
                            'evaluation_question_id' => $this->vltn->id,
                            'evaluated' => $this->employee->employee_id,
                            'evaluator' => auth()->user()->employee_id . '-',
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
                            'grade' => $grade . '%',
                            'dep_employee' => '1/'.count($dep_employee)
                        ]); 
                   }
                }else{
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
                }

                if($evaluation){
                    $employee = User::where('employee_id', $evaluation->evaluated)->first();
                    $route_name = 'employee.performance';
                    $content = 'PERFORMANCE';
                    $month = $evaluation->month;
                    $employee->notify(new EvaluationForEmployee($employee->employee_id, $month, $content, $route_name));
                    session()->flash('success', 'Evaluate successful.');
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
        $this->reset('evaluationQuestion');
    }
    
    public function evaluateEmployee($employee_id)
    {
        $this->employee = User::where('employee_id', $employee_id)->first();
        $this->evaluationQuestion = true;
        $this->evaluationsModal = false;
    }

    public function evaluateEmployees($id)
    {
        $this->vltn = EvaluationQuestion::find($id);
        $this->evaluationsModal = true;
    }

    public function showEvaluation($id)
    {
        $this->show_evaluation = $id;
    }
    public function hideEvaluation($id)
    {
        $this->show_evaluation = null;
    }
    public function render()
    {
            if($this->month == null){
                $this->month = date('n', time());
                $this->my_evaluations = Evaluation::where('evaluated', auth()->user()->employee_id)
                                                ->where('month', $this->month)->first();
            }else{
                $this->my_evaluations = Evaluation::where('evaluated', auth()->user()->employee_id)
                                                ->where('month', $this->month)->first();
            }

            // if($dp_head != null){
            //     $qone = 0;
            //     $qtwo = 0;
            //     $qthree = 0;
            //     $qfour = 0;
            //     $qfive = 0;
            //     $qsix = 0;
            //     $qseven = 0;
            //     $qeight = 0;
            //     $qnine = 0;
            //     $qten = 0;

            //     $q_qone = "";
            //     $q_qtwo = "";
            //     $q_qthree = "";
            //     $q_qfour = "";
            //     $q_qfive = "";
            //     $q_qsix = "";
            //     $q_qseven = "";
            //     $q_qeight = "";
            //     $q_qnine = "";
            //     $q_qten = "";
            //     $recommendation = "";
            //     foreach($dp_head as $key => $value){
            //         $qone += $value->qone;
            //         $qtwo += $value->qtwo;
            //         $qthree += $value->qthree;
            //         $qfour += $value->qfour;
            //         $qfive += $value->qfive;
            //         $qsix += $value->qsix;
            //         $qseven += $value->qseven;
            //         $qeight += $value->qeight;
            //         $qnine += $value->qnine;
            //         $qten += $value->qten;

            //         if($q_qone == ""){
            //             $q_qone = $value->evaluation_question->qone;
            //         }
            //         if($q_qtwo == ""){
            //             $q_qtwo = $value->evaluation_question->qtwo;
            //         }
            //         if($q_qthree == ""){
            //             $q_qthree = $value->evaluation_question->qthree;
            //         }
                    
            //         if($q_qfour == ""){
            //             $q_qfour = $value->evaluation_question->qfour;
            //         }
            //         if($q_qfive == ""){
            //             $q_qfive = $value->evaluation_question->qfive;
            //         }
            //         if($q_qsix == ""){
            //             $q_qsix = $value->evaluation_question->qsix;
            //         }
            //         if($q_qseven == ""){
            //             $q_qseven = $value->evaluation_question->qseven;
            //         }
            //         if($q_qeight == ""){
            //             $q_qeight = $value->evaluation_question->qeight;
            //         }
            //         if($q_qnine == ""){
            //             $q_qnine = $value->evaluation_question->qnine;
            //         }
            //         if($q_qten == ""){
            //             $q_qten = $value->evaluation_question->qten;
            //         }

            //         $recommendation .= $value->recommendation . ',';
            //     }
            // $dp_employee = User::where('role', 1)
            //                     ->where('department', auth()->user()->department)->get()->except(auth()->user()->id);    
            // $this->department_head_evaluations = [
            //     'q_one' => $q_qone . ' - ' . $qone,
            //     'q_two' => $q_qtwo . ' - ' . $qtwo,
            //     'q_three' => $q_qthree . ' - ' . $qthree,
            //     'q_four' => $q_qfour . ' - ' . $qfour,
            //     'q_five' => $q_qfive . ' - ' . $qfive,
            //     'q_six' => $q_qsix . ' - ' . $qsix,
            //     'q_seven' => $q_qseven . ' - ' . $qseven,
            //     'q_eight' => $q_qeight . ' - ' . $qeight,
            //     'q_nine' => $q_qnine . ' - ' . $qnine,
            //     'q_ten' => $q_qten . ' - ' . $qten,
            //     'recommendation' => $recommendation,
            //     'evaluator' => count($dp_head),
            //     'department_employees' => count($dp_employee)
            // ];


            // }

        return view('livewire.users.employee.performance');
    }
}
