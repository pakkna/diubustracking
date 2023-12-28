@section('dashboard', 'mm-active')
@section('Applications-li', 'mm-active')
@section('Applications-ul', 'mm-show')
@include('layouts.header')

@include('layouts.sidebar')
<script type="text/javascript">
    function go_map(params) {
        let settings = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
        width=800,height=600,left=100,top=100`;
        if (params.indexOf('http') > -1) {
            open(params, 'test',settings);
        }else{
            alert("Map Url Is Not Valid !");
        }

    }
</script>
<!-- Dashboard Header  section -->

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title app-page-title-simple">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>
                        <div class="page-title-head center-elem">
                            <span class="d-inline-block pr-2">
                                <i class="lnr-bus opacity-6"></i>
                            </span>
                            <span class="d-inline-block">DIU Bus Tracking System</span>
                        </div>
                        <div class="page-title-subheading opacity-10">
                            <nav class="" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i aria-hidden="true" class="fa fa-home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Dashboards</a>
                                    </li>
                                    <li class="active breadcrumb-item" aria-current="page">
                                        Home
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Dashboard Row section -->

        <div class="mbg-3 h-auto pl-0 pr-0 bg-transparent no-border card-header">
            <div class="card-header-title fsize-2 text-capitalize font-weight-normal">Overview Section</div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content">
                            <h6 class="widget-subheading">Total Bus</h6>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 w-100">
                                    <div class="widget-chart-flex text-success">
                                        <div class="fsize-4">
                                            <small><i class="fa fa-bus"> </i></small>
                                            {{ $totalBus }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content">
                            <h6 class="widget-subheading">Registered Driver</h6>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 w-100">
                                    <div class="widget-chart-flex text-primary">
                                        <div class="fsize-4">
                                            <small><i class="metismenu-icon pe-7s-users"></i></small>
                                            {{ $totalDriver }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content">
                            <h6 class="widget-subheading">Unassign Bus</h6>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 w-100">
                                    <div class="widget-chart-flex">
                                        <div class="fsize-4 text-danger">
                                            <small class=" text-danger"><i
                                                    class="metismenu-icon pe-7s-exapnd2"></i></small>
                                            {{ $unAssignBus }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content">
                            <h6 class="widget-subheading">Assign Bus</h6>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 w-100">
                                    <div class="widget-chart-flex">
                                        <div class="fsize-4 text-primary">
                                            <small class=" text-bg-primary"><i
                                                    class="metismenu-icon pe-7s-check"></i></small>
                                            {{ $assignBus }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content">
                            <h6 class="widget-subheading">Bus Routes</h6>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 ">
                                    <div class="widget-chart-flex text-warning">
                                        <div class="fsize-4">
                                            <small class="text-warning"> <i
                                                    class="metismenu-icon pe-7s-way"></i></small>
                                            {{ $totalRoute }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                    <div class="widget-chat-wrapper-outer">
                        <div class="widget-chart-content">
                            <h6 class="widget-subheading">Registered User</h6>
                            <div class="widget-chart-flex">
                                <div class="widget-numbers mb-0 ">
                                    <div class="widget-chart-flex text-success">
                                        <div class="fsize-4">
                                            <small class="text-success"><i class="metismenu-icon pe-7s-users"></i>
                                            </small>
                                            {{ $totalUser }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">Bus Schedule Time</div>

            </div>
            <div class="table-responsive">

                <div class="card-body">

                    <table style="width: 100%;" id="process_data_table"
                        class="table table-hover table-striped table-bordered">

                        <thead>
                            <th>Bus Name</th>
                            <th>Driver Name</th>
                            <th>Route Name</th>
                            <th>Start Time</th>
                            <th>Departure Time</th>
                            <th>Route Map</th>
                            <th>Created At</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dolphin 11</td>
                                <td>GH-46544</td>
                                <td><span class="badge badge-success">7.00AM</span></td>
                                <td><span class="badge badge-primary">4.00PM</span></td>
                                <td>Dhanmondi -> DSC</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>Uttara 14</td>
                                <td>GH-46654</td>
                                <td><span class="badge badge-success">10.50 AM</span></td>
                                <td><span class="badge badge-primary">4.00 PM</span></td>
                                <td>Dhanmondi -> DSC</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>Mirpur 10</td>
                                <td>GH-43244</td>
                                <td><span class="badge badge-success">10.50 AM</span></td>
                                <td><span class="badge badge-primary">5:00 PM</span></td>
                                <td>Dhanmondi -> DSC</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>Dolphin 21</td>
                                <td>GH-45544</td>
                                <td><span class="badge badge-success">7.00AM</span></td>
                                <td><span class="badge badge-primary">4.00PM</span></td>
                                <td>Dhanmondi -> DSC</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>Mirpur 5</td>
                                <td>GH-66644</td>
                                <td><span class="badge badge-success">7.00AM</span></td>
                                <td><span class="badge badge-primary">4.00PM</span></td>
                                <td>Dhanmondi -> DSC</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="d-block p-4 text-center card-footer">

                <a class="btn-pill btn-shadow btn-wide fsize-1 btn btn-dark btn-lg"
                    href="{{url('/assign-route-list')}}">
                    <span class="mr-2 opacity-7"><i class="fa fa-cog fa-spin"></i>
                    </span>
                    <span class="mr-1">Assigned Bus Route Schedules</span>
                </a>

            </div>

        </div>

    </div>

</div>

@include('layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
            var table =
            $('#process_data_table').DataTable({
                processing: false,
                serverSide: true,
                paging: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                dom: 'l<"#date-filter">frtip',
                ajax: {
                    url: '{{ route("assign.route.data")}}',
                    type: 'POST',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {
                        data: 'bus_name',
                        name: 'bus_name',
                        searchable: false,
                        render: function(data, type, row) {
                            return row.bus_name+' ('+row.bus_number+')';
                        }

                    },

                    {
                        data: 'name',
                        name: 'name',
                        searchable: false,

                        render: function(data, type, row) {
                            return row.name+' ('+row.mobile+')';
                        }
                    },
                    {
                        data: 'route_name',
                        name: 'route_name',
                        searchable: false,
                        render: function(data, type, row) {
                            return row.route_name+' ('+row.route_code+')';
                        }
                    },
                    {
                        data: 'start_time_slot',
                        name: 'start_time_slot',
                        searchable: false,
                    },
                    {
                        data: 'departure_time_slot',
                        name: 'departure_time_slot',
                        searchable: false,
                    },
                    {
                        data: 'route_map_url',
                        name: 'route_map_url',
                        searchable: false,
                    },
                    {
                        data: 'created_at',

                        name: 'created_at',

                        searchable: false,

                        render: function(data, type, row) {

                            return moment(row.created_at).format("Do MMMM YYYY");
                        }

                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                    }
                ]
            });

            $("table").wrapAll("<div style='overflow-x:auto;width:100%' />");
            $('.dataTables_wrapper').addClass('row');
            $('#process_data_table_length').addClass('col-lg-3 col-md-3 col-sm-3');
            $('#process_data_table_length select').addClass('custom-select custom-select-sm form-control form-control-sm');
            $('#date-filter').addClass('col-lg-4 col-md-4 col-sm-4 adjust');
            $('#process_data_table_filter').addClass('offset-2 col-md-2 col-sm-2');
            $('#process_data_table_filter input').addClass('form-control form-control-sm');

            var date_picker_html = '<div id="date_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;"> <i class="fa fa-calendar"> </i>&nbsp; <span> </span> <i class="fa fa-caret-down"></i></div>';
            $('#date-filter').append(date_picker_html);

            $(function() {
                var start = moment().subtract(29, 'days');
                var end = moment();
                function cb(start, end) {
                    $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'));
                    var range = start.format("YYYY-MM-DD") + "~" + end.format("YYYY-MM-DD");
                    table.columns(5).search(range).draw();
                }

                $('#date_range').daterangepicker({
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment()
                            .subtract(1, 'month').endOf('month')
                        ]
                    }
                }, cb);
                $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
            });
        });
</script>
