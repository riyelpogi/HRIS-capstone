<div class="w-11/12 relative flex justify-center m-5 overflow-y-auto">
    <div class="w-full  bg-white relative flex flex-col justiy-center items-center overflow-y-auto">
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
        <div class="w-11/12 mt-3 ml-3 mb-1 realtive flex gap-3 " style="border-bottom:0.5px solid gray;">
            <div class="p-1  rounded-lg border cursor-pointer hover:bg-yellow-green {{$ats_content == 'ats_jobs' ? 'bg-yellow-green' : ''}}" wire:click="atsjobs">
                <h1 class="text-xs" >My Jobs</h1>
            </div>
            <div class="p-1 rounded-lg cursor-pointer border hover:bg-yellow-green {{$ats_content == 'ats_postajob' ? 'bg-yellow-green' : ''}}"  wire:click="atspostajob">
                <h1 class="text-xs">Post Job</h1>
            </div>

            <div class="p-1 rounded-lg cursor-pointer border hover:bg-yellow-green {{$ats_content == 'ats_interviewee' ? 'bg-yellow-green' : ''}}"  wire:click="atsinterviewee">
                <h1 class="text-xs">Interviewee</h1>
            </div>
            
            <div class="p-1 rounded-lg cursor-pointer border hover:bg-yellow-green {{$ats_content == 'ats_shortlisted' ? 'bg-yellow-green' : ''}}"  wire:click="atsshortlisted">
                <h1 class="text-xs">Shortlisted</h1>
            </div>
        </div>
        <div class="w-full relative">
           @if ($ats_content == 'ats_jobs')
            <table class="w-full">
                <tr class="border rounded rounded-lg">
                    <th class="w-40 text-xs">Job ID</th>
                    <th class="w-40 text-xs">Job Title</th>
                    <th class="w-40 text-xs">Applicants</th>
                    <th class="w-40 text-xs">Status</th>
                    <th class="w-40 text-xs">Action</th>
                </tr>
                @if ($jobs != null)
                @foreach ($jobs as $job)
                    <tr class="rounded-lg  hover:bg-gray-200">
                        <td class="text-center text-xs">{{$job->job_id}}</td>
                        <td class="text-center text-xs">{{$job->job_title}}</td>
                        <td class="text-center text-xs">{{count($job->applicants)}}</td>
                        <td class="text-center text-xs">{{$job->status}}</td>
                        <td class="text-center text-xs flex justify-center items-center">
                            <h1 wire:click="showJob('{{$job->job_id}}')" class="cursor-pointer">         
                                                   <svg xmlns="http://www.w3.org/2000/svg" height="16" class="cursor-pointer" viewBox="0 -960 960 960" width="16"><path d="M468-240q-96-5-162-74t-66-166q0-100 70-170t170-70q97 0 166 66t74 162l-84-25q-13-54-56-88.5T480-640q-66 0-113 47t-47 113q0 57 34.5 100t88.5 56l25 84Zm48 158q-9 2-18 2h-18q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v18q0 9-2 18l-78-24v-12q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h12l24 78Zm305 22L650-231 600-80 480-480l400 120-151 50 171 171-79 79Z" /></svg>
                            </h1>
                        </td>
                  </tr>
                @endforeach
            @endif
            </table>

            <div class="mt-5 w-full relative p-2 ">
                @if ($show_job != null)
                <div class="w-full relative flex flex-col justify-center gap-5">
                  
                    <div class="w-full relative flex xsmr:flex-col smr:flex-col">
                        <div class="text-sm flex w-6/12 flex-col xsmr:w-full smr:w-full">
                            <x-label for="job_title" class="font-semibold">Job Title:</x-label>
                            <h1 class="ml-5" id="job_title">{{$show_job->job_title}}</h1>
                        </div>
                        <div class="text-sm flex w-6/12 flex-col xsmr:w-full smr:w-full ">
                            <x-label for="job_responsibilities" class="font-semibold">Hiring Limit:</x-label>
                            <h1 class="ml-5" id="job_responsibilities">{{$show_job->hiring_limit}}</h1>
                        </div>
                    </div>

                    <div class="w-full relative flex flex xsmr:flex-col smr:flex-col">
                        <div class="text-sm flex w-6/12 flex-col xsmr:w-full smr:w-full">
                            <x-label for="job_description" class="font-semibold">Job Description:</x-label>
                            <h1 class="ml-5" id="job_description">{{$show_job->job_description}}</h1>
                        </div>
                        <div class="text-sm flex w-6/12 flex-col xsmr:w-full smr:w-full">
                            <x-label for="job_responsibilities" class="font-semibold">Job Responsibilities:</x-label>
                            <h1 class="ml-5" id="job_responsibilities">{{$show_job->job_responsibilities}}</h1>
                        </div>
                    </div>

                    <div class="w-full relative flex flex xsmr:flex-col smr:flex-col">
                        
                        <div class="text-sm flex w-6/12 flex-col relative xsmr:w-full smr:w-full">
                            <x-label for="job_skills_required" class="font-semibold">Skills Required:</x-label>
                            <h1 class="ml-5" id="job_skills_required">
                                @if ($show_job->job_skills_required != null)
                                    @foreach (explode('-', $show_job->job_skills_required) as $skill)
                                    @if ($skill != null)
                                    <span>*{{$skill}}</span>
                                    @endif
                                    @endforeach
                                @endif
                            </h1>
                        </div>
                        
                       <div class="text-sm flex w-6/12 flex-col xsmr:w-full smr:w-full">
                            <x-label for="job_experienced_required" class="font-semibold">Job Qualifications:</x-label>
                            @if ($show_job->job_qualifications != null)
                                    @foreach (explode('-', $show_job->job_qualifications) as $qualification)
                                        @if ($qualification != null)
                                        <span>*{{$qualification}}</span>
                                        @endif
                                    @endforeach
                                @endif

                        </div>
                       
                    </div>

                    <div class="w-full relative flex flex xsmr:flex-col smr:flex-col">
                        
                        <div class="text-sm flex w-6/12 flex-col xsmr:w-full smr:w-full relative">
                            <x-label for="job_skills_required" class="font-semibold">Hiring Date:</x-label>
                            <h1 class="ml-5" id="job_skills_required">
                                  {{ $show_job->hiring_date }}
                            </h1>
                        </div>
                        
                       <div class="text-sm flex w-6/12 flex-col xsmr:w-full smr:w-ful">
                            <x-label for="job_experienced_required" class="font-semibold">Hiring Closing Date:</x-label>
                            <h1 class="ml-5" id="job_experienced_required"> {{ $show_job->hiring_closing_date }}</h1>
                           
                        </div>
                       
                    </div>
                   
                </div>
                    <div class="w-full relative flex flex-col justify-center items-center mt-5">
                        <div class="w-full relative flex justify-center items-center flex-col">
                            <table class="">
                                <caption class="text-sm w-full font-semibold border rounded-lg uppercase">{{$show_job->job_title}} Applicants</caption>
                                <tr class="rounded-lg ">
                                    <th class="text-xs w-40">ID</th>
                                    <th class="text-xs w-40">Date Application</th>
                                    <th class="text-xs w-40">Name</th>
                                    <th class="text-xs w-40 xsmr:hidden smr:hidden">Email</th>
                                    <th class="text-xs w-40">Resume/CSV</th>
                                    <th class="text-xs w-40">Status</th>
                                    <th class="text-xs w-40">Set Interview</th>
                                </tr>
                                @foreach ($show_job->applicants as $applicant)
                                    <tr class="rounded-lg  hover:bg-gray-200">
                                        <td class="text-center text-xs">{{$applicant->user->id}}</td>
                                        <td class="text-center text-xs">{{$applicant->created_at}}</td>
                                        <td class="text-center text-xs">{{$applicant->user->name}}</td>
                                        <td class="text-center text-xs xsmr:hidden smr:hidden">{{$applicant->user->email}}</td>
                                        <td class="text-center text-xs text-blue-500">
                                            <a href="/user/hrofficer/download/resume/{{$applicant->user->employee_information->resume}}">
                                                {{$applicant->user->employee_information->resume}}
                                            </a>
                                           </td>
                                           <td class="text-center text-xs uppercase">{{$applicant->application_status}}</td>
                                        <td class="text-center flex justify-center items-center text-xs">
                                            @if ($applicant->scheduled == 'done')
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                                                    </span>
                                            @else
                                            <span class="cursor-pointer" wire:click="setInterview({{$applicant->user->id}},'{{$show_job->job_id}}',{{$applicant->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>
                                            </span>

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="w-full relative flex justify-end" wire:poll>
                            @if ($show_job->status != 'On Going')
                            <button class="p-2 m-5 rounded-lg border hover:bg-yellow-green text-xs" wire:click="openJob({{ $show_job->id }})" wire:key="open-job-{{ $show_job->id }}" wire:confirm="Are you sure you want to open this job title?">Open</button>
                            @else
                            <button class="p-2 m-5 rounded-lg border hover:bg-yellow-green text-xs" wire:click="closeJob({{ $show_job->id }})" wire:key="close-job-{{ $show_job->id }}" wire:confirm="Are you sure you want to close this job title?">Close</button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

           @elseif($ats_content == 'ats_postajob')
               <div class="w-full relative flex justify-center items-center mb-5">
                <div class="w-full relative flex justify-center items-center flex-col">
                    <form wire:submit="postAJob" method="POST">
                        @csrf
                        <div class="flex flex-col">
                            <x-label for="job_title"  class="mb-3 mt-3 text-xs ">Job Title:</x-label>
                            <x-input type="text" name="job_title" class="h-8 text-sm xsmr:w-6/12 smr:w-6/12" wire:model="job_title" id="job_title" />
                            @error('job_title')
                                <span class="text-xs text-red-400">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col xsmrw-full">
                            <x-label for="job_description " class="mb-3 mt-3 text-xs ">Job Description:</x-label>
                            <x-input type="text" name="job_description" class="h-8 text-sm" wire:model="job_description" id="job_description" />
                            @error('job_description')
                            <span class="text-xs text-red-400">{{$message}}</span>
                         @enderror
                        </div>
                        <div class="flex flex-col">
                            <x-label for="job_responsibilities"  class="mb-3 mt-3 text-xs ">Job Responsibilities:</x-label>
                            <x-input type="text" name="job_responsibilities" class="h-8 text-sm" wire:model="job_responsibilities" id="job_responsibilities" />
                            @error('job_responsibilities')
                            <span class="text-xs text-red-400">{{$message}}</span>
                         @enderror
                        </div>
                        <div class="flex flex-col ">
                            <x-label for="skill"  class="mb-3 mt-3 text-xs ">Skills:</x-label>
                                <div class="flex relative gap-2 flex-wrap w-64 mb-2">
                                    @if ($job_skills_required != null)
                                        @foreach ($job_skills_required as $job_skill_required)
                                            <span class="text-xs p-1 rounded bg-blue-400">{{$job_skill_required}}</span>
                                        @endforeach
                                    @endif
                                </div>
                            <div class="w-full relative flex gap-3">
                                <x-input type="text" name="skill" class="h-8 text-sm w-10/12" wire:model="skill" id="skill" />
                                <span wire:click="pushSkill" class="flex justify-center cursor-pointer items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></span>
                            </div>
                        </div>
                        <div class="w-full relative flex gap-5">
                            <div class="w-full flex flex-col">
                                <x-label for="job_qualification"  class="mb-3 mt-3 text-xs ">Qualifications:</x-label>
                                <div class="flex relative gap-2 flex-wrap w-64 mb-2">
                                    @if ($job_qualifications_array != null)
                                        @foreach ($job_qualifications_array as $qualification)
                                            <span class="text-xs p-1 rounded bg-blue-400">{{$qualification}}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="w-full relative flex gap-3">
                                    <x-input type="text" name="job_qualification" class="h-8 text-sm w-10/12" wire:model="job_qualification" id="job_qualification" />
                                    <span wire:click="pushQualification" class="flex justify-center cursor-pointer items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></span>
                                </div>
                                @error('job_qualification')
                                <span class="text-xs text-red-400">{{$message}}</span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="w-full relative flex xsmr:flex-col smr:flex-col gap-5">
                            <div class="flex flex-col">
                                <x-label for="job_applicants_limit"  class="mb-3 mt-3 text-xs ">Hiring Limit:</x-label>
                                <x-input type="number" name="job_applicants_limit" class="h-8 text-sm" wire:model="job_applicants_limit" id="job_applicants_limit" />
                                @error('job_applicants_limit')
                                <span class="text-xs text-red-400">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col">
                                <x-label for="job_department"  class="mb-3 mt-3 text-xs ">Job Department:</x-label>
                                 <select name="job_department" class="h-8 rounded border border-gray-200 text-sm" wire:model="job_department" id="job_department" >
                                    <option value=""></option>
                                    <option value="Information Technology">IT DEPARTMENT</option>
                                    <option value="Accounting">ACCOUNTING</option>
                                    <option value="Human Resources">HUMAN RESOURCES</option>
                                    <option value="Marketing">MARKETING</option>
                                    <option value="Finance">FINANCE DEPARTMENT</option>
                                    <option value="Purchasing">PURCHASING</option>
                                    <option value="others">OTHERS</option>
                                </select> 
                                @error('job_department')
                                <span class="text-xs text-red-400">{{$message}}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="w-full relative flex gap-5">
                            <div class="flex flex-col w-full">
                                <x-label for="hiring_date"  class="mb-3 mt-3 text-xs ">Hiring Date:</x-label>
                                <x-input type="date" name="hiring_date" class="h-8 text-sm" wire:model="hiring_date" id="hiring_date" />
                                @error('hiring_date')
                                <span class="text-xs text-red-400">{{$message}}</span>
                                @enderror
                            </div>
    
                            <div class="flex flex-col w-full">
                                <x-label for="hiring_closing_date"  class="mb-3 mt-3 text-xs ">Closing Deadline:</x-label>
                                <x-input type="date" name="hiring_closing_date" class="h-8 text-sm" wire:model="hiring_closing_date" id="hiring_closing_date" />
                                @error('hiring_closing_date')
                                <span class="text-xs text-red-400">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col justify-end mt-5">
                            <x-button type="submit" class="text-center" >post</x-button>
                        </div>
                    </form>
                </div>
               </div>

               @elseif($ats_content == 'ats_interviewee')
                <div class="w-full realtive flex flex-col justify-center mb-5">
                    <table class=" border-black w-full">
                        <caption class="border font-semibold">INITIAL INTERVIEW</caption>
                        <tr class=" rounded-lg">
                            <th class="text-xs w-24 ">NAME</th>
                            <th class="text-xs w-24 xsmr:hidden smr:hidden">EMAIL</th>
                            <th class="text-xs w-24">JOB POSITION</th>
                            <th class="text-xs w-16 xsmr:hidden smr:hidden">TIME</th>
                            <th class="text-xs w-24">DATE</th>
                            <th class="text-xs w-24">SET EXAMINATION</th>
                            <th class="text-xs w-16">FAILED</th>
                        </tr>
                        @if ($interviewees != null)
                            @foreach ($interviewees as $interviewee)
                               @if ($interviewee->user->role == 0)
                                        @if ($interviewee->interview_type == 'initial' && $interviewee->status == null) 
                                        <tr class="hover:bg-gray-200  rounded-lg">
                                            <td class="text-xs text-center">{{$interviewee->user->name}}</td>
                                            <td class="text-xs text-center xsmr:hidden smr:hidden">{{$interviewee->user->email}}</td>
                                            <td class="text-xs text-center">{{$interviewee->job->job_title}}</td>
                                            <td class="text-xs text-center xsmr:hidden smr:hidden"> {{$interviewee->time}}</td>
                                            <td class="text-xs text-center">{{$interviewee->date}}</td>
                                            <td class="text-xs text-center relative flex justify-center items-center" wire:click="showExaminationModal({{$interviewee->id}})" wire:key="examination-examination-{{$interviewee->id}}" >
                                                <span class="cursor-pointer w-full flex justify-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>
                                                </span>
                                            </td>
                                            
                                            <td class="text-xs text-center" >
                                                <span class="cursor-pointer w-full flex justify-center text-center" wire:click="fail_initial_interview({{$interviewee->id}})" wire:confirm="Are you sure you want to failed this applicant?">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                       @endif
                                    @endforeach
                               @endif
                    </table>

                    <table class=" border-black w-full mt-10">
                        <caption class="border font-semibold">EXAMINATION</caption>
                        <tr class=" rounded-lg">
                            <th class="text-xs w-24 ">NAME</th>
                            <th class="text-xs w-24 xsmr:hidden smr:hidden ">EMAIL</th>
                            <th class="text-xs w-24">JOB POSITION</th>
                            <th class="text-xs w-16 xsmr:hidden smr:hidden">TIME</th>
                            <th class="text-xs w-24">DATE</th>
                            <th class="text-xs w-24">SET FINAL INTERVIEW</th>
                            <th class="text-xs w-16">FAILED</th>
                        </tr>
                        @if ($interviewees != null)
                            @foreach ($interviewees as $interviewee)
                               @if ($interviewee->user->role == 0)
                                        @if ($interviewee->interview_type == 'examination' && $interviewee->status == null) 
                                        <tr class="hover:bg-gray-200  rounded-lg">
                                            <td class="text-xs text-center">{{$interviewee->user->name}}</td>
                                            <td class="text-xs text-center xsmr:hidden smr:hidden">{{$interviewee->user->email}}</td>
                                            <td class="text-xs text-center">{{$interviewee->job->job_title}}</td>
                                            <td class="text-xs text-center xsmr:hidden smr:hidden"> {{$interviewee->time}}</td>
                                            <td class="text-xs text-center">{{$interviewee->date}}</td>
                                            <td class="text-xs text-center relative flex justify-center items-center" wire:click="showFinalInterviewModal({{$interviewee->id}})" wire:key="final-interview-{{$interviewee->id}}" >
                                                <span class="cursor-pointer w-full flex justify-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>
                                                </span>
                                            </td>
                                            <td class="text-xs text-center" >
                                                <span class="cursor-pointer w-full flex justify-center text-center" wire:click="fail_examination({{$interviewee->id}})" wire:confirm="Are you sure you want to failed this applicant?">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 -960 960 960" width="16"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                       @endif
                                    @endforeach
                               @endif
                    </table>

                    <table class=" mt-10">
                        <caption class="border font-semibold">FINAL INTERVIEW</caption>
                        <tr class=" rounded-lg ">
                            <th class="text-xs w-24 ">NAME</th>
                            <th class="text-xs w-24 xsmr:hidden smr:hidden">EMAIL</th>
                            <th class="text-xs w-24">JOB POSITION</th>
                            <th class="text-xs w-24 xsmr:hidden smr:hidden">TIME</th>
                            <th class="text-xs w-24">DATE</th>
                            <th class="text-xs w-24">RESULT</th>
                        </tr>
                        @if ($interviewees != null)
                            @foreach ($interviewees as $interviewee)
                              @if ($interviewee->user->role == 0)
                                    @if ($interviewee->interview_type == 'final' && $interviewee->status == null)
                                    <tr class=" rounded-lg hover:bg-gray-200">
                                        <td class="text-xs text-center">{{$interviewee->user->name}}</td>
                                        <td class="text-xs text-center xsmr:hidden smr:hidden">{{$interviewee->user->email}}</td>
                                        <td class="text-xs text-center">{{$interviewee->job->job_title}}</td>
                                        <td class="text-xs text-center xsmr:hidden smr:hidden"> {{$interviewee->time}}</td>
                                        <td class="text-xs text-center">{{$interviewee->date}}</td>
                                        <td class="text-xs text-center"><span wire:click="MakefinalInterviewResult({{$interviewee->id}})" wire:key="MakefinalInterviewResult-{{$interviewee->id}}" class="flex justify-center items-center cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" class="cursor-pointer" viewBox="0 -960 960 960" width="16"><path d="M468-240q-96-5-162-74t-66-166q0-100 70-170t170-70q97 0 166 66t74 162l-84-25q-13-54-56-88.5T480-640q-66 0-113 47t-47 113q0 57 34.5 100t88.5 56l25 84Zm48 158q-9 2-18 2h-18q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v18q0 9-2 18l-78-24v-12q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h12l24 78Zm305 22L650-231 600-80 480-480l400 120-151 50 171 171-79 79Z" /></svg>
                                        </span></td>
                                    </tr>
                                    @endif
                                    @endif

                                @endforeach
                                    @endif
                    </table>

                    <div class="w-full relative flex justify-end mt-10">
                        <button type="submit" wire:click="wordInterviewModal" class="text-xs hover:bg-yellow-green rounded-lg p-2 border">Download Interviews</button>
                    </div>
                </div>
                @elseif($ats_content == 'ats_shortlisted')
                    <div class="w-full realtive flex flex-col justify-center mb-5 ">
                        <div class="w-full  relative flex justify-center items-center flex-col gap-10 flex-col">
                            @foreach ($jobs as $job)
                                @if ($job->status == 'On Going')
                                <table class="w-full relative">
                                    <caption class="border text-sm uppercase">{{$job->job_title}}</caption>
                                    <tr class="rounded-lg rounded-lg ">
                                        <th class="text-xs w-32">Application ID</th>
                                        <th class="text-xs w-32">Name</th>
                                        <th class="text-xs w-32 xsmr:hidden smr:hidden">Email</th>
                                        <th class="text-xs w-32 xsmr:hidden smr:hidden">Final Interview</th> 
                                        <th class="text-xs w-32">Status</th> 
                                        <th class="text-xs w-32">Action</th> 
                                    </tr>
                                        @foreach ($job->shortlisteds as $data)
                                           @if ($data->user->role == 0)
                                           <tr class="hover:bg-gray-200">
                                            <td class="text-xs text-center w-32">{{$data->application_id}}</td>
                                            <td class="text-xs text-center w-32">{{$data->user->name}}</td>
                                            <td class="text-xs text-center w-32 xsmr:hidden smr:hidden">{{$data->user->email}}</td>
                                            <td class="text-xs text-center w-32 xsmr:hidden smr:hidden">{{$data->date}}</td>
                                            <td class="text-xs text-center w-32">{{$data->status}}</td>
                                            <td class="text-xs text-center w-32">
                                                    <button class="p-1 rounded-lg border bg-yellow-green text-xs" wire:click="hire({{ $data->user_id }}, '{{ $job->job_title }}', '{{ $job->job_id }}', {{ $data->id }})" wire:key="hire-{{ $data->user_id }}">Hire</button>
                                            </td>
                                        </tr>
                                           @endif
                                        @endforeach
                                </table>
                                @endif
                            @endforeach
                        </div>
                    </div>
           @endif
        </div>
    </div>
