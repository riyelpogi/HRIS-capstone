<div class="w-11/12 overflow-y-scroll relative flex justify-center m-5 flex-col">
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
        <div class="">
            <button class="p-2 rounded-lg border hover:bg-yellow-green" wire:click="showAddTrainingModal">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M450-200v-250H200v-60h250v-250h60v250h250v60H510v250h-60Z"/></svg>
            </button>
        </div>
    </div>

    <div class="w-full relative  bg-white rounded flex p-2">
      @if ($training_content == 'TRAININGS')
        <div class="w-full relative" wire:poll>
            <table class=" relative">
                <tr class="border">
                    <th class="text-xs h-16">Training Name</th>
                    <th class="text-xs h-16 xsmr:hidden smr:hidden">Department</th>
                    <th class="text-xs h-16">From Date</th>
                    <th class="text-xs h-16">To Date</th>
                    <th class="text-xs h-16 xsmr:hidden smr:hidden">Description</th>
                    <th class="text-xs h-16">Applicants</th>
                    <th class="text-xs h-16">Status</th>
                    <th class="text-xs h-16">Action</th>
                </tr>
                @if (count($training_availables) > 0)
                    @foreach ($training_availables as $training_available)
                        <tr class="border {{ $parameter_id == $training_available->id ? 'border border-2 border-black' : '' }}">
                            <td class="text-xs text-center w-64 h-16">{{ $training_available->training_name }}</td>
                            <td class="text-xs text-center w-64 h-16 xsmr:hidden smr:hidden">{{ $training_available->department }}</td>
                            <td class="text-xs text-center w-64 h-16">{{ $training_available->start_date }}</td>
                            <td class="text-xs text-center w-64 h-16">{{ $training_available->to_date }}</td>
                            <td class="text-xs text-center w-64 h-16 xsmr:hidden smr:hidden">{{ $training_available->training_description }}</td>
                            <td class="text-xs text-center w-64 h-16">{{ count($training_available->training_applicants) }}</td>
                            <td class="text-xs text-center w-64 h-16">{{ $training_available->status }}</td>
                            <td class="text-xs text-center w-64 h-16 ">
                               <span class="flex justify-center items-center cursor-pointer" wire:click="showTrainingModel({{ $training_available->id }})"> <svg xmlns="http://www.w3.org/2000/svg" height="16" class="cursor-pointer" viewBox="0 -960 960 960" width="16"><path d="M468-240q-96-5-162-74t-66-166q0-100 70-170t170-70q97 0 166 66t74 162l-84-25q-13-54-56-88.5T480-640q-66 0-113 47t-47 113q0 57 34.5 100t88.5 56l25 84Zm48 158q-9 2-18 2h-18q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480v18q0 9-2 18l-78-24v-12q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93h12l24 78Zm305 22L650-231 600-80 480-480l400 120-151 50 171 171-79 79Z" /></svg></span>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
        @elseif($training_content == 'LEARNINGMATERIALS')
                <div class="w-full relative flex flex-wrap" wire:poll>
                    <div class="relative flex rounded-lg gap-5">
                        <button class="p-2 rounded-lg border text-xs {{ $learning_materials_content == 'EBOOKS' ? 'bg-yellow-green' : '' }}" wire:click="ebooks">Ebooks</button>
                        <button class="p-2 rounded-lg border text-xs {{ $learning_materials_content == 'VIDEOS' ? 'bg-yellow-green' : '' }}" wire:click="videos">Videos</button>
                        <button class="p-2 rounded-lg border text-xs {{ $learning_materials_content == 'WEBSITES' ? 'bg-yellow-green' : '' }}" wire:click="websites">Websites</button>
                        <button class="w-full flex justify-center items-center rounded-lg p-2 border rounded-lg hover:bg-yellow-green" wire:click="showAddELearningMaterialsModal">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M450-200v-250H200v-60h250v-250h60v250h250v60H510v250h-60Z"/></svg>
                        </button>
                    </div>

                    @if ($learning_materials_content == 'EBOOKS')
                        <div class="w-11/12 relative flex gap-10 flex-col  m-5">
                            @if ($e_books != null)
                            <div class="w-full relative flex justify-center items-center">
                                <input type="search" class="w-full border pl-5 rounded-full" placeholder="Search e-book here" name="search_ebook" id="search_ebook" wire:model.live="search_ebook">
                            </div>
                            <div class="w-full relative flex flex-wrap gap-10" >
                                @foreach ($e_books as $e_book)
                                    <div class="w-64 relative flex flex-col rounded cursor-pointer" >
                                        <div class="border p-2 relative rounded flex flex-col justify-center items-center">
                                               <div class="w-full relative flex justify-center items-center" wire:click="previewEbooks({{ $e_book->id }})" wire:key="previewEbook-{{ $e_book->id }}">
                                                <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" width="80" height="80" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 101.37" style="enable-background:new 0 0 122.88 101.37" xml:space="preserve"><g><path d="M12.64,77.27l0.31-54.92h-6.2v69.88c8.52-2.2,17.07-3.6,25.68-3.66c7.95-0.05,15.9,1.06,23.87,3.76 c-4.95-4.01-10.47-6.96-16.36-8.88c-7.42-2.42-15.44-3.22-23.66-2.52c-1.86,0.15-3.48-1.23-3.64-3.08 C12.62,77.65,12.62,77.46,12.64,77.27L12.64,77.27z M103.62,19.48c-0.02-0.16-0.04-0.33-0.04-0.51c0-0.17,0.01-0.34,0.04-0.51V7.34 c-7.8-0.74-15.84,0.12-22.86,2.78c-6.56,2.49-12.22,6.58-15.9,12.44V85.9c5.72-3.82,11.57-6.96,17.58-9.1 c6.85-2.44,13.89-3.6,21.18-3.02V19.48L103.62,19.48z M110.37,15.6h9.14c1.86,0,3.37,1.51,3.37,3.37v77.66 c0,1.86-1.51,3.37-3.37,3.37c-0.38,0-0.75-0.06-1.09-0.18c-9.4-2.69-18.74-4.48-27.99-4.54c-9.02-0.06-18.03,1.53-27.08,5.52 c-0.56,0.37-1.23,0.57-1.92,0.56c-0.68,0.01-1.35-0.19-1.92-0.56c-9.04-4-18.06-5.58-27.08-5.52c-9.25,0.06-18.58,1.85-27.99,4.54 c-0.34,0.12-0.71,0.18-1.09,0.18C1.51,100.01,0,98.5,0,96.64V18.97c0-1.86,1.51-3.37,3.37-3.37h9.61l0.06-11.26 c0.01-1.62,1.15-2.96,2.68-3.28l0,0c8.87-1.85,19.65-1.39,29.1,2.23c6.53,2.5,12.46,6.49,16.79,12.25 c4.37-5.37,10.21-9.23,16.78-11.72c8.98-3.41,19.34-4.23,29.09-2.8c1.68,0.24,2.88,1.69,2.88,3.33h0V15.6L110.37,15.6z M68.13,91.82c7.45-2.34,14.89-3.3,22.33-3.26c8.61,0.05,17.16,1.46,25.68,3.66V22.35h-5.77v55.22c0,1.86-1.51,3.37-3.37,3.37 c-0.27,0-0.53-0.03-0.78-0.09c-7.38-1.16-14.53-0.2-21.51,2.29C79.09,85.15,73.57,88.15,68.13,91.82L68.13,91.82z M58.12,85.25 V22.46c-3.53-6.23-9.24-10.4-15.69-12.87c-7.31-2.8-15.52-3.43-22.68-2.41l-0.38,66.81c7.81-0.28,15.45,0.71,22.64,3.06 C47.73,78.91,53.15,81.64,58.12,85.25L58.12,85.25z"/></g></svg>
                                               </div>
                                            <div class="w-full relative gap-5 flex justify-between items-center">
                                                <h1 class="whitespace-nowrap text-xs"  wire:click="previewEbooks({{ $e_book->id }})" wire:key="previewEbook-{{ $e_book->id }}">{{ $e_book->ebook_name }}</h1>
                                                <span class="cursor-pointer" wire:click="deleteEbook({{ $e_book->id }})" wire:key="deleteEbook-{{ $e_book->id }}" wire:confirm="Are you sure you want to delete this E-book?">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <div class="w-full relative flex justify-end">
                                    <button class="p-2 text-xs hover:bg-yellow-green border rounded-lg" wire:click="ebookLimit">More</button>
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
                                    <div class="w-full relative flex justify-between">
                                        <h1>{{ $e_video->video_name }}</h1>
                                        <span class="cursor-pointer" wire:click="deleteVideo({{ $e_video->id }})" wire:key="deleteVideo-{{ $e_video->id }}" wire:confirm="Are you sure you want to delete this video?">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="w-full relative flex justify-end">
                                <button class="p-2 text-xs hover:bg-yellow-green border rounded-lg" wire:click="videoLimit">More</button>
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
                                    <span class="w-full relative flex justify-between items-center">
                                        <h1 class="whitespace-nowrap">{{ $e_website->website_name }}</h1>
                                        <span class="cursor-pointer" wire:click="deleteWebsite({{ $e_website->id }})" wire:key="deleteWebsite-{{ $e_website->id }}" wire:confirm="Are you sure you want to delete this website?">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                        </span>
                                    </span>
                                    <h1><a href="{{ $e_website->website_link }}" class="hover:bg-blue-400" target="_blank">{{ $e_website->website_link }}</a></h1>
                                    <span class="text-xs">{{ $e_website->website_description }}</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="w-full relative flex justify-end">
                            <button class="p-2 text-xs hover:bg-yellow-green border rounded-lg" wire:click="websiteLimit">More</button>
                        </div>
                        </div>
                          
                        @endif
                    </div>
                @endif  
            </div>
        @endif  

    </div>

