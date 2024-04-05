<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmployeeController extends Controller
{
    public function downloadCertificate($cert)
    {
        if($cert != null){
            $file = public_path()."/storage/employee-certificates/";
            if($file){
                return Response::download($file.$cert);
            }else{
                return back()->with('failed', 'Failed, please try again later.');
            }
        }else{
                return back()->with('failed', 'Failed, please try again later.');
        }
    }

    public function benefits($id = 0, $content = '')
    {
        return view('users.employee.benefits', ['id' => $id, 'content' => $content]);

    }

    public function eventsandnews($id = 0, $content = '')
    {
        return view('users.employee.eventsandnews', ['id' => $id, 'content' => $content]);
    }

    public function performance($id = 0, $content = '', $month = 0)
    {
        return view('users.employee.performance', ['id' => $id, 'content' => $content, 'month' => $month]);
    }

    public function daily_time_record($id  = 0, $cntt = "")
    {
        $ticket_id = 0;
        $content = "";

        if($cntt != null){
            $content = $cntt;
        }

        if($id != null){
            $ticket_id = $id;
        }   
        return view('users.employee.daily-time-record', ['id' => $ticket_id, 'content' => $content]);
    }

    public function Training($id = 0,$content = '')
    {
        return view('users.employee.trainings', ['id' => $id, 'content' => $content]);
    }

    public function Schedule($id = 0, $content = "", $content_of_content = "")
    {
        return view('users.employee.schedule', ['id' => $id, 'content' => $content, 'contentofcontent' => $content_of_content]);
    }

    public function EmployeeDashboard()
    {
        return view('users.employee.dashboard');
    }

    public function showProfile($cid = 0, $content = '')
    {
        return view('profile.show', ['cid' => $cid, 'content' => $content]);
    }

}
