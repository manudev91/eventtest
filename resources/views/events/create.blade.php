@extends('layouts.backend')

@section('title', 'Event')

@section('content')
<div class="col-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Add New Event</h4>
        </div>
        <div class="row">
            <div class="col-sm-12 pl-5 pr-5 pt-2">
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('event.store') }}">
                {{csrf_field()}}
                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="event_name" class="form-control">
                    @if ($errors->has('event_name'))
                        <span class="text-danger">{{ $errors->first('event_name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label>Event Description</label>
                    <textarea class="form-control" name="event_description" spellcheck="false"></textarea>
                    @if ($errors->has('event_description'))
                        <span class="text-danger">{{ $errors->first('event_description') }}</span>
                    @endif
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label>Event Venue</label>
                        <input type="text" name="event_venue" class="form-control">
                        @if ($errors->has('event_venue'))
                            <span class="text-danger">{{ $errors->first('event_venue') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Event Location</label>
                        <input type="text" name="event_location" class="form-control">
                        @if ($errors->has('event_location'))
                            <span class="text-danger">{{ $errors->first('event_location') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label>Event Start Date</label>
                        <input type="date" name="event_start_date" class="form-control">
                        @if ($errors->has('event_start_date'))
                            <span class="text-danger">{{ $errors->first('event_start_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Event Start Time</label>
                        <input type="time" name="event_start_time" class="form-control">
                        @if ($errors->has('event_start_time'))
                            <span class="text-danger">{{ $errors->first('event_start_time') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label>Event End Date</label>
                        <input type="date" name="event_end_date" class="form-control">
                        @if ($errors->has('event_end_date'))
                            <span class="text-danger">{{ $errors->first('event_end_date') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Event End Time</label>
                        <input type="time" name="event_end_time" class="form-control">
                        @if ($errors->has('event_end_time'))
                            <span class="text-danger">{{ $errors->first('event_end_time') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                   
                     <div class="form-group col-sm-4">
                        <label>Event Status</label>
                        <select class="form-control" name="status">
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div> 
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    @endsection