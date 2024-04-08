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
    <div class="w-full relative  bg-white rounded flex justify-between items-center  p-4">
        <div class="flex gap-5">
             <button class="p-2 rounded-lg hover:bg-yellow-green border text-xs ml-5 {{ $training_content == 'TRAININGS' ? 'bg-yellow-green' : '' }}" wire:click="trainings">Trainings</button>        
             <button class="p-2 rounded-lg hover:bg-yellow-green border text-xs {{ $training_content == 'LEARNINGMATERIALS' ? 'bg-yellow-green' : '' }}" wire:click="learningMaterials">E-Learning Materials</button>
        </div>      
     </div>


     <div class="w-full relative bg-white rounded flex flex-col p-2">
        @if ($training_content == 'TRAININGS')
        <div class="w-full relative" wire:poll>
            <table class="w-full relative ">
                <tr class="border">
                    <th class="text-xs h-16">Training Name</th>
                    <th class="text-xs h-16">Department</th>
                    <th class="text-xs h-16">From Date</th>
                    <th class="text-xs h-16">To Date</th>
                    <th class="text-xs h-16 xsmr:hidden smr:hidden">Description</th>
                    <th class="text-xs h-16">Status</th>
                    <th class="text-xs h-16">Action</th>
                </tr>
                @if (count($training_availables) > 0)
                        @foreach ($training_availables as $training_available)
                        <tr class="{{ $parameter_id == $training_available->id ? 'border border-2 border-black ' : '' }}">
                    <td class="text-xs h-16 text-center w-40">{{ $training_available->training_name }}</td>
                    <td class="text-xs h-16 text-center w-40">{{ $training_available->department }}</td>
                    <td class="text-xs h-16 text-center w-40">{{ $training_available->start_date }}</td>
                    <td class="text-xs h-16 text-center w-40">{{ $training_available->to_date }}</td>
                    <td class="text-xs h-16 text-center w-40 xsmr:hidden smr:hidden">{{ $training_available->training_description }}</td>
                    <td class="text-xs h-16 text-center w-40">{{ $training_available->status }}</td>
                            @if ($training_available->status == 'pending' )
                                @if(in_array(auth()->user()->employee_id, array_column($training_available->training_applicants->toArray(), 'employee_id')))
                                    @if (in_array(auth()->user()->employee_id, array_column($training_available->approved_applicants->toArray(), 'employee_id')))
                                    <td class="text-xs h-16 text-center w-40"><button class="p-1 rounded-lg bg-yellow-green" >Application Approved</button></td>      
                                    @else
                                     <td class="text-xs h-16 text-center w-40"><button class="p-1 rounded-lg bg-yellow-green" wire:click="cancelApplication({{ $training_available->id }})" wire:key="application-{{ $training_available->id }}" >Cancel Application</button></td>      
                                    @endif
                                @else
                                    <td class="text-xs h-16 text-center w-40"><button class="p-1 rounded-lg bg-yellow-green" wire:click="apply({{ $training_available->id }})" wire:key="apply-{{ $training_available->id }}">Apply</button></td>   
                                @endif
                            @elseif($training_available->status == 'On Going')
                                    @if (in_array(auth()->user()->employee_id, array_column($training_available->approved_applicants->toArray(), 'employee_id')))
                                        <td class="text-xs h-16 text-center w-40"><button class="p-1 rounded-lg bg-yellow-green" >Participant</button></td>   
                                    @else
                                        <td class="text-xs h-16 text-center w-40"><button class="p-1 rounded-lg bg-gray-200" >Apply</button></td>       
                                    @endif
                            @elseif($training_available->status == 'Ended')  
                                    @if (in_array(auth()->user()->employee_id, array_column($training_available->approved_applicants->toArray(), 'employee_id')))
                                        <td class="text-xs h-16 text-center w-40"><button class="p-1 rounded-lg bg-yellow-green" >Participated</button></td>   
                                    @else
                                        <td class="text-xs h-16 text-center w-40"><button class="p-1 rounded-lg bg-gray-200" >Apply</button></td>       
                                    @endif      
                            @endif
                    </tr>
                    @endforeach
                @endif
            </table>
        </div>
        @elseif($training_content == 'LEARNINGMATERIALS')
                <div class="w-full relative flex flex-wrap" wire:poll>
                    <div class="relative flex rounded-lg gap-5 ml-5">
                        <button class="p-2 rounded-lg border text-xs hover:bg-yellow-green {{ $learning_materials_content == 'EBOOKS' ? 'bg-yellow-green' : '' }}" wire:click="ebooks">Ebooks</button>
                        <button class="p-2 rounded-lg border hover:bg-yellow-green text-xs {{ $learning_materials_content == 'VIDEOS' ? 'bg-yellow-green' : '' }}" wire:click="videos">Videos</button>
                        <button class="p-2 rounded-lg border hover:bg-yellow-green text-xs {{ $learning_materials_content == 'WEBSITES' ? 'bg-yellow-green' : '' }}" wire:click="websites">Websites</button>
                        <button class="p-2 rounded-lg border hover:bg-yellow-green text-xs {{ $learning_materials_content == 'FAVORITES' ? 'bg-yellow-green' : '' }}" wire:click="favorite">Favorites</button>
                    </div>
                </div>
                @if ($learning_materials_content == 'EBOOKS')
                <div class="w-11/12 relative flex gap-10 flex-col  m-5">
                    @if ($e_books != null)
                    <div class="w-full relative flex justify-center items-center">
                        <input type="search" class="w-full border pl-5 rounded-full" placeholder="Search e-book here" name="search_ebook" id="search_ebook" wire:model.live="search_ebook">
                    </div>
                    <div class="w-full relative flex flex-wrap gap-10">
                        @foreach ($e_books as $e_book)
                            <div class="w-64 relative flex flex-col rounded cursor-pointer" >
                                <div class="border p-2 relative rounded flex flex-col justify-center items-center">
                                       <div class="w-full relative flex justify-center items-center" wire:click="previewEbooks({{ $e_book->id }})" wire:key="previewEbook-{{ $e_book->id }}">
                                        <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" width="80" height="80" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 101.37" style="enable-background:new 0 0 122.88 101.37" xml:space="preserve"><g><path d="M12.64,77.27l0.31-54.92h-6.2v69.88c8.52-2.2,17.07-3.6,25.68-3.66c7.95-0.05,15.9,1.06,23.87,3.76 c-4.95-4.01-10.47-6.96-16.36-8.88c-7.42-2.42-15.44-3.22-23.66-2.52c-1.86,0.15-3.48-1.23-3.64-3.08 C12.62,77.65,12.62,77.46,12.64,77.27L12.64,77.27z M103.62,19.48c-0.02-0.16-0.04-0.33-0.04-0.51c0-0.17,0.01-0.34,0.04-0.51V7.34 c-7.8-0.74-15.84,0.12-22.86,2.78c-6.56,2.49-12.22,6.58-15.9,12.44V85.9c5.72-3.82,11.57-6.96,17.58-9.1 c6.85-2.44,13.89-3.6,21.18-3.02V19.48L103.62,19.48z M110.37,15.6h9.14c1.86,0,3.37,1.51,3.37,3.37v77.66 c0,1.86-1.51,3.37-3.37,3.37c-0.38,0-0.75-0.06-1.09-0.18c-9.4-2.69-18.74-4.48-27.99-4.54c-9.02-0.06-18.03,1.53-27.08,5.52 c-0.56,0.37-1.23,0.57-1.92,0.56c-0.68,0.01-1.35-0.19-1.92-0.56c-9.04-4-18.06-5.58-27.08-5.52c-9.25,0.06-18.58,1.85-27.99,4.54 c-0.34,0.12-0.71,0.18-1.09,0.18C1.51,100.01,0,98.5,0,96.64V18.97c0-1.86,1.51-3.37,3.37-3.37h9.61l0.06-11.26 c0.01-1.62,1.15-2.96,2.68-3.28l0,0c8.87-1.85,19.65-1.39,29.1,2.23c6.53,2.5,12.46,6.49,16.79,12.25 c4.37-5.37,10.21-9.23,16.78-11.72c8.98-3.41,19.34-4.23,29.09-2.8c1.68,0.24,2.88,1.69,2.88,3.33h0V15.6L110.37,15.6z M68.13,91.82c7.45-2.34,14.89-3.3,22.33-3.26c8.61,0.05,17.16,1.46,25.68,3.66V22.35h-5.77v55.22c0,1.86-1.51,3.37-3.37,3.37 c-0.27,0-0.53-0.03-0.78-0.09c-7.38-1.16-14.53-0.2-21.51,2.29C79.09,85.15,73.57,88.15,68.13,91.82L68.13,91.82z M58.12,85.25 V22.46c-3.53-6.23-9.24-10.4-15.69-12.87c-7.31-2.8-15.52-3.43-22.68-2.41l-0.38,66.81c7.81-0.28,15.45,0.71,22.64,3.06 C47.73,78.91,53.15,81.64,58.12,85.25L58.12,85.25z"/></g></svg>
                                       </div>
                                    <div class="w-full relative gap-5 flex justify-between items-center">
                                        <h1 class="whitespace-nowrap text-xs"  wire:click="previewEbooks({{ $e_book->id }})" wire:key="previewEbook-{{ $e_book->id }}">{{ $e_book->ebook_name }}</h1>
                                       
                                    @if (in_array($e_book->id, array_column(auth()->user()->favorite_ebooks->toArray(), 'learning_id')))
                                    <span class="bg-yellow-400 rounded-full cursor-pointer" wire:click="removeToFavorites({{ $e_book->id }}, 'ebook')" wire:key="removeToFavorites-ebook-{{ $e_book->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                        </span>
                                    @else
                                    <span class="cursor-pointer" wire:click="addToFavorites({{ $e_book->id }},'ebook')" wire:key="addToFavorites-ebook-{{ $e_book->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                        </span>    
                                    @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="w-full relative flex justify-end">
                            <button class="text-xs p-2 border rounded-lg hover:bg-yellow-green" wire:click="moreEbook">More</button>
                        </div>
                    </div>
                        
                    @endif
                </div>
                @elseif($learning_materials_content == 'VIDEOS')    
                <div class="w-11/12 relative flex flex-col gap-5 m-5" >
                    @if ($e_videos != null)
                    <div class="w-full relative flex justify-center items-center">
                        <input type="search" class="w-full border pl-5 rounded-full" placeholder="Search videos here" name="search_videos" id="search_videos" wire:model.live="search_videos">
                    </div>
                    <div class="w-full relative flex flex-wrap gap-10">
                        @foreach ($e_videos as $e_video)
                        <div class="w-64 relative rounded">
                            <video  width="320" class="rounded"  height="240" controls> 
                                <source src="/storage/learning-materials/video/{{ $e_video->video_file_name }}" type="video/mp4">
                            </video>
                            <div class="w-full relative flex justify-between items-center">
                                <h1>{{ $e_video->video_name }}</h1>

                                @if (in_array($e_video->id, array_column(auth()->user()->favorite_videos->toArray(), 'learning_id')))
                                <span class="bg-yellow-400 rounded-full cursor-pointer" wire:click="removeToFavorites({{ $e_video->id }}, 'video')" wire:key="removeToFavorites-video-{{ $e_video->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                    </span>
                                @else
                                <span class="cursor-pointer" wire:click="addToFavorites({{ $e_video->id }},'video')" wire:key="addToFavorites-video-{{ $e_video->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                    </span>    
                                @endif
                            </span>
                            </div>
                        </div>
                    @endforeach
                    <div class="w-full relative flex justify-end">
                        <button class="text-xs p-2 border rounded-lg hover:bg-yellow-green" wire:click="morevideo">More</button>
                    </div>
                    </div>
                    @endif
                </div>
                @elseif($learning_materials_content == 'WEBSITES')
                <div class="w-11/12 relative flex flex-col gap-5 m-5">
                        @if ($e_websites != null)
                        <div class="w-full relative flex justify-center items-center">
                            <input type="search" class="w-full border pl-5 rounded-full" placeholder="Search websites here" name="search_websites" id="search_websites" wire:model.live="search_websites">
                        </div>
                        <div class="w-full relative flex flex-wrap gap-10">
                            @foreach ($e_websites as $e_website)
                            <div class=" relative flex flex-col roundeed cursor-pointer">
                                <div class="border p-2 relative rounded ">
                                    <span class="w-full relative flex justify-between items-center" >
                                        <h1 class="whitespace-nowrap">{{ $e_website->website_name }}</h1>
                                        @if (in_array($e_website->id, array_column(auth()->user()->favorite_websites->toArray(), 'learning_id')))
                                        <span class="bg-yellow-400 rounded-full" wire:click="removeToFavorites({{ $e_website->id }}, 'website')" wire:key="removeToFavorites-website-{{ $e_website->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                            </span>
                                        @else
                                        <span class="" wire:click="addToFavorites({{ $e_website->id }},'website')" wire:key="addToFavorites-website-{{ $e_website->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                            </span>    
                                        @endif
                                    </span>
                                    <h1><a href="{{ $e_website->website_link }}" class="hover:bg-blue-400" target="_blank">{{ $e_website->website_link }}</a></h1>
                                    <span class="text-xs">{{ $e_website->website_description }}</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="w-full relative flex justify-end">
                            <button class="text-xs p-2 border rounded-lg hover:bg-yellow-green" wire:click="moreWebsite">More</button>
                        </div>
                        </div>
                        @endif
                    </div>
                @elseif($learning_materials_content == 'FAVORITES')  
                <div class="w-11/12 relative flex flex-col gap-5 m-5">
                    <div class="w-full relative flex items-center flex-wrap gap-5">
                        @if (count($favorites) > 0)
                            @foreach ($favorites as $favorite)
                                @if ($favorite->type == 'ebook')
                                <div class="w-64 relative flex flex-col rounded cursor-pointer" >
                                    <div class="border p-2 relative rounded flex flex-col justify-center items-center">
                                           <div class="w-full relative flex justify-center items-center" wire:click="previewEbooks({{ $favorite->learning_id }})" wire:key="previewEbook-{{ $favorite->learning_id }}">
                                            <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" width="80" height="80" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 101.37" style="enable-background:new 0 0 122.88 101.37" xml:space="preserve"><g><path d="M12.64,77.27l0.31-54.92h-6.2v69.88c8.52-2.2,17.07-3.6,25.68-3.66c7.95-0.05,15.9,1.06,23.87,3.76 c-4.95-4.01-10.47-6.96-16.36-8.88c-7.42-2.42-15.44-3.22-23.66-2.52c-1.86,0.15-3.48-1.23-3.64-3.08 C12.62,77.65,12.62,77.46,12.64,77.27L12.64,77.27z M103.62,19.48c-0.02-0.16-0.04-0.33-0.04-0.51c0-0.17,0.01-0.34,0.04-0.51V7.34 c-7.8-0.74-15.84,0.12-22.86,2.78c-6.56,2.49-12.22,6.58-15.9,12.44V85.9c5.72-3.82,11.57-6.96,17.58-9.1 c6.85-2.44,13.89-3.6,21.18-3.02V19.48L103.62,19.48z M110.37,15.6h9.14c1.86,0,3.37,1.51,3.37,3.37v77.66 c0,1.86-1.51,3.37-3.37,3.37c-0.38,0-0.75-0.06-1.09-0.18c-9.4-2.69-18.74-4.48-27.99-4.54c-9.02-0.06-18.03,1.53-27.08,5.52 c-0.56,0.37-1.23,0.57-1.92,0.56c-0.68,0.01-1.35-0.19-1.92-0.56c-9.04-4-18.06-5.58-27.08-5.52c-9.25,0.06-18.58,1.85-27.99,4.54 c-0.34,0.12-0.71,0.18-1.09,0.18C1.51,100.01,0,98.5,0,96.64V18.97c0-1.86,1.51-3.37,3.37-3.37h9.61l0.06-11.26 c0.01-1.62,1.15-2.96,2.68-3.28l0,0c8.87-1.85,19.65-1.39,29.1,2.23c6.53,2.5,12.46,6.49,16.79,12.25 c4.37-5.37,10.21-9.23,16.78-11.72c8.98-3.41,19.34-4.23,29.09-2.8c1.68,0.24,2.88,1.69,2.88,3.33h0V15.6L110.37,15.6z M68.13,91.82c7.45-2.34,14.89-3.3,22.33-3.26c8.61,0.05,17.16,1.46,25.68,3.66V22.35h-5.77v55.22c0,1.86-1.51,3.37-3.37,3.37 c-0.27,0-0.53-0.03-0.78-0.09c-7.38-1.16-14.53-0.2-21.51,2.29C79.09,85.15,73.57,88.15,68.13,91.82L68.13,91.82z M58.12,85.25 V22.46c-3.53-6.23-9.24-10.4-15.69-12.87c-7.31-2.8-15.52-3.43-22.68-2.41l-0.38,66.81c7.81-0.28,15.45,0.71,22.64,3.06 C47.73,78.91,53.15,81.64,58.12,85.25L58.12,85.25z"/></g></svg>
                                           </div>
                                        <div class="w-full relative gap-5 flex justify-between items-center">
                                            <h1 class="whitespace-nowrap text-xs"  wire:click="previewEbooks({{ $favorite->learning_id }})" wire:key="previewEbook-{{ $favorite->learning_id }}">{{ $favorite->name }}</h1>
                                           
                                        <span class="bg-yellow-400 rounded-full cursor-pointer" wire:click="removeToFavorites({{ $favorite->learning_id }}, 'ebook')" wire:key="removeToFavorites-ebook-{{ $favorite->learning_id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                            </span>
                                       
                                        </div>
                                    </div>
                                </div>
                                @elseif($favorite->type == 'video')    
                                <div class="w-64 relative rounded">
                                    <video  width="320" class="rounded"  height="240" controls> 
                                        <source src="/storage/learning-materials/video/{{ $favorite->file_name }}" type="video/mp4">
                                    </video>
                                    <div class="w-full relative flex justify-between items-center">
                                        <h1>{{ $favorite->name }}</h1>
                                        <span class="bg-yellow-400 rounded-full cursor-pointer" wire:click="removeToFavorites({{ $favorite->learning_id }}, 'video')" wire:key="removeToFavorites-video-{{ $favorite->learning_id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                            </span>
                                    </span>
                                    </div>
                                </div>
                                @elseif($favorite->type == 'website')
                                <div class=" relative flex flex-col roundeed cursor-pointer">
                                    <div class="border p-2 relative rounded ">
                                        <span class="w-full relative flex justify-between items-center" >
                                            <h1 class="whitespace-nowrap">{{ $favorite->name }}</h1>
                                            <span class="bg-yellow-400 rounded-full" wire:click="removeToFavorites({{ $favorite->learning_id }}, 'website')" wire:key="removeToFavorites-website-{{ $favorite->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m354-247 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-80l65-281L80-550l288-25 112-265 112 265 288 25-218 189 65 281-247-149L233-80Zm247-350Z"/></svg>
                                                </span>
                                        </span>
                                        <h1><a href="{{ $favorite->file_name }}" class="hover:bg-blue-400" target="_blank">{{ $favorite->file_name }}</a></h1>
                                        <span class="text-xs">{{ $favorite->description }}</span>
                                    </div>
                                </div>  
                                @endif
                            @endforeach
                            <div class="w-full relative flex justify-end">
                                <button class="text-xs p-2 border rounded-lg hover:bg-yellow-green" wire:click="moreFavorites">More</button>
                            </div>
                        @endif
                    </div>
                </div>
             @endif  

        @endif  
     </div>

     <x-modal wire:model="previewModal">
        <div class="w-full relative bg-whitey rounded p-5 flex justify-center items-center">
            @if ($previewEbook != null)
                <iframe src="{{ $previewEbook }}" class="w-screen h-screen" frameborder="0"></iframe>
            @endif
        </div>
    </x-modal>     
</div>