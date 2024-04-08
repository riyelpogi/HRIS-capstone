<?php

namespace App\Livewire\Users\Hrofficer\ShowUsers;

use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\February;
use App\Models\January;
use App\Models\July;
use App\Models\June;
use App\Models\March;
use App\Models\May;
use App\Models\November;
use App\Models\October;
use App\Models\September;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ShowEmployees extends Component
{
    public $search;
    public $employees;


  public $mply;
  public $actionModal = false;
  public $actionContent = '';
  #[Rule('required')]
  public $status;

  #[Rule('required')]
  public $from_date;
  #[Rule('required')]
  public $to_date;
  public $setScheduleModal = false;

  #[Rule('required')]
  public $Mon;
  #[Rule('required')]
  public $Wed;
  #[Rule('required')]
  public $Thu;
  #[Rule('required')]
  public $Fri;
  #[Rule('required')]
  public $Sun;
  #[Rule('required')]
  public $Sat;
  #[Rule('required')]
  public $Tue;

  public $from_yr;
  public $from_month;
  public $from_day;

  public $to_yr;
  public $to_month;
  public $to_day;


  public function submitSchedule()
  {
    $this->validate([
      'Mon' => 'required',
      'Tue' => 'required',
      'Wed' => 'required',
      'Thu' => 'required',
      'Fri' => 'required',
      'Sat' => 'required',
      'Sun' => 'required',
    ]);
      if(Gate::allows('admin')){
        if($this->from_yr == $this->to_yr){
          $from_user_sched = [];
          if($this->from_month == 1){
            $from_user_sched = January::where('employee_id', $this->mply->employee_id)
                                        ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 2){
            $from_user_sched = February::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 3){
            $from_user_sched = March::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 4){
            $from_user_sched = April::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 5){
            $from_user_sched = May::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 6){
            $from_user_sched = June::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 7){
            $from_user_sched = July::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 8){
            $from_user_sched = August::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 9){
            $from_user_sched = September::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 10){
            $from_user_sched = October::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 11){
            $from_user_sched = November::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }else if($this->from_month == 12){
            $from_user_sched = December::where('employee_id', $this->mply->employee_id)
            ->where('year', $this->from_yr)->first();
          }
            if($this->from_month == $this->to_month){
                for ($i=$this->from_day; $i <= $this->to_day; $i++) { 
                   $day = date('D', strtotime($this->from_yr.'-'.$this->from_month.'-'.$i));
                   if($day == "Mon"){
                       $from_user_sched->$i = $this->Mon;
                   }elseif($day == "Tue"){
                     $from_user_sched->$i = $this->Tue;
                   }elseif($day == "Wed"){
                     $from_user_sched->$i = $this->Wed;
                   }elseif($day == "Thu"){
                     $from_user_sched->$i = $this->Thu;
                   }elseif($day == "Fri"){
                     $from_user_sched->$i = $this->Fri;
                   }elseif($day == "Sat"){
                     $from_user_sched->$i = $this->Sat;
                   }elseif($day == "Sun"){
                     $from_user_sched->$i = $this->Sun;
                   }
    
               }
              $from_user_sched->save();
               session()->flash('success', 'Schedule set successful.');
    
            }elseif($this->from_month < $this->to_month){
              for ($i=$this->from_month; $i <= $this->to_month; $i++) { 
                  $start_days = 1;
                  $end_days = cal_days_in_month(CAL_GREGORIAN, $i, $this->from_yr);
                  if($i == $this->from_month){
                    $start_days = $this->from_day;
                  }else if($i == $this->to_month){
                    $end_days = $this->to_day;
                  }
    
                  $sched = [];
                  if($i == 1){
                    $arr = January::where('employee_id', $this->mply->employee_id)
                                                ->where('year', $this->to_yr)->first();
                  }else if($i == 2){
                    $arr = February::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 3){
                    $arr = March::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 4){
                    $arr = April::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 5){
                    $arr = May::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 6){
                    $arr = June::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 7){
                    $arr = July::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 8){
                    $arr = August::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 9){
                    $arr = September::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 10){
                    $arr = October::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 11){
                    $arr = November::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }else if($i == 12){
                    $arr = December::where('employee_id', $this->mply->employee_id)
                    ->where('year', $this->to_yr)->first();
                  }
              
                  for($a = $start_days; $a <= $end_days; $a++){
                      $day = date('D', strtotime($this->from_yr.'-'.$i.'-'.$a));
                      if($day == "Mon"){
                        $arr->$a = $this->Mon;
                    }elseif($day == "Tue"){
                      $arr->$a = $this->Tue;
                    }elseif($day == "Wed"){
                      $arr->$a = $this->Wed;
                    }elseif($day == "Thu"){
                      $arr->$a = $this->Thu;
                    }elseif($day == "Fri"){
                      $arr->$a = $this->Fri;
                    }elseif($day == "Sat"){
                      $arr->$a = $this->Sat;
                    }elseif($day == "Sun"){
                      $arr->$a = $this->Sun;
                    }
                  }
                  $arr->save();
              }

              session()->flash('success', 'Schedule set successful.');
            }else{
              session()->flash('failed', 'Failed, please try again later.');
            }
        }elseif($this->from_yr <= $this->to_yr){
              for($i = $this->from_yr; $i <= $this->to_yr; $i++){
                $from_month = 1;
                $to_month = 12;
                
                if($this->from_yr == $i){
                  $from_month = $this->from_month;
                }
                
                
                if($this->to_yr == $i){
                  $to_month = $this->to_month;
                }
                
                for($a = $from_month; $a <= $to_month; $a++){
                    $user_sched = [];
                    if($a == 1){
                      $user_sched = January::where('employee_id', $this->mply->employee_id)
                                                  ->where('year', $i)->first();
                    }else if($a == 2){
                      $user_sched = February::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 3){
                      $user_sched = March::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 4){
                      $user_sched = April::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 5){
                      $user_sched = May::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 6){
                      $user_sched = June::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 7){
                      $user_sched = July::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 8){
                      $user_sched = August::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 9){
                      $user_sched = September::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 10){
                      $user_sched = October::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 11){
                      $user_sched = November::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }else if($a == 12){
                      $user_sched = December::where('employee_id', $this->mply->employee_id)
                      ->where('year', $i)->first();
                    }
                    
                    $from_day = 1;
                    $to_day = cal_days_in_month(CAL_GREGORIAN, $a, $i);
                    
                    if($this->from_month == $a && $this->from_yr == $i){
                        $from_day = $this->from_day;
                    }
                    
                    
                    if($this->to_month == $a && $this->to_yr == $i){
                      $to_day = $this->to_day;
                    }
                    
                    for($b = $from_day; $b <= $to_day; $b++){
                        $day = date('D', strtotime($i.'-'.$a.'-'.$b));
                      if($day == "Mon"){
                          $user_sched->$b = $this->Mon;
                      }elseif($day == "Tue"){
                        $user_sched->$b = $this->Tue;
                      }elseif($day == "Wed"){
                        $user_sched->$b = $this->Wed;
                      }elseif($day == "Thu"){
                        $user_sched->$b = $this->Thu;
                      }elseif($day == "Fri"){
                        $user_sched->$b = $this->Fri;
                      }elseif($day == "Sat"){
                        $user_sched->$b = $this->Sat;
                      }elseif($day == "Sun"){
                        $user_sched->$b = $this->Sun;
                      }
                    }
                    $user_sched->save();
                  }
              }

          session()->flash('success', 'Schedule set successful.');

        }else{
          session()->flash('failed', 'Failed, please try again later.');
        }
    
      }else{
        session()->flash('failed', 'Failed, please try again later.');
      }
    
    $this->reset('Mon');
    $this->reset('Tue');
    $this->reset('Wed');
    $this->reset('Thu');
    $this->reset('Fri');
    $this->reset('Sat');
    $this->reset('Sun');
    $this->reset('from_yr');
    $this->reset('from_month');
    $this->reset('from_day');
    $this->reset('from_date');
    $this->reset('to_date');
    $this->reset('to_yr');
    $this->reset('to_month');
    $this->reset('to_day');
    $this->reset('mply');
    $this->reset('setScheduleModal');

  }

  public function saveSchedule()
  {
    $this->validate([
      'from_date' => 'required',
      'to_date' => 'required',
    ]);


    $from = explode('-', $this->from_date);
    $this->from_yr = $from[0];
    $this->from_month = $from[1];
    if($from[2] <= 9){
      $str_from_day = strval($from[2]);
      if(strlen($str_from_day) == 2){
        $this->from_day = intval($str_from_day[1]);
      }else{
        $this->from_day = intval($str_from_day);
      }
    }else{
      $this->from_day = intval($from[2]);
    }

    $to = explode('-', $this->to_date);
    $this->to_yr = $to[0];
    $this->to_month = $to[1];
    $this->to_day = $to[2];

    if($to[2] <= 9){
      $str_to_day = strval($to[2]);
      if(strlen($str_to_day) == 2){
        $this->to_day = $str_to_day[1];
      }else{
        $this->to_day = $str_to_day;
      }
    }else{
      $this->to_day = $to[2];
    }
    if($this->from_yr == $this->to_yr){
      
                if($this->from_month == $this->to_month){
                  $from_user_sched = [];
                if($this->from_month == 1){
                  $from_user_sched = January::where('employee_id', $this->mply->employee_id)
                                              ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 2){
                  $from_user_sched = February::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 3){
                  $from_user_sched = March::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 4){
                  $from_user_sched = April::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 5){
                  $from_user_sched = May::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 6){
                  $from_user_sched = June::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 7){
                  $from_user_sched = July::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 8){
                  $from_user_sched = August::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 9){
                  $from_user_sched = September::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 10){
                  $from_user_sched = October::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 11){
                  $from_user_sched = November::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 12){
                  $from_user_sched = December::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }
            
                          if($from_user_sched == null){
                              if($this->from_month == 1){
                            $schdl = January::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 2){
                            $schdl = February::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 3){
                            $schdl = March::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 4){
                            $schdl = April::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 5){
                            $schdl = May::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 6){
                            $schdl = June::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 7){
                            $schdl = July::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 8){
                            $schdl = August::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 9){
                            $schdl = September::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 10){
                            $schdl = October::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 11){
                            $schdl = November::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }else if($this->from_month == 12){
                            $schdl = December::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->from_yr
                            ]);
                          }
            
                      }
            
                }elseif(abs($this->from_month - $this->to_month) == 1){
                  $from_user_sched = [];
                if($this->from_month == 1){
                  $from_user_sched = January::where('employee_id', $this->mply->employee_id)
                                              ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 2){
                  $from_user_sched = February::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 3){
                  $from_user_sched = March::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 4){
                  $from_user_sched = April::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 5){
                  $from_user_sched = May::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 6){
                  $from_user_sched = June::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 7){
                  $from_user_sched = July::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 8){
                  $from_user_sched = August::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 9){
                  $from_user_sched = September::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 10){
                  $from_user_sched = October::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 11){
                  $from_user_sched = November::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }else if($this->from_month == 12){
                  $from_user_sched = December::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->from_yr)->first();
                }
            
                $to_user_sched = [];
                if($this->to_month == 1){
                  $to_user_sched = January::where('employee_id', $this->mply->employee_id)
                                              ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 2){
                  $to_user_sched = February::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 3){
                  $to_user_sched = March::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 4){
                  $to_user_sched = April::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 5){
                  $to_user_sched = May::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 6){
                  $to_user_sched = June::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 7){
                  $to_user_sched = July::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 8){
                  $to_user_sched = August::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 9){
                  $to_user_sched = September::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 10){
                  $to_user_sched = October::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 11){
                  $to_user_sched = November::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }else if($this->to_month == 12){
                  $to_user_sched = December::where('employee_id', $this->mply->employee_id)
                  ->where('year', $this->to_yr)->first();
                }
            
                if($from_user_sched == null){
                  if($this->from_month == 1){
                $from_schdl = January::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 2){
                $from_schdl = February::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 3){
                $from_schdl = March::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 4){
                $from_schdl = April::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 5){
                $from_schdl = May::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 6){
                $from_schdl = June::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 7){
                $from_schdl = July::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 8){
                $from_schdl = August::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 9){
                $from_schdl = September::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 10){
                $from_schdl = October::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 11){
                $from_schdl = November::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }else if($this->from_month == 12){
                $from_schdl = December::create([
                  'employee_id' => $this->mply->employee_id,
                  'year' => $this->from_yr
                ]);
              }
            
            }
            
            
                          if($to_user_sched == null){
                              if($this->to_month == 1){
                            $schdl = January::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 2){
                            $schdl = February::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 3){
                            $schdl = March::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 4){
                            $schdl = April::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 5){
                            $schdl = May::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 6){
                            $schdl = June::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 7){
                            $schdl = July::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 8){
                            $schdl = August::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 9){
                            $schdl = September::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 10){
                            $schdl = October::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 11){
                            $schdl = November::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }else if($this->to_month == 12){
                            $schdl = December::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $this->to_yr
                            ]);
                          }
            
                      }
            
            
                }elseif(abs($this->from_month - $this->to_month) > 1){
                  for($i = $this->from_month; $i <= $this->to_month; $i++){
                    $arr = [];
                    if($i == 1){
                      $arr = January::where('employee_id', $this->mply->employee_id)
                                                  ->where('year', $this->to_yr)->first();
                    }else if($i == 2){
                      $arr = February::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 3){
                      $arr = March::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 4){
                      $arr = April::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 5){
                      $arr = May::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 6){
                      $arr = June::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 7){
                      $arr = July::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 8){
                      $arr = August::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 9){
                      $arr = September::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 10){
                      $arr = October::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 11){
                      $arr = November::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }else if($i == 12){
                      $arr = December::where('employee_id', $this->mply->employee_id)
                      ->where('year', $this->to_yr)->first();
                    }
            
                    if($arr == null){
                      if($i == 1){
                    $arr = January::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 2){
                    $arr = February::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 3){
                    $arr = March::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 4){
                    $arr = April::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 5){
                    $arr = May::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 6){
                    $arr = June::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 7){
                    $arr = July::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 8){
                    $arr = August::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 9){
                    $arr = September::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 10){
                    $arr = October::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 11){
                    $arr = November::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }else if($i == 12){
                    $arr = December::create([
                      'employee_id' => $this->mply->employee_id,
                      'year' => $this->from_yr
                    ]);
                  }
            
                  }
            
                }
            
            
                }
    }elseif($this->from_yr < $this->to_yr){
            for($i = $this->from_yr; $i <= $this->to_yr; $i++){
                  $from_month = 1;
                  $to_month = 12;
                  if($this->from_yr == $i){
                    $from_month = $this->from_month;
                  }else if($this->to_yr == $i){
                      $to_month = $this->to_month;
                  }

                      for($a = $from_month; $a <= $to_month; $a++){
                          $user_sched = [];
                          if($a == 1){
                            $user_sched = January::where('employee_id', $this->mply->employee_id)
                                                        ->where('year', $i)->first();
                          }else if($a == 2){
                            $user_sched = February::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 3){
                            $user_sched = March::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 4){
                            $user_sched = April::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 5){
                            $user_sched = May::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 6){
                            $user_sched = June::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 7){
                            $user_sched = July::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 8){
                            $user_sched = August::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 9){
                            $user_sched = September::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 10){
                            $user_sched = October::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 11){
                            $user_sched = November::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }else if($a == 12){
                            $user_sched = December::where('employee_id', $this->mply->employee_id)
                            ->where('year', $i)->first();
                          }

                          if($user_sched == null){
                              if($a == 1){
                            $user_sched = January::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 2){
                            $user_sched = February::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 3){
                            $user_sched = March::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 4){
                            $user_sched = April::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 5){
                            $user_sched = May::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 6){
                            $user_sched = June::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 7){
                            $user_sched = July::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 8){
                            $user_sched = August::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 9){
                            $user_sched = September::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 10){
                            $user_sched = October::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 11){
                            $user_sched = November::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }else if($a == 12){
                            $user_sched = December::create([
                              'employee_id' => $this->mply->employee_id,
                              'year' => $i
                            ]);
                          }
                          }


                      }

            }
    }
    
    $this->setScheduleModal = true;
    $this->actionModal = false;
  }

  public function saveStatus()
  {
    $this->validate([
      'status' => 'required'
    ]);

    if(Gate::allows('admin')){
      if($this->mply != null){
        $this->mply->status = $this->status;
        $this->mply->save();
        session()->flash('success', 'Status set successful.');
      }else{
      session()->flash('failed', 'Failed, please try again later.');
      }
    }else{
      session()->flash('failed', 'Failed, please try again later.');
    }

    $this->reset('mply');
    $this->reset('status');
    $this->reset('actionModal');
  }
  public function setSchedule()
  {
    $this->actionContent = 'SCHEDULE';
  }

  public function setStatus()
  {
    $this->actionContent = 'STATUS';
  }

  public function showActionModal($employee_id)
  {
    $this->mply = User::where('employee_id', $employee_id)
                          ->where('role', 1)->first();
    $this->status = $this->mply->status;
    $this->actionModal = true;                      
  }

    public function render()
    {
        if($this->actionContent == null){
          $this->actionContent = 'STATUS';
        }


        if($this->search != null){
            $this->employees = User::where('name',$this->search)
                                    ->where('role', 1)
                                    ->get();
          }else{
            $this->employees = User::where('role', 1)
                                    ->take(20)
                                    ->get();
          }
        return view('livewire.users.hrofficer.show-users.show-employees');
    }
}
