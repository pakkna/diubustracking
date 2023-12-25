@section('Applications-li', 'mm-active')
@section('Applications-ul', 'mm-show')
@section('pending-estimation-list', 'mm-active')
@include('layouts.header')

@include('layouts.sidebar')

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

                            <span class="d-inline-block">Pending Estimation List</span>

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

                                        Filter Pending Estimation List

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

                <table style="width: 100%;" id="process_data_table" class="table table-hover table-striped table-bordered">

                    <thead>

                        <tr>

                            <th>Order Number</th>
                            <th>Customer Name</th>
                            <th>Customer Mobile</th>
                            <th>Service Type</th>
                            <th>Order Date</th>
                            <th>Total Items</th>
                            <th>Total Cost</th>
                            <th>Vat </th>
                            <th>Gross Rate</th>
                            <th>Total Shedule</th>
                            <th>Task Completed</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>

                    </thead>

                </table>

            </div>

        </div>

        <script>

            function ajaxApprove(id, the, action) {

                Swal.fire({
                title: "Are you sure?",
                text: "are you sure to "+action,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({

                        url: '{{ route("pending-estimation-delete") }}',
                        type: 'post',
                        data: {
                            id: id,
                            type: action,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(response) {

                            if (response.status==true) {
                                $(the).closest("tr").fadeOut(200, function() {
                                    $(this).remove();
                                });
                                Swal.fire({
                                title: "Delete",
                                text: "Estimation deleted successfully",
                                icon: "success",
                                });
                            }else{
                                Swal.fire({
                                title: "Action",
                                text: response.msg,
                                icon: "error",
                                });
                            }

                        }
                    });
                } else {
                    Swal.fire("Your estimation data is safe!");
                }
                });
            }
        </script>




    </div>

</div>

@include('layouts.footer')

<!-- Modal Section -->
<div class="modal fade bd-example-modal-lg" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_header">Estimation Item Details :</h5>
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

                    url: '{{ route("pending-estimation-data") }}',

                    type: 'POST',

                    data: function(d) {

                        d._token = "{{ csrf_token() }}";

                    }

                },

                columns: [

                    {

                        data: 'OrderNumber',

                        name: 'OrderNumber',

                        searchable: true

                    },
                    {

                        data: 'UserName',

                        name: 'UserName',

                        searchable: true,

                    },
                    {

                        data: 'Phone',

                        name: 'Phone',

                        searchable: true,



                    },
                    {

                        data: 'ServiceTypeName',

                        name: 'ServiceTypeName',

                        searchable: true,



                    },
                    {

                        data: 'OrderDate',

                        name: 'OrderDate',

                        searchable: false,

                        render: function(data, type, row) {

                            return moment(row.OrderDate).format("Do MMMM YYYY");
                        }

                    },

                    {

                        data: 'TotalItem',

                        name: 'TotalItem',

                        searchable: true,

                    },
                    {

                        data: 'TotalRate',

                        name: 'TotalRate',

                        searchable: true,

                    },
                    {

                        data: 'TotalVAT',

                        name: 'TotalVAT',

                        searchable: true,

                    },
                    {

                        data: 'GrossRate',

                        name: 'GrossRate',

                        searchable: true,

                    },
                    {

                        data: 'TotalShedule',

                        name: 'TotalShedule',

                        searchable: false,

                    },
                     {

                        data: 'TaskComplete',

                        name: 'TaskComplete',

                        searchable: true,

                        render: function(data, type, row) {

                            return '<div class="badge badge-pill badge-info">'+row.TaskComplete +'</div>';
                        }

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

                $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            $('#date_range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        });

    });

    function get_item_detsils_html(params) {
            $.post('{{ route('orderItem.list') }}', {_token:'{{ csrf_token() }}', id:params}, function(data){
                $('#model_body').empty();
                $('#model_body').html(data);
                $('#modal_header').text('Estimation Item Details:');
            });
    }
    function get_shedule_html(params) {
            $.post('{{ route('orderShedule.list') }}', {_token:'{{ csrf_token() }}', id:params}, function(data){
                $('#model_body').empty();
                $('#model_body').html(data);
                $('#modal_header').text('Invoice Shedules List:');
            });
    }

</script>
