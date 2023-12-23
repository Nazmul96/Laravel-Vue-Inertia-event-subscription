<?php

namespace App\Http\Controllers;

use App\Jobs\SendEventEmailJob;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;


class EventController extends Controller
{
    public function index(){

        $events = Event::select('name','start_date','end_date')->get();
        return $events;
    }

    public function store(Request $request){
        $request->validate([
            'name'       => 'required|string',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date'   => 'required|date_format:Y-m-d H:i:s',
        ]);

        Event::create($request->all());

        return redirect()->route('employees')->with('message', 'Employee Created Successfully');
    }

    public function eventRegistration(Request $request){
        $request->validate([
            'user_name'       => 'required|string',
            'user_email'      => 'required||email|unique:event_registrations,email'
        ]);
       
        EventRegistration::create($request->all());

        return redirect()->route('employees')->with('message', 'Employee Created Successfully');
    }
}
