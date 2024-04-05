<div class="w-11/12 relative bg-white rounded m-5">
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
    <div class="w-full relative mb-5 flex gap-5 pl-5 ">
        <div class="text-xs hover:bg-yellow-green p-2 mt-5 border rounded-lg cursor-pointer {{$attendance_content == 'SCHEDULE' ? 'bg-yellow-green' : ''}}" wire:click="schedule_content">Schedule</div>
        <div class="text-xs hover:bg-yellow-green p-2 mt-5 border rounded-lg cursor-pointer {{$attendance_content == 'REQUESTS' ? 'bg-yellow-green' : ''}}" wire:click="requests">Requests</div>
    </div>
    <div class="w-full relative">
    @if ($attendance_content == 'SCHEDULE')
    <div class="w-full relative mt-5 flex justify-center items-center">
     
        <div class="mr-4 flex gap-5">
            <x-button wire:click="showRequestScheduleModal">Request Schedule</x-button>
            <x-button wire:click="requestOff">Change Off</x-button>
            <x-button wire:click="requestLeave">Request Leave</x-button>
        </div>
    </div>

    <div class="w-full relative flex justify-center items-center gap-2 mt-5 flex-wrap">
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'January' ? 'bg-yellow-green' : '' }} text-xs" wire:click="jan">
            Jan
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'February' ? 'bg-yellow-green' : '' }} text-xs" wire:click="feb">
            Feb
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'March' ? 'bg-yellow-green' : '' }} text-xs" wire:click="mar">
            Mar
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'April' ? 'bg-yellow-green' : '' }} text-xs" wire:click="apr">
            Apr
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'May' ? 'bg-yellow-green' : '' }} text-xs" wire:click="may">
            May
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'June' ? 'bg-yellow-green' : '' }} text-xs" wire:click="jun">
            Jun
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'July' ? 'bg-yellow-green' : '' }} text-xs" wire:click="jul">
            Jul
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'August' ? 'bg-yellow-green' : '' }} text-xs" wire:click="aug">
            Aug
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'September' ? 'bg-yellow-green' : '' }} text-xs" wire:click="sept">
            Sept
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'October' ? 'bg-yellow-green' : '' }} text-xs" wire:click="oct">
            Oct
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'November' ? 'bg-yellow-green' : '' }} text-xs" wire:click="nov">
            Nov
        </div>
        <div class="p-2 rounded-lg border cursor-pointer {{$month == 'December' ? 'bg-yellow-green' : '' }} text-xs" wire:click="dec">
            Dec
        </div>

        @for ($i = date('Y', time()); $i <= date('Y', time()) + 1; $i++)
        <div class="p-2 rounded-lg border cursor-pointer {{$year == $i ? 'bg-yellow-green' : ''}} text-xs" wire:click="setYear({{$i}})" wire:key="year-{{$i}}">
            {{$i}}
        </div>
        @endfor

    </div>
    <div class="w-full relative flex justify-center items-center mt-3 flex-wrap gap-1" wire:poll>
        @if ($schedule != null)
        @for ($i = 1; $i <= $total_days; $i++)
        <div class="w-20 relative h-20 border flex flex-col "  wire:key="date-{{$i}}">
           <div class="w-full flex justify-between">
                <h1 class="ml-2 text-xs">{{$i}}</h1>
                <div class="">
                    @if ($this->month == 'December')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-12-$i"))}}</h1>
                    @elseif($this->month == 'November')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-11-$i"))}}</h1>
                    @elseif($this->month == 'October')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-10-$i"))}}</h1>
                    @elseif($this->month == 'September')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-9-$i"))}}</h1>
                    @elseif($this->month == 'August')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-8-$i"))}}</h1>
                    @elseif($this->month == 'July')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-7-$i"))}}</h1>
                    @elseif($this->month == 'June')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-6-$i"))}}</h1>
                    @elseif($this->month == 'May')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-5-$i"))}}</h1>
                    @elseif($this->month == 'April')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-4-$i"))}}</h1>
                    @elseif($this->month == 'March')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-3-$i"))}}</h1>
                    @elseif($this->month == 'February')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-2-$i"))}}</h1>
                    @elseif($this->month == 'January')
                    <h1 class="mr-2 text-xs">{{date('D', strtotime("$year-1-$i"))}}</h1>
                    @endif
                </div>
            </div>
        <div class="w-full flex justify-center items-center h-20 ">
            <h1 class="text-xs text-center {{ $schedule[$i] == 'On Sick Leave' ? 'text-red-400' : '' }} {{ $schedule[$i] == 'On Maternity Leave' ? 'text-red-400' : '' }} {{ $schedule[$i] == 'On Training' ? 'text-red-400' : '' }} {{ $schedule[$i] == 'LEAVE' ? 'text-red-400' : '' }}">{{$schedule[$i]}}</h1>
        </div>
        </div>
    @endfor
        @endif
    </div>
    @elseif($attendance_content == 'REQUESTS')
        <div class="w-full relative flex flex-col justif-center">
            <div class="flex gap-5 ml-5">
                <button class="p-1 text-xs rounded hover:bg-yellow-green {{$request_content == 'SCHEDULE' ? 'bg-yellow-green' : ''}}" wire:click="requestContentSchedule" >Schedule</button>
                <button class="p-1 text-xs rounded hover:bg-yellow-green {{$request_content == 'LEAVE' ? 'bg-yellow-green' : ''}}"  wire:click="requestContentLeave">Leave</button>
                <button class="p-1 text-xs rounded hover:bg-yellow-green {{$request_content == 'OFF' ? 'bg-yellow-green' : ''}}"  wire:click="requestContentOff">Off</button>
            </div>
           @if ($request_content == 'OFF')
           <div class="w-full mt-5 mb-5 relative flex justify-center" wire:poll>
            <table class="w-full">
                <caption class="text-sm border font-semibold">REQUEST OFFS</caption>
                <tr class="border">
                    <th class="w-40 text-xs ">DATE</th>
                    <th class="w-40 text-xs ">CHANGE REST DAY</th>
                    <th class="w-40 text-xs xsmr:hidden smr:hidden">REASON</th>
                    <th class="w-40 text-xs xsmr:hidden smr:hidden">REASON TO DECLINE</th>
                    <th class="w-40 text-xs ">STATUS</th>
                    <th class="w-40 text-xs ">ACTION</th>
                </tr>
                    @if ($requestsOffs != null)
                    @foreach ($requestsOffs as $requestOff)
                    <tr class="{{ $requestOff->id == $parameter_id ? 'border border-2 border-black' : '' }}">
                        <td class="text-xs text-center">{{$requestOff->date}}</td>
                        <td class="text-xs text-center">{{$requestOff->rest_day}}</td>
                        <td class="text-xs text-center xsmr:hidden smr:hidden">{{$requestOff->reason}}</td>
                        <td class="text-xs text-center xsmr:hidden smr:hidden">{{$requestOff->reason_to_decline}}</td>
                        <td class="text-xs text-center uppercase">{{$requestOff->status}}</td>
                        <td class="text-xs text-center">
                            @if ($requestOff->status  != 'pending')
                                <button class="text-xs p-1 rounded-lg bg-gray-200 hover:bg-red-200 ">Cancel</button>
                            @else
                                <button class="text-xs p-1 rounded-lg bg-red-400  " wire:click="cancelRequestOff({{$requestOff->id}})" wire:key="cancelrequestoff-{{$requestOff->id}}"  {{$requestOff->status != 'pending' ? 'disabled' : ''}} wire:confirm="Are you sure you want to cancel this?" >Cancel</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
            </table>
            </div>

            @elseif($request_content == 'LEAVE')
            <div class="w-full mt-5 mb-5 relative flex justify-center" wire:poll>
                <table class="w-full">
                    <caption class="text-sm border font-semibold">REQUEST LEAVE</caption>
                    <tr class="border">
                        <th class="w-40 text-xs ">FROM</th>
                        <th class="w-40 text-xs ">TO</th>
                        <th class="w-40 text-xs xsmr:hidden smr:hidden">REASON</th>
                        <th class="w-40 text-xs xsmr:hidden smr:hidden">REASON TO DECLINE</th>
                        <th class="w-40 text-xs ">STATUS</th>
                        <th class="w-40 text-xs ">ACTION</th>
                    </tr>
                    @if($request_leaves != null)
                        @foreach ($request_leaves as $request_leave)
                        <tr class="{{ $request_leave->id == $parameter_id ? 'border border-2 border-black' : '' }}">
                            <td class="text-xs text-center">{{$request_leave->from}}</td>
                            <td class="text-xs text-center">{{$request_leave->to}}</td>
                            <td class="text-xs text-center xsmr:hidden smr:hidden">{{$request_leave->reason}}</td>
                            <td class="text-xs text-center xsmr:hidden smr:hidden">{{$request_leave->reason_to_decline}}</td>
                            <td class="text-xs text-center uppercase">{{$request_leave->status}}</td>
                            <td class="text-xs text-center">
                                @if ($request_leave->status != 'pending')
                                    <button class="text-xs p-1 rounded-lg bg-gray-200 " >Cancel</button>
                                @else    
                                    <button class="text-xs p-1 rounded-lg bg-red-400 hover:bg-red-200" wire:click="cancelRequestLeave({{$request_leave->id}})" wire:key="cancelRequestLeave-{{$request_leave->id}}" {{$request_leave->status != 'pending' ? 'disabled' : ''}}  wire:confirm="Are you sure you want to cancel this?" >Cancel</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif    
                </table>
            
            </div>

            @elseif($request_content = 'SCHEDULE')
            <div class="w-full mt-5 mb-5 relative flex justify-center" wire:poll>
                <table class="w-full">
                    <caption class="text-sm border font-semibold">REQUEST SCHEDULE</caption>
                    <tr class="border">
                        <th class="w-40 text-xs ">CUTOFF</th>
                        <th class="w-40 text-xs ">STATUS</th>
                        <th class="w-40 text-xs xsmr:hidden smr:hidden">REASON TO DECLINE</th>
                        <th class="w-40 text-xs ">ACTION</th>
                    </tr>
                    @if($request_schedules)
                        @foreach ($request_schedules as $request_schedule)
                        <tr class="{{ $parameter_id == $request_schedule->id ? 'border border-2 border-black' : '' }}">
                            <td class="text-xs text-center">{{$request_schedule->cutoff}}</td>
                            <td class="text-xs text-center uppercase">{{$request_schedule->status}}</td>
                            <td class="text-xs text-center xsmr:hidden smr:hidden">{{$request_schedule->reason_to_decline}}</td>
                            <td class="text-xs text-center">
                                @if ($request_schedule->status != 'pending')
                                    <button class="text-xs p-1 rounded-lg bg-gray-200"  >Cancel</button>
                                @else
                                    <button class="text-xs p-1 rounded-lg bg-red-400 hover:bg-red-200 " wire:click="cancelRequestSchedule({{$request_schedule->id}})" wire:confirm="Are you sure you want to cancel this?" wire:key="cancelRequestSchedule-{{$request_schedule->id}}" >Cancel</button>    
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif    
                </table>
            
            </div>
           @endif

           

        </div>
    @endif
    </div>

