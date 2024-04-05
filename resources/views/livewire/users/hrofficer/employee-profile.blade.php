<div class="w-11/12 xsmr:w-11/12 smr:w-11/12 relative items-center flex flex-col justify-center m-5 smr:m-2">
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
    <div class="w-11/12 ml-5 relative flex gap-5 rounded">
        <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == 'INFORMATION' ? 'bg-yellow-green' : '' }}" wire:click="information">Information</button>
        <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == '201FILES' ? 'bg-yellow-green' : '' }}" wire:click="show201Files">201Files</button>
        <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == 'BENEFITS' ? 'bg-yellow-green' : '' }}" wire:click="showBenefits">Benefits</button>
        <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == 'TRAININGS' ? 'bg-yellow-green' : '' }}" wire:click="showTrainings">Trainings</button>
    </div>
    <div class="w-11/12 smr:2-10- m-5 relative bg-white rounded flex smr:flex-col smr:gap-5">
        @if ($content == 'INFORMATION')
            <div class="w-1/4 smr:w-full  flex flex-col items-center rounded">
            <div class="w-full relative flex justify-center items-center mt-5 cursor-pointer">
                @if ($user->profile_photo_path != null)
                    <img src="/storage/employee-media/{{$user->profile_photo_path}}" alt="" class="w-16 h-16 rounded-full border">
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="rounded-full h-9/12 border" height="62" viewBox="0 96 960 960" width="62"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>
                @endif
            </div>
            <div class="mt-5">
                <h1 class="font-semibold text-center">{{$user->name}}</h1>
            </div>
        </div>
        <div class="w-10/12 bg-white smr:w-full rounded ml-5 smr:ml-0 relative ">
            <div class="w-full">
                @if ($user->employee_information)
                        <div class="w-11/12 m-3 relative">
                            <div class="w-full relative flex flex-col">
                                <div class="flex justify-between mt-3">
                                    <div class="ml-3">
                                    <x-label>Name:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->name}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Employee ID:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_id}}</h1>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Department:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->department}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Position:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->position}}</h1>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Date Hired:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->date_hired}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Date Regular:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->date_regular}}</h1>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Deployment Date:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->deployment_date}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Country:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->country}}</h1>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Email:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->email}}</h1>
                                    </div>
                                </div>

                                <div class="w-full ml-5 mt-10"> <h1 class="uppercase font-semibold text-blue-400">Contact</h1></div>

                                <div class="flex justify-between mt-5">
                                    {{-- <div class="ml-3">
                                    <x-label>Age:</x-label>
                                    <h1 class="font-semibold">{{$user->employee_information->age}}</h1>

                                    </div> --}}
                                    <div class="ml-3">
                                        <x-label class="">Birthday:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->birthday}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Region:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->region}}</h1>
         
                                     </div>
                                </div>

                                <div class="flex justify-between mt-5">
                                   
                                    <div class="ml-3">
                                        <x-label class="">Province:</x-label>
                                          <h1 class="font-semibold text-sm">{{$user->employee_information->province}}</h1>
                                     </div>
                                     <div class="mr-3 bg-whiterelative">
                                        <x-label class="text-right">City:</x-label>
                                          <h1 class="font-semibold text-sm">{{$user->employee_information->city}}</h1>
                                     </div>
                                </div>
                             
                                
                                <div class=" flex justify-between ml-3 mt-5 relative">
                                    
                                    <div class="w-2/4 white-space-wrap relative">
                                       <x-label class="">Address:</x-label>
                                       <h1 class="font-semibold text-sm">{{$user->employee_information->address}}</h1>
                                    </div>

                                    <div class="mr-3">
                                        <x-label class="text-right">Postal Code:</x-label>
                                        <h1 class="font-semibold text-sm text-right">{{$user->employee_information->postal_code}}</h1>
                                        </div>
                                </div>
                                
                                
                                <div class="flex justify-between mt-5">
                                    
                                    <div class="ml-3">
                                        <x-label class="">Barangay:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->barangay}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Mobile Number:</x-label>
                                        <h1 class="font-semibold text-sm">{{$user->employee_information->mobile_number}}</h1>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Resume/CV:</x-label>
                                    <h1 class="font-semibold">{{$user->employee_information->resume}}</h1>
                                    </div>
                                   
                                </div>

                               
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
           
                @elseif($content == '201FILES')
                <div class="w-full relative flex p-2 flex-wrap gap-5">
                    <div class="w-full relative flex justify-end items-center">
                        <button class="p-2 rounded-lg text-xs bg-yellow-green hover:bg-green-400" wire:click='showUploadFileModal'>Upload File</button>

                        <button class="p-2 rounded-lg text-xs bg-yellow-green hover:bg-green-400" wire:click='showChecklist'>Show Checklist</button>
                    </div>
                    @if ($user->two_zero_one_file)
                            <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                                <h1 class="text-sm  font-semibold text-center">SSS</h1>
                                <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadSss('{{ $user->two_zero_one_file->sss }}')">
                            {{ $user->two_zero_one_file->sss  }}</h1>
                            </div>

                    <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center">TIN</h1>
                        <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadTin('{{ $user->two_zero_one_file->tin }}')">
                          {{   $user->two_zero_one_file->tin }}
                        </h1>
                     </div>

                     <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center">PHILHEALTH</h1>
                        <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadPhilhealth('{{ $user->two_zero_one_file->philhealth }}')">
                       {{ $user->two_zero_one_file->philhealth  }}</h1>
                     </div>
                     

                     <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center">NBI</h1>
                        <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadNbi('{{ $user->two_zero_one_file->nbi }}')">
                       {{ $user->two_zero_one_file->nbi  }}</h1>
                     </div>

                     <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center">DIPLOMA</h1>
                        <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadDiploma('{{ $user->two_zero_one_file->diploma }}')">
                       {{ $user->two_zero_one_file->diploma  }}</h1>
                     </div>

                     <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center">TOR</h1>
                        <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadTor('{{ $user->two_zero_one_file->tor }}')">
                       {{ $user->two_zero_one_file->tor  }}</h1>
                     </div>

                     

                     <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center">RESUME</h1>
                        <h1 class="cursor-pointer hover:text-red-400">
                            {{ $user->two_zero_one_file->resume }}
                        </h1>
                     </div>

                     <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center">EMPLOYMENT CONTRACTS</h1>
                        <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadContracts">
                            {{ $user->two_zero_one_file->employment_contract }}
                        </h1>
                     </div>
                     @foreach ($other_requirements_file_name as $key => $file)
                     <div class="w-3/12 flex flex-col justify-center items-center p-2 relative border cursor-pointer rounded">
                        <h1 class="text-sm  font-semibold text-center uppercase">{{ $file[0] }}</h1>
                        <h1 class="cursor-pointer hover:text-red-400 w-full  relative overflow-x-hidden overflow-y-hidden text-wrap" wire:click="downloadOthers('{{ $file[1] }}')" wire;key="others-{{ $key }}">
                            {{ $file[1]}}
                        </h1>
                     </div>
                     @endforeach
            @endif
                </div>
         @elseif($content == 'BENEFITS')
                <div class="w-11/12 relative flex justify-center items-center flex-wrap gap-5">
                    <table class="w-full m-5">
                        <tr class="border">
                            <th class="text-xs p-2 w-40">Benefits</th>
                            <th class="text-xs p-2 w-40">Status</th>
                            <th class="text-xs p-2 w-40">Date Request</th>
                            <th class="text-xs p-2 w-40">Date Approved</th>
                        </tr>
                    @foreach ($user->approved_benefits as $benefit)
                        <tr>
                            <td class="text-xs p-2 text-center">{{ $benefit->benefit->benefit_name }}</td>
                            <td class="text-xs p-2 text-center">{{ $benefit->status }}</td>
                            <td class="text-xs p-2 text-center">{{ $benefit->created_at }}</td>
                            <td class="text-xs p-2 text-center">{{ $benefit->date_approved }}</td>
                        </tr>
                    @endforeach
                </table>
                </div>
        @elseif($content == 'TRAININGS')
                <div class="w-11/12 relative flex justify-center items-center flex-wrap gap-5">
                    <table class="w-full m-5">
                        <tr class="border">
                            <th class="text-xs p-2 w-40">Training</th>
                            <th class="text-xs p-2 w-40">Request Status</th>
                            <th class="text-xs p-2 w-40">Training Status</th>
                            <th class="text-xs p-2 w-40">Date Started</th>
                            <th class="text-xs p-2 w-40">Date Ended</th>
                        </tr>
                    @foreach ($user->participated_trainings as $training)
                        <tr>
                            <td class="text-xs p-2 text-center">{{ $training->training_available->training_name }}</td>
                            <td class="text-xs p-2 text-center">{{ $training->status }}</td>
                            <td class="text-xs p-2 text-center">{{ $training->training_available->status }}</td>
                            <td class="text-xs p-2 text-center">{{ $training->training_available->start_date }}</td>
                            <td class="text-xs p-2 text-center">{{ $training->training_available->to_date }}</td>
                        </tr>
                    @endforeach
                </table>
                </div>               
        @endif
    </div>

