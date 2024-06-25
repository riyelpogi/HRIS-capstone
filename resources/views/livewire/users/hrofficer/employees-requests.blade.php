<div class="w-11/12  relative flex bg-white  justify-center m-5 flex-col">
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
    <div class="w-full relative rounded flex m-5 gap-5">
        <button class="text-xs p-2 mt-5 border rounded-lg ml-5 cursor-pointer {{$requests_content == 'SCHEDULE' ? 'bg-yellow-green' : ''}}" wire:click="schedule" >Schedule</button>
        <button class="text-xs p-2 mt-5 border rounded-lg cursor-pointer {{$requests_content == 'LEAVE' ? 'bg-yellow-green' : ''}}"  wire:click="leave">Leave</button>
        <button class="text-xs p-2 mt-5 border rounded-lg cursor-pointer {{$requests_content == 'OFF' ? 'bg-yellow-green' : ''}}" wire:click="off">Off</button>
                <button class="text-xs p-2 mt-5 border rounded-lg cursor-pointer {{$requests_content == 'COEREQUEST' ? 'bg-yellow-green' : ''}}" wire:click="coe">COE</button>
    </div>

    <div class="w-full relative rounded flex" wire:poll>
        @if ($requests_content == 'SCHEDULE')
        <div class="w-full relative flex justify-center items-center">
            <table class="w-full relative">
                <caption class="border">Request Schedule</caption>
                <tr>
                    <th class="text-sm xsmr:hidden smr:hidden">EID</th>
                    <th class="text-sm">Name</th>
                    <th class="text-sm xsmr:hidden smr:hidden">Department</th>
                    <th class="text-sm">Cutoff</th>
                    <th class="text-sm">Action</th>
                </tr>

              @if ($pending_schedule_requests != null )
              @foreach ($pending_schedule_requests as $pending_schedule_request)
              <tr>
               <td class="text-xs text-center xsmr:hidden smr:hidden">{{$pending_schedule_request->employee_id}}</td>
               <td class="text-xs text-center">{{$pending_schedule_request->user->name}}</td>
                <td class="text-xs text-center xsmr:hidden smr:hidden">{{ $pending_schedule_request->user->department }}</td>
                <td class="text-xs text-center">{{$pending_schedule_request->cutoff}}</td>
               <td class="text-xs text-center flex justify-center cursor-pointer" wire:click="viewRequestsSchedule({{$pending_schedule_request->id}})" wire:key="request-schedule-{{$pending_schedule_request->id}}">
                   <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
               </td>
           </tr>
              @endforeach
              @endif
            </table>
        </div>
        @endif

        @if ($requests_content == 'LEAVE')
            <div class="w-full relative flex justify-center items-center">
                <table class="w-full relative">
                    <caption class="border">Request Leave</caption>
                    <tr>
                        <th class="text-sm xsmr:hidden smr:hidden">EID</th>
                        <th class="text-sm">Name</th>
                        <th class="text-sm xsmr:hidden smr:hidden">Department</th>
                        <th class="text-sm ">Date</th>
                        <th class="text-sm xsmr:hidden smr:hidden">Reason</th>
                        <th class="text-sm xsmr:hidden smr:hidden">Leave Credit</th>
                        <th class="text-sm">Action</th>
                    </tr>
                   @if ($pending_leave_requests != null)
                   @foreach ($pending_leave_requests as $pending_leave_request)
                   <tr>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$pending_leave_request->employee_id}}</td>
                    <td class="text-xs text-center">{{$pending_leave_request->user->name}}</td>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{ $pending_leave_request->user->department }}</td>
                    <td class="text-xs text-center">{{$pending_leave_request->from}} - {{$pending_leave_request->to}}</td>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$pending_leave_request->reason}}</td>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$pending_leave_request->user->leave_credits->leave_credit}}</td>
                    <td class="text-xs text-center flex justify-center items-center">
                        <span wire:click="viewLeaveRequest({{$pending_leave_request->id}})" wire:key="viewLeaveRequest-{{$pending_leave_request->id}}" class="cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg></span>
                    </td>
                    </tr>
                   @endforeach
                   @endif
                </table>
            </div>
        @endif

        @if ($requests_content == 'OFF')
        <div class="w-full relative flex justify-center items-center">
            <table class="w-full relative">
                <caption class="border">Request Off</caption>
                <tr>
                    <th class="text-sm xsmr:hidden smr:hidden">EID</th>
                    <th class="text-sm ">Name</th>
                    <th class="text-sm xsmr:hidden smr:hidden">Department</th>
                    <th class="text-sm">Date</th>
                    <th class="text-sm xsmr:hidden smr:hidden">Reason</th>
                    <th class="text-sm">Action</th>
                </tr>
               @if ($pending_off_requests != null)
               @foreach ($pending_off_requests as $pending_off_request)
               <tr>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$pending_off_request->employee_id}}</td>
                    <td class="text-xs text-center">{{$pending_off_request->user->name}}</td>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$pending_off_request->user->department}}</td>
                    <td class="text-xs text-center">{{$pending_off_request->date}}</td>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$pending_off_request->reason}}</td>
                    <td class="text-xs text-center flex justify-center items-center cursor-pointer" wire:click="viewRequestOff({{$pending_off_request->id}})" wire:key="viewRequestOff-{{$pending_off_request->id}}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                    </td>
                </tr>
               @endforeach
               @endif
            </table>
        </div>
        @endif
        
         @if ($requests_content == 'COEREQUEST')
        <div class="w-full relative flex justify-center items-center">
            <table class="w-full relative">
                <caption class="border">COE REQUEST</caption>
                <tr>
                    <th class="text-sm xsmr:hidden smr:hidden">EID</th>
                    <th class="text-sm xsmr:hidden smr:hidden">Date</th>
                    <th class="text-sm ">Name</th>
                    <th class="text-sm xsmr:hidden smr:hidden">Position</th>
                    <th class="text-sm ">For</th>
                    <th class="text-sm">Action</th>
                </tr>
               @if ($coe_requests != null)
               @foreach ($coe_requests as $coe_request)
               <tr>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$coe_request->employee_id}}</td>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$coe_request->created_at}}</td>
                    <td class="text-xs text-center">{{$coe_request->user->name}}</td>
                    <td class="text-xs text-center xsmr:hidden smr:hidden">{{$coe_request->user->position}}</td>
                    <td class="text-xs text-center ">{{$coe_request->for}}</td>
                    <td class="text-xs text-center flex justify-center gap-5 items-center cursor-pointer" >
                       <button class="p-2 rounded-lg bg-yellow-green" wire:click="approveCoeRequest({{ $coe_request->id }})" wire:key='approveCoeRequest-{{ $coe_request->id }}' wire:confirm='Are you sure you want to approve this request?'>Approve</button>
                       <button class="p-2 rounded-lg bg-red-300"  wire:click="declineCoeRequestModal({{ $coe_request->id }})" wire:key='declineCoeRequestModal-{{ $coe_request->id }}' wire:confirm='Are you sure you want to decline this request?'>Decline</button>
                    </td>
                </tr>
               @endforeach
               @endif
            </table>
        </div>
        @endif
    </div>