<x-modal wire:model='showWordInterviewModal'>
    <div class="w-full relative flex justify-center items-center">
        <div class="w-full mt-10 mb-10 relative p-10  gap-5 flex flex-col justify-center  flex-col bg-whitey rounded">
            <form wire:submit='downloadInterviews' method="POST">
                <div class="w-11/12 relative">
                    <h1 class="font-bold">Download Interviews</h1>
                </div>
                <div class="w-full relative flex mt-5 gap-5 mb-5 ">
                    <div class="w-6/12 flex flex-col">
                        <label for="interview_from_date" class="font-semibold">From:</label>
                        <input type="date" name="interview_from_date" class="rounded w-full border border-gray-200" id="interview_from_date" wire:model='interview_from_date'>
                        @error('interview_from_date')
                            <span class="text-xs text-red-200 ">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-6/12 flex flex-col">
                        <label for="interview_to_date" class="font-semibold">To:</label>
                        <input type="date" name="interview_to_date" class="rounded w-full border border-gray-200" id="interview_to_date" wire:model='interview_to_date'>
                        @error('interview_to_date')
                            <span class="text-xs text-red-200 text-wrap">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-6/12 flex mt-5 mb-5">
                    <x-button type="submit" >Submit</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>
    <x-modal wire:model="showHireModal">
        <div class="w-full relative flex rounded justify-center items-center flex-col">
            <div class="w-10/12 bg-whitey rounded p-5 relative flex flex-col m-10">
            <form wire:submit="hired" method="POST">
                @csrf
                <div class="flex flex-col m-5">
                    @if ($hire_user != null)
                    <x-label>Applicant Name:</x-label>
                    <h1 class=" font-semibold">{{$hire_user->name}}</h1>
                    <x-label>Position:</x-label>
                    <h1 class=" font-semibold">{{$position}}</h1>
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
                    <x-input wire:model="deployment_date" type="date" name="deployment_date" id="deployment_date" />
                    @error('deployment_date')
                    <p class="p-1 rounded text-red-400 text-xs text-center">{{$message}}</p>
                   @enderror
                </div>
                <div class="flex flex-col m-5">
                    <x-button tyoe="submit" class="w-full">Hire</x-button>
                </div>
            </form>
            </div>
        </div>
    </x-modal>    

    <x-modal wire:model="setInitialInterviewModal" >
        <div class="w-full relative flex ">
            <div class="w-10/12 m-10 bg-whitey rounded p-5 rounded flex justify-center flex-col relative ">
                <form wire:submit="initialInterview" method="POST">
                    @csrf
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col">
                        <div class="w-full mt-3 mb-5">
                            <h1 class="font-semibold text-center text-lg">
                                Initial Interview Schedule
                            </h1>
                        </div>
                        <label for="time">Time:</label>
                            <select name="time" wire:model="time" class="w-10/12 rounded relative" id="time">
                                <option class="w-10/12" value=""></option>
                                <option class="w-10/12" value="8">8</option>
                                <option class="w-10/12" value="9">9</option>
                                <option class="w-10/12" value="10">10</option>
                                <option class="w-10/12" value="11">11</option>
                                <option class="w-10/12" value="12">12</option>
                                <option class="w-10/12" value="1">1</option>
                                <option class="w-10/12" value="2">2</option>
                                <option class="w-10/12" value="3">3</option>
                                <option class="w-10/12" value="4">4</option>
                            </select>
                        <div class="flex w-full justify-center items-center relative gap-5 mt-5">
                           <span> <x-input type="radio" name="a" wire:model="a" id="am" value="AM"  />
                            <x-label class="p-1 rounded text-sm cursor-pointer  {{$a == 'AM' ? 'bg-green-200' : ''}}" for="am">AM</x-label></span>
                            <span>
                                <x-input type="radio" name="a" wire:model="a" id="pm" value="PM" class="" />
                                <x-label class="p-1 rounded text-sm cursor-pointer  {{$a == 'PM' ? 'bg-red-200' : ''}}" for="pm">PM</x-label>
                            </span>
                            @error('a')
                                {{$message}}
                            @enderror
                            @error('time')
                                {{$message}}
                            @enderror
                            @error('date')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col mt-5">
                        <label for="date">Date:</label>
                        <input type="date" class="w-10/12 rounded" wire:model="date" name="date" id="date
                        " class="w-full" />
                    </div>
                    <div class="flex w-10/12 ml-10 justify-center items-center flex-col mt-5">
                        <x-button type="submit" class="w-10/12 ">save</x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>

    <x-modal wire:model="finalInterviewModal">
        <div class="w-full relative ">
            <div class="w-10/12 m-10 bg-whitey  p-5 rounded flex justify-center flex-col relative "">
                <form wire:submit="finalInterview" method="POST">
                    @csrf
                    
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col mt-5">
                        <div class="w-full mt-3 mb-5">
                            <h1 class="font-semibold text-lg">
                                Final Interview Schedule
                            </h1>
                        </div>
                        <label for="time">Time:</label>
                            <select name="time" wire:model="time" class="w-10/12 rounded relative" id="time">
                                <option value=""></option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        <div class="flex w-full justify-center items-center relative gap-5 mt-5">
                           <span> <x-input type="radio" name="a" wire:model="a" id="am" value="AM"  />
                            <x-label class="p-1 rounded text-sm cursor-pointer  {{$a == 'AM' ? 'bg-green-200' : ''}}" for="am">AM</x-label></span>
                            <span>
                                <x-input type="radio" name="a" wire:model="a" id="pm" value="PM" class="" />
                                <x-label class="p-1 rounded text-sm cursor-pointer  {{$a == 'PM' ? 'bg-red-200' : ''}}" for="pm">PM</x-label>
                            </span>
                            @error('a')
                                {{$message}}
                            @enderror
                            @error('time')
                                {{$message}}
                            @enderror
                            @error('date')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col mt-5">
                        <label for="date">Date:</label>
                        <input type="date" wire:model="date"  class="w-10/12 rounded" name="date" id="date
                        " class="w-full" />
                    </div>
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col mt-5">
                        <x-button type="submit"  class="w-10/12 rounded">save</x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
    <x-modal wire:model="showExamination">
        <div class="w-full relative ">
            <div class="w-10/12 m-10 bg-whitey  p-5 rounded flex justify-center flex-col relative "">
                <form wire:submit="setExamination" method="POST">
                    @csrf
                    
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col mt-5">
                        <div class="w-full mt-3 mb-5">
                            <h1 class="font-semibold text-lg">
                               Examination Schedule
                            </h1>
                        </div>
                        <label for="exam_time">Time:</label>
                            <select name="exam_time" wire:model="exam_time" class="w-10/12 rounded relative" id="exam_time">
                                <option value=""></option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        <div class="flex w-full justify-center items-center relative gap-5 mt-5">
                           <span> <x-input type="radio" name="a" wire:model="exam_a" id="am" value="AM"  />
                            <x-label class="p-1 rounded text-sm cursor-pointer  {{$exam_a == 'AM' ? 'bg-green-200' : ''}}" for="am">AM</x-label></span>
                            <span>
                                <x-input type="radio" name="a" wire:model="exam_a" id="pm" value="PM" class="" />
                                <x-label class="p-1 rounded text-sm cursor-pointer  {{$exam_a == 'PM' ? 'bg-red-200' : ''}}" for="pm">PM</x-label>
                            </span>
                            @error('a')
                                {{$message}}
                            @enderror
                            @error('time')
                                {{$message}}
                            @enderror
                            @error('date')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col mt-5">
                        <label for="exam_date">Date:</label>
                        <input type="date" wire:model="exam_date"  class="w-10/12 rounded" name="exam_date" id="exam_date
                        " class="w-full" />
                    </div>
                    <div class="flex w-10/12 ml-10 justify-center items-center relative flex-col mt-5">
                        <x-button type="submit"  class="w-10/12 rounded">save</x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
