@extends('layouts.backend')

@section('title', 'Events')

@section('content')
<div class="col-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{route('event.create')}}" class="btn btn-primary pull-right"> Add Event </a>
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
    $(document).ready(function(){
        load_datatable();
    });
  function load_datatable(){
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('userevents') }}",
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
               
            ],
            // dom: 'Bfrtip',
            // buttons: [
            //     'pdf'
            // ]
        });
    }
 

</script>
<style>
    #DataTables_Table_0_filter{
        display: none;
    }
    </style>
@endpush
