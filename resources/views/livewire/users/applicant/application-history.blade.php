<div class="w-full relative flex justify-center items-center flex-col">
    <div class="w-10/12 relative flex flex-col justify-center items-center gap-10 mt-10">
        <div class="w-9/12 rounded bg-white relative flex flex-col justify-center">
            <h1 class="p-3 font-semibold">Application History</h1>
        </div>
        @foreach ($applications as $application)
            <div class="w-9/12 rounded bg-white relative flex flex-col justify-center mb-5">
                <div class="m-3 flex justify-between">
                    <h1 class="font-semibold"><span>{{$application->job->job_title}}</span></h1>
                    <h1 class="text-xs uppercase font-semibold" >{{$application->application_status}}</h1>
                </div>
                <div class="flex w-full relative gap-10">
                    <div class="w-full flex">
                    @foreach ($application->interviews as $interview)
                        <div class="m-3">
                            <h1><span class="uppercase font-semibold">{{$interview->interview_type}}:</span> <span>{{$interview->date}} - ({{$interview->time}}) <span class="uppercase">{{ $interview->status }}</span></span></h1>
                        </div>
                    @endforeach
                </div>
                    <div class="flex mr-5 flex justify-center items-center cursor" >
                       @if ($more == $application->id)
                           <span class="cursor-pointer" wire:click="hide" wire:key="off-{{$application->id}}"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m296-345-56-56 240-240 240 240-56 56-184-184-184 184Z"/></svg></span>
                        @else
                        <span class="cursor-pointer" wire:click="seeMore({{$application->id}})" wire:key="seemore-{{$application->id}}"> <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-345 240-585l56-56 184 184 184-184 56 56-240 240Z"/></svg></span>
                       @endif
                    </div>
                </div>
                
                @if ($more == $application->id)
                    <div class="w-full relative flex flex-col justify-center">
                        <div class="m-3">
                            <h1 class="text-xs">Job Description: <span class="font-semibold">{{$application->job->job_description}}</span></h1>
                        </div>
                        <div class="m-3">
                            <h1 class="text-xs">Job Responsibilities: <span class="font-semibold">{{$application->job->job_responsibilities}}</span></h1>
                        </div>
                        <div class="m-3">
                            <h1 class="text-xs font-semibold indent-2 flex flex-col gap-3">Job Skills Required: @if ($application->job->job_skills_required != null)
                                @foreach (explode('-',$application->job->job_skills_required) as $key => $skill)
                                    @if (count(explode('-',$application->job->job_skills_required)) - $key == 1)
                                        <span class="font-semibold indent-2 flex flex-col gap-3">
                                            {{$skill}}
                                        </span>
                                    @else
                                        <span class="font-semibold indent-2 flex flex-col gap-3">
                                            *{{$skill}}
                                        </span>
                                    @endif
                                @endforeach
                            @endif</h1>
                        </div>
                        <div class="m-3">
                            <h1 class="text-xs font-semibold flex flex-col gap-3">Job Qualifications: 
                                @if ($application->job->job_qualifications != null)
                                    @foreach (explode('-',$application->job->job_qualifications) as $key => $qualification)
                                        @if (count(explode('-',$application->job->job_qualifications)) - $key == 1)
                                            <span class="font-semibold indent-2 flex flex-col gap-3">
                                                {{$qualification}}
                                            </span>
                                        @else
                                            <span class="font-semibold indent-2 flex flex-col gap-3">
                                                *{{$qualification}}
                                            </span>
                                        @endif
                                    @endforeach
                                @endif</h1>
                        </div>
                    </div>
                @endif
                <div class="w-full relative flex justify-end items-center">
                    @if ($application->application_status != 'application canceled')
                                @if($application->application_status == 'pending' )
                                <x-button class="mr-3 mb-3" wire:click="cancelApplication({{$application->id}}, '{{$application->job->job_id}}')" wire:key="cancelApplication-{{$application->id}}" >Cancel Application</x-button>
                                @endif
                    @else
                            <x-button class="mr-3 mt-3 mb-3">Canceled</x-button>
                   @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
