<div class="w-11/12  relative flex justify-center m-5">
   <div class="w-full relative bg-white rounded flex flex-col">
@if (session()->has('failed'))
    <div class="w-full relative ">
       <x-failed-message />    
    </div>
@endif
    @if (session()->has('success'))
    <div class="w-full relative ">
    <x-success-message />    
    </div>
@endif
            <div class="w-full relative flex m-5 gap-5">
                <button class="p-2 text-xs border rounded-lg hover:bg-yellow-green" wire:click="showAddEvaluationQuestionsModal">
                    Add Evaluation Questions
                </button>
            </div>
            <div class="w-full relative flex flex-col m-5 justify-center">
                @foreach ($evaluation_questions as $evaluation_question)
                    <div class="w-11/12 relative flex flex-col justify-center border m-2">
                        <div class="w-11/12 relative flex justify-between m-5">
                            <h1 class="text-sm font-bold">
                                @if ($evaluation_question->month == 1)
                                    January
                                @elseif($evaluation_question->month == 2)
                                    February
                                @elseif($evaluation_question->month == 3)
                                    March    
                                @elseif($evaluation_question->month == 4)
                                    April    
                                @elseif($evaluation_question->month == 5)
                                    May
                                @elseif($evaluation_question->month == 6)
                                    June    
                                @elseif($evaluation_question->month == 7)
                                    July
                                @elseif($evaluation_question->month == 8)
                                    August
                                @elseif($evaluation_question->month == 9)
                                    September    
                                @elseif($evaluation_question->month == 10)
                                    October   
                                @elseif($evaluation_question->month == 11)
                                    November    
                                @elseif($evaluation_question->month == 12)
                                    December     
                                @endif
                                <span>({{ $evaluation_question->year }})</span>
                            </h1>
                                @if($show_evaluation == $evaluation_question->id)
                                    <span class="p-2 rounded-full hover:bg-gray-400 cursor-pointer" wire:click="hideEvaluation({{ $evaluation_question->id }})" wire:key="hide-evaluation-{{ $evaluation_question->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="m296-345-56-56 240-240 240 240-56 56-184-184-184 184Z"/></svg>
                                    </span>    
                                @else
                                    <span class="p-2 rounded-full hover:bg-gray-400 cursor-pointer" wire:click="showEvaluation({{ $evaluation_question->id }})" wire:key="show-evaluation-{{ $evaluation_question->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M480-345 240-585l56-56 184 184 184-184 56 56-240 240Z"/></svg>  
                                    </span>
                                @endif
                            
                        </div>
                        @if ($show_evaluation == $evaluation_question->id)
                        <div class="w-11/12 relative flex flex-col m-5">
                            <h1 class="text-xs font-bold italic">Evaluation Questions:</h1>
                            <p class="text-xs font-semibold italic">1.{{ $evaluation_question->qone }}</p>
                            <p class="text-xs font-semibold italic">2.{{ $evaluation_question->qtwo }}</p>
                            <p class="text-xs font-semibold italic">3.{{ $evaluation_question->qthree }}</p>
                            <p class="text-xs font-semibold italic">4.{{ $evaluation_question->qfour }}</p>
                            <p class="text-xs font-semibold italic">5.{{ $evaluation_question->qfive }}</p>
                            <p class="text-xs font-semibold italic">6.{{ $evaluation_question->qsix }}</p>
                            <p class="text-xs font-semibold italic">7.{{ $evaluation_question->qseven }}</p>
                            <p class="text-xs font-semibold italic">8.{{ $evaluation_question->qeight }}</p>
                            <p class="text-xs font-semibold italic">9.{{ $evaluation_question->qnine }}</p>
                            <p class="text-xs font-semibold italic">10.{{ $evaluation_question->qten }}</p>
                        </div>

                        <div class="w-11/12 relative justify-end flex m-5">
                            <div class="flex gap-5">
                                @if ($evaluation_question->status != 'closed')
                                    <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green" wire:click="closeEvaluation({{ $evaluation_question->id }})" wire:key="close-evaluation-{{ $evaluation_question->id }}">Close this Evaluation</button>  
                                @else
                                    <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green" wire:click="openEvaluation({{ $evaluation_question->id }})" wire:key="open-evaluation-{{ $evaluation_question->id }}">Open this Evaluation</button>
                                @endif
                                <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green" wire:click="showRatings({{ $evaluation_question->id  }})" wire:key="show-ratings-{{ $evaluation_question->id  }}">Show Ratings</button>
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
    </div>  
    <x-modal wire:model="evaluationModal">
        @if ($vltn != null && $employee != null)
            <div class="w-full flex justify-center relative">
                <div class="w-11/12 bg-whitey p-5 rounded relative flex justify-center flex-col">
                    <div class="w-11/12 relative m-5 flex justify-center flex-col">
                        <h1 class="text-sm font-semibold">Evaluation:</h1>
                        <span class="text-xs font-semibold">@if ($vltn->month == 1)
                            January
                        @elseif($vltn->month == 2)
                            February
                        @elseif($vltn->month == 3)
                            March    
                        @elseif($vltn->month == 4)
                            April    
                        @elseif($vltn->month == 5)
                            May
                        @elseif($vltn->month == 6)
                            June    
                        @elseif($vltn->month == 7)
                            July
                        @elseif($vltn->month == 8)
                            August
                        @elseif($vltn->month == 9)
                            September    
                        @elseif($vltn->month == 10)
                            October   
                        @elseif($vltn->month == 11)
                            November    
                        @elseif($vltn->month == 12)
                            December     
                        @endif</span>
                        <span class="text-xs">Notice:Evaluate employee from 5 being the highest and 1 being the Lowest</span>
                    </div>
                    <div class="w-11/12 relative m-5 flex justify-around items-center">
                        <div class="flex gap-5 items-center">
                            @if ($employee->profile_photo_path != null)
                                <img src="/storage/employee-media/{{ $employee->profile_photo_path }}" alt="" class="w-8 h-8 rounded-full border">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="border rounded-full" height="24" viewBox="0 96 960 960" width="24"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>    
                            @endif
                        <h1 class="text-sm font-semibold">{{ $employee->name }}</h1>
                        </div>
                        <span class="text-xs">{{ $employee->position }}</span>
                    </div>
                    <form wire:submit="submitEvaluation" method="POST">
                        @csrf
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q1:{{ $vltn->qone }}</h1>
                            <select name="qone" wire:model="qone" id="qone" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qone')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div>  
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q2:{{ $vltn->qtwo }}</h1>
                            <select name="qtwo" wire:model="qtwo" id="qtwo" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qtwo')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div>  
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q3:{{ $vltn->qthree }}</h1>
                            <select name="qthree" wire:model="qthree" id="qthree" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qthree')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col" >
                            <h1 class="text-sm font-semibold">Q4:{{ $vltn->qfour }}</h1>
                            <select name="qfour" wire:model="qfour" id="qfour" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qfour')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q5:{{ $vltn->qfive }}</h1>
                            <select name="qfive" wire:model="qfive" id="qfive" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qfive')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q6:{{ $vltn->qsix }}</h1>
                            <select name="qsix" wire:model="qsix" id="qsix" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qsix')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col" class="rounded">
                            <h1 class="text-sm font-semibold">Q7:{{ $vltn->qseven }}</h1>
                            <select name="qseven" wire:model="qseven" id="qseven">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qseven')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q8:{{ $vltn->qeight }}</h1>
                            <select name="qeight" wire:model="qeight" id="qeight" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qeight')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q9:{{ $vltn->qnine }}</h1>
                            <select name="qnine" wire:model="qnine" id="qnine" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qnine')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Q10:{{ $vltn->qten }}</h1>
                            <select name="qten" wire:model="qten" id="qten" class="rounded">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('qten')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <h1 class="text-sm font-semibold">Recommendation / Feedback:</h1>
                            <x-input type="text" wire:model="recommendation" name="recommendation" id="recommendation"  />
                            @error('recommendation')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="w-11/12 relative m-3 flex flex-col">
                            <x-button type="submit">submit</x-button>
                        </div> 
                    </form>
                </div>
            </div>
        @endif
    </x-modal> 
    
