@extends('layouts.backend')

@section('title', 'Events')

@section('content')
<div class="col-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                @if(auth()->user()->user_types == "superadmin")
                    <a href="{{route('event.create')}}" class="btn btn-primary pull-right"> Add Event </a>
                @endif
            </div>  
            <div class="pt-5">
                <div class="form-row">
                    <div class="row input-daterange">
                        <div class="form-group  col-md-4">
                            <input type="date" name="from_date" id="from_date" class="form-control " placeholder="From Date"  />
                        </div>
                        <div class="form-group  col-md-4">
                            <input type="date" name="to_date" id="to_date" class="form-control " placeholder="To Date"  />
                        </div>
            
                        <div class="form-group  col-md-4">
                            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                            <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive pt-4">
                <table class="table table-striped  data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Venue</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')


<script type="text/javascript">
$('.datepicker').val('');

    $(document).ready(function(){
        load_datatable();
    });
  function load_datatable(from_date = '', to_date =''){
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('event.index') }}",
                data: {
                    from_date: from_date,
                    to_date: to_date
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'event_name',
                    name: 'Title'
                },
                {
                    data: 'event_venue',
                    name: 'Venu'
                },
                {
                    data: 'event_location',
                    name: 'Location'
                },
                {
                    data: 'event_start_date',
                    name: 'Event Start Date'
                },
                {
                    data: 'event_end_date',
                    name: 'Event End Date'
                },
                {
                    data: 'event_status',
                    name: 'Status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            // dom: 'Bfrtip',
            // buttons: [
            //     'pdf'
            // ]
        });
    }
 
    $('#filter').click(function() {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        $('.data-table').DataTable().destroy();
        load_datatable(from_date, to_date);

    });

    $('#refresh').click(function() {
        $('#from_date').val('');
        $('#to_date').val('');
        $('.data-table').DataTable().destroy();
        load_datatable();
    });

    function deleteEvent(eventId) {
        swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this Event!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    deleteAjax(eventId)

                } else {
                    swal('Your Event is safe!');
                }
            });
    }

    function deleteAjax(eventId) {
        $.ajax({

            url: "events/delete/" + eventId,
            data: {
                "_token": "{{ csrf_token() }}",
                "id": eventId
            },
            method: "delete"
        }).done(function() {
            $('.data-table').DataTable().destroy();
            load_datatable();
            swal('Woof! Your Event has been deleted!', {
                icon: 'success',
            });
        });
    }

    function joinEvent(eventId) {
        swal({
                title: 'Are you sure?',
                text: 'you want to join this event',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    joinEventAjax(eventId)

                } else {
                    swal('Your did not join the event');
                }
            });
    }

    function joinEventAjax(eventId) {
        $.ajax({

            url: "events/joinevent",
            data: {
                "_token": "{{ csrf_token() }}",
                "eventId": eventId
            },
            method: "post"
        }).done(function(result) {
            result = JSON.parse(result);
            swal(result.msg, {
                icon: result.icon,
            });
        });
    }
</script>
<style>
     #DataTables_Table_0_filter{
        display: none;
    }
    </style>
@endpush