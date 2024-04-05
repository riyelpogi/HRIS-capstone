<div class="w-11/12 relative flex flex-col justify-center bg-white flex-col m-5">
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
        <button class="p-2 border text-xs rounded-lg hover:bg-yellow-green {{ $content == 'DTR' ? 'bg-yellow-green' : '' }}" wire:click="showDtr">DTR</button>
        <button class="p-2 border text-xs rounded-lg hover:bg-yellow-green {{ $content == 'MYTICKETS' ? 'bg-yellow-green' : '' }}" wire:click="showMyTickets">Tickets</button>
    </div>
    
    @if ($content == "DTR")
                <div class="w-full relative   rounded flex justify-center items-center">
                    <table wire:poll>
                        <caption class="w-full relative text-xs">
                            <select name="month" id="month" class=" text-xs w-10/12" wire:model="month">
                                <option value=""></option>
                                <option class="text-xs" value="1">January</option>
                                <option class="text-xs" value="2">February</option>
                                <option class="text-xs" value="3">March</option>
                                <option class="text-xs" value="4">April</option>
                                <option class="text-xs" value="5">May</option>
                                <option class="text-xs" value="6">June</option>
                                <option class="text-xs" value="7">July</option>
                                <option class="text-xs" value="8">August</option>
                                <option class="text-xs" value="9">September</option>
                                <option class="text-xs" value="10">October</option>
                                <option class="text-xs" value="11">November</option>
                                <option class="text-xs" value="12">December</option>
                            </select>
                            <select name="year" id="year" class=" text-xs w-10/12" wire:model="year">
                                @for ($i = (date('Y', time()) - 2); $i <= date('Y', time()) + 5; $i++)
                                    <option class="text-xs" value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </caption>
                        <tr class=" ">
                            <th class="text-xs w-40 p-3 xsmr:hidden smr:hidden">Employee ID</th>
                            <th class="text-xs w-40 p-3">Date</th>
                            <th class="text-xs w-40 p-3">Schedule</th>
                            <th class="text-xs w-40 p-3">In/Out</th>
                            <th class="text-xs w-40 p-3">Time</th>
                            <th class="text-xs w-40 p-3">Status</th>
                        </tr>
                        @foreach ($arr as $record)
                        <tr>
                            <td class="text-xs text-center xsmr:hidden smr:hidden">{{ $record['employee_id'] }}</td>
                            <td class="text-xs text-center">{{ $record['date'] }}</td>
                            <td class="text-xs text-center">{{ $record['schedule'] }}</td>
                            <td class="text-xs text-center">{{ $record['inorout'] }}</td>
                            <td class="text-xs text-center">{{ $record['time'] }}</td>
                            <td class="text-xs text-center">{{ $record['status'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <div class="w-111/12 relative h-5/6  rounded flex m-5 justify-end items-center">
                    <x-button wire:click="showDtrModal">Sent a Ticket</x-button>
                </div>
    @elseif($content == 'MYTICKETS') 
                <div class="w-full relative flex justify-center items-center">
                    <table class="w-full relative" wire:poll>
                        <caption class="w-full text- uppercase font-bold p-5">
                            Tickets
                        </caption>
                        <tr>
                            <th class="w-40 text-xs xsmr:hidden smr:hidden">EMPLOYEE ID</th>
                            <th class="w-40 text-xs">DATE</th>
                            <th class="w-40 text-xs">TIME</th>
                            <th class="w-40 text-xs">IN/OUT</th>
                            <th class="w-40 text-xs">PROOF</th>
                            <th class="w-40 text-xs xsmr:hidden smr:hidden">DECLINE REASON</th>
                            <th class="w-40 text-xs">STATUS</th>
                            <th class="w-40 text-xs">ACTION</th>
                        </tr>
                        @foreach ($tickets as $ticket)
                        <tr class="{{ $ticket->id == $ticket_id ? 'bg-red-200' : '' }}">
                            <td class="text-xs w-40 relative text-center xsmr:hidden smr:hidden">{{ $ticket->employee_id }}</td>
                            <td class="text-xs w-40 relative text-center">{{ $ticket->date }}</td>
                            <td class="text-xs w-40 relative text-center">{{ $ticket->time }}</td>
                            <td class="text-xs w-40 relative text-center">{{ $ticket->inorout }}</td>
                            <td class="text-xs w-40 relative text-center text-wrap"><span class="cursor-pointer hover:text-blue-200" wire:click="showImageModal('{{ $ticket->file_name }}')" wire:key="show-image-modal-{{ $ticket->id }}">
                                {{ $ticket->file_name }}</span></td>
                            <td class="text-xs w-40 relative text-center xsmr:hidden smr:hidden">{{ $ticket->reason_to_decline }}</td>
                            <td class="text-xs w-40 relative text-center">{{ $ticket->status }}</td>
                            <td class="text-xs w-40 relative text-center">
                                @if ($ticket->status != 'pending')
                                    <button class="p-1 text-xs border rounded-lg bg-gray-200">Cancel</button>
                                    
                                @else
                                    <button class="p-1 text-xs border rounded-lg bg-red-400 hover:bg-red-300" wire:click="cancelMyTicket({{ $ticket->id }})" wire:key='cancelMyTicket-{{ $ticket->id }}' wire:confirm="Are you sure you want to cancel your ticket?">Cancel</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
    @endif
    
  
<x-modal wire:model="showImage">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 relative bg-whitey rounded p-5 flex justify-center items-center">
            @if ($image != null)
                <img src="/storage/employee-ticket/{{ $image }}" alt="">
            @endif
        </div>
    </div>
</x-modal>
    <x-modal wire:model="dtrModal">
        <div class="w-full relative flex justify-center items-center">
            <div class="w-9/12 bg-whitey rounded p-5 relative flex items-center justify-center m-5">
                <form wire:submit="dtrticketsubmit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="w-full relative mt-5 mb-5 flex flex-col">
                        <x-label for="date">DATE:</x-label>
                        <x-input type="date" name="date" wire:model="date"  id="date" />
                        @error('date')
                            <span class="bg-red-200 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full relative mt-5 mb-5 flex flex-col">
                        <x-label for="time">TIME:</x-label>
                        <x-input type="time" name="time" wire:model="time"  id="time" />
                        @error('time')
                            <span class="bg-red-200 text-xs">{{ $message }}</span>
                        @enderror
                    </div> 
                    <div class="w-full relative mt-5 mb-5 flex flex-col">
                        <select name="inorout" wire:model="inorout"  id="inorout">
                            <option value=""></option>
                            <option value="IN">IN</option>
                            <option value="OUT">OUT</option>
                        </select>
                        @error('inorout')
                            <span class="bg-red-200 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full relative mt-5 mb-5 flex flex-col">
                        <x-label for="">Proof:</x-label>
                        <x-label for="proof" class="text-xs p-2 rounded-lg border hover:bg-yellow-green cursor-pointer mrd:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden">Upload</x-label>
                        <x-input type="file" name="proof" wire:model="proof" class="xsmr:hidden smr:hidden" id="proof" />
                        @error('proof')
                            <span class="bg-red-200 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-full relative mt-5 mb-5 flex justify-end"">
                        <x-button type="submit" >submit</x-button>
                    </div>
                   </form>
            </div>
        </div>
    </x-modal>
</div>
