<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(){
    
        $users = User::count();
        $allEvents = Event::count();
        $upcomingEvent = Event::where('event_start_date','>=',Carbon::now()->toDateString())->count();
        $completedEvent = Event::where('event_end_date','<',Carbon::now()->toDateString())->count();
       
        return view('dashboard',compact(['users','allEvents','upcomingEvent','completedEvent']));    
   }
}
