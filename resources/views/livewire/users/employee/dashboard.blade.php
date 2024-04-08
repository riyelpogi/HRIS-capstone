<div class="w-full flex ">
   
      <div class="w-full h-screen bg-whitey relative flex flex-col ">
      
          <div class="w-full h-auto flex cursor-pointer  flex-col justify-center items-center mt-10" >
              
              <a href="/user/employee/schedule" class="w-full text-xs font-semibold" wire:navigate><div class="w-full h-auto pt-5 pb-5 rounded flex justify-center items-center hover:bg-yellow-green  cursor-pointer {{ Route::is('employee.schedule') == true ? 'bg-yellow-green text-black' : '' }}">
                 Schedule
              </div></a>
  
               <a href="/user/employee/daily/time/record" class="w-full text-xs font-semibold" wire:navigate><div class="w-full h-auto pt-5 pb-5 rounded flex justify-center items-center hover:bg-yellow-green  cursor-pointer  {{ Route::is('employee.daily.time.record') == true ? 'bg-yellow-green text-black' : '' }}">
                 DTR
              </div></a>
              
              
              <a href="/user/employee/trainings" class="w-full text-xs font-semibold" wire:navigate><div class="w-full h-auto pt-5 pb-5 rounded flex justify-center items-center hover:bg-yellow-green  cursor-pointer {{ Route::is('employee.training') == true ? 'bg-yellow-green text-black' : '' }}">
                 Training
              </div></a>
             
              <a href="/user/employee/performance" class="w-full text-xs font-semibold" wire:navigate> <div class="w-full h-auto pt-5 pb-5 rounded flex justify-center items-center hover:bg-yellow-green  cursor-pointer {{ Route::is('employee.performance') == true ? 'bg-yellow-green text-black' : '' }}"  >
                 Performance
              </div></a>
  
              <a href="/user/employee/eventsandnews" class="w-full text-xs font-semibold" wire:navigate> <div class="w-full h-auto pt-5 pb-5 rounded flex justify-center items-center hover:bg-yellow-green  cursor-pointer {{ Route::is('employee.eventsandnews') == true ? 'bg-yellow-green text-black' : '' }}"  >
                  Events and News
               </div></a>
  
               <a href="/user/employee/benefits" class="w-full text-xs font-semibold" wire:navigate> <div class="w-full h-auto pt-5 pb-5 rounded flex justify-center items-center hover:bg-yellow-green  cursor-pointer {{ Route::is('employee.benefits') == true ? 'bg-yellow-green text-black' : '' }}"  >
                 Benefits
              </div></a>
  
          </div>
        
      </div>
      
  
</div>