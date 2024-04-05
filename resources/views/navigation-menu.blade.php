<nav x-data="{ open: false }" class="bg-dim-grey border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-12 ">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <!-- ADMIN -->
                    @if (auth()->user())
                      @if (auth()->user()->role == 2)
                      <a href="{{ route('admin.dashboard') }}">
                          <x-application-mark class="block h-9 w-auto" />
                      </a>
                      <!-- EMPLOYEE -->
                      @elseif(auth()->user()->role == 1)
                      <a href="{{ route('employee.dashboard') }}">
                          <x-application-mark class="block h-9 w-auto" />
                      </a>
                      <!-- APPLICANTS -->
                      @elseif(auth()->user()->role == 0)
                      <a href="{{ route('applicant.dashboard') }}">
                          <x-application-mark class="block h-9 w-auto" />
                      </a>
                      @elseif(auth()->user()->role == 3)
                      <a href="{{ route('dashboard.admin') }}">
                          <x-application-mark class="block h-9 w-auto" />
                      </a>
                      @endif
                    @else
                    <a href="{{ route('login') }}">
                      <x-application-mark class="block h-9 w-auto" />
                  </a>
                    @endif
                </div>

                <!-- Navigation Links -->
             
            </div>

            <div class="flex justify-center items-center gap-3">
                @if (auth()->user())
                    @if (auth()->user()->role == 0)
                      <livewire:users.applicant.notifications />
                    @elseif(auth()->user()->role == 2) 
                    <livewire:users.hrofficer.admin-notification />
                      @elseif(auth()->user()->role == 1)
                    <livewire:users.employee.employee-notification />
                    @endif
                @endif

                @if (auth()->user())
                <x-dropdown align="right">
                  <x-slot name="trigger">
                          <div class="w-8 h-8 flex justify-center items-center cursor-pointer relative border border-yellow-green rounded-full">
                            @if (auth()->user()->profile_photo_path != null)
                              <img src="/storage/employee-media/{{auth()->user()->profile_photo_path}}" alt="" class="w-8 h-8 rounded-full">
                            @else
                              <svg xmlns="http://www.w3.org/2000/svg" class="rounded-full" fill="#BAFF39" height="24" viewBox="0 96 960 960" width="24"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>
                            @endif
                          </div>
                  </x-slot>
                  <x-slot name="content">
                   <!-- APPLICANTS -->

                     @if(auth()->user()->role == 0)
                     <x-dropdown-link href="{{ route('applicant.profile') }}"
                     >
                       {{ __('Profile') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('applicant.application.history') }}"
                      >
                        {{ __('Application History') }}
                       </x-dropdown-link>
                      @endif
                  <!-- EMPLOYEE -->

                    @if(auth()->user()->role == 1)
                    <x-dropdown-link href="{{ route('employee.profile') }}"
                    >
                    {{ __('Profile') }}
                     </x-dropdown-link>
                     
                    <x-dropdown-link href="{{ route('employee.schedule') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('employee.schedule') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Schedule') }}
                      </x-dropdown-link>
                      
                      <x-dropdown-link href="{{ route('employee.daily.time.record') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('employee.daily.time.record') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('DTR') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('employee.training') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('employee.training') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Training') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('employee.performance') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('employee.performance') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Performance') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('employee.eventsandnews') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('employee.eventsandnews') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Events and News') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('employee.benefits') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('employee.benefits') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Benefits') }}
                      </x-dropdown-link>
                      
                  <!-- ADMIN -->
                     @elseif(auth()->user()->role == 2)
                     <x-dropdown-link href="{{ route('admin.profile') }} " class="{{ Route::is('admin.profile') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Profile') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('admin.users.employee') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.users.employee') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Employee') }}
                      </x-dropdown-link>
                      {{-- <x-dropdown-link href="{{ route('admin.users.applicant') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.users.applicant') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Applicants') }}
                      </x-dropdown-link> --}}
                      <x-dropdown-link href="{{ route('admin.employees.requests') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.employees.requests') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Employee Requests') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('admin.application.tracker') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.application.tracker') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Applicant Tracking System') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('admin.employee.inandout') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.employee.inandout') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Employee In/Out') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('admin.trainings') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.trainings') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Trainings') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('admin.benefits') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.benefits') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Employee Benefits') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('admin.employee.performance') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.employee.performance') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Employee Performance') }}
                      </x-dropdown-link>
                      <x-dropdown-link href="{{ route('admin.announcements') }}" class="mdr:hidden lgr:hidden xlr:hidden 2xlr:hidden 3xlr:hidden {{ Route::is('admin.announcements') == true ? 'bg-yellow-green text-black' : '' }}"
                     >
                       {{ __('Announcements & Events') }}
                      </x-dropdown-link>
                    @endif
                     
                     <form method="POST" action="{{ route('logout') }}" x-data>
                         @csrf

                         <x-dropdown-link href="{{ route('logout') }}"
                                  @click.prevent="$root.submit();">
                             {{ __('Log Out') }}
                         </x-dropdown-link>
                     </form>

                  </x-slot>
                  
              </x-dropdown>
                  @else
                    <div class="rounded-full bg-yellow-green p-1 relative">
                      <a href="{{ route('login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z"/></svg>     
                        
                      </a>
                    </div>
                    @endif
            </div>
    </div>

  


    </div>

</nav>
