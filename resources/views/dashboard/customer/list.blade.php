@section('Applications-li', 'mm-active')
@section('Applications-ul', 'mm-show')
@section('customer-list', 'mm-active')
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

                            <span class="d-inline-block">Customer List</span>

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

                                        Filter Customer List

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
            <form method="post" action="{{route('do-all-short-list')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="card-body">

                <table style="width: 100%;" id="process_data_table" class="table table-hover table-striped table-bordered">

                    <thead>

                        <tr>

                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Street No</th>
                            <th>Street Name</th>
                            <th>City</th>
                            <th>PostCode</th>
                            <th>Created At</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>

                    </thead>

                </table>

            </div>
           
            </form>

        </div>

        <script>
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


            function ajaxApprove(id, the, action) {

                $.ajax({

                    url: '{{ route("pending-estimation-delete") }}',
                    type: 'post',
                    data: {
                        id: id,
                        type: action
                    },
                    dataType: 'json',
                    success: function(response) {

                        if (response==1) {
                            $(the).closest("tr").fadeOut(200, function() {
                                $(this).remove();
                            });
                            swal({
                            title: "Delete",
                            text: "Estimation deleted successfully",
                            icon: "success",
                            });    
                        }else{
                            swal({
                            title: "Action",
                            text: "application action error",
                            icon: "error",
                            });   
                        }


                    }
                });
            }
        </script>




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

                    url: '{{ route("customer-data") }}',

                    type: 'POST',

                    data: function(d) {

                        d._token = "{{ csrf_token() }}";

                    }

                },

                columns: [
                     
                    {

                        data: 'Id',

                        name: 'Id',

                        searchable: false

                    },
                    {

                        data: 'name',

                        name: 'name',

                        searchable: true,

                    },
                    {

                        data: 'UserName',

                        name: 'UserName',

                        searchable: true,

                    },
                    {

                        data: 'Phone',

                        name: 'Phone',

                        searchable: true

                    },
                    {

                        data: 'StreetNo',

                        name: 'StreetNo',

                        searchable: true

                    },
                    
                    {

                        data: 'StreetName',

                        name: 'StreetName',

                        searchable: true,

                    },
                    {

                        data: 'City',

                        name: 'City',

                        searchable: true,

                    },
                  
                    {

                        data: 'PostCode',

                        name: 'PostCode',

                        searchable: true,


                    },
                    {

                        data: 'CreateDate',

                        name: 'CreateDate',

                        searchable: false,

                        render: function(data, type, row) {

                            return moment(row.added_date).format("MMMM Do YYYY");
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
</script>