<div class="w-full h-screen relative">
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
    <div class="w-11/12 m-10  relative bg-white xsmr:flex-col smr:justify-center xsmr:justify-center smr:flex-col xsmr:gap-5 smr:gap-5  rounded flex">
      
        <div class="w-40 h-full xsmr:w-full h-screen  xsmr:h-40 smr:h-40  rounded smr:w-full bg-white flex flex-col items-center">
            <div class="w-full relative flex cursor-pointer justify-center items-center mt-5" wire:click="editProfilePhoto">
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
        <div class="w-10/12 bg-white xsmr:w-full smr:w-full xsmr:ml-0 smr:ml-0 rounded  ml-5 mb-5 relative ">
            <div class="w-full">
                @if (auth()->user()->employee_information)
                <div class="w-11/12 m-3 relative">
                    <div class="w-full relative flex flex-col">
                        <div class="flex justify-between mt-3">
                            <div class="ml-3">
                               <x-label>Name:</x-label>
                                 <h1 class="font-semibold">{{auth()->user()->name}}</h1>
                            </div>
                            <div class="mr-3">
                                <x-label  class="text-right">Employee ID:</x-label>
                                  <h1 class="font-semibold">{{auth()->user()->employee_id}}</h1>
                             </div>
                        </div>

                        <div class="flex justify-between mt-5">
                            <div class="ml-3">
                               <x-label>Email:</x-label>
                                 <h1 class="font-semibold">{{auth()->user()->email}}</h1>
                            </div>
                            <div class="mr-3">
                                <x-label class="text-right">Country:</x-label>
                                  <h1 class="font-semibold">{{auth()->user()->employee_information->country}}</h1>
                             </div>
                        </div>


                        <div class="w-full ml-5 mt-10"> <h1 class="uppercase font-semibold text-blue-400">Contact</h1></div>

                        <div class="flex justify-between mt-5">
                            <div class="ml-3">
                               <x-label>Age:</x-label>
                               <h1 class="font-semibold">{{auth()->user()->employee_information->age}}</h1>

                            </div>
                            <div class="mr-3">
                                <x-label class="text-right">Birthday:</x-label>
                                  <h1 class="font-semibold">{{auth()->user()->employee_information->birthday}}</h1>
                             </div>
                        </div>
                  
                            
                        <div class="flex justify-between mt-5">
                            <div class="ml-3">
                               <x-label>Region:</x-label>
                               <h1 class="font-semibold">{{auth()->user()->employee_information->region}}</h1>

                            </div>
                            <div class="mr-3">
                                <x-label class="text-right">Province:</x-label>
                                  <h1 class="font-semibold">{{auth()->user()->employee_information->province}}</h1>
                             </div>
                        </div>
                     
                        
                        <div class=" flex justify-between  mt-5 relative">
                            <div class="ml-3 bg-white    relative">
                                <x-label>City:</x-label>
                                  <h1 class="font-semibold">{{auth()->user()->employee_information->city}}</h1>
                             </div>
                            <div class="w-2/4 white-space-wrap relative">
                               <x-label class="text-right mr-3">Address:</x-label>
                               <h1 class="font-semibold ">{{auth()->user()->employee_information->address}}</h1>
                            </div>
                        </div>
                        
                        
                        <div class="flex justify-between mt-5">
                            <div class="ml-3">
                               <x-label>Postal Code:</x-label>
                               <h1 class="font-semibold">{{auth()->user()->employee_information->postal_code}}</h1>

                            </div>
                            <div class="mr-3">
                                <x-label class="text-right">Barangay :</x-label>
                                  <h1 class="font-semibold">{{auth()->user()->employee_information->barangay}}</h1>
                             </div>
                        </div>
                        <div class="flex justify-between mt-5">

                            <div class="ml-3">
                                <x-label >Mobile Number:</x-label>
                                  <h1 class="font-semibold">{{auth()->user()->employee_information->mobile_number}}</h1>
                             </div>
                        </div>
                        <div class="w-full relative mb-10 mt-10">
                        <x-button wire:click="editEmployee" class="mt-5 ml-5">Edit Your Information</x-button>

                        </div>
                    </div>
                </div>

                @else
                    <x-button wire:click="editEmployee" class="mt-5 ml-5">Edit Your Information</x-button>
                @endif
            </div>
        </div>
    </div>
    
    <x-modal wire:model="editProfilePhotoModal">
        <div class="w-full relative flex justify-center items-center">
            <div class="w-10/12 m-10 p-5 rounded bg-whitey relative flex flex-col">
                <form wire:submit.prevent="saveProfilePhoto" method="POST" enctype="multipart/form-data" wire:loading.attr="disable">
                    @csrf
                    <div class="w-10/12 relative text-center rounded bg-red-400">
                        @error('image')
                            <p>{{$message}}</p>
                        @enderror
                    </div>
                    <div class="w-10/12 relative">
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
    
                    <div class="mt-5 relative w-10/12 flex gap-5">
                        <x-label for="image" class="py-2 px-3 rounded border w-28 cursor-pointer text-center" >Upload Photo</x-label>
                        <x-label wire:click="removePhoto" class="py-2 px-3 rounded border w-32 cursor-pointer text-center" >Remove Photo</x-label>
                        <x-input type="file" wire:model="image" name="image" id="image" class="hidden" />
                    </div>
    
                    <div class="mt-5 relative w-10/12">
                        <x-button type="submit">save</x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

<x-modal wire:model="editInformationModal">
    <div class="w-full relative flex justify-center items-center " wire:poll>
        <div class="w-full rounded m-5 p-5 bg-whitey relative  ">
            <form wire:submit.prevent="saveInformation" method="POST">
                @csrf
                <div class="w-full rounded flex flex-col relative">
                    <x-label for="age">Age:</x-label>
                    <x-input type="number" wire:model="age" name="age"  id="age" />
                </div>
                <div class="w-full rounded flex flex-col relative mt-3">
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
                <div class="w-full rounded flex flex-col relative mt-3">
                    <x-label for="address">Address:</x-label>
                    <x-input type="text" wire:model="address" name="address" id="address" />
                </div>

                <div class="w-full rounded flex flex-col relative mt-3">
                    <x-label for="postal_code">Postal Code:</x-label>
                    <x-input type="number" wire:model="postal_code" name="postal_code" id="postal_code" />
                </div>
                <div class="w-full rounded flex flex-col relative mt-3">
                    <x-label for="mobile_number">Mobile Number:</x-label>
                    <div class="flex w-full">
                        <button>+63</button>
                        <x-input type="number" wire:model="mobile_number" class="w-full" name="mobile_number" id="mobile_number" />
                    </div>
                </div>
                <div class="w-full rounded flex flex-col relative mt-3 justify-end">
                  <x-button type="submit">save</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>
</div>
