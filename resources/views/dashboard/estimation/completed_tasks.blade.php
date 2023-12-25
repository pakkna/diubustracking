
@section('completed-task', 'mm-active')
@include('layouts.header')

@include('layouts.sidebar')

<!-- Dashboard Header  section -->

<!-- Dashboard Header  section -->

<div class="app-main__outer">

    <div class="app-main__inner">

        <div class="app-page-title app-page-title-simple">

            <div class="page-title-wrapper">

                <div class="page-title-heading">

                    <div>

                        <div class="page-title-head center-elem">

                            <span class="d-inline-block pr-2">

                                <i class="lnr-apartment opacity-6"></i>

                            </span>

                            <span class="d-inline-block">Competed Task List</span>

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

                                        Check Completed Tasks

                                    </li>

                                </ol>

                            </nav>

                        </div>

                    </div>

                </div>



            </div>

        </div>



        <!-- table Section -->

        <div class="mbg-3 h-auto pl-0 pr-0 bg-transparent no-border card-header">

            <div class="card-header-title fsize-5 text-capitalize font-weight-normal"></div>

        </div>



        @include("layouts.includes.flash")

        <div class="main-card mb-3 card">
            <div class="card-body">

                <table style="width: 100%;" id="process_data_table"
                    class="table table-hover table-striped table-bordered">

                    <thead>

                        <tr>
                            <th>Task Number</th>
                            <th>Order Number</th>
                            <th>Customer Name</th>
                            <th>Start Time</th>
                            <th>Start Date</th>
                            <th>Complete Time</th>
                            <th>Complete Date</th>
                            <th>Status</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>

                    </thead>

                </table>

            </div>

        </div>

        <script>
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            function ajaxAction(id, the, action) {

                Swal.fire({
                                title: 'Are you sure?',
                                text: 'This Task activity will effected !',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No'
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    $.ajax({

                                        url: '{{ route('Task.info.action') }}',
                                        type: 'post',
                                        data: {
                                            id: id,
                                            action: action

                                        },
                                        dataType: 'json',
                                        success: function(response) {

                                           if(response==1){
                                              Swal.fire("Active", "Task activity deleted successfully", "success");
                                              $('#process_data_table').DataTable().ajax.reload();
                                            }else if(response==2){
                                              $('#cleaner_assign_table').click()
                                              Swal.fire("Active", "Cleaner deleted successfully", "success");

                                            }
                                            else{
                                                Swal.fire(
                                                    'Action Error',
                                                    'Your imaginary status is not change.',
                                                    'error'
                                                )
                                            }

                                        }
                                    });
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    Swal.fire(
                                        'Cancelled',
                                        'Your imaginary status is safe.',
                                        'error'
                                    )
                                }
                    });

            }
        </script>

    </div>

</div>

@include('layouts.footer')
<!-- Modal Section -->
<div class="modal fade bd-example-modal-lg"  id="newModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_header">Task Assigned Cleaners :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="model_body">


            </div>
            <div class="modal-footer" style="display: flex;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

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

                    url: '{{ route("completed.tasks.data") }}',

                    type: 'POST',

                    data: function (d) {

                        d._token = "{{ csrf_token() }}";

                    }

                },

                columns: [

                    {

                        data: 'TasKNumber',

                        name: 'TasKNumber',

                        searchable: true,

                    },
                    {

                        data: 'OrderNumber',

                        name: 'OrderNumber',

                        searchable: false

                    },
                    {

                        data: 'CustomerName',

                        name: 'CustomerName',

                        searchable: false,

                    },
                    {

                        data: 'StartedTime',

                        name: 'StartedTime',

                        searchable: false,


                    },
                    {

                        data: 'StartDate',

                        name: 'StartDate',

                        searchable: false,

                        render: function (data, type, row) {
                            
                            if(row.StartDate){
                                return moment(row.StartDate).format("MMMM Do YYYY");
                            }else{
                                return row.StartDate;
                            }
                        }

                    },
                    {

                        data: 'CompletedTime',

                        name: 'CompletedTime',

                        searchable: false,


                    },
                    {

                        data: 'CompleteDate',

                        name: 'CompleteDate',

                        searchable: false,

                        render: function (data, type, row) {

                            if(row.CompleteDate){
                                return moment(row.CompleteDate).format("MMMM Do YYYY");
                            }else{
                                return row.CompleteDate;
                            }

                        }

                    },
                    {

                        data: 'Status',

                        name: 'Status',

                        searchable: false,

                    },
                    {

                        data: 'action',

                        name: 'action',

                        searchable: false,

                    },

                ]

            });


        $("table").wrapAll("<div style='overflow-x:auto;width:100%' />");

        $('.dataTables_wrapper').addClass('row');

        // $('.dataTables_processing').addClass('m-loader m-loader--brand');

        $('#process_data_table_length').addClass('col-lg-3 col-md-3 col-sm-3');

        $('#process_data_table_length select').addClass(
            'custom-select custom-select-sm form-control form-control-sm');

        $('#date-filter').addClass('col-lg-4 col-md-4 col-sm-4 adjust');

        $('#process_data_table_filter').addClass('offset-2 col-md-2 col-sm-2');

        $('#process_data_table_filter input').addClass('form-control form-control-sm');



        var date_picker_html =
            '<div id="date_range" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;"> <i class="fa fa-calendar"> </i>&nbsp; <span> </span> <i class="fa fa-caret-down"></i></div>';

        $('#date-filter').append(date_picker_html);

        $(function () {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {

                $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));

                var range = start.format("YYYY-MM-DD") + "~" + end.format("YYYY-MM-DD");

                table.columns(7).search(range).draw();

                //alert(range);
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

    function get_assign_cleaner_html(params) {
            $.post('{{ route('Task.Assigned.Cleaners.list') }}', {_token:'{{ csrf_token() }}', TaskId:params}, function(data){
                $('#model_body').empty();
                $('#model_body').html(data);
            });
    }
    function get_item_detsils_html(params) {
            $.post('{{ route('orderItem.list') }}', {_token:'{{ csrf_token() }}', id:params}, function(data){
                $('#model_body').empty();
                $('#model_body').html(data);
                $('#modal_header').text('Estimation Item Details:');
            });
    }
</script>
