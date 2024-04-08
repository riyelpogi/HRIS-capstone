<div class="w-11/12  relative flex flex-col justify-center m-5">
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
            <button class="p-2 m-5 rounded-lg border hover:bg-yellow-green" wire:click="showAddBenefitsModal">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M450-200v-250H200v-60h250v-250h60v250h250v60H510v250h-60Z"/></svg>
            </button>
        </div>        
    </div>

    <div class="w-full relative  bg-white rounded flex flex-col" wire:poll>
        @if ($content == 'BENEFITS')
                @foreach ($benefits as $benefit)
                <div class="w-11/12 relative m-3 flex border flex-col rounded ">
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
                            <div class="w-11/12 flex flex-col m-5">
                                <h1 class="text-xs font-bold">Requirements:</h1>
                                @foreach (explode('-', $benefit->benefit_requirements) as $requirement)
                                    <p class="text-xs italic indent-5">{{ $requirement }}</p>
                                @endforeach
                            </div>
                            <div class="w-full relative justify-end flex">
                                @if ($benefit->status != 'open')
                                    <button class="p-2 m-2 text-xs m-5 border hover:bg-yellow-green rounded-lg" wire:click="openApplication({{ $benefit->id }})" wire:key="open-application-{{ $benefit->id }}">Open Application</button> 
                                @else
                                    <button class="p-2 m-3 text-xs border hover:bg-yellow-green rounded-lg" wire:click="closeApplication({{ $benefit->id }})" wire:key="close-application-{{ $benefit->id }}">Close Application</button> 
                                @endif
                                    <button class="p-2 m-3 text-xs border hover:bg-yellow-green rounded-lg" wire:click="showBeneficiariesModal({{ $benefit->id }})" wire:key="show-beneficiaries-modal-{{ $benefit->id }}">Beneficiaries</button>
                            </div>
                        @endif
                    </div>
                    
                </div>
            @endforeach

        @elseif($content == 'REQUEST')    
        <div class="w-full relative flex flex-col justify-center gap-10 items-center">
            @foreach ($benefits as $benefit)
                    @if (count($benefit->benefits_applicants) > 0)
                    <table class="w-full relative {{ $parameter_id == $benefit->id ? 'border border-2 border-black' : '' }}">
                        <tr>
                            <caption class="border">{{ $benefit->benefit_name }}</caption>
                            <th class="w-40 text-xs ">EID</th>
                            <th class="w-40 text-xs ">NAME</th>
                            <th class="w-40 text-xs ">DEPARTMENT</th>
                            <th class="w-40 text-xs ">BENEFIT</th>
                            <th class="w-40 text-xs ">NOTICE</th>
                            <th class="w-40 text-xs ">STATUS</th>
                            <th class="w-40 text-xs">ACTION</th>
                        </tr>
                        @foreach ($benefit->benefits_applicants as $request)
                            <tr>
                                <td class="text-xs text-center">{{ $request->employee_id }}</td>
                                <td class="text-xs text-center">{{ $request->user->name }}</td>
                                <td class="text-xs text-center">{{ $request->user->department }}</td>
                                <td class="text-xs text-center">{{ $request->benefit->benefit_name }}</td>
                                <td class="text-xs text-center">{{ $request->notice }}</td>
                                <td class="text-xs text-center">{{ $request->status }}</td>
                                <td class="text-xs text-center h-8">
                                    <span class="cursor-pointer w-full relative flex justify-center " wire:click="showRequestActionModal({{ $request->id }})" wire:key="request-action-{{ $request->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" class="cursor-pointer" viewBox="0 -960 960 960" width="16"><path d="M468-240q-96-5-162-74t-66-166q0-100 70-170t170-70q97 0 166 66t74 162l-84-25q-13-54-56-88.5T480-640q-66 0-113 47t-47 113q0 57 34.5 100t88.5 56l25 84Zm48 158q-9 2-18 2h-18q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v18q0 9-2 18l-78-24v-12q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h12l24 78Zm305 22L650-231 600-80 480-480l400 120-151 50 171 171-79 79Z" /></svg>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @endif
            @endforeach
            
        </div>        
        @endif
    </div>