<x-modal wire:model="ratingsModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 bg-whitey p-5 rounded relative items-center justify-center mb-5 flex flex-col">
           <div class="w-full relative flex p-5 gap-5 justify-center">
                <button class="p-2 text-xs border rounded-lg hover:bg-yellow-green {{ $ratings_content == 'DEPARTMENTEMPLOYEES' ? 'bg-yellow-green' : '' }}" wire:click='departmentEmployeesRatings'>Department Employees</button>
                <button class="p-2 text-xs border rounded-lg hover:bg-yellow-green {{ $ratings_content == 'DEPARTMENTHEADS' ? 'bg-yellow-green' : '' }}" wire:click='departmentHeadsRatings({{ $eval_id }})'>Department Heads</button>
           </div>
           <div class="w-11/12 relative m-5 flex justify-center items-center flex-col rounded">
            <h1 class="text-sm font-semibold">Employee Rating</h1>
            <h1 class="text-xs font-semibold italic">For the month of
                @if ($ratings_month == 1)
                January
            @elseif($ratings_month == 2)
                February
            @elseif($ratings_month == 3)
                March    
            @elseif($ratings_month == 4)
                April    
            @elseif($ratings_month == 5)
                May
            @elseif($ratings_month == 6)
                June    
            @elseif($ratings_month == 7)
                July
            @elseif($ratings_month == 8)
                August
            @elseif($ratings_month == 9)
                September    
            @elseif($ratings_month == 10)
                October   
            @elseif($ratings_month == 11)
                November    
            @elseif($ratings_month == 12)
                December     
            @endif
            ({{ $ratings_yr }})
            </h1>
        </div>
           @if ($ratings_content == 'DEPARTMENTEMPLOYEES')
                    @if ($department_employee_ratings != null)
                        <div class="w-full relative m-1 p-3 rounded border flex flex-col justify-between items-center">
                                <table class="w-full relative">
                                    <tr>
                                        <th class="text-sm">Profile</th>
                                        <th class="text-sm">Name</th>
                                        <th class="text-sm">Department</th>
                                        <th class="text-sm">Grade</th>
                                    </tr>
                            @foreach ($department_employee_ratings as $rating)
                                
                                        <tr>
                                                <td class="">
                                                    <span class="w-full relative flex justify-center items-center">
                                                        @if ($rating->user->profile_photo_path != null)
                                                            <img src="/storage/employee-media/{{$rating->user->profile_photo_path  }}" alt="" class="w-8 h-8 rounded-full border">
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="border rounded-full" height="30" viewBox="0 96 960 960" width="30"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>    
                                                        @endif
                                                    </span>
                                                        
                                                </td>
                                                <td class="text-center">
                                                    <h1 class="text-xs ml-5">{{ $rating->user->name }}</h1>
                                                
                                            </td>
                                            <td class="text-center">
                                                    <h1 class="text-xs text-center">{{ $rating->user->department }}</h1>
                                            </td>
                                            <td class="text-center">
                                                <h1 class="text-xs  text-center">{{ $rating->grade }}</h1>
                                            </td>
                                        </tr>
                            @endforeach
                        </table>
                        <div class="w-full relative flex justify-end items-end mt-10">
                            <button class="hover:bg-yellow-green text-xs rounded-lg border p-2" wire:click='downloadAceEmployees({{ $eval_id }})'>Download A+ Employees</button>
                        </div>
                        </div>
                    @endif
           @elseif($ratings_content == 'DEPARTMENTHEADS')
                        @if ($department_heads != null)
                            <div class="w-full relative m-1 p-3 rounded border flex flex-col justify-between items-center">
                                    <table class="w-full relative">
                                        <tr>
                                            <th class="text-sm">Profile</th>
                                            <th class="text-sm">Name</th>
                                            <th class="text-sm">Department</th>
                                            <th class="text-sm">Grade</th>
                                        </tr>
                                @foreach ($department_heads as $department_head)
                                    
                                            <tr>
                                                    <td class="">
                                                        <span class="w-full relative flex justify-center items-center">
                                                            @if ($department_head->user->profile_photo_path != null)
                                                                <img src="/storage/employee-media/{{$department_head->user->profile_photo_path  }}" alt="" class="w-8 h-8 rounded-full border">
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="border rounded-full" height="30" viewBox="0 96 960 960" width="30"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>    
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <h1 class="text-xs ml-5">{{ $department_head->user->name }}</h1>
                                                    
                                                </td>
                                                <td class="text-center">
                                                        <h1 class="text-xs text-center">{{ $department_head->user->department }}</h1>
                                                </td>
                                                <td class="text-center">
                                                    <h1 class="text-xs  text-center">{{ $department_head->grade }}</h1>
                                                </td>
                                            </tr>
                                @endforeach
                            </table>
                            <div class="w-full relative flex justify-end items-end mt-10">
                                <button class="hover:bg-yellow-green text-xs rounded-lg border p-2" wire:click='downloadAceDepartmentHeads({{ $eval_id }})'>Download Ace Department Head</button>
                            </div>
                            </div>
                        @endif
           @endif
        </div>
    </div>

