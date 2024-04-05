<div class="w-11/12 relative flex flex-col justify-center m-5">

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
    <div class="w-full relative  bg-white rounded flex ">
        <div class="w-full relative flex justify-between">
            <div class="m-5 ">
                <button class="p-2 text-xs mr-3 rounded-lg border hover:bg-yellow-green {{ $content == 'BENEFITS' ? 'bg-yellow-green' : '' }}" wire:click="showBenefits">Benefits</button>
                <button class="p-2 text-xs ml-1 rounded-lg border hover:bg-yellow-green {{ $content == 'REQUEST' ? 'bg-yellow-green' : '' }}" wire:click="showRequest">Request</button>
            </div>
        </div>        
    </div>

    <div class="w-full relative  bg-white rounded flex flex-col" wire:poll>
        @if ($content == 'BENEFITS')
                @foreach ($benefits as $benefit)
                <div class="w-11/12 relative m-3 flex border flex-col rounded {{ $parameter_id == $benefit->id ? 'border border-2 border-black' : '' }}">
                    <div class="flex w-11/2 justify-between m-5">
                        <h1 class="font-bold">{{ $benefit->benefit_name }}</h1>
                            @if ($benefitExtend ==  $benefit->id )
                                <span wire:click="hide({{ $benefit->id }})" class="p-2 rounded-full hover:bg-gray-200 cursor-pointer" wire:key="hide-{{ $benefit->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="m296-345-56-56 240-240 240 240-56 56-184-184-184 184Z"/></svg>
                                </span>
                                @else
                                <span wire:click="show({{ $benefit->id }})" class="p-2 rounded-full hover:bg-gray-200 cursor-pointer" wire:key="show-{{ $benefit->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20"   viewBox="0 -960 960 960" width="20"><path d="M480-345 240-585l56-56 184 184 184-184 56 56-240 240Z"/></svg>    
                                </span>
                            @endif
                    </div>
                    <div class="w-full relative flex flex-col">
                        @if ($benefitExtend ==  $benefit->id)
                            <div class="w-11/12 flex flex-col m-5">
                                <h1 class="text-xs font-bold">Description:</h1>
                                    <p class="text-xs italic indent-5">{{ $benefit->benefit_description }}</p>
                            </div>
                            <div class="relative w-11/12 flex flex-col m-5">
                                <h1 class="text-xs font-bold">Requirements:</h1>
                                @foreach (explode('-', $benefit->benefit_requirements) as $requirement)
                                    <p class="text-xs italic indent-5">{{ $requirement }}</p>
                                @endforeach
                                <div class="w-full flex justify-end relative">
                                    @if (in_array(auth()->user()->employee_id, array_column($benefit->beneficiaries->toArray(), 'employee_id')))
                                             <button class="p-2 border rounded-lg text-xs hover:bg-white bg-yellow-green">Beneficiary</button> 
                                    @else
                                                @if (in_array(auth()->user()->employee_id, array_column($benefit->applicants->toArray(), 'employee_id')))
                                                    @if (in_array(auth()->user()->employee_id, array_column($benefit->beneficiaries->toArray(), 'employee_id')))
                                                        <button class="p-2 relative flex text-xs bg-yellow-green border rounded-lg">Beneficiary</button>
                                                    @else
                                                        <button class="p-2 relative flex text-xs  border rounded-lg">Applied</button>
                                                    @endif
                                                @else
                                                    <button class="p-2 border rounded-lg text-xs hover:bg-white bg-yellow-green" wire:key="apply-{{ $benefit->id }}" wire:click="applyBenefit({{ $benefit->id }})" wire:confirm="Are you sure you want to apply to this benefit?">Apply</button>    
                                                @endif  
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

        @elseif($content == 'REQUEST')    
            <div class="w-full relative flex flex-col justify-center gap-10 items-center">
                @foreach ($benefits as $benefit)
                        @if (count($benefit->applicants) > 0)
                        <table class="w-full relative {{ $parameter_id == $benefit->id ? 'border border-black border-2' : ''}}"  >
                            <tr>
                                <caption class="border text-gray-500 font-bold uppercase">{{ $benefit->benefit_name }}</caption>
                                <th class="w-40 text-xs ">EID</th>
                                <th class="w-40 text-xs ">BENEFIT</th>
                                <th class="w-40 text-xs ">NOTICE</th>
                                <th class="w-40 text-xs ">STATUS</th>
                                <th class="w-40 text-xs">ACTION</th>
                            </tr>
                            @foreach ($benefit->applicants as $request)
                                @if ($request->employee_id == auth()->user()->employee_id)
                                    <tr>
                                    <td class="text-xs text-center">{{ $request->employee_id }}</td>
                                    <td class="text-xs text-center">{{ $request->benefit->benefit_name }}</td>
                                    <td class="text-xs text-center">{{ $request->notice }}</td>
                                    <td class="text-xs text-center">{{ $request->status }}</td>
                                    <td class="text-xs text-center h-8">
                                        @if ($request->status == 'pending')
                                            <span class="p-1 text-xs border rounded-lg bg-red-400 hover:bg-red-100 cursor-pointer" wire:click="cancelRequest({{ $request->id }})" wire:key="cancel-request-{{ $request->id }}">Cancel</span>
                                        @else
                                        <span class="p-1 text-xs border rounded-lg bg-gray-200  cursor-pointer">Canceled</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                        @endif
                @endforeach
                
            </div>        

        @endif
    </div>




</div>