<x-modal wire:model="requestOffModal" >
    <div class="w-full relative flex justify-center items-center">
        <div class="w-9/12 bg-whitey rounded p-5 relative flex items-center justify-center m-5">
            <form wire:submit="requestOffSubmit" method="POST">
                @csrf
                <div class="w-full relative mt-5 mb-5">
                    <h1 class="font-semibold">Change Day Off</h1>
                    <span class="text-xs">Note: your request can review up to 2 to 3 days.</span>
                </div>

                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <x-label for="date">Date:</x-label>
                    <x-input type="date" wire:model="date" name="date" id="date" />
                    @error('date')
                    <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>

                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <x-label for="date">Your Rest Day:</x-label>
                    <select name="rest_day" id="rest_day" wire:model="rest_day" class="border border-gray-300 rounded">
                        <option value=""></option>
                        @if ($rest_days != null)
                        @foreach ($rest_days as $value)
                        <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    @endif
                    </select>
                    @error('date')
                    <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>

                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <x-label for="reason">Reason:</x-label>
                    <x-input wire:model="reason" name="reason" id="reason" />
                    @error('reason')
                        <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>
                
                <div class="w-full relative mt-5 mb-5 flex justify-end">
                    <x-button type="submit">Submit</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>    

<x-modal wire:model="requestScheduleModal" >
    <div class="w-full relative flex justify-center items-center">
        <div class="w-9/12 bg-whitey rounded p-5 relative flex  flex-col items-center justify-center m-5">
                <form wire:submit="cutoffsave" method="POST">
                    @csrf
                    <div class="w-full relative mt-5 mb-5 flex flex-col">
                        <h1 class="font-semibold">Request Schedule</h1>
                        <span class="text-xs">Note: you can only request schedule for the following months.</span>
                        <span class="text-xs">Note: your request can review up to 4 to 7 days.</span>
                    </div>
    
                    <div class="w-full relative mt-5 mb-5 flex flex-col">
                        <x-label for="cutoff">Pick a cut off</x-label>.
                        <select name="cutoff" id="cutoff" wire:model="cutoff">
                            
                            <option value=""></option>
                            @foreach ($cutofflists as $key => $cutofflist)
                                @foreach ($cutofflist as $cutoffkey =>  $date)
                                  @if ($key >= date('Y', time()) + date('n', time()))
                                  <option value="{{$date}}">{{$date}}</option>
                                  @endif
                                @endforeach    
                            @endforeach
                        </select>
                    </div>
    
                    <div class="w-full relative mt-5 mb-5 flex">
                        <x-button type='submit'>submit</x-button>
                    </div>
                </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="setScheduleModal" >
    <div class="w-full relative flex justify-center items-center">
        <div class="w-9/12 bg-whitey rounded p-5 border relative flex flex-col justify-center m-5">
                <form wire:submit="setSchedule" method="POST">
                    @csrf
                    <div class="w-full relative mt-5 mb-5 flex flex-col">
                        <h1 class="font-semibold text-center">Request Schedule</h1>
                        <span class="text-xs text-center">Note: you can only request schedule for the following months.</span>
                        <span class="text-xs text-center">Note: your request can review up to 4 to 7 days.</span>
                        <span class="text-xs text-center">Note: you can only have 2 rest days per week.</span>
                    </div>

                    <div class="w-full  relative flex flex-col ">
                        <h1 class="font-semibold text-center">Cut Off: {{$cutoff}}</h1>
                    </div>
                    
                    <div class="w-full relative mt-5 mb-5 flex flex-col justify-center ">
                        <x-label>Monday:</x-label>
                        <select name="Mon" class="" id="Mon" wire:model="Mon">
                            <option value=""></option>
                            <option value="7am - 3pm">7am - 3pm</option>
                            <option value="10am - 6pm">10am - 6pm</option>
                            <option value="2pm - 10pm">2pm - 10pm</option>
                            <option value="RD">Rest Day</option>
                        </select>
                    </div>

                    <div class="w-full relative mt-5 mb-5 flex flex-col ">
                        <x-label>Tuesday:</x-label>
                        <select name="Tue" class="" id="Tue" wire:model="Tue">
                            <option value=""></option>
                            <option value="7am - 3pm">7am - 3pm</option>
                            <option value="10am - 6pm">10am - 6pm</option>
                            <option value="2pm - 10pm">2pm - 10pm</option>
                            <option value="RD">Rest Day</option>
                        </select>
                    </div>

                    <div class="w-full relative mt-5 mb-5 flex flex-col ">
                        <x-label>Wednesday:</x-label>
                        <select name="Wed" class="" id="Wed" wire:model="Wed">
                            <option value=""></option>
                            <option value="7am - 3pm">7am - 3pm</option>
                            <option value="10am - 6pm">10am - 6pm</option>
                            <option value="2pm - 10pm">2pm - 10pm</option>
                            <option value="RD">Rest Day</option>
                        </select>
                    </div>

                    <div class="w-full relative mt-5 mb-5 flex flex-col  ">
                        <x-label>Thursday:</x-label>
                        <select name="Thu" class="" id="Thu" wire:model="Thu">
                            <option value=""></option>
                            <option value="7am - 3pm">7am - 3pm</option>
                            <option value="10am - 6pm">10am - 6pm</option>
                            <option value="2pm - 10pm">2pm - 10pm</option>
                            <option value="RD">Rest Day</option>
                        </select>
                    </div>

                    <div class="w-full relative mt-5 mb-5 flex flex-col  ">
                        <x-label>Friday:</x-label>
                        <select name="Fri" class="" id="Fri" wire:model="Fri">
                            <option value=""></option>
                            <option value="7am - 3pm">7am - 3pm</option>
                            <option value="10am - 6pm">10am - 6pm</option>
                            <option value="2pm - 10pm">2pm - 10pm</option>
                            <option value="RD">Rest Day</option>
                        </select>
                    </div>

                    <div class="w-full relative mt-5 mb-5 flex flex-col  ">
                        <x-label>Saturday:</x-label>
                        <select name="Sat" class="" id="Sat" wire:model="Sat">
                            <option value=""></option>
                            <option value="7am - 3pm">7am - 3pm</option>
                            <option value="10am - 6pm">10am - 6pm</option>
                            <option value="2pm - 10pm">2pm - 10pm</option>
                            <option value="RD">Rest Day</option>
                        </select>
                    </div>

                    <div class="w-full relative mt-5 mb-5 flex flex-col ">
                        <x-label>Sunday:</x-label>
                        <select name="Sun" class="" id="Sun" wire:model="Sun">
                            <option value=""></option>
                            <option value="7am - 3pm">7am - 3pm</option>
                            <option value="10am - 6pm">10am - 6pm</option>
                            <option value="2pm - 10pm">2pm - 10pm</option>
                            <option value="RD">Rest Day</option>
                        </select>
                    </div>
    
                    
    
                    <div class="w-full relative mt-5 mb-5 flex">
                        <x-button type='submit'>submit</x-button>
                    </div>
                </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="showRequestmodal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-9/12 bg-whitey rounded p-5 relative flex items-center justify-center m-5">
                <form wire:submit="submitRequestleave" method="POST" >
                    @csrf
                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <h1 class="font-semibold">Request Leave</h1>
                    <span class="text-xs">Note: your request can review up to 5 to 10 days.</span>
                    <span class="text-xs">Leave Credits: <span class="text-red-400 font-bold">{{auth()->user()->leave_credits->leave_credit}}</span></span>
                </div>

                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <x-label for="from" >FROM:</x-label>
                    <x-input type="date" name="from" wire:model="from" id="from" />
                    @error('from')
                    <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>

                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <x-label for="to" >TO:</x-label>
                    <x-input type="date" name="to" wire:model="to" id="to" />
                    @error('to')
                    <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                    @error('reason')
                    <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>

                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <x-label for="reason_request_leave" >REASON:</x-label>
                    <x-input type="text" name="reason_request_leave" wire:model="reason_request_leave" id="reason_request_leave" />
                    @error('reason_request_leave')
                    <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>

                <div class="w-full relative mt-5 mb-5 flex justify-end">
                    <x-button type="submit">Submit</x-button>
                </div>
            </form>
        </div>

    </div>

</x-modal>

</div>
