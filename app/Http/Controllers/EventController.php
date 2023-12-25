<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRegisterRequest;
use App\Jobs\SendEventEmailJob;
use App\Models\Event;
use App\Models\EventRegistration;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index(){

        $events = Event::select('name','start_date','end_date')->get();
        return $events;
    }

    public function store(Request $request){

        $request->validate([
            'name'       => 'required|string',
            'start_date' => 'required',
            'end_date'   => 'required',
        ]);

        $event = new Event();
        $event->name       = $request->name;  
        $event->start_date = Carbon::parse($request->start_date)->second(0)->format('Y-m-d H:i:s');  
        $event->end_date   = Carbon::parse($request->end_date)->second(0)->format('Y-m-d H:i:s');
        $event->save();
        return redirect()->route('admin')->with('message', 'Event Created Successfully');
    }

    public function eventRegistration(EventRegisterRequest $request){
 
        $registration = new EventRegistration();
        $registration->event_id   = $request->event_id;  
        $registration->user_name  = $request->user_name;  
        $registration->user_email = $request->user_email; 
        $registration->save();

        return redirect()->back()->with('message', 'Event Registartion Successfully Done');
    }

    public function admin(){
        $all_events = $this->allEventGet();
        return Inertia::render('event/admin',['all_events'=>$all_events]);
    }

    public function user(){
        $all_events = $this->allEventGet();
        return Inertia::render('event/user',['all_events'=>$all_events]);
    }

    public function allEventGet(){
        $events = Event::select('id','name','start_date','end_date')->get();
        foreach ($events as $key => $event) {
            $startDateTime = new DateTime($event['start_date']);
            $endDateTime   = new DateTime($event['end_date']);
        
            $all_events[] = [
                'id' => $event['id'],
                'title' => $event['name'],
                'start' => $startDateTime->format('Y-m-d') . 'T' . $startDateTime->format('H:i:s'),
                'end' => $endDateTime->format('Y-m-d') . 'T' . $endDateTime->format('H:i:s'),
            ];
        }
        return $all_events;
    }


}