<x-modal wire:model="previewModal">
    <div class="w-full p-5 rounded relative flex bg-whitey rounded justify-center items-center">
        @if ($previewEbook != null)
            <iframe src="{{ $previewEbook }}" class="w-screen h-screen" frameborder="0"></iframe>
        @endif
    </div>
</x-modal>
<x-modal wire:model="ElearningMaterialModal">
    <div class="w-full relative flex bg-whitey p-5 rounded justify-center items-center flex-col">
        <div class="w-10/12 relative  rounded  p-5 flex flex-col justify-center items-center m-5">
            <div class="w-full relative flex justify-center items-center gap-5">
            <button class="p-2 rounded-lg border text-xs {{ $ElearningMaterialModal_content == 'EBOOK' ? 'bg-yellow-green' : ''  }}" wire:click="ebook">EBOOK</button>
            <button class="p-2 rounded-lg border text-xs {{ $ElearningMaterialModal_content == 'VIDEO' ? 'bg-yellow-green' : ''  }}" wire:click="video">Video</button>
            <button class="p-2 rounded-lg border text-xs {{ $ElearningMaterialModal_content == 'WEBSITE' ? 'bg-yellow-green' : ''  }}" wire:click="website">Website</button>
            </div>
        </div>
        <div class="w-11/12  relative flex flex-col justify-center items-center">
            @if ($ElearningMaterialModal_content == 'EBOOK')
                <form wire:submit="addEbook" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="w-11/12 m-5 relative flex flex-col border p-3">
                            <x-label for="ebook_name">E-book Name:</x-label>
                            <x-input type="text" name="ebook_name" class="w-80" id="ebook_name" wire:model="ebook_name" />
                            @error('ebook_name')
                            <span class="text-xs text-red-200">{{ $message }}</span>
                            @enderror
                        </div>
                    
                    <div class="w-11/12 m-5 relative flex flex-col border p-3">
                        <x-label for="ebook_file">File:</x-label>
                        <x-input type="file" name="ebook_file" id="ebook_file" class="w-80" wire:model="ebook_file" />
                        @error('ebook_file')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-11/12 m-5 relative flex flex-col border p-3">
                        <x-button type="submit">Submit</x-button>
                    </div>
                </form>

            @elseif($ElearningMaterialModal_content == 'VIDEO')   
            <form action="{{ route('admin.save.video') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="w-11/12 m-5 relative flex flex-col border p-3">
                    <x-label for="video_name">Video Name:</x-label>
                    <x-input type="text" name="video_name" class="w-80" id="video_name" wire:model="video_name" />
                    @error('video_name')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 m-5 relative flex flex-col border p-3">
                    <x-label for="video_file">File:</x-label>
                    <x-input type="file" name="video_file" id="video_file" class="w-80" wire:model="video_file" />
                    @error('video_file')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                    <span wire:loading wire:target="video_file">loading video</span>
                </div>

                <div class="w-11/12 m-5 relative flex flex-col border p-3">
                    <x-button type="submit" wire:loading.attr='disabled' wire:target="video_file" >Submit</x-button>
                </div>
            </form>
            @elseif ($ElearningMaterialModal_content == 'WEBSITE')
            <form wire:submit="addWebsite" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="w-11/12 m-5 relative flex flex-col border p-3">
                    <x-label for="website_name">Website Name:</x-label>
                    <x-input type="text" name="website_name" class="w-80" id="website_name" wire:model="website_name" />
                    @error('website_name')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 m-5 relative flex flex-col border p-3">
                    <x-label for="website_description">Description:</x-label>
                    <x-input type="text" name="website_description" id="website_description" wire:model="website_description" />
                    @error('website_description')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-11/12 m-5 relative flex flex-col border p-3">
                    <x-label for="website_link">Link:</x-label>
                    <x-input type="text" name="website_link" id="website_link" wire:model="website_link" />
                    @error('website_link')
                    <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-11/12 m-5 relative flex flex-col border p-3">
                    <x-button type="submit">Submit</x-button>
                </div>
            </form>
            @endif
        </div>
    </div>
