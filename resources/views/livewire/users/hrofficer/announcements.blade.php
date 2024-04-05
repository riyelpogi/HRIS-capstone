<div class="w-11/12  relative flex justify-center m-5 flex-col">
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
        <div class="flex justify-between w-11/12 m-5 relative">
            <div class="">
                <h1>Happening Now!</h1>
            </div>
            <div class="">
                <x-button wire:click="showModal">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M450-200v-250H200v-60h250v-250h60v250h250v60H510v250h-60Z"/></svg></x-button>
            </div>
        </div>
        <div class="w-full relative flex flex-col" wire:poll>
            <div class="w-full relative m-5">
                <h1 class="font-semibold uppercase">Events</h1>
            </div>
            @foreach ($events_happening_now as $event)
                <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5">
                    <h1 class="text-sm font-semibold">What: {{$event->event_name}}</h1>
                    <h1 class="text-sm font-semibold">When: {{$event->when}}</h1>
                    <h1 class="text-sm font-semibold">Where: {{$event->where}}</h1>
                    <p class="indent-5">
                        {{$event->description}}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="w-full relative flex flex-col" wire:poll>
            <div class="w-full relative m-5">
                <h1 class="font-semibold uppercase">Announcements</h1>
            </div>
            @foreach ($announcement_happening_now as $announcement)
                <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5">
                    <h1 class="text-sm font-semibold">What: {{$announcement->announcement_name}}</h1>
                    <h1 class="text-sm font-semibold">When: {{$announcement->when}}</h1>
                    <p class="indent-5">
                        {{$announcement->description}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

<div class="w-full relative  bg-white rounded flex flex-col mb-5">
    <div class="w-full relative m-5">
        <h1>Incoming Events and Announcements</h1>
    </div>
 @if (count($incomming_events) > 0)
        <div class="w-full relative flex flex-col" wire:poll>
            <div class="w-full relative m-5">
                <h1 class="font-semibold uppercase">Events</h1>
            </div>
            @foreach ($incomming_events as $incomming_event)
            <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5">
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
            <div class="w-11/12 rounded relative flex flex-col ml-5 mb-5 border p-5">
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
    <div class="w-full relative m-5">
        <h1>Past Events and Announcements</h1>
    </div>
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

<x-modal wire:model="addModal">
   
        <div class="w-full relative bg-whitey rounded p-5 flex justify-center items-center flex-col">
            <div class="w-full flex justify-center items-center m-3 gap-5">
                <button wire:click="events" class="p-2 border rounded-lg text-xs cursor-pointer {{$addModalContent == 'events' ? 'bg-yellow-green' : ''}} ">Event</button>
                <button wire:click="announcements" class="p-2 border text-xs rounded-lg cursor-pointer {{$addModalContent == 'announcements' ? 'bg-yellow-green' : ''}} ">Announcements</button>
            </div>
            @if ($addModalContent == 'events')
            <div class="w-full flex flex-col justify-center items-center">
                <div class="w-full relative text-green-400">
                    <p class="text-xs text-center">
                        {{$events_saved_success}}
                    </p>
                </div>
                <form wire:submit="saveEvents" method="POST">
                    @csrf
                    <div class="w-11/12 relative flex flex-col mt-3 mb-3">
                        <x-label for="event_name">Event Name:</x-label>
                        <x-input type="text" name="event_name" wire:model="event_name" id="event_name" />
                        @error('event_name')
                            <p class="text-red-200 text-xs">
                                {{$message}}
                            </p>
                        @enderror
                    </div>
                    <div class="w-11/12 relative flex flex-col  mt-3 mb-3">
                        <x-label for="description">Event Description:</x-label>
                        <textarea name="description" class="border text-xs" id="description" wire:model="description" cols="30" rows="5"></textarea>
                        @error('description')
                        <p class="text-red-200 text-xs">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                    <div class="w-11/12 relative flex flex-col  mt-3 mb-3">
                        <x-label for="when">When:</x-label>
                        <x-input type="date" name="when" wire:model="when" id="when" />
                        @error('when')
                        <p class="text-red-200 text-xs">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                    <div class="w-11/12 relative flex flex-col  mt-3 mb-3">
                        <x-label for="where">Where:</x-label>
                        <x-input type="text" name="where" wire:model="where" id="where" />
                        @error('where')
                        <p class="text-red-200 text-xs">
                            {{$message}}
                        </p>
                        @enderror
                    </div>
                    <div class="w-11/12 relative flex justify-end flex-col  mt-5 mb-3">
                        <x-button type="submit">Save</x-button>
                    </div>
                </form>
            </div>
        </div>
   
       
        @elseif($addModalContent == 'announcements')
        <div class="w-full p-5 relative flex flex-col justify-center items-center">
            <div class="w-full relative text-green-400">
                <p class="text-xs text-center">
                    {{$announcement_saved_success}}
                </p>
            </div>
            <form wire:submit="saveAnnouncement" method="POST">
                @csrf
                <div class="w-11/12 relative flex flex-col mt-3 mb-3">
                    <x-label for="announcement_name">Announcement Name:</x-label>
                    <x-input type="text" name="announcement_name" wire:model="announcement_name" id="event_name" />
                    @error('announcement_name')
                    <p class="text-red-200 text-xs">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="w-11/12 relative flex flex-col mt-3 mb-3">
                    <x-label for="announcement_description">Announcement Description:</x-label>
                    <textarea name="announcement_description" class="border text-xs" id="announcement_description" wire:model="announcement_description" cols="30" rows="5"></textarea>
                    @error('announcement_description')
                    <p class="text-red-200 text-xs">
                        {{$message}}
                    </p>
                    @enderror
                </div>
                <div class="w-11/12 relative flex flex-col  mt-3 mb-3">
                    <x-label for="announcement_when">When:</x-label>
                    <x-input type="date" name="announcement_when" wire:model="announcement_when" id="when" />
                    @error('announcement_when')
                    <p class="text-red-200 text-xs">
                        {{$message}}
                    </p>
                    @enderror
                </div>

                <div class="w-11/12 relative flex justify-end flex-col  mt-5 mb-3">
                    <x-button type="submit">Save</x-button>
                </div>
            </form>
        </div>
        @endif
</x-modal>

</div>