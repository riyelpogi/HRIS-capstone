<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Livewire\WithFileUploads;

class HrOfficerController extends Controller
{
    use WithFileUploads;

    public function downloadCertificate($cert)
    {   
        if($cert != null){
            $file = public_path().'/storage/employee-certificates/';
            if($file){
                return Response::download($file.$cert);
            }else{
            return back()->with('failed', 'Failed, please try again later.');

            }
        }else{
            return back()->with('failed', 'Failed, please try again later.');
        }
    }

    public function EmployeeProfile($eid)
    {
        return view('users.hrofficer.employee-profile', ['eid' => $eid]);

    }

    public function EmployeePerformance()
    {
        return view('users.hrofficer.employee-performance');
    }

    public function saveVideo(Request $request)
    {
        $validated = $request->validate([
            'video_name' => 'required',
            'video_file' => 'required|mimes:mp4'
        ]);

       if(Gate::allows('admin')){
        if ($validated) {
            $name = $validated['video_file']->getClientOriginalName();
            $validated['video_file']->storeAs('/public/learning-materials/video/', $name);
            $video = Video::create([
                'video_name' => $validated['video_name'],
                'video_file_name' => $name,
            ]);

            return back()->with('success','Video uploaded successful.');
            }else{
                return back()->with('failed','Please Try again later.');
            }
       }else{
        return back()->with('failed','Please Try again later.');
    }
    }
    public function EmployeesRequests($content = "")
    {
        return view('users.hrofficer.employees-requests', ['content' => $content]);
        
    }

    public function Announcements()
    {
        return view('users.hrofficer.announcements');
        
    }
    public function Benefits($id = 0, $content = '')
    {
        return view('users.hrofficer.benefits', ['id' => $id, 'content' => $content]);
        
    }

    public function Trainings($id = 0, $content = '')
    {
        return view('users.hrofficer.trainings', ['id' => $id, 'content' => $content]);
    }

    public function Employee()
    {
        return view('users.hrofficer.show-employees');
    }

    public function Applicants()
    {
        return view('users.hrofficer.show-applicants');
    }

    public function ApplicationTracker()
    {
        return view('users.hrofficer.application-tracker');

    }
    public function EmployeeIndAndOut($content = '')
    {
        return view('users.hrofficer.employee-inandout', ['content' => $content]);
    }

    public function download($resume)
    {
        $file = public_path().'/storage/resume-cv/';
        
        if($file){
            return Response::download($file.$resume);
        }else{
            return back();
        }
    }

    public function adminDashboard(){
        return view('users.hrofficer.dashboard');
    }

    public function showProfile()
    {
        return view('users.hrofficer.profile');
    }
}