</x-modal>

<x-modal wire:model="addTrainingModal">
    <div class="w-full relative flex justify-center items-center">
        <div class="w-9/12 reltive p-5 bg-whitey rounded flex rounded flex-col m-5">
            <form wire:submit="addTraining" method="POST">
                @csrf
                <div class="flex flex-col mt-4 mb-4">
                    <x-label for="training_name">Training Name:</x-label>
                    <x-input type="text" name="training_name" wire:model="training_name" id="training_name" />
                    @error('training_name')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col  mt-4 mb-4">
                    <x-label for="department">Department:</x-label>
                    <select name="department" class="h-8 rounded border border-gray-200 text-sm" wire:model="department" id="department" >
                        <option value=""></option>
                        <option value="Information Technology">IT DEPARTMENT</option>
                        <option value="Accounting">ACCOUNTING</option>
                        <option value="Human Resources">HUMAN RESOURCES</option>
                        <option value="Marketing">MARKETING</option>
                        <option value="Finance">FINANCE DEPARTMENT</option>
                        <option value="Purchasing">PURCHASING</option>
                        <option value="others">OTHERS</option>
                    </select> 
                    @error('department')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col mt-4 mb-4">
                    <x-label for="start_date">From:</x-label>
                    <x-input type="date" name="start_date" wire:model="start_date" id="start_date" />
                    @error('start_date')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col mt-4 mb-4">
                    <x-label for="to_date">To:</x-label>
                    <x-input type="date" name="to_date" wire:model="to_date" id="to_date" />
                    @error('to_date')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col mt-4 mb-4">
                    <x-label for="training_description">Training Description:</x-label>
                    <x-input type="text" name="training_description" wire:model="training_description" id="training_description" />
                    @error('training_description')
                        <span class="text-xs text-red-200">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col mt-4 mb-4">
                    <x-button type="submit">Submit</x-button>
                </div>
            </form>
        </div>
    </div>