<x-modal wire:model="request_off_modal">
    <div class="w-full bg-whitey rounded p-5 relative flex justify-center ">
        @if ($request_off != null)
        <div class="w-11/12 relative flex flex-col m-10  p-5">
            <div class="w-full relative mt-3 mb-3 ">
                <x-label class="font-semibold" >Change Off Request:</x-label>
            </div>
            <div class="w-full relative mt-3 mb-3 ">
                <x-label>Name:</x-label>
                <h1 class="indent-5 p-2 border rounded">{{$request_off->user->name}}</h1>
            </div>
            <div class="w-full relative mt-3 mb-3 ">
                <x-label>Date:</x-label>
                <h1 class="indent- p-2 border rounded">{{$request_off->date}}</h1>
            </div>
            <div class="w-full relative mt-3 mb-3 ">
                <x-label>Rest Day:</x-label>
                <h1 class="indent- p-2 border rounded">{{$request_off->rest_day}}</h1>
            </div>
            <div class="w-full relative mt-3 mb-3 ">
                <x-label>Reason:</x-label>
                <h1 class="indent-5 p-2 border rounded">{{$request_off->reason}}</h1>
            </div>

            <div class="w-full flex gap-5 justify-end relative mt-3 mb-3 ">
                <button wire:click="approveRequestOff({{$request_off->id}})" wire:confirm="Are you sure you want to approve this?" wire:key="approveRequestOff-{{$request_off->id}}" class="p-2 bg-yellow-green border rounded text-xs font-semibold">Approve</button>
                <button wire:click="declineRequestOff({{$request_off->id}})" wire:key="declineRequestOff-{{$request_off->id}}" class="p-2 bg-yellow-green border rounded text-xs font-semibold">Decline</button>

            </div>
        </div>
        @endif
    </div>
</x-modal>