<x-modal wire:model="showChecklistModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-full relative p-5 gap-5 flex flex-col justify-center items-center bg-whitey">
            <div class="">
                <h1 class=" font-bold">201 File Checklist</h1>
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="font-bold p-5">201 File</th>
                        <th class="font-bold p-5">Checklist</th>
                    </tr>
                </thead>
               @if ($user->two_zero_one_file)
               <tbody>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->sss != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
            
                    </td>
                    <td><h1 class=" font-bold italic">SSS</h1></td>
                </tr>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->tin != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
                    </td>
                    <td><h1 class=" font-bold italic">TIN</h1></td>
                </tr>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->philhealth != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
                    </td>
                    <td><h1 class=" font-bold italic">PHILHEALTH</h1></td>
                </tr>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->nbi != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
                    </td>
                    <td><h1 class=" font-bold italic">NBI</h1></td>
                </tr>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->diploma != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
                    </td>
                    <td><h1 class=" font-bold italic">Diploma</h1></td>
                </tr>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->tor != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
                    </td>
                    <td><h1 class=" font-bold italic">TOR</h1></td>
                </tr>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->resume != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
                    </td>
                    <td><h1 class=" font-bold italic">RESUME</h1></td>
                </tr>
                <tr>
                    <td class="font-bold p-5">
                        @if ($user->two_zero_one_file->employment_contracts != null)
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                    @endif
                    </td>
                    <td><h1 class=" font-bold italic">EMPLOYMENT CONTRACTS</h1></td>
                </tr>
                <tr>
                    <td colspan="2" class="font-bold p-5 text-center">OTHERS</td>
                </tr>
                @foreach ($other_requirements as $requirement)
                    @if ($requirement != "")
                    <tr>
                        <td class="p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>   
                        </td>
                        <td class="font-bold  text-center italic">{{ $requirement }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>

                @else
                <tbody>
                    <tr>
                        <td class="font-bold p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                        </td>
                        <td class="font-bold p-5">SSS</td>
                    </tr>
                    <tr>
                        <td class="font-bold p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                        </td>
                        <td class="font-bold p-5">TIN</td>
                    </tr>
                    <tr>
                        <td class="font-bold p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                        </td>
                        <td class="font-bold p-5">PHILHEALTH</td>
                    </tr>
                    <tr>
                        <td class="font-bold p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                        </td>
                        <td class="font-bold p-5">NBI</td>
                    </tr>
                    <tr>
                        <td class="font-bold p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                        </td>
                        <td class="font-bold p-5">DIPLOMA</td>
                    </tr>
                    <tr>
                        <td class="font-bold p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                        </td>
                        <td class="font-bold p-5">TOR</td>
                    </tr>
                    <tr>
                        <td class="font-bold p-5">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>    
                        </td>
                        <td class="font-bold p-5">RESUME</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="font-bold p-5 text-center">OTHERS</td>
                    </tr>
                  
                </tbody>
               @endif
            </table>
        

         
           
        </div>
    </div>
</x-modal>
<x-modal wire:model='showUploadModal'>
    <div class="w-full relative justify-center items-center flex">
        <div class="w-full relative flex bg-whitey p-5  flex-col justify-center items-center">
            <form wire:submit='requirementUpload' enctype="multipart/form-data">
                <div class="w-full relative flex flex-col mt-5 mb-5">
                    <x-label for="requirement_name">Requirements Type:</x-label>
                    <select name="requirement_name" class="rounded border border-gray-200" id="requirement_name" wire:model='requirement_name'>
                        <option value=""></option>
                        <option value="sss" class="uppercase">SSS</option>
                        <option value="tin" class="uppercase">TIN</option>
                        <option value="philhealth" class="uppercase">PHILHEALTH</option>
                        <option value="nbi" class="uppercase">NBI</option>
                        <option value="diploma" class="uppercase">Diploma</option>
                        <option value="tor" class="uppercase">tor</option>
                        <option value="resume" class="uppercase">resume</option>
                        <option value="employment_contracts" class="uppercase">employment contracts</option>
                        <option value="others" class="uppercase">others</option>
                    </select>
                    @error('requirement_name')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full relative flex flex-col mt-5 mb-5">
                    <x-label for="file_upload">File Name:</x-label>
                    <input type="file" wire:model='file_upload' id="file_upload" name="file_upload">
                    @error('file_upload')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                @if ($requirement_name == 'others')
                    <div class="w-full relative flex flex-col mt-5 mb-5" >
                        <x-label for="specify">Specify:</x-label>
                        <input type="text" wire:model='specify' class="rounded border border-gray-200" id="specify" name="specify">
                        @error('specify')
                            <span class="text-xs text-red-200">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                <div class="w-full relative mt-5 mb-5 flex flex-col">
                    <x-button type="submit">Upload</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>
</div>
