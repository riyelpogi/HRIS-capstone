<div class="w-11/12 xsmr:w-full m-5 bg-whitey rounded smr:w-full relative flex justify-center flex-col p-5 ">
    <div class="w-full relative  rounded flex flex-col justify-center ">
        @if ($birthday_celebrants != null)
        <div class="w-full relative flex justify-center m-5 items-center">
            <h1 class="text-lg font-semibold">{{ date('F', time()) }} Birthday Celebrants</h1>
        </div>
            <div class="w-full relative flex flex-wrap gap-3 justify-center items-center mb-5">
                @foreach ($birthday_celebrants as $birthday_celebrant)
                    <div class="    w-44 h-44 flex flex-col gap-5 justify-center items-center relative">
                        <div class="w-32 h-32 relative">
                            @if ($birthday_celebrant['profile'] != null)
                            <img src="/storage/employee-media/{{ $birthday_celebrant['profile'] }}" alt="" class="w-full h-full rounded-full border">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="border rounded-full" height="120" viewBox="0 96 960 960" width="120"><path d="M480 575q-66 0-108-42t-42-108q0-66 42-108t108-42q66 0 108 42t42 108q0 66-42 108t-108 42ZM160 896v-94q0-38 19-65t49-41q67-30 128.5-45T480 636q62 0 123 15.5t127.921 44.694q31.301 14.126 50.19 40.966Q800 764 800 802v94H160Zm60-60h520v-34q0-16-9.5-30.5T707 750q-64-31-117-42.5T480 696q-57 0-111 11.5T252 750q-14 7-23 21.5t-9 30.5v34Zm260-321q39 0 64.5-25.5T570 425q0-39-25.5-64.5T480 335q-39 0-64.5 25.5T390 425q0 39 25.5 64.5T480 515Zm0-90Zm0 411Z"/></svg>     
                        @endif
                        </div>
                            <div class="w-full flex flex-col">
                                <h1 class="text-sm font-semibold text-center"> {{ $birthday_celebrant['name'] }}</h1>
                                <h1 class="text-xs font-semibold text-center"> 
                                    {{ date('F', time())  }} - {{ $birthday_celebrant['day'] }}
                                </h1>
                            </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="w-full relative flex justify-center items-center flex-col">
                <h1 class="font-bold uppercase tracking-wide">human resources information system</h1>
                <img src="/storage/hrislogo/HRIS.png" class="w-64 h-64"   alt="">
            </div>
        @endif
        
        </div>

</div>