<x-modal wire:model="schedule_request_modal">
   @if ($schedule_request != null)
   <div class="w-full relative flex justify-center items-center">
    <div class="w-8/12 relative bg-whitey rounded p-5 flex flex-col justify-center items-center m-10">
        <div class="w-8/12 p-2 rounded relative m-2 border rounded ">
            <h1>Name: {{$schedule_request->user->name}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Date: {{$schedule_request->cutoff}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Monday: {{$schedule_request->Mon}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Tuesday: {{$schedule_request->Tue}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Wednesday: {{$schedule_request->Wed}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Thursday: {{$schedule_request->Thu}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Friday: {{$schedule_request->Fri}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Saturday: {{$schedule_request->Sat}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2 border rounded">
            <h1>Sunday: {{$schedule_request->Sun}}</h1>
        </div>
        <div class="w-8/12 p-2 rounded relative m-2  border rounded">
            <div class="flex justify-end gap-5">
                <button class="p-2 bg-yellow-green border rounded text-xs font-semibold" wire:click="approveScheduleRequests({{$schedule_request->id}})" wire:key="approveScheduleRequests-{{$schedule_request->id}}" wire:confirm="Are you sure you want to approve this?">Approve</button>
                <button class="p-2 bg-yellow-green border rounded text-xs font-semibold" wire:click="declineScheduleRequests({{$schedule_request->id}})" wire:key="declineScheduleRequests-{{$schedule_request->id}}">Decline</button>
            </div>
        </div>
    </div>
</div>
   @endif
</x-modal>
<x-modal wire:model="request_off_decline_modal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-6/12 flex bg-whitey rounded p-5 flex-col gap-5 m-10 justify-center">
            <form wire:submit="declineRequestOffReason" method="POST">
                @csrf
                <div class="w-full relative flex flex-col">
                    <x-label for="decline_request_off">State a reason:</x-label>
                    <x-input type="text" class="w-full" wire:model="decline_request_off" name="decline_request_off" id="decline_request_off" />
                    @error('decline_request_off')
                        <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>
                <div class="w-full relative mt-5 flex justify-end">
                    <x-button type="submit" >
                        submit
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="schedule_request_decline_modal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-6/12 flex bg-whitey rounded p-5 flex-col gap-5 m-10 justify-center">
            <form wire:submit="scheduleRequestReason" method="POST">
                @csrf
                <div class="w-full relative flex flex-col">
                    <x-label for="decline">State a reason:</x-label>
                    <x-input type="text" class="w-full" wire:model="decline" name="decline" id="decline" />
                    @error('decline')
                        <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>
                <div class="w-full relative mt-5 flex justify-end">
                    <x-button type="submit" >
                        submit
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="decline_coe_request_modal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-6/12 flex bg-whitey rounded p-5 flex-col gap-5 m-10 justify-center">
            <form wire:submit="declineCoeRequest" method="POST">
                @csrf
                <div class="w-full relative flex flex-col">
                    <x-label for="decline_coe_request">State a reason:</x-label>
                    <x-input type="text" class="w-full" wire:model="decline_coe_request" name="decline_coe_request" id="decline_coe_request" />
                    @error('decline_coe_request')
                        <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>
                <div class="w-full relative mt-5 flex justify-end">
                    <x-button type="submit" >
                        submit
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="decline_leave_modal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-6/12 flex bg-whitey rounded p-5 flex-col gap-5 m-10 justify-center">
            <form wire:submit="declineLeaveRequest" method="POST">
                @csrf
                <div class="w-full relative flex flex-col">
                    <x-label for="decline_leave_reason">State a reason:</x-label>
                    <x-input type="text" class="w-full" wire:model="decline_leave_reason" name="decline_leave_reason" id="decline_leave_reason" />
                    @error('decline_leave_reason')
                        <span class="text-xs text-red-200">{{$message}}</span>
                    @enderror
                </div>
                <div class="w-full relative mt-5 flex justify-end">
                    <x-button type="submit" >
                        submit
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="request_leave_modal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-6/12 flex bg-whitey rounded p-5 flex-col gap-5 m-10 justify-center">
            @if ($request_leave != null)
                <div class="w-full relative flex flex-col">
                        <x-label>Leave Information:</x-label>
                </div>
                <div class="w-full relative flex flex-col">
                    <x-label>Name:</x-label>
                    <h1 class="indent-5 p-2 border rounded">
                    {{$request_leave->user->name}}
                    </h1>
            </div>
                <div class="w-full relative flex flex-col">
                    <x-label>Leave Request:</x-label>
                    <h1 class="indent-5 p-2 border rounded">
                    {{$request_leave->from}} - {{$request_leave->to}}
                    </h1>
                </div>
                <div class="w-full relative flex flex-col">
                    <x-label>Leave Credits:</x-label>
                    <h1 class="indent-5 p-2 border rounded">
                    {{$request_leave->user->leave_credits->leave_credit}}
                    </h1>
                </div>
                <form wire:submit="leaveRequestApprove" method="POST">
                    @csrf
                    <div class="w-full relative flex flex-col">
                        <x-label for="request_leave_total_days">Total Days:</x-label>
                        <x-input type="number" name="request_leave_total_days" id="request_leave_total_days" wire:model="request_leave_total_days" />
                    </div>
                    <div class="w-full relative mt-5 flex justify-end gap-5">
                        <button type="submit" class="p-2 bg-yellow-green border rounded text-xs font-semibold" wire:confirm="Are you sure you want to approve this request?">
                            Approve
                        </button>
                         
                         <p wire:click="showDeclineLeaveRequestModal({{$request_leave->id}})" wire:key="showDeclineLeaveRequestModal-{{$request_leave->id}}" class="p-2 bg-yellow-green border rounded text-xs font-semibold">Decline</p>
                    </div>
                    </form>
                @endif
        </div>
    </div>
</x-modal>

</div>