<x-modal wire:model="MakefinalInterviewResultModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-10/12 flex bg-whitey flex-col justify-center rounded items-center relative relative mt-10 mb-10 border">
            <form wire:submit="finalInterviewResult" method="POST">
                @csrf
                <div class="w-full mt-3 mb-5">
                    <h1 class="font-semibold text-lg">
                        Final Interview Result
                    </h1>
                </div>
                <div class="mt-3 w-full mb-5">
                    <h1 class="uppercase">Job Title:</h1>
                    <x-label  class="font-semibold pl-5 uppercase">{{$finalInterviewresultJobtitle }}</x-label>
                    <h1 class="uppercase">Applicant:</h1>
                    <x-label  class="font-semibold pl-5 uppercase">{{$finalInterviewresultApplicantName}}</x-label>
                </div>
                <div class="relative mt-3 mb-5 w-full flex gap-5">
                    <div class="w-full flex gap-2">
                        <x-label for="pass" class="cursor-pointer font-semibold">Pass</x-label>
                        <x-input type="radio" wire:model="result" class="cursor-pointer" name="result" id="pass" value="pass" />
                    </div>
                    <div class="flex w-full gap-2">
                        <x-label for="fail" class="font-semibold cursor-pointer">Fail</x-label>
                        <x-input type="radio" wire:model="result" class="cursor-pointer" name="result" id="fail" value="fail" />
                    </div>
                </div>
                <div class="mt-3 w-full mb-5">
                    <x-button typ="submit">Save result</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

</div>