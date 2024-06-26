@if (session()->has('failed'))
<div class="bg-red absolute z-20 m-5 bg-white border-t-4 z-100 border-red-500 rounded-b text-teal-900 px-4 py-3 shadow-md w-60"  role="alert"  x-data="{ show:true }" x-show="show" x-init="setTimeout(() => show = false , 5000)">
  <div class="flex">
    <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">Alert</p>
      <p class="text-xs">{{session('failed')}}</p>
    </div>
  </div>
</div>
@endif