<div class="w-11/12 relative flex flex-col justify-center m-5 bg-white gap-5">
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
    <button class="p-2 text-xs border rounded-lg hover:bg-yellow-green {{ $content == 'INANDOUT' ? 'bg-yellow-green' : '' }}" wire:click="showinandout">In and Out</button>
    <button class="p-2 text-xs border rounded-lg hover:bg-yellow-green {{ $content == 'TICKETS' ? 'bg-yellow-green' : '' }}" wire:click="showTickets">Tickets</button>
   </div>
    @if ($content == 'INANDOUT')
        <div class="w-full flex relative justify-center items-center overflow-y-auto">
            <table class="w-full relative">
                <caption class="w-full border p-5 font-semibold">Employee In And Out History</caption>
                <tr>
                    <th class="w-40 p-5 text-xs xsmr:hidden smr:hidden">Date Uploaded</td>
                    <th class="w-40 p-5 text-xs">EMPLOYEE ID</td>
                    <th class="w-40 p-5 text-xs">DATE</td>
                    <th class="w-40 p-5 text-xs">INOROUT</td>
                    <th class="w-40 p-5 text-xs">TIME</td>
                </tr>
            @foreach ($histories as $history)
            <tr>
                <td class="text-xs text-center xsmr:hidden smr:hidden">{{ $history->created_at }}</td>
                <td class="text-xs text-center">{{ $history->employee_id }}</td>
                <td class="text-xs text-center">{{ $history->year . '/' . $history->month . '/' . $history->date }}</td>
                <td class="text-xs text-center">{{ $history->inorout }}</td>
                <td class="text-xs text-center">{{ $history->time }}</td>
            </tr>
            @endforeach

        </table>
        </div> 

        <div class="w-11/12 relative rounded flex m-5">
            <div class="w-full relative flex justify-end">
            <button class="p-2 border hover:bg-yellow-green rounded-lg text-sm" wire:click="uploadFileModal">Upload Data</button>
            </div>
        </div>
    @elseif($content == 'TICKETS')    
        <div class="w-full relative flex justify-center items-center overflow-y-auto" wire:poll >
            <table>
                <caption class="text-xs font-semibold p-5">TICKETS</caption>
                <tr>
                    <th class="w-40 text-xs xsmr:hidden smr:hidden">EMPLOYEE ID</th>
                    <th class="w-40 text-xs">DATE</th>
                    <th class="w-40 text-xs">TIME</th>
                    <th class="w-40 text-xs">IN/OUT</th>
                    <th class="w-40 text-xs">PROOF</th>
                    <th class="w-40 text-xs">ACTION</th>
                </tr>
                @foreach ($tickets as $tckt)
                    <tr>
                        <td class="text-xs text-center xsmr:hidden smr:hidden">{{ $tckt->employee_id }}</td>
                        <td class="text-xs text-center">{{ $tckt->date }}</td>
                        <td class="text-xs text-center">{{ $tckt->time }}</td>
                        <td class="text-xs text-center">{{ $tckt->inorout }}</td>
                        <td class="text-xs text-center"><span class="text-blue-400 cursor-pointer" wire:click="showProof('{{ $tckt->file_name }}')" wire:key="proof-{{ $tckt->id }}">{{ $tckt->file_name }}</span></td>
                        <td class="text-xs text-center"><span class="w-full flex justify-center" wire:click="showTicket({{ $tckt->id }})" wire:key="showTicket-{{ $tckt->id }}"><svg xmlns="http://www.w3.org/2000/svg" height="16" class="cursor-pointer" viewBox="0 -960 960 960" width="16"><path d="M468-240q-96-5-162-74t-66-166q0-100 70-170t170-70q97 0 166 66t74 162l-84-25q-13-54-56-88.5T480-640q-66 0-113 47t-47 113q0 57 34.5 100t88.5 56l25 84Zm48 158q-9 2-18 2h-18q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v18q0 9-2 18l-78-24v-12q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h12l24 78Zm305 22L650-231 600-80 480-480l400 120-151 50 171 171-79 79Z" /></svg></span></td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
   
<x-modal wire:model="showDeclineTicketModal">
   <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 bg-whitey p-5 relative flex justify-center items-center ">
            <form wire:submit="submitDeclineTicket" method="POST">
                @csrf
                <div class="w-11/12 relative m-5 flex flex-col ">
                    <x-label class="text-xs" for="reason_to_decline">Please state a reason:</x-label>
                    <input type="text" name="reason_to_decline" id="reason_to_decline" wire:model="reason_to_decline">
                </div>
                <div class="w-11/12 relative m-5 flex flex-col ">
                    <x-button type="submit">submit</x-button>
                </div>
            </form>
        </div>
   </div>
</x-modal>
<x-modal wire:model="showTicketModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 relative bg-whitey flex p-5 rounded flex-col justify-center items-center">
            @if ($ticket != null)
                <div class="w-11/12 m-5 relative flex justify-around">
                    <div class="w-6/12 relative flex flex-col ">
                        <x-label for="employee_id">Employee ID:</x-label>
                        <h1 id="employee_id">{{ $ticket->employee_id }}</h1>
                    </div>
                    <div class="w-6/12 relative flex flex-col ">
                        <x-label for="date">Date:</x-label>
                        <h1 id="date">{{ $ticket->date }}</h1>
                    </div>
                </div>

                <div class="w-11/12 m-5 relative flex justify-around">
                    <div class="w-6/12 relative flex flex-col ">
                        <x-label for="time">Time:</x-label>
                        <h1 id="time">{{ $ticket->time }}</h1>
                    </div>
                    <div class="w-6/12 relative flex flex-col ">
                        <x-label for="inorout">in/out:</x-label>
                        <h1 id="inorout">{{ $ticket->inorout }}</h1>
                    </div>
                </div>
                
               
                <div class="w-11/12 relative flex flex-col m-2">
                    <x-label for="img">Proof:</x-label>
                    <img src="/storage/employee-ticket/{{ $ticket->file_name }}" id="img" alt="">
                </div>

                <div class="w-11/12 relative flex justify-end gap-5  m-2">
                        <button class="p-2 border rounded-lg hover:bg-yellow-green text-xs" wire:click="approveTicket({{ $ticket->id }})" wire:key="approveTicket-{{ $ticket->id }}" wire:confirm="Are you sure you want to approve this one?">Approve</button>
                        <button class="p-2 border rounded-lg hover:bg-yellow-green text-xs" wire:click="declineTicket({{$ticket->id}})" wire:key="declineTicket-{{ $ticket->id }}" wire:confirm="Are you sure you want to decline this one?">Decline</button>
                </div>
            @endif
        </div>
    </div>    
</x-modal>    


<x-modal  wire:model="showProofModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 m-5 bg-whitey relative rounded p-5 flex justify-center items-center">
            @if ($file_name != null)
            <img src="/storage/employee-ticket/{{ $file_name }}" alt="error">
            
            @endif
        </div>
    </div>
</x-modal>
<x-modal wire:model="uploadModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 flex bg-whitey rounded p-5 justify-center items-center">
            <form wire:submit="uploadFileExcel" method="POST">
                @csrf
                <div class="w-11/12 relative m-5 flex flex-col">
                    <x-label for="excel">File:</x-label>
                    <x-input type="file" name="excel" wire:model="excel" id="excel" />
                </div>
                <div class="w-11/12 relative m-5 flex flex-col">
                    <button class="p-2 rounded-lg border hover:bg-yellow-green " type="submit">Submit</button>
                </div>
               
            </form>
        </div>
        

    </div>
</x-modal>


</div>