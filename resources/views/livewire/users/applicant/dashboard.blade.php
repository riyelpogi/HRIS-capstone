<div class="w-full relative flex flex-col justify-center items-center"> 
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
    <div class="w-10/12 mt-5 relative z-10 flex justify-center items-center flex-col" wire:poll>
        <div class="w-full relative flex justify-center items-center gap-5">
            <input type="text" wire:model.live.debounce.1000ms='search' class="text-xs w-6/12 border border-gray-200 rounded-full pl-5" placeholder="Search jobs here" id="search" name="search">
        </div>
        <div class="w-full relative mt-5 smr:gap-2 flex smr:flex-wrap xsmr:flex-wrap justify-center items-center gap-5">
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'ALL' ? 'bg-yellow-green' : '' }}" wire:click='showAllJobs' >ALL</button>
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'INFORMATION TECHNOLOGY' ? 'bg-yellow-green' : '' }}" wire:click='showItJobs' >INFORMATION TECHNOLOGY</button>
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'ACCOUNTING' ? 'bg-yellow-green' : '' }}" wire:click='showAccJobs' >ACCOUNTING</button>
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'HUMAN RESOURCES' ? 'bg-yellow-green' : '' }}" wire:click='showHrJobs' >HUMAN RESOURCES</button>
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'MARKETING' ? 'bg-yellow-green' : '' }}" wire:click='showMarketingJobs' >MARKETING</button>
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'FINANCE DEPARTMENT' ? 'bg-yellow-green' : '' }}" wire:click='showFinanceJobs' >FINANCE DEPARTMENT</button>
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'PURCHASING' ? 'bg-yellow-green' : '' }}" wire:click='showPurchasingJobs' >PURCHASING</button>
            <button class="text-xs border p-3 rounded-lg hover:bg-yellow-green {{ $job_content == 'OTHERS' ? 'bg-yellow-green' : '' }}" wire:click='showOthersJobs' >OTHERS</button>
        </div>
        @foreach ($jobs as $job)
            <div class="w-10/12 m-5 relative bg-whitey rounded flex flex-col" wire:key="job-{{$job->job_id}}">
                <div class="m-3 w-full flex justify-between items-center">
                    <div class="">
                        <x-label class="font-semibold">Job Title:</x-label>
                    <h1 class="font-semibold">{{$job->job_title}}@foreach ( explode('/', $job->hiring_limit) as $key => $limit)
                        @if ($key == 1)
                            ({{ $limit }})
                        @endif
                    @endforeach</h1>
                    <p class="text-xs mt-2 font-semibold">Hiring Date:&nbsp;{{ $job->hiring_date }} - {{ $job->hiring_closing_date }}</p>

                    </div>

                    <div class="flex mr-5 justify-between items-center cursor-pointer hover:bg-gray-200 p-3" wire:click="expand('{{$job->job_id}}')" wire:key="jobkey-{{$job->job_id}}">
                        <span>
                            @if ($more == $job->job_id)
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m296-345-56-56 240-240 240 240-56 56-184-184-184 184Z"/></svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-345 240-585l56-56 184 184 184-184 56 56-240 240Z"/></svg>    
                            @endif
                        </span>
                    </div>
                </div>
                
                <div class="w-full relative flex flex-col justify-center mt-3 mb-3">
                   
                    @if ($more == $job->job_id)
                    <div class="m-3">
                        <x-label class="font-semibold">Job Description:</x-label>
                        <h1 class=" text-xs">{{$job->job_description}}</h1>
                        
                    </div>
                    <div class="m-3">
                        <x-label class="font-semibold">Job Responsibilities:</x-label>
                        <h1 class=" text-xs">{{$job->job_responsibilities}}</h1>
                    </div>
                        <div class="m-3 "> 
                            <x-label class="font-semibold">Skills Required:</x-label>
                            <h1 class="flex flex-col ml-5 text-xs">
                                @foreach (explode('-', $job->job_skills_required) as $skill)
                                    @if ($skill != null)
                                    <span class="italic">*{{$skill}}</span>
                                    @endif
                                @endforeach
                            </h1>
                        </div>
                        <div class="m-3 "> 
                            <x-label class="font-semibold">Job Qualifications:</x-label>
                            <h1 class="flex flex-col ml-5 text-xs">
                                @foreach (explode('-', $job->job_qualifications) as $qualification)
                                    @if ($qualification != null)
                                    <span class="italic">*{{$qualification}}</span>
                                    @endif
                                @endforeach
                            </h1>
                        </div>
                    @endif
                </div>
                <div class="w-full relative flex justify-end">
                    @if (auth()->user())
                        @if (in_array(auth()->user()->id, explode('-', $job->job_applicants)))
                            <x-button class="mr-5 mb-5">Applied</x-button>
                            @else
                            <x-button class="mr-5 mb-5" wire:click="apply('{{$job->job_id}}',{{auth()->user()->id}})">Apply Now</x-button>
                        @endif
                    @else
                        <x-button class="mr-5 mb-5" wire:click="loginFirst">Apply Now</x-button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
