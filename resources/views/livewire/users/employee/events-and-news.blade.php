<div class="w-11/12 relative flex justify-center m-5 flex-col">
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
    <div class="w-full relative  bg-white rounded flex flex-col mb-5">
        @if (count($events_happening_now) > 0)
        <div class="flex justify-between w-11/12 m-5 relative">
            <div class="">
                <h1>Happening Now!</h1>
            </div>

        </div>
        <div class="w-full relative flex flex-col" wire:poll>
            <div class="w-full relative m-5">
                <h1 class="font-semibold uppercase">Events</h1>
            </div>
            @foreach ($events_happening_now as $event)
                <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5 {{ $content == 'event_happening_now' || $event->id == $parameter_id ? 'border border-black border-2' : ''}}">
                    <h1 class="text-sm font-semibold">What: {{$event->event_name}}</h1>
                    <h1 class="text-sm font-semibold">When: {{$event->when}}</h1>
                    <h1 class="text-sm font-semibold">Where: {{$event->where}}</h1>
                    <p class="indent-5">
                        {{$event->description}}
                    </p>
                </div>
            @endforeach
        </div>
        @endif

        <div class="w-full relative flex flex-col" wire:poll>
           @if (count($announcement_happening_now) > 0)
           <div class="w-full relative m-5">
            <h1 class="font-semibold uppercase">Announcements</h1>
        </div>
        @foreach ($announcement_happening_now as $announcement)
            <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5 {{ $content == 'announcement_happening_now' || $announcement->id == $parameter_id ? 'border border-black border-2' : ''}}">
                <h1 class="text-sm font-semibold">What: {{$announcement->announcement_name}}</h1>
                <h1 class="text-sm font-semibold">When: {{$announcement->when}}</h1>
                <p class="indent-5">
                    {{$announcement->description}}
                </p>
            </div>
        @endforeach
           @endif
        </div>
    </div>

<div class="w-full relative  bg-white rounded flex flex-col mb-5">
 @if (count($incomming_events) > 0)
        <div class="w-full relative m-5">
        <h1>Incoming Events and Announcements</h1>
    </div>
        <div class="w-full relative flex flex-col" wire:poll>
            <div class="w-full relative m-5">
                <h1 class="font-semibold uppercase">Events</h1>
            </div>
            @foreach ($incomming_events as $incomming_event)
            <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5 {{ $content == 'event' && $incomming_event->id == $parameter_id ? 'border border-2 border-black' : '' }}">
                <h1 class="text-sm font-semibold">What: {{$incomming_event->event_name}}</h1>
                <h1 class="text-sm font-semibold">When: {{$incomming_event->when}}</h1>
                <h1 class="text-sm font-semibold">Where: {{$incomming_event->where}}</h1>
                <p class="indent-5">
                    {{$incomming_event->description}}
                </p>
            </div>
            @endforeach
        </div>
    @endif

    @if (count($incomming_announcements) > 0)
        <div class="w-full relative flex flex-col" wire:poll>
            <div class="w-full relative m-5">
                <h1 class="font-semibold uppercase">Announcements</h1>
            </div>
            @foreach ($incomming_announcements as $incomming_announcement)
            <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5  {{ $content == 'announcement' && $incomming_announcement->id == $parameter_id ? 'border border-2 border-black' : '' }}">
                <h1 class="text-sm font-semibold">What: {{$incomming_announcement->announcement_name}}</h1>
                <h1 class="text-sm font-semibold">When: {{$incomming_announcement->when}}</h1>
                <p class="indent-5">
                    {{$incomming_announcement->description}}
                </p>
            </div>
            @endforeach
        </div>
    @endif
</div>

<div class="w-full relative  bg-white rounded flex flex-col mb-5">
   @if (count($past_events) > 0 && count($past_announcements) > 0)
        <div class="w-full relative m-5">
        <h1>Past Events and Announcements</h1>
        </div>
   @endif
 @if (count($past_events) > 0)
        <div class="w-full relative flex flex-col" wire:poll>
            <div class="w-full relative m-5">
                <h1 class="font-semibold uppercase">Events</h1>
            </div>
            @foreach ($past_events as $past_event)
            <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5">
                <h1 class="text-sm font-semibold">What: {{$past_event->event_name}}</h1>
                <h1 class="text-sm font-semibold">When: {{$past_event->when}}</h1>
                <h1 class="text-sm font-semibold">Where: {{$past_event->where}}</h1>
                <h1 class="text-sm font-semibold">Where: {{$past_event->where}}</h1>

                <p class="indent-5">
                    {{$past_event->description}}
                </p>
            </div>
            @endforeach
        </div>
    @endif

    @if (count($past_announcements) > 0)
    <div class="w-full relative flex flex-col" wire:poll>
        <div class="w-full relative m-5">
            <h1 class="font-semibold uppercase">Announcements</h1>
        </div>
        @foreach ($past_announcements as $past_announcement)
        <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5">
            <h1 class="text-sm font-semibold">What: {{$past_announcement->announcement_name}}</h1>
            <h1 class="text-sm font-semibold">When: {{$past_announcement->when}}</h1>
            <p class="indent-5">
                {{$past_announcement->description}}
            </p>
        </div>
        @endforeach
    </div>
@endif

</div>



</div>