<x-modal wire:model="showBeneficiaries">
    @if (count($beneficiaries) > 0)
        <div class="w-full relative flex justify-center items-center">
            <div class="w-11/12 bg-whitey rounded p-5 relative bg-whitey p-5 flex justify-center flex-col m-5">
                <div class="w-11/12 relative flex flex-col rounded p-2 text-xs m-2">
                    <x-label class="text-xs font-bold uppercase">{{ $bnft_name }}</x-label>
                </div>
                <div class="w-full relative flex rounded p-2 ml-2 txt-xs">
                    <x-label class="text-xs font-bold uppercase">Beneficiaries:</x-label>
                </div>
                <table border="">
                    <tr>
                        <th class="text-xs font-bold ">EID</th>
                        <th class="text-xs font-bold">NAME</th>
                        <th class="text-xs font-bold">DEPARTMENT</th>
                        <th class="text-xs font-bold">DATE APPROVED</th>
                    </tr>
                <tbody>
                    @foreach ($beneficiaries as $beneficiary)
                        <tr>
                            <td class="text-xs text-center">{{ $beneficiary->user->employee_id }}</td>
                            <td class="text-xs text-center">{{ $beneficiary->user->name }}</td>
                            <td class="text-xs text-center">{{ $beneficiary->user->department }}</td>
                            <td class="text-xs text-center">{{ $beneficiary->date_approved }}</td>
                        </tr>
                     @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @else
        <div class="w-full relative flex bg-whitey justify-center items-center">
            <h1 class="text-center font-semibold">NO BENEFICIARIES</h1>
        </div>
    @endif
</x-modal>
<x-modal wire:model="requestActionModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-11/12 relative bg-whitey rounded flex p-5 flex-col justify-center gap-10">
            @if ($request != null)
                <form wire:submit="submitAction" method="POST">
                    @csrf
                    <div class="w-full flex flex-col mt-5 mb-5">
                        <x-label class="text-xs font-semibold uppercase">{{  $request_name }}</x-label>
                        <x-label class="text-xs font-semibold uppercase">{{ $request_position }}</x-label>
                        <x-label class="text-xs font-semibold uppercase">{{ $request_department }}</x-label>
                        
                    </div>
                    <div class="w-full flex flex-col mt-5 mb-5">
                        <x-label for="notice">Notice:</x-label>
                        <x-input type="text" name="notice" id="notice" wire:model="notice" />
                    </div>

                    <div class="w-full flex flex-col mt-5 mb-5">
                        <x-label for="status">Set status:</x-label>
                        <select name="status" id="status" wire:model="status">
                            <option value=""></option>
                            <option value="pending">pending</option>
                            <option value="reviewing">reviewing</option>
                            <option value="approved">approved</option>
                        </select>
                    </div>

                    <div class="w-full flex flex-col mt-5 mb-5">
                        <x-button type="submit">submit</x-button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-modal>

<x-modal wire:model="addBenefitModal">
    <div class="w-full relative  flex justify-center items-center">
        <div class="w-11/12 m-5 relative bg-whitey p-5 flex flex-col">
                <form wire:submit="addBenefit" method="POST">
                    @csrf 
                       <div class="w-full relative flex flex-col mt-3 mb-3">
                            <x-label for="benefit_name">Name:</x-label>
                            <x-input type="text" name="benefit_name" wire:model="benefit_name" id="benefit_name" />
                            @error('benefit_name')
                                <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full relative flex flex-col mt-3 mb-3">
                            <x-label for="benefit_description">Description:</x-label>
                            <textarea name="benefit_description" id="benefit_description" name="benefit_descriptionbenefit_description" wire:model="benefit_description" cols="30" rows="10"></textarea>
                            @error('benefit_description')
                            <span class="text-xs text-red-200">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="w-full relative flex flex-col mt-5 mb-5">
                            <x-label for="benefit_requirement">Requirements:</x-label>
                            @foreach ($requirements as $requirement)
                                <span class="text-xs font-bold italic">*{{ $requirement }}</span>
                            @endforeach
                            <div class="w-full relative flex gap-3 justify-center items-center">
                                <x-input type="text" class="w-11/12" name="benefit_requirement" wire:model="benefit_requirement" id="benefit_name" />
                                <span class="p-2 border rounded-lg cursor-pointer hover:bg-yellow-green" wire:click="addrequirement"><svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M450-200v-250H200v-60h250v-250h60v250h250v60H510v250h-60Z"/></svg></span>
                            </div>
                            @error('benefit_requirement')
                            <span class="text-xs text-red-200">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="w-full relative flex flex-col mt-3 mb-3">
                          <x-button type="submit">submit</x-button>
                        </div>


                </form>
        </div>    
    </div>    
</x-modal>    
</div>