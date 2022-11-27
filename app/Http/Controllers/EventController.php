<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currDate = Carbon::now()->format('Y-m-d');
        $events = Event::where('start_date', '>=', $currDate)->orderBy('start_date')->get();
        $finishedEvents = Event::where('start_date', '<', $currDate)->orderBy('start_date')->get();

        if (!isset($events)) {
            $events = [];
        }

        if (!isset($finishedEvents)) {
            $finishedEvents = [];
        }

        return view('events.index', ['events' => $events, 'finishedEvents' => $finishedEvents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'date|date-format:Y-m-d',
            'end_date' => 'date|date-format:Y-m-d|after_or_equal:start_date',
        ]);

        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;

        $event->save();

        return redirect()->route('events.create')->with('success','Events created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $event = Event::find($id);
        return view('events.show', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $event = Event::find($id);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'start_date' => 'date|date-format:Y-m-d',
            'end_date' => 'date|date-format:Y-m-d|after_or_equal:start_date',
        ]);

        $event = Event::find($id);
        $event->title = $request->title;
        $event->description = $request->description;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;

        $event->update();

        // return redirect()->route('events.create')->with('success','Event updated successfully.');
        return redirect()->back()->with('success','Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (isset($id) && $id != null) {
             $event = Event::find($id);
             $event->delete();

             return response()->json(['success'=>true, 'id'=>$id]);
        }       

         //We may use this response to print error message if required later
         return response()->json(['error'=>true, 'message'=>'Could not delete the event!']);
    }

    /**
     * Filter the events
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function filterEvents(Request $request)
    {
        $currDate = Carbon::now()->format('Y-m-d');
        $after7Days = Carbon::now()->addDays(7)->format('Y-m-d');
        $before7Days = Carbon::now()->subDays(7)->format('Y-m-d');

        $eventFilter = $request->eventfilter;

        if (isset($eventFilter) && $eventFilter != null) {
            if ($eventFilter == 'finished') {
                $events = Event::where('end_date', '<', $currDate)->orderBy('start_date')->get();

                if (isset($events) && $events != null && count($events) >= 1) {
                    return view('events.index', compact('events', 'eventFilter'));
                }

            }

            if ($eventFilter == 'upcoming') {
                $events = Event::where('start_date', '>', $currDate)->orderBy('start_date')->get();

                if(isset($events) && $events != null && count($events) >= 1) {
                    return view('events.index', compact('events', 'eventFilter'));
                } else {
                    return view('events.notfound');   
                }
            }

            if ($eventFilter == 'events7') {
                $events = Event::where('start_date', '>=', $currDate)->where('start_date', '<=', $after7Days)->orderBy('start_date')->get();

                if(isset($events) && $events != null && count($events) >= 1) {
                    return view('events.index', compact('events', 'eventFilter'));
                } else {
                    return view('events.notfound');   
                }
            }

            if ($eventFilter == 'finished7') {
                $events = Event::where('end_date', '<', $currDate)->where('end_date', '>=', $before7Days)->orderBy('start_date')->get();

                if(isset($events) && $events != null && count($events) >= 1) {
                    return view('events.index', compact('events', 'eventFilter'));
                } else {
                    return view('events.notfound');   
                }
            }

            if ($eventFilter == 'all') {
                $events = Event::orderBy('start_date')->get();

                if(isset($events) && $events != null && count($events) >= 1) {
                    return view('events.index', compact('events', 'eventFilter'));
                } else {
                    return view('events.notfound');   
                }
            }        

        }

    }
}