</x-modal>
<x-modal wire:model="evalutaionQuestionModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 bg-whitey p-5 relative rounded flex justify-center flex-col m-5">
            <form wire:submit="saveQuestions" method="POST">
                @csrf
                <div class="w-11/12 relative flex m-3 flex-col">
                    <h1>Evaluation Question:</h1>
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qOne">Q1:</x-label>
                    <x-input type="text" name="qOne" wire:model="qOne" id="qOne" />
                    @error('qOne')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qTwo">Q2:</x-label>
                    <x-input type="text" name="qTwo" wire:model="qTwo" id="qTwo" />
                    @error('qTwo')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qThree">Q3:</x-label>
                    <x-input type="text" name="qThree" wire:model="qThree" id="qThree" />
                    @error('qThree')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qFour">Q4:</x-label>
                    <x-input type="text" name="qFour" wire:model="qFour" id="qFour" />
                    @error('qFour')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qFive">Q5:</x-label>
                    <x-input type="text" name="qFive" wire:model="qFive" id="qFive" />
                    @error('qFive')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qSix">Q6:</x-label>
                    <x-input type="text" name="qSix" wire:model="qSix" id="qSix" />
                    @error('qSix')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qSeven">Q7:</x-label>
                    <x-input type="text" name="qSeven" wire:model="qSeven" id="qSeven" />
                    @error('qSeven')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qEight">Q8:</x-label>
                    <x-input type="text" name="qEight" wire:model="qEight" id="qEight" />
                    @error('qEight')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qNine">Q9:</x-label>
                    <x-input type="text" name="qNine" wire:model="qNine" id="qNine" />
                    @error('qNine')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-label for="qTen">Q10:</x-label>
                    <x-input type="text" name="qTen" wire:model="qTen" id="qTen" />
                    @error('qTen')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 relative flex m-3 flex-col">
                    <x-button type="submit">Submit</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>
