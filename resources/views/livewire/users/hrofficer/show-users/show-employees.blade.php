    <div class="w-11/12 m-5 relative flex flex-col justify-center">
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
        <div class="w-full relative flex">
            <x-input type="text" wire:model.live.debounce.1000ms="search" placeholder="Search employee" class="w-full h-8 pl-5 rounded-xl" />
        </div>
      <table  class="border-collapse mt-5 border border-slate-400" wire:poll>
        <tr class="text-sm">
            <th class="w-16 xsmr:hidden smr:hidden">EID</th>
            <th class="w-32">Name</th>
            <th class="w-32 xsmr:hidden smr:hidden">Email</th>
            <th class="w-32 ">Position</th>
            <th class="w-32 xsmr:hidden smr:hidden">Department</th>
            <th class="w-32">Action</th>
            <th class="w-16"></th>
        </tr>
                @foreach ($employees as $employee)
                    <tr class="text-xs text-center m-2" style="border-top:0.5px solid gray">
                        <td class="xsmr:hidden smr:hidden">{{$employee->employee_id}}</td>
                        <td>{{$employee->name}}</td>
                        <td class="xsmr:hidden smr:hidden">{{$employee->email}}</td>
                        <td class="">{{$employee->position}}</td>
                        <td class="xsmr:hidden smr:hidden">{{$employee->department}}</td>
                        <td>
                            <span class="cursor-pointer w-full relative flex justify-center " wire:click="showActionModal('{{ $employee->employee_id }}')" wire:key="show-action-modal{{ $employee->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" class="cursor-pointer" viewBox="0 -960 960 960" width="16"><path d="M468-240q-96-5-162-74t-66-166q0-100 70-170t170-70q97 0 166 66t74 162l-84-25q-13-54-56-88.5T480-640q-66 0-113 47t-47 113q0 57 34.5 100t88.5 56l25 84Zm48 158q-9 2-18 2h-18q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v18q0 9-2 18l-78-24v-12q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h12l24 78Zm305 22L650-231 600-80 480-480l400 120-151 50 171 171-79 79Z" /></svg>
                            </span>
                        </td>
                        <td><a href="{{ route('admin.employee.profile', ['employeeid' => $employee->employee_id]) }}" wire:navigate class="p-1 m-2 rounded-lg bg-yellow-green">visit</a></td>

                    </tr>
                @endforeach
      </table>




      <x-modal wire:model="actionModal">
        <div class="w-full relative flex justify-center items-center">
            <div class="w-11/12 relative bg-whitey rounded p-5 flex flex-col justify-center ">
                <div class="w-full relative flex justify-center items-center m-5 gap-10 ">
                    <button class="p-2 relative border text-xs rounded-lg hover:bg-yellow-green {{ $actionContent == 'STATUS' ? 'bg-yellow-green' : '' }}" wire:click="setStatus">STATUS</button>
                    <button class="p-2 relative border text-xs rounded-lg hover:bg-yellow-green {{ $actionContent == 'SCHEDULE' ? 'bg-yellow-green' : '' }}" wire:click="setSchedule">SCHEDULE</button>
                </div>
                    @if ($actionContent == 'STATUS')
                        @if ($mply != null)
                            <form wire:submit="saveStatus" method="POST">
                                @csrf
                                <div class="w-11/12 relative flex flex-col m-5">
                                    <h1 class="uppercase text-xs">EMPLOYEE NAME: &nbsp;{{ $mply->name }}</h1>
                                    <h1 class="uppercase text-xs">EMPLOYEE ID: &nbsp;{{ $mply->employee_id }}</h1>
                                    <h1 class="uppercase text-xs">POSITION: &nbsp;{{ $mply->position }}</h1>
                                    <h1 class="uppercase text-xs">DEPARTMENT: &nbsp;{{ $mply->department }}</h1>
                                </div>
                                <div class="w-11/12 relative flex flex-col m-5">
                                    <x-label for="status">Set Status</x-label>
                                    <select name="status" wire:model="status" id="status">
                                        <option value=""></option>
                                        <option value="Active">Active</option>
                                        <option value="Resigned">Resigned</option>
                                        <option value="On Maternity Leave">On Maternity Leave</option>
                                        <option value="On Sick Leave">On Sick Leave</option>
                                        <option value="On Leave">On Leave</option>
                                        <option value="On Training">On Training</option>
                                    </select>
                                </div>
                                <div class="w-11/12 relative flex flex-col m-5">
                                    <x-button type='submit'>submit</x-button>
                                </div>
                            </form>
                            @endif
                    @elseif($actionContent == 'SCHEDULE')    
                        @if ($mply != null)
                            <form wire:submit="saveSchedule" method="POST">
                                @csrf
                                <div class="w-11/12 relative flex flex-col m-5">
                                    <h1 class="uppercase text-xs">EMPLOYEE NAME: &nbsp;{{ $mply->name }}</h1>
                                    <h1 class="uppercase text-xs">EMPLOYEE ID: &nbsp;{{ $mply->employee_id }}</h1>
                                </div>

            
                                <div class="w-11/12 relative flex flex-col m-5">
                                    <x-label for="from_date">From:</x-label>
                                    <x-input type="date" wire:model="from_date" id="from_date" name="from_date" />
                                </div>
                                <div class="w-11/12 relative flex flex-col m-5">
                                    <x-label for="to_date">To:</x-label>
                                    <x-input type="date" wire:model="to_date" id="to_date" name="to_date" />
                                </div>
                                <div class="w-11/12 relative flex flex-col m-5">
                                    <x-button type='submit'>submit</x-button>
                                </div>
                            </form>
                        @endif


                    @endif


                  
                
            </div>
        </div>
      </x-modal>

      <x-modal wire:model="setScheduleModal" >
        <div class="w-full relative flex justify-center items-center">
            <div class="w-9/12 relative bg-whitey rounded p-5 flex flex-col justify-center">
                    <form wire:submit="submitSchedule" method="POST">
                        @csrf
                        <div class="w-full relative mt-5 mb-5 flex flex-col">
                            <h1 class="font-semibold">Date: {{$this->from_date}} - {{ $this->to_date }}</h1>
                        </div>
                        <div class="w-full relative mt-5 mb-5 flex flex-col ">
                            <x-label>Monday:</x-label>
                            <select name="Mon" class="  text-sm" id="Mon" wire:model="Mon">
                                <option value=""></option>
                                <option value="7am - 3pm">7am - 3pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                                <option value="2pm - 10pm">2pm - 10pm</option>
                                <option value="RD">Rest Day</option>
                                <option value="On Leave">On Leave</option>
                                <option value="On Sick Leave">On Sick Leave</option>
                                <option value="On Maternity Leave">On Maternity Leave</option>
                                <option value="On Training">On Training</option>
                            </select>
                        </div>
    
                        <div class="w-full relative mt-5 mb-5 flex flex-col ">
                            <x-label>Tuesday:</x-label>
                            <select name="Tue" class="  text-sm" id="Tue" wire:model="Tue">
                                <option value=""></option>
                                <option value="7am - 3pm">7am - 3pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                                <option value="2pm - 10pm">2pm - 10pm</option>
                                <option value="RD">Rest Day</option>
                                <option value="On Leave">On Leave</option>
                                <option value="On Sick Leave">On Sick Leave</option>
                                <option value="On Maternity Leave">On Maternity Leave</option>
                                <option value="On Training">On Training</option>
                            </select>
                        </div>
    
                        <div class="w-full relative mt-5 mb-5 flex flex-col ">
                            <x-label>Wednesday:</x-label>
                            <select name="Wed" class="  text-sm" id="Wed" wire:model="Wed">
                                <option value=""></option>
                                <option value="7am - 3pm">7am - 3pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                                <option value="2pm - 10pm">2pm - 10pm</option>
                                <option value="RD">Rest Day</option>
                                <option value="On Leave">On Leave</option>
                                <option value="On Sick Leave">On Sick Leave</option>
                                <option value="On Maternity Leave">On Maternity Leave</option>
                                <option value="On Training">On Training</option>
                            </select>
                        </div>
    
                        <div class="w-full relative mt-5 mb-5 flex flex-col  ">
                            <x-label>Thursday:</x-label>
                            <select name="Thu" class="  text-sm" id="Thu" wire:model="Thu">
                                <option value=""></option>
                                <option value="7am - 3pm">7am - 3pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                                <option value="2pm - 10pm">2pm - 10pm</option>
                                <option value="RD">Rest Day</option>
                                <option value="On Leave">On Leave</option>
                                <option value="On Sick Leave">On Sick Leave</option>
                                <option value="On Maternity Leave">On Maternity Leave</option>
                                <option value="On Training">On Training</option>
                            </select>
                        </div>
    
                        <div class="w-full relative mt-5 mb-5 flex flex-col  ">
                            <x-label>Friday:</x-label>
                            <select name="Fri" class="  text-sm" id="Fri" wire:model="Fri">
                                <option value=""></option>
                                <option value="7am - 3pm">7am - 3pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                                <option value="2pm - 10pm">2pm - 10pm</option>
                                <option value="RD">Rest Day</option>
                                <option value="On Leave">On Leave</option>
                                <option value="On Sick Leave">On Sick Leave</option>
                                <option value="On Maternity Leave">On Maternity Leave</option>
                                <option value="On Training">On Training</option>
                            </select>
                        </div>
    
                        <div class="w-full relative mt-5 mb-5 flex flex-col  ">
                            <x-label>Saturday:</x-label>
                            <select name="Sat" class="  text-sm" id="Sat" wire:model="Sat">
                                <option value=""></option>
                                <option value="7am - 3pm">7am - 3pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                                <option value="2pm - 10pm">2pm - 10pm</option>
                                <option value="RD">Rest Day</option>
                                <option value="On Leave">On Leave</option>
                                <option value="On Sick Leave">On Sick Leave</option>
                                <option value="On Maternity Leave">On Maternity Leave</option>
                                <option value="On Training">On Training</option>
                            </select>
                        </div>
    
                        <div class="w-full relative mt-5 mb-5 flex flex-col ">
                            <x-label>Sunday:</x-label>
                            <select name="Sun" class="  text-sm" id="Sun" wire:model="Sun">
                                <option value=""></option>
                                <option value="7am - 3pm">7am - 3pm</option>
                                <option value="10am - 6pm">10am - 6pm</option>
                                <option value="2pm - 10pm">2pm - 10pm</option>
                                <option value="RD">Rest Day</option>
                                <option value="On Leave">On Leave</option>
                                <option value="On Sick Leave">On Sick Leave</option>
                                <option value="On Maternity Leave">On Maternity Leave</option>
                                <option value="On Training">On Training</option>
                            </select>
                        </div>
        
                        <div class="w-full relative mt-5 mb-5 flex">
                            <x-button type='submit'>submit</x-button>
                        </div>
                    </form>
            </div>
        </div>
    </x-modal>
    </div>
