<div class="w-full flex justify-between ">
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
    
    <div class="w-full  justify-center items-center flex flex-col relative ">
        <div class="w-10/12 m-5 bg-whitey rounded">
            <div class="w-full gap-5 relative flex p-2 ">
                <button class="rounded-lg p-2 relative text-xs border {{ $content == "APPLICANTS" ? 'bg-yellow-green' : "" }}" wire:click="showApplicants">Applicants</button>
                <button class="rounded-lg p-2 relative text-xs border {{ $content == "EMPLOYEES" ? 'bg-yellow-green' : "" }}" wire:click="showEmployees">Employees</button>
                <button class="rounded-lg p-2 relative text-xs border {{ $content == "HROFFICERS" ? 'bg-yellow-green' : "" }}" wire:click="showHrOfficers">Hr Officers</button>
            </div>
            <div class="w-full gap-5 relative flex p-2 justify-center items-center">
                <input type="text" wire:model.live.debounce.1000ms="search" class="w-10/12 pl-5 rounded bg-gray-200 rounded-full">
            </div>
            <div class="w-full relative" wire:poll>
                <table>
                  @if ($content == "APPLICANTS")
                  <thead>
                    <tr>
                        <th class="text-xs text-center p-5 font-semibold w-40">ID</th>
                        <th class="text-xs text-center p-5 font-semibold w-40"></th>
                        <th class="text-xs text-center p-5 font-semibold w-40">NAME</th>
                        <th class="text-xs text-center p-5 font-semibold w-40 xsmr:hidden smr:hidden">EMAIL</th>
                        <th class="text-xs text-center p-5 font-semibold w-40  xsmr:hidden smr:hidden">ROLE</th>
                    </tr>
                   </thead>
                   <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-xs p-5 font-semibold text-center  items-center"><span>{{ $user->id }}</span>
                           
                        </td>
                        <td class="text-xs p-5 font-semibold text-center"> @if ($user->profile_photo_path != null)
                                <img src="/storage/employee-media/{{ $user->profile_photo_path }}" class="w-20 h-20 rounded-full" alt="">
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="rounded-full h-9/12 border" height="16" viewBox="0 96 960 960" width="16"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>
                            @endif</td>
                        <td class="text-xs p-5 font-semibold text-center">{{$user->name}}</td>
                        <td class="text-xs p-5 font-semibold text-center xsmr:hidden smr:hidden">{{$user->email}}</td>
                        <td class="text-xs p-5 font-semibold text-center  xsmr:hidden smr:hidden">Applicant</td>
                    </tr>
                    @endforeach
                   </tbody>
                   @elseif($content == 'EMPLOYEES')
                   <thead>
                    <tr>
                        <th class="text-xs text-center p-5 font-semibold w-40">EID</th>
                        <th class="text-xs text-center p-5 font-semibold w-40  xsmr:hidden smr:hidden"></th>
                        <th class="text-xs text-center p-5 font-semibold w-40">NAME</th>
                        <th class="text-xs text-center p-5 font-semibold w-40  xsmr:hidden smr:hidden">EMAIL</th>
                        <th class="text-xs  text-center p-5 font-semibold w-40">POSITION</th>
                        <th class="text-xs text-center p-5 font-semibold w-40  xsmr:hidden smr:hidden">ROLE</th>
                    </tr>
                   </thead>
                   <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-xs p-5 font-semibold text-center">{{ $user->employee_id }}
                            
                        </td>
                        <td class="text-xs p-5 font-semibold text-center  xsmr:hidden smr:hidden">@if ($user->profile_photo_path != null)
                                <img src="/storage/employee-media/{{ $user->profile_photo_path }}" class="w-20 h-20 rounded-full" alt="">
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="rounded-full h-9/12 border" height="16" viewBox="0 96 960 960" width="16"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>
                            @endif</td>
                        <td class="text-xs p-5 font-semibold text-center">{{ $user->name }}</td>
                        <td class="text-xs p-5 font-semibold text-center  xsmr:hidden smr:hidden">{{ $user->email }}</td>
                        <td class="text-xs p-5 font-semibold text-center">{{ $user->position }}</td>
                        <td class="text-xs p-5 font-semibold text-center  xsmr:hidden smr:hidden">EMPLOYEE</td>
                    </tr>
                    @endforeach
                   </tbody>
                   @elseif($content == 'HROFFICERS')
                   <thead>
                    <tr>
                        <th class="text-xs text-center p-5 font-semibold w-40">EID</th>
                        <th class="text-xs text-center p-5 font-semibold w-40 xsmr:hidden smr:hidden"></th>
                        <th class="text-xs text-center p-5 font-semibold w-40 ">NAME</th>
                        <th class="text-xs text-center p-5 font-semibold w-40 xsmr:hidden smr:hidden">EMAIL</th>
                        <th class="text-xs text-center p-5 font-semibold w-40  xsmr:hidden smr:hidden">ROLE</th>
                    </tr>
                   </thead>
                   <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-xs p-5 font-semibold text-center ">{{ $user->employee_id }}
                        </td>
                        <td class="text-xs p-5 font-semibold text-center xsmr:hidden smr:hidden">@if ($user->profile_photo_path != null)
                                <img src="/storage/employee-media/{{ $user->profile_photo_path }}" class="w-20 h-20 rounded-full" alt="">
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="rounded-full h-9/12 border" height="16" viewBox="0 96 960 960" width="16"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>
                            @endif</td>
                        <td class="text-xs p-5 font-semibold text-center">{{ $user->name }}</td>
                        <td class="text-xs p-5 font-semibold text-center xsmr:hidden smr:hidden">{{ $user->email }}</td>
                        <td class="text-xs p-5 font-semibold text-center  xsmr:hidden smr:hidden">HR OFFICER</td>
                    </tr>
                    @endforeach
                   </tbody>
                  @endif
                </table>
            </div>
        </div>
    </div>
</div>