<x-modal wire:model="addEvaluationQuestionsModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-10/12 relative rounded bg-whitey p-5 flex justify-center flex-col m-5">
            <form wire:submit="setMonthForEvaluationQuestion" method="POST">
                @csrf
                <div class="w-11/12 relative flex flex-col m-5">
                    <h1 class="font-semibold text-sm">Set Evaluation Question for the month of.</h1>
                </div>
                <div class="w-11/12 relative flex flex-col m-5">
                   <x-label for="month">Month:</x-label>
                   <select name="month" id="month" wire:model="month">
                        <option value=""></option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                   </select>
                   @error('month')
                       <span class="text-xs text-red-200">{{ $message }}</span>
                   @enderror
                </div>

                <div class="w-11/12 relative flex flex-col m-5">
                    <x-label for="year">Year:</x-label>
                    <select name="year" id="year" wire:model="year">
                         <option value=""></option>
                         @for ($i = date('Y', time()); $i <= (date('Y', time()) + 10); $i++)
                             <option value="{{ $i }}">{{ $i }}</option>
                         @endfor
                    </select>
                    @error('year')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                @enderror
                 </div>

                 <div class="w-11/12 relative flex flex-col m-5">
                    <x-button type="submit">Next</x-button>
                 </div>
            </form>
        </div>    
    </div>    
</x-modal>    
</div>