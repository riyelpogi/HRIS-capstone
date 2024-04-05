<div class="w-full  relative">
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
<div class="w-11/12 ml-5 mt-5 relative flex gap-5 rounded">
    <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == 'INFORMATION' ? 'bg-yellow-green' : '' }}" wire:click="information">Information</button>
    <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == '201file' ? 'bg-yellow-green' : '' }}" wire:click="showcertificates">201 Files</button>
    <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == 'BENEFITS' ? 'bg-yellow-green' : '' }}" wire:click="showBenefits">Benefits</button>
        <button class="p-2 text-xs rounded-lg border hover:bg-yellow-green {{ $content == 'TRAININGS' ? 'bg-yellow-green' : '' }}" wire:click="showTrainings">Trainings</button>
</div>
    <div class="w-11/12 m-5 relative  xsmr:flex-col bg-white smr:justify-center xsmr:justify-center smr:flex-col xsmr:gap-5 smr:gap-5 rounded flex">
            @if ($content == 'INFORMATION')
            <div class="w-40 h-screen xsmr:h-40 smr:h-40 bg-white xsmr:w-full smr:w-full flex flex-col items-center rounded">
                <div class="w-full relative flex justify-center items-center mt-5 cursor-pointer" wire:click="editProfilePhoto">
                    @if (auth()->user()->profile_photo_path != null)
                        <img src="/storage/employee-media/{{auth()->user()->profile_photo_path}}" alt="" class="w-16 h-16 rounded-full border">
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="rounded-full h-9/12 border" height="62" viewBox="0 96 960 960" width="62"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>
    
                    @endif
                </div>
                <div class="mt-5">
                    <h1 class="font-semibold text-center">{{auth()->user()->name}}</h1>
                </div>
            </div>
            <div class="w-10/12 bg-white  xsmr:w-full smr:w-full  rounded ml-5 xsmr:ml-0 smr:ml-0 relative ">
                <div class="w-full">
                    @if (auth()->user()->employee_information)
                        <div class="w-11/12 m-3 relative">
                            <div class="w-full relative flex flex-col">
                                <div class="flex justify-between mt-3">
                                    <div class="ml-3">
                                    <x-label>Name:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->name}}</h   1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label  class="text-right">Employee ID:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_id}}</h1>
                                    </div>
                                </div>
        
                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Department:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->department}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label  class="text-right">Position:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->position}}</h1>
                                    </div>
                                </div>
        
                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Date Hired:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->date_hired}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label  class="text-right">Date Regularization:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->date_regular}}</h1>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Deployment Date:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->deployment_date}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Country:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->country}}</h1>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Email:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->email}}</h1>
                                    </div>
                                 
                                </div>
        
                                

                                <div class="w-full ml-5 mt-10"> <h1 class="uppercase font-semibold text-blue-400">Contact</h1></div>
        
                                <div class="flex justify-between mt-5">
                                    {{-- <div class="ml-3">
                                    <x-label>Age:</x-label>
                                    <h1 class="font-semibold">{{auth()->user()->employee_information->age}}</h1> 
        
                                    </div>--}}
                                    <div class="ml-3">
                                        <x-label class="">Birthday:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->birthday}}</h1>
                                    </div>
                                    <div class="mr-3">
                                        <x-label class="text-right">Region:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->region}}</h1>
         
                                     </div>
                                </div>
                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                        <x-label class="">Province:</x-label>
                                          <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->province}}</h1>
                                     </div>

                                     <div class="mr-3 bg-white  relative">
                                        <x-label class="text-right">City:</x-label>
                                          <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->city}}</h1>
                                     </div>
                                </div>
                             
                                
                                <div class=" flex justify-between ml-3  mt-5 relative">
                                    <div class="w-2/4 white-space-wrap relative">
                                       <x-label class="">Address:</x-label>
                                       <h1 class="font-semibold uppercase text-sm">{{auth()->user()->employee_information->address}}</h1>
                                    </div>

                                    <div class="mr-3">
                                        <x-label >Postal Code:</x-label>
                                        <h1 class="font-semibold text-right text-sm">{{auth()->user()->employee_information->postal_code}}</h1>
            
                                        </div>
                                </div>
                                
                                
                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                        <x-label class="">Barangay:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->barangay}}</h1>
                                    </div>

                                    <div class="mr-3">
                                        <x-label class="text-right">Mobile Number:</x-label>
                                        <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->mobile_number}}</h1>
                                    </div>
                                </div>
        
                                <div class="flex justify-between mt-5">
                                    <div class="ml-3">
                                    <x-label>Resume/CV:</x-label>
                                    <h1 class="font-semibold text-sm">{{auth()->user()->employee_information->resume}}</h1>
                                    </div>
                                   
                                </div>
        
                                <div class="w-full relative mt-10">
                                <x-button wire:click="editEmployee" class="mt-5 ml-5">Edit Your Information</x-button>
        
                                </div>
                            </div>
                        </div>
        
                        @else
                            <x-button wire:click="editEmployee" class="mt-5 ml-5">Edit Your Information</x-button>
                        @endif
                    </div>
                </div>
            @elseif($content == '201file')
            <div class="w-full relative flex  bg-gray-100 flex-wrap gap-5">
                <div class="w-full relative flex justify-end items-center">
                    <button class="p-2 rounded-lg text-xs bg-yellow-green hover:bg-green-400" wire:click='uploadFile'>Upload File</button>
                </div>
                <div class="w-full relative flex flex-wrap gap-5">
                    @if (auth()->user()->two_zero_one_file)
                            <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                               <h1 class="text-sm  font-semibold text-center">SSS</h1>
                               <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadSss('{{ auth()->user()->two_zero_one_file->sss }}')">
                            {{ auth()->user()->two_zero_one_file->sss  }}</h1>
                            </div>

                            <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                                <h1 class="text-sm  font-semibold text-center">TIN</h1>
                                <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadTin('{{ auth()->user()->two_zero_one_file->tin }}')">
                                  {{   auth()->user()->two_zero_one_file->tin }}
                                </h1>
                             </div>

                             <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                                <h1 class="text-sm  font-semibold text-center">PHILHEALTH</h1>
                                <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadPhilhealth('{{ auth()->user()->two_zero_one_file->philhealth }}')">
                               {{ auth()->user()->two_zero_one_file->philhealth  }}</h1>
                             </div>
                             
                             <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                                <h1 class="text-sm  font-semibold text-center">NBI</h1>
                                <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadNbi('{{ auth()->user()->two_zero_one_file->nbi }}')">
                               {{ auth()->user()->two_zero_one_file->nbi  }}</h1>
                             </div>

                             <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                                <h1 class="text-sm  font-semibold text-center">DIPLOMA</h1>
                                <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadDiploma('{{ auth()->user()->two_zero_one_file->diploma }}')">
                               {{ auth()->user()->two_zero_one_file->diploma  }}</h1>
                             </div>

                             <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                                <h1 class="text-sm  font-semibold text-center">TOR</h1>
                                <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadTor('{{ auth()->user()->two_zero_one_file->tor }}')">
                               {{ auth()->user()->two_zero_one_file->tor  }}</h1>
                             </div>

                             <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                                <h1 class="text-sm  font-semibold text-center">RESUME</h1>
                                <h1 class="cursor-pointer hover:text-red-400" wire:click="downloadResume('{{ auth()->user()->two_zero_one_file->resume  }}')">
                                    {{ auth()->user()->two_zero_one_file->resume }}
                                </h1>
                             </div>

                            
                             
                             @foreach ($other_requirements_file_name as $key => $file)
                             <div class="w-3/12 flex flex-col justify-center items-center p-2 relative bg-whitey">
                                <h1 class="text-sm  font-semibold text-center uppercase">{{ $file[0] }}</h1>
                                <h1 class="cursor-pointer hover:text-red-400 w-full relative overflow-x-hidden overflow-y-hidden text-wrap" wire:click="downloadOthers('{{ $file[1] }}')" wire:key='others-{{ $key }}'>
                                    {{ $file[1] }}
                                </h1>
                             </div>
                             @endforeach
                    @endif
                </div>
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
                    @foreach (auth()->user()->approved_benefits as $benefit)
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
                    @foreach (auth()->user()->participated_trainings as $training)
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
                    <x-label for="file_image">File Name:</x-label>
                    <input type="file" wire:model='file_image' id="file_image" name="file_image">
                    @error('file_image')
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
<x-modal wire:model="editInformationModal">
    <div class="w-full relative justify-center items-center flex">
        <div class="w-full relative m-10 bg-whitey p-5 rounded" wire:poll>
            <form wire:submit.prevent="saveInformation" method="POST">
                @csrf

                <div class="w-full flex flex-col relative mt-3">
                    <x-label for="birthday">Birthday:</x-label>
                    <x-input type="date" wire:model="birthday" name="birthday" id="birthday" />
                </div>
                <div class="w-full rounded flex flex-col relative mt-3">
                    <x-label for="u_region">Region:</x-label>
                    <select name="u_region" id="u_region" class="rounded border border-gray-300" wire:model="u_region">
                        <option value=""></option>
                        @if ($regions != null)
                                @foreach ($regions as $region)
                                    <option value="{{ $region->region_description }}">{{ $region->region_description }}</option>
                                @endforeach
                        @endif
                    </select>
                </div>
                <div class="w-full rounded flex flex-col relative mt-3" wire:poll>
                    <x-label for="u_province">Province:</x-label>
                    <select name="u_province" id="u_province" class="rounded border border-gray-300" wire:model="u_province">
                        @if (auth()->user()->employee_information)
                            @if (auth()->user()->employee_information->region == $u_region)
                               <option value="{{ $u_province }}">{{ $u_province }}</option>
                            @else
                               <option value=""></option>    
                            @endif
                        @else
                            <option value=""></option> 
                        @endif
                        @if ($provinces)
                            @foreach ($provinces as $province)
                                <option value="{{ $province->province_description }}">{{ $province->province_description }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
    
                <div class="w-full rounded flex flex-col relative mt-3">
                    <x-label for="u_city">Cities:</x-label>
                    <select name="u_city" id="u_city" class="rounded border border-gray-300" wire:model="u_city">
                        @if (auth()->user()->employee_information)
                            @if (auth()->user()->employee_information->region == $u_region && auth()->user()->employee_information->province == $u_province)
                                <option value="{{ $u_city }}">{{ $u_city }}</option>
                            @else
                                <option value=""></option> 
                            @endif
                        @else
                            <option value=""></option>     
                        @endif
                        @if ($cities)
                            @foreach ($cities as $city)
                                <option value="{{ $city->city_municipality_description }}">{{ $city->city_municipality_description }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="w-full rounded flex flex-col relative mt-3">
                    <x-label for="u_brgy">Barangay:</x-label>
                    <select name="u_brgy" id="u_brgy" class="rounded border border-gray-300" wire:model="u_brgy">
                        @if (auth()->user()->employee_information)
                            @if (auth()->user()->employee_information->region == $u_region && auth()->user()->employee_information->province == $u_province && auth()->user()->employee_information->barangay == $u_brgy)
                                <option value="{{ $u_brgy }}">{{ $u_brgy }}</option>
                            @else
                                <option value=""></option>     
                            @endif
                        @else
                            <option value=""></option>    
                        @endif
                        @if ($brgys)
                            @foreach ($brgys as $brgy)
                                <option value="{{ $brgy->barangay_description }}">{{ $brgy->barangay_description }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="w-full flex flex-col relative mt-3">
                    <x-label for="address">Address:</x-label>
                    <x-input type="text" wire:model="address" name="address" id="address" />
                </div>
                <div class="w-full flex flex-col relative mt-3">
                    <x-label for="postal_code">Postal Code:</x-label>
                    <x-input type="number" wire:model="postal_code" name="postal_code" id="postal_code" />
                </div>
                <div class="w-full flex flex-col relative mt-3">
                    <x-label for="mobile_number">Mobile Number:</x-label>
                    <div class="flex w-full">
                        <button>+63</button>
                        <x-input type="number" wire:model="mobile_number" class="w-full" name="mobile_number" id="mobile_number" />
                    </div>
                </div>
                <div class="w-full flex flex-col relative mt-3 justify-end">
                  <x-button type="submit">save</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="editProfilePhotoModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-10/12 mt-10 bg-whitey p-5 rounded mb-10 relative flex flex-col">
            <form wire:submit.prevent="saveProfilePhoto" method="POST" enctype="multipart/form-data" wire:loading.attr="disable">
                @csrf
                <div class="w-full relative text-center rounded bg-red-400">
                    @error('image')
                        <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="w-full relative">
                    @if (auth()->user()->profile_photo_path != null)
                        @if ($image != null)
                            @if (in_array($checker, ['jpeg','jpg','bng','png','tmp']))
                            <img src="{{$image->temporaryUrl()}}" alt="" class="w-16 h-16 rounded-full border" >
                            @endif
                        @else
                        <img src="/storage/employee-media/{{auth()->user()->profile_photo_path}}" alt="" class="w-16 h-16 rounded-full border" >

                        @endif
                    @else
                        @if ($image != null)
                            @if (in_array($checker, ['jpeg','jpg','bng','png','tmp']))
                            <img src="{{$image->temporaryUrl()}}" alt="" class="w-16 h-16 rounded-full border" >
                            @endif
                       @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="rounded-full h-9/12 border" height="62" viewBox="0 96 960 960" width="62"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>
                        @endif
                    @endif
                </div>

                <div class="mt-5 relative w-full flex gap-5">
                    <x-label for="image" class="py-2 px-3 rounded border w-28 cursor-pointer text-center" >Upload Photo</x-label>
                    <x-label wire:click="removePhoto" class="py-2 px-3 rounded border w-32 cursor-pointer text-center" >Remove Photo</x-label>
                    <x-input type="file" wire:model="image" name="image" id="image" class="hidden" />
                </div>

                <div class="mt-5 relative w-full">
                    <x-button type="submit" wire:target='saveProfilePhoto' wire:loading.attr='disabled'>save</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>
</div>