</x-modal>

<x-modal wire:model="trainingModal">
    <div class="w-full relative flex justify-center items-center">
        @if ($training != null)
        <div class="w-10/12 relative bg-whitey p-5 rounded flex flex-col ">
            <div class="w-11/12 relative flex  flex-col m-5">
                <table>
                    <tr>
                        <td class="text-center">Training Name: </td>
                        <td class="text-center"><span class="font-semibold">{{ $training->training_name }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">Department: </td>
                        <td class="text-center"><span class="font-semibold">{{ $training->department }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">From Date: </td>
                        <td class="text-center"><span class="font-semibold">{{ $training->start_date }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">To Date: </td>
                        <td class="text-center"><span class="font-semibold">{{ $training->to_date }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">Status: </td>
                        <td class="text-center"><span class="font-semibold">{{ $training->status }}</span></td>
                    </tr>
                </table>
            </div>
            <div class="w-11/12 relative flex flex-col m-5">
                <h1 class="font-semibold">Description:</h1>
                <h1 class="text-xs indent-5">{{ $training->training_description }}</h1>
            </div>

            <div class="w-11/12 relative flex flex-col m-5">
                @if ($training->status != 'pending')
                <h1 class="font-semibold">Participants:</h1>
                        @if (count($training->approved_applicants) > 0)
                            @foreach ($training->approved_applicants as $applicant)
                                @if ($applicant->status == 'approved')
                                    <div class="ml-5 mr-5 mt-2 mb-2 flex justify-between p-2 items-center border rounded">
                                        <h1 class="">{{ $applicant->user->name }}</h1>
                                    </div>
                                @endif
                            @endforeach
                        @else
                                <div class="ml-5 mr-5 mt-2 mb-2 flex justify-between p-2 items-center border rounded">
                                    <h1 class="uppercase">No participants</h1>
                                </div>
                        @endif
                @else
                <h1 class="font-semibold">Applicants:</h1>
                    @if (count($training->training_applicants) > 0)
                            @foreach ($training->training_applicants as $applicant)
                            @if (in_array($applicant->employee_id, array_column($training->approved_applicants->toArray(), 'employee_id')))
                               <div class="ml-5 mr-5 mt-1 mb-1 flex justify-between p-2 items-center border rounded">
                                   <h1 class="">{{ $applicant->user->name }}</h1>
                                   <button class="p-2 rounded-lg border hover:bg-white bg-yellow-green" wire:click="approveTrainingApplicant({{ $training->id }}, {{ $applicant->id }})" wire:key="approveTrainingApplicant-{{ $applicant->id }}">Approved</button>
                               </div>  
                            @else
                                    <div class="ml-5 mr-5 mt-1 mb-1 flex justify-between p-2 items-center border rounded">
                                    <h1 class="">{{ $applicant->user->name }}</h1>
                                    <button class="p-2 rounded-lg border hover:bg-yellow-green" wire:click="approveTrainingApplicant({{ $training->id }}, {{ $applicant->id }})" wire:key="approveTrainingApplicant-{{ $applicant->id }}">Approve</button>
                                </div>  
           
                            @endif
                           @endforeach 
                    @else
                        <div class="ml-5 mr-5 mt-1 mb-1 flex justify-between p-2 items-center border rounded">
                            <h1 class="font-bold text-center">NO APPLICANT</h1>
                            
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>
</x-modal>
</div>