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
            <x-input type="text" wire:model.live.debounce.1000ms="searchapplicants" placeholder="Search employee" class="w-full h-8 pl-5 rounded-xl" />
        </div>
      <table  class="border-collapse mt-5 border border-slate-400 overflow-y-auto" wire:poll>
        <tr class="text-sm">
            <th class="w-32">Name</th>
            <th class="w-32">Email</th>
            <th class="w-32"></th>
        </tr>
               @if ($applicants != null)
               @foreach ($applicants as $applicant)
               <tr class="text-xs text-center" style="border-top:0.5px solid gray">
                   <td>{{$applicant->name}}</td>
                   <td>{{$applicant->email}}</td>
                   <td ><button class="p-1 rounded bg-green-400" wire:click="hireModal({{$applicant->id}})" wire:key="hireModal-{{$applicant->id}}">Hire</button></td>
               </tr>
               @endforeach
               @endif
      </table>
      <x-modal wire:model="hireShowModal">
        <div class="w-full relative flex justify-center items-center flex-col">
            <div class="w-10/12 bg-whitey p-5 rounded relative flex flex-col m-10">
            <form wire:submit="hired" method="POST">
                @csrf
                <div class="flex flex-col m-5">
                    @if ($applicant != null)
                    <x-label>Applicant Name:</x-label>
                    <h1 class=" font-semibold">{{$applicant_name}}</h1>
                    @endif
                </div>
                <div class="flex flex-col m-5">
                    <x-label for="department">Department:</x-label>
                    <x-input wire:model="department" type="text" name="department" id="department" />
                    @error('department')
                         <p class="p-1 rounded text-red-400 text-xs text-center">{{$message}}</p>
    
                    @enderror
                </div>
                <div class="flex flex-col m-5">
                    <x-label for="position">Position:</x-label>
                    <x-input wire:model="position" type="text" name="position" id="position" />
                    @error('position')
                    <p class="p-1 rounded text-red-400 text-xs text-center">{{$message}}</p>
                   @enderror
                </div>
                <div class="flex flex-col m-5">
                    <x-label for="deployment_date">Deployment Date:</x-label>
                    <x-input wire:model="deployment_date" type="text" name="deployment_date" id="deployment_date" />
                    @error('deployment_date')
                    <p class="p-1 rounded text-red-400 text-xs text-center">{{$message}}</p>
                   @enderror
                </div>
                <x-button tyoe="submit">Hire</x-button>
            </form>
            </div>
        </div>
    </x-modal>
    </div>
   