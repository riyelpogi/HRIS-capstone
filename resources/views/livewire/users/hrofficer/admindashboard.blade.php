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
    <div class="w-full h-screen bg-whitey relative flex flex-col" >
        <div class="w-full h-auto flex pt-3 pb-3 cursor-pointer flex-col justify-center items-center hover:bg-yellow-green mt-10 {{ Route::is('admin.users.employee') == true ? 'bg-yellow-green text-black' : '' }}" >
                {{-- <div class="w-full relative  " wire:click="userextend">
                    <h1 class="font-semibold text-sm flex w-full justify-around items-center p-1"> 
                        <span class="flex items-center "> <svg class="smr:hidden " xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg><span class="text-xs">Users</span></span>
                        @if ($userExtend == true)
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="m296-345-56-56 240-240 240 240-56 56-184-184-184 184Z"/></svg>
                        @elseif($userExtend == false)
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M480-345 240-585l56-56 184 184 184-184 56 56-240 240Z"/></svg>    
                        @endif
                        </h1>
                    </div>
                        @persist('scrollbar')
                        @if ($userExtend == true)
                            <div class="w-full h-auto relative ">
                                   <a href="/user/hrofficer/users/employee" class="lgr:pt-3 lgr:pb-3 w-full relative " wire:navigate>
                                    <div class="w-full font-semibold h-8  flex text-xs justify-center items-center cursor-pointer {{ Route::is('admin.users.employee') == true ? 'bg-yellow-green text-black' : '' }}"  >
                                        Employee
                                    </div>
                                     </a> 
                                   <a href="/user/hrofficer/users/applicants" class="w-full lgr:pt-3 lgr:pb-3  relative {{ Route::is('admin.users.applicant') == true ? 'bg-yellow-green text-black' : '' }}" wire:navigate>
                                    <div class="w-full font-semibold h-8  flex text-xs justify-center items-center cursor-pointer " >
                                        Applicants
                                    </div> 
                                    </a> 
                            </div>
                        @endif
                        @endpersist --}}
                            <a href="/user/hrofficer/users/employee" class="hover:bg-yellow-green w-full relative " wire:navigate >
                                <div class="w-full h-auto flex cursor-pointer flex-col justify-center items-center  text-xs font-semibold  "  >
                                    Employee
                                </div>
                            </a>
                         
        </div>

        <div class="w-full h-auto pt-3 pb-3 flex cursor-pointer flex-col justify-center items-center hover:bg-yellow-green {{ Route::is('admin.employees.requests') == true ? 'bg-yellow-green text-black' : '' }}"   >
            <a href="/user/hrofficer/employees/requests" class="w-full" wire:navigate>
                <div class="w-full relative ">
               <h1 class="font-semibold text-xs flex justify-center items-center p-1 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" class="smr:hidden "  viewBox="0 -960 960 960" width="16"><path d="M411-480q-28 0-46-21t-13-49l12-72q8-43 40.5-70.5T480-720q44 0 76.5 27.5T597-622l12 72q5 28-13 49t-46 21H411Zm24-80h91l-8-49q-2-14-13-22.5t-25-8.5q-14 0-24.5 8.5T443-609l-8 49ZM124-441q-23 1-39.5-9T63-481q-2-9-1-18t5-17q0 1-1-4-2-2-10-24-2-12 3-23t13-19l2-2q2-19 15.5-32t33.5-13q3 0 19 4l3-1q5-5 13-7.5t17-2.5q11 0 19.5 3.5T208-626q1 0 1.5.5t1.5.5q14 1 24.5 8.5T251-596q2 7 1.5 13.5T250-570q0 1 1 4 7 7 11 15.5t4 17.5q0 4-6 21-1 2 0 4l2 16q0 21-17.5 36T202-441h-78Zm676 1q-33 0-56.5-23.5T720-520q0-12 3.5-22.5T733-563l-28-25q-10-8-3.5-20t18.5-12h80q33 0 56.5 23.5T880-540v20q0 33-23.5 56.5T800-440ZM0-240v-63q0-44 44.5-70.5T160-400q13 0 25 .5t23 2.5q-14 20-21 43t-7 49v65H0Zm240 0v-65q0-65 66.5-105T480-450q108 0 174 40t66 105v65H240Zm560-160q72 0 116 26.5t44 70.5v63H780v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5Zm-320 30q-57 0-102 15t-53 35h311q-9-20-53.5-35T480-370Zm0 50Zm1-280Z"/></svg>
                <span class="font-semibold">Employees Requests</span>
            </h1>
            </div>
            </a>
        </div>

        <div class="w-full h-auto pt-3 pb-3 flex cursor-pointer flex-col justify-center items-center hover:bg-yellow-green {{ Route::is('admin.application.tracker') == true ? 'bg-yellow-green text-black' : '' }}"   >
            <a href="/user/hrofficer/application/tracker" class="w-full" wire:navigate>
                <div class="w-full relative ">
               <h1 class="font-semibold text-xs flex justify-center items-center p-1 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" class="smr:hidden " viewBox="0 -960 960 960" width="16"><path d="M411-480q-28 0-46-21t-13-49l12-72q8-43 40.5-70.5T480-720q44 0 76.5 27.5T597-622l12 72q5 28-13 49t-46 21H411Zm24-80h91l-8-49q-2-14-13-22.5t-25-8.5q-14 0-24.5 8.5T443-609l-8 49ZM124-441q-23 1-39.5-9T63-481q-2-9-1-18t5-17q0 1-1-4-2-2-10-24-2-12 3-23t13-19l2-2q2-19 15.5-32t33.5-13q3 0 19 4l3-1q5-5 13-7.5t17-2.5q11 0 19.5 3.5T208-626q1 0 1.5.5t1.5.5q14 1 24.5 8.5T251-596q2 7 1.5 13.5T250-570q0 1 1 4 7 7 11 15.5t4 17.5q0 4-6 21-1 2 0 4l2 16q0 21-17.5 36T202-441h-78Zm676 1q-33 0-56.5-23.5T720-520q0-12 3.5-22.5T733-563l-28-25q-10-8-3.5-20t18.5-12h80q33 0 56.5 23.5T880-540v20q0 33-23.5 56.5T800-440ZM0-240v-63q0-44 44.5-70.5T160-400q13 0 25 .5t23 2.5q-14 20-21 43t-7 49v65H0Zm240 0v-65q0-65 66.5-105T480-450q108 0 174 40t66 105v65H240Zm560-160q72 0 116 26.5t44 70.5v63H780v-65q0-26-6.5-49T754-397q11-2 22.5-2.5t23.5-.5Zm-320 30q-57 0-102 15t-53 35h311q-9-20-53.5-35T480-370Zm0 50Zm1-280Z"/></svg>
                <span class="font-semibold text-xs">Applicant Tracking System</span>
            </h1>
            </div>
            </a>
        </div>

        <div class="w-full h-auto pt-3 pb-3 flex cursor-pointer flex-col justify-center items-center hover:bg-yellow-green {{ Route::is('admin.employee.inandout') == true ? 'bg-yellow-green text-black' : '' }}"   >
            <a href="/user/hrofficer/employee/in&out" class="w-full" wire:navigate>
            <div class="w-full relative ">
               <h1 class="font-semibold text-xs flex justify-center items-center p-1 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" class="smr:hidden "  viewBox="0 -960 960 960" width="16"><path d="M320-400q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm160 0q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm160 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>
                <span class="font-semibold">Employee In/Out</span>
            </h1>
            </div>
        </a>
        </div>

        <div class="w-full h-auto smr:pt-3 smr:pb-3 pt-3 pb-3 relative flex cursor-pointer flex-col justify-center items-center hover:bg-yellow-green font-bold {{ Route::is('admin.trainings') == true ? 'bg-yellow-green text-black' : ' ' }} "   >
            <a href="/user/hrofficer/employee/trainings" class="w-full" wire:navigate>
                <div class="w-full relative">
               <h1 class="font-semibold text-xs flex justify-center items-center p-1 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" class="smr:hidden " viewBox="0 -960 960 960" width="16"><path d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z"/></svg>
                <span class="font-semibold">Trainings</span>
            </h1>
            </div>
            </a>
        </div>


        <div class="w-full h-auto pt-3 pb-3 flex cursor-pointer flex-col justify-center items-center hover:bg-yellow-green {{ Route::is('admin.benefits') == true ? 'bg-yellow-green text-black' : ' ' }}">
            <a href="/user/hrofficer/employee/benefits" class="w-full" wire:navigate>
                <div class="w-full relative">
               <h1 class="font-semibold text-xs flex justify-center items-center p-1 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" class="smr:hidden " viewBox="0 -960 960 960" width="16"><path d="M280-240h80v-80h80v-80h-80v-80h-80v80h-80v80h80v80Zm240-140h240v-60H520v60Zm0 120h160v-60H520v60ZM160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm280-440h80v-200h-80v200Zm40 220Z"/></svg>
                <span class="font-semibold">Employee Benefits</span>
            </h1>
            </div>
            </a>
        </div>

        <div class="w-full h-auto pt-3 pb-3 flex cursor-pointer flex-col justify-center items-center hover:bg-yellow-green {{ Route::is('admin.employee.performance') == true ? 'bg-yellow-green text-black' : ' ' }}">
            <a href="/user/hrofficer/employee/performance" class="w-full" wire:navigate>
                <div class="w-full relative">
               <h1 class="font-semibold text-xs flex justify-center items-center p-1 gap-2">
                    <span class="font-semibold"><span class="smr:hidden">Employee</span> Performance</span>
            </h1>
            </div>
            </a>
        </div>

                  
        <div class="w-full h-auto pt-3 pb-3 flex cursor-pointer flex-col justify-center items-center hover:bg-yellow-green {{ Route::is('admin.announcements') == true ? 'bg-yellow-green text-black' : ' ' }}">
            <a href="/user/hrofficer/company/announcements" class="w-full" wire:navigate>
                <div class="w-full relative ">
               <h1 class="font-semibold text-xs flex justify-center items-center p-1 gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" height="16" class="smr:hidden " viewBox="0 -960 960 960" width="16"><path d="M640-440v-80h160v80H640Zm48 280-128-96 48-64 128 96-48 64Zm-80-480-48-64 128-96 48 64-128 96ZM120-360v-240h160l200-200v640L280-360H120Zm280-246-86 86H200v80h114l86 86v-252ZM300-480Z"/></svg>
                <span class="font-semibold">Events & News</span>
            </h1>
            </div>
            </a>
        </div>


</div>
</div>

