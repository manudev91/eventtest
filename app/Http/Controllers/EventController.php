<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\User;
use App\Http\Requests\EventRequest;
use DB;
use Yajra\DataTables\DataTables;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendNotifyEmail;

class EventController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        if ($request->ajax()) {

            $data = Event::all();
            if (!empty($request->input('from_date'))  ) {
                $data = Event::whereBetween('event_start_date', array($request->input('from_date'), $request->input('to_date')))->get();     
            }else{
                $data = Event::all();
            }

             return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('event_start_date', function ($row) {
                    return $row['event_start_date'] .' '. $row['event_start_time'] ;
                })
                ->addColumn('event_end_date', function ($row) {
                    return $row['event_end_date'] .' '. $row['event_end_time'] ;
                })
                ->addColumn('event_status', function ($row) {
                        if ($row['status'] == 1)
                        return '<span class="badge badge-success">Active</span>';
                        else
                        return '<span  class="badge badge-danger">In-Active</span>';
                })
                ->addColumn('action', function ($row) {
                    if (Auth()->user()->user_types == 'superadmin') {
                        $btn = '<a href="events/edit/' . $row['id'] . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                           <a href="javascript:void(0)" onclick="deleteEvent(' . $row['id'] . ')" class="edit btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>

                           <a href="javascript:void(0)" onclick="joinEvent(' . $row['id'] . ')" class="edit btn btn-info btn-sm"><i class="fa fa-calendar" aria-hidden="true"></i></a>

                           <a href="events/notify/' . $row['id'] . '" class="edit btn btn-info btn-sm" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a>

                           ';
                    }else{
                        $btn = '

                        <a href="javascript:void(0)" onclick="joinEvent(' . $row['id'] . ')" class="edit btn btn-info btn-sm"><i class="fa fa-calendar" aria-hidden="true"></i></a>

                        ';
                    }    
                    return $btn;
                })
                ->rawColumns(['action', 'event_status','event_end_date','event_start_date'])

                ->make(true);
        }
        return view('events.index');
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
    public function store(EventRequest $request)
    {
        $validated = $request->validated();

        $input = $request->except(['_token', 'Submit']);
        try {
            Event::create($input);
            Session::flash('success', 'Event Created Successfully');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }
        return back();
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $event = Event::find($id);
        return view('events.update', compact(['event']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $inputs = $request->except(['_token']);
        try {
            $result = Event::find($inputs['id'])->update($inputs);
            Session::flash('success', 'Event Updated Successfully');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }
        return redirect()->route('event.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $result = Event::where('id',$id)->delete();
        echo $result;
    }
    
    /**
     * join event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function joinEvent( Request $request)
    {
        $eventId = $request->input('eventId');
        $userId = Auth()->user()->id;
        
        $alreadyExistCheck = EventUser::where('user_id',$userId)->where('event_id',$eventId)->count();
        $response = array(
            "msg" => "Successfully Joined the event",
            "icon" => "success"
        );
        if($alreadyExistCheck){
            $response["msg"] ="You have already joined the event";
            $response["icon"] ="error";
        }else{
            $data = array(
                "user_id" => $userId,
                "event_id" => $eventId,
            );
            EventUser::insert($data);
        }

        echo json_encode($response);
        
    }

   
    public function notifyUser($eventId){

        $details = ['subject' => 'Event Notification','eventId' => $eventId];
    	
        $job = (new SendNotifyEmail($details))->delay(now()->addSeconds(2)); 

        dispatch($job);

    }

}
