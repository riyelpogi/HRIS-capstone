<div class="w-11/12 relative flex justify-center m-5">
    <div class="w-full relative  bg-white rounded flex flex-col">
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
           <div class="w-full relative flex gap-5 m-5">
                <button class="p-2 border text-xs rounded-lg {{ $content == 'PERFORMANCE' ? 'bg-yellow-green' : '' }}" wire:click="performance">Performance</button>
                <button class="p-2 border text-xs rounded-lg {{ $content == 'EVALUATE' ? 'bg-yellow-green' : '' }}"" wire:click="evaluate">Evaluations</button>
            </div>
                @if ($content == 'PERFORMANCE')
                <div class="w-11/12 relative flex ">
                    <h1 class="text-lh font-semibold p-5">Performance</h1>
                </div>
               <div class="w-full  smr:flex-col xsmr:flex-col relative xsmr:gap-5 smr:gap-5 flex justify-center ">
                    <div class="w-6/12 m-2 xsmr:w-full smr:w-full flex flex-col justify-center items-center">
                        @if (auth()->user()->profile_photo_path != null)
                        <img src="/storage/employee-media/{{auth()->user()->profile_photo_path  }}" alt="" class="w-60 h-60 rounded-full border">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="border rounded-full" height="200" viewBox="0 96 960 960" width="200"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>    
                    @endif
                    <div class="w-11/12 flex justify-between m-2">
                        <h1 class="font-semibold text-sm">{{ auth()->user()->name }}</h1>
                        <h1 class="font-semibold text-sm">{{ auth()->user()->employee_id }}</h1>
                    </div>
                    <div class="w-11/12 flex justify-between m-2">
                        <h1 class="font-semibold text-sm">{{ auth()->user()->position }}</h1>
                        <h1 class="font-semibold text-sm">{{ auth()->user()->department }}</h1>
                    </div>
                    </div>
                    <div class="w-6/12 relative flex-col xsmr:w-full smr:w-full m-2 flex">
                        <div class="w-full relative flex">
                            <select name="month" class="rounded text-xs w-full h-10 " wire:model="month" id="month">
                                <option value=""></option>
                                <option value="1">January</option>
                                <option value="2">Februrary</option>
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
                        </div>
                        <div class="w-full relative flex">
                            <h1 class="text-sm font-semibold italic ml-4 mt-3" wire:poll>
                                Evaluation for the month of 
                            @if ($month == 1)
                                January
                            @elseif($month == 2)
                                February
                            @elseif($month == 3)
                                March    
                            @elseif($month == 4)
                                April    
                            @elseif($month == 5)
                                May
                            @elseif($month == 6)
                                June    
                            @elseif($month == 7)
                                July
                            @elseif($month == 8)
                                August
                            @elseif($month == 9)
                                September    
                            @elseif($month == 10)
                                October   
                            @elseif($month == 11)
                                November    
                            @elseif($month == 12)
                                December     
                            @endif
                            ({{ date('Y', time()) }})
                            </h1>
                        </div>

                      @if (strpos(auth()->user()->position, 'Head') || strpos(auth()->user()->position, 'head'))
                                @if ($my_evaluations != null)
                                        <div class="text-6xl flex relative justify-center w-ull m-3">
                                            <h1 class="text-center font-bold">{{ $my_evaluations->grade }}</h1>
                                        </div>
                                        <div class="w-full relative flex flex-col mt-5">
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q1:{{ $my_evaluations->evaluation_question->qone }} - {{ $my_evaluations->qone }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q2:{{ $my_evaluations->evaluation_question->qtwo }} - {{ $my_evaluations->qtwo }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q3:{{ $my_evaluations->evaluation_question->qthree }} - {{ $my_evaluations->qthree }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q4:{{ $my_evaluations->evaluation_question->qfour }} - {{ $my_evaluations->qfour }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q5:{{ $my_evaluations->evaluation_question->qfive }} - {{ $my_evaluations->qfive }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q6:{{ $my_evaluations->evaluation_question->qsix }} - {{ $my_evaluations->qsix }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q7:{{ $my_evaluations->evaluation_question->qseven }} - {{ $my_evaluations->qseven }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q8:{{ $my_evaluations->evaluation_question->qeight }} - {{ $my_evaluations->qeight }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q9:{{ $my_evaluations->evaluation_question->qnine }} - {{ $my_evaluations->qnine }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs">Q10:{{ $my_evaluations->evaluation_question->qten }} - {{ $my_evaluations->qten }} </x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs font-semibold">Recommendation: {{ $my_evaluations->recommendation }}</x-label>
                                            </div>
                                            <div class="w-11/12 relative flex flex-col ml-4">
                                                <x-label class="text-xs font-semibold">You are evaluated by your department employees : {{ $my_evaluations->dep_employee }}</x-label>
                                            </div>
                                    </div>
                                @else
                                    <div class="text-6xl flex relative justify-center w-ull m-3">
                                        <h1 class="text-sm font-bold uppercase ">No evaluation for this month.</h1>   
                                    </div>    
                                @endif
                      @else
                                @if ($my_evaluations != null)
                                    <div class="text-6xl flex relative justify-center w-ull m-3">
                                        <h1 class="text-center font-bold">{{ $my_evaluations->grade }}</h1>
                                    </div>
                                <div class="w-full relative flex flex-col mt-5">
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q1:{{ $my_evaluations->evaluation_question->qone }} - {{ $my_evaluations->qone }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q2:{{ $my_evaluations->evaluation_question->qtwo }} - {{ $my_evaluations->qtwo }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q3:{{ $my_evaluations->evaluation_question->qthree }} - {{ $my_evaluations->qthree }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q4:{{ $my_evaluations->evaluation_question->qfour }} - {{ $my_evaluations->qfour }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q5:{{ $my_evaluations->evaluation_question->qfive }} - {{ $my_evaluations->qfive }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q6:{{ $my_evaluations->evaluation_question->qsix }} - {{ $my_evaluations->qsix }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q7:{{ $my_evaluations->evaluation_question->qseven }} - {{ $my_evaluations->qseven }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q8:{{ $my_evaluations->evaluation_question->qeight }} - {{ $my_evaluations->qeight }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q9:{{ $my_evaluations->evaluation_question->qnine }} - {{ $my_evaluations->qnine }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs">Q10:{{ $my_evaluations->evaluation_question->qten }} - {{ $my_evaluations->qten }}</x-label>
                                        </div>
                                        <div class="w-11/12 relative flex flex-col ml-4">
                                            <x-label class="text-xs font-semibold">Recommendation: {{ $my_evaluations->recommendation }}</x-label>
                                        </div>
                                    
                                </div>
                                @else
                                    <div class="text-6xl flex relative justify-center w-ull m-3">
                                        <h1 class="text-sm font-bold uppercase ">No evaluation for this month.</h1>   
                                    </div>
                                @endif    
                      @endif
                    </div>
                </div>
                
                @elseif($content == 'EVALUATE') 
                        <div class="w-11/12 relative flex flex-col  justify-center m-2">
                            <h1 class="text-sm font-bold">Evaluations:</h1>
                        </div>
                    @foreach ($evaluations as $evaluation)
                    <div class="w-11/12 relative flex flex-col justify-center border m-2 {{ $evaluation->id == $parameter_id ? 'border border-2 border-black' : '' }}" >
                        <div class="w-11/12 relative flex items-center justify-between m-5">
                            <h1 class="text-sm font-bold">
                                @if ($evaluation->month == 1)
                                    January
                                @elseif($evaluation->month == 2)
                                    February
                                @elseif($evaluation->month == 3)
                                    March    
                                @elseif($evaluation->month == 4)
                                    April    
                                @elseif($evaluation->month == 5)
                                    May
                                @elseif($evaluation->month == 6)
                                    June    
                                @elseif($evaluation->month == 7)
                                    July
                                @elseif($evaluation->month == 8)
                                    August
                                @elseif($evaluation->month == 9)
                                    September    
                                @elseif($evaluation->month == 10)
                                    October   
                                @elseif($evaluation->month == 11)
                                    November    
                                @elseif($evaluation->month == 12)
                                    December     
                                @endif
                                <span>({{ $evaluation->year }})</span>
                            </h1>
                                @if($show_evaluation == $evaluation->id)
                                    <span class="p-2 rounded-full hover:bg-gray-400 cursor-pointer" wire:click="hideEvaluation({{ $evaluation->id }})" wire:key="hide-evaluation-{{ $evaluation->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="m296-345-56-56 240-240 240 240-56 56-184-184-184 184Z"/></svg>
                                    </span>    
                                @else
                                    <span class="p-2 rounded-full hover:bg-gray-400 cursor-pointer" wire:click="showEvaluation({{ $evaluation->id }})" wire:key="show-evaluation-{{ $evaluation->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M480-345 240-585l56-56 184 184 184-184 56 56-240 240Z"/></svg>  
                                    </span>
                                @endif
                        </div>
                        @if ($show_evaluation == $evaluation->id)
                        <div class="w-11/12 relative flex flex-col m-5">
                            <h1 class="text-xs font-bold italic">Evaluation Questions:</h1>
                            <p class="text-xs font-semibold italic">1.{{ $evaluation->qone }}</p>
                            <p class="text-xs font-semibold italic">2.{{ $evaluation->qtwo }}</p>
                            <p class="text-xs font-semibold italic">3.{{ $evaluation->qthree }}</p>
                            <p class="text-xs font-semibold italic">4.{{ $evaluation->qfour }}</p>
                            <p class="text-xs font-semibold italic">5.{{ $evaluation->qfive }}</p>
                            <p class="text-xs font-semibold italic">6.{{ $evaluation->qsix }}</p>
                            <p class="text-xs font-semibold italic">7.{{ $evaluation->qseven }}</p>
                            <p class="text-xs font-semibold italic">8.{{ $evaluation->qeight }}</p>
                            <p class="text-xs font-semibold italic">9.{{ $evaluation->qnine }}</p>
                            <p class="text-xs font-semibold italic">10.{{ $evaluation->qten }}</p>
                        </div>

                        <div class="w-11/12 relative justify-end flex m-5">
                            @if ($head == true)
                                <div class="flex gap-5">
                                    <button class="p-2 rounded-lg text-xs border hover:bg-yellow-green" wire:click="evaluateEmployees({{ $evaluation->id }})" wier:key="evaluate-employees-{{ $evaluation->id }}">Evaluate Employees</button>
                                </div>
                            @else
                                <div class="flex gap-5">
                                    <button class="p-2 rounded-lg text-xs border hover:bg-yellow-green" wire:click="showEvaluateHeadModal({{ $evaluation->id }},{{ $evaluation->month }}, {{ $evaluation->year }})" wier:key="showEvaluateHeadModal-{{ $evaluation->id }}">Evaluate Your Head</button>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach  
                @endif
    </div>

<x-modal wire:model="evaluationQuestion">
    @if ($vltn != null && $employee != null)
        <div class="w-full flex justify-center relative">
            <div class="w-11/12 bg-whitey rounded p-5 relative flex justify-center flex-col">
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
                <form wire:submit="submitEvluation" method="POST">
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

<x-modal wire:model="evaluationsModal">
    <div class="w-full relative flex justify-center flex-col items-center">
        <div class="w-11/12 bg-whitey rounded p-5 relative flex flex-col justify-center items-center">
            <div class="w-full relative justify-center flex  items-center m-5">
                <h1 class="font-semibold text-sm p-3">Pick Employee:</h1>
            </div>
            <div class="w-full relative flex justify-around m-2 items-center rounded">
                <table class="w-full">
                    <tr>
                        <th class="text-sm">Profile</th>
                        <th class="text-sm">Name</th>
                        <th class="text-sm">Position</th>
                        <th class="text-sm">Action</th>
                    </tr>
            @foreach ($department_employees as $department_employee)
                @if ($department_employee->employee_id != auth()->user()->employee_id)
                        <tr>
                            <td class="text-center">
                                    <span class="flex justify-center items-center">
                                        @if ($department_employee->profile_photo_path != null)
                                            <img src="/storage/employee-media/{{ $department_employee->profile_photo_path }}" alt="" class="w-8 h-8 rounded-full border">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="border rounded-full" height="24" viewBox="0 96 960 960" width="24"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>    
                                        @endif
                                    </span>
                            </td>
                            <td class="text-center">
                                    <h1 class="text-xs p-2">{{ $department_employee->name }}</h1>
                            </td>
                            <td class="text-center">
                                <h1 class="text-xs p-2">{{ $department_employee->position }}</h1>
                            </td>
                            <td class="text-center">
                                @if ($vltn != null)
                                    @if (in_array($department_employee->employee_id, array_column($vltn->evaluated  ->toArray(), 'evaluated')))
                                        <button class="text-xs p-1 m-2 rounded-lg border bg-yellow-green" >Evaluated</button>
                                    @else
                                    <button class="text-xs p-1 m-2 rounded-lg border hover:bg-yellow-green" wire:click="evaluateEmployee('{{ $department_employee->employee_id }}')" wire:key="evaluate-employee-{{ $department_employee->employee_id }}">Evaluate</button>   
                                    @endif
                                @endif
                            </td>
                        </tr>
                    
                @endif
            @endforeach
                 </table>
            </div>
        </div>
    </div>
</x-modal>    
</div>
