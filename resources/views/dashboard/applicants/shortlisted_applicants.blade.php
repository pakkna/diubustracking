@section('Applications-li', 'mm-active')
@section('Applications-ul', 'mm-show')
@section('applicants-shortlist', 'mm-active')
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

                            <span class="d-inline-block">Shortlisted Applicants</span>

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

                                        Filter Shortlist Applicants List

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
            <form id="mail_form" method="post" action="{{route('send-mail')}}" enctype="multipart/form-data">
            <div class="card-body">

                <table style="width: 100%;" id="process_data_table" class="table table-hover table-striped table-bordered">

                    <thead>

                        <tr>

                            <th>Reg-Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Full Address</th>
                            <th>Work Experience</th>
                            <th>Phone</th>
                            <th>Time_available</th>
                            <th>Mailed</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>

                    </thead>

                </table>

            </div>
            <div class="text-center d-block p-3 card-footer">
                {{-- <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-success btn-lg" type="button"  data-toggle="modal" data-target=".bd-example-modal-lg"> --}}
                <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-success btn-lg" type="submit">
                    <span class="mr-2 opacity-10">
                        <i class="metismenu-icon pe-7s-mail-open-file"></i>
                    </span>
                    <span class="mr-1">Send Mail</span>
                </button>
            </div>
        </div>

        <script>
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


         function ajaxApprove(id, the, action) {

                if (action == "delete") {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover applicants info!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({

                                url: '{{ route('applicant-action') }}',
                                type: 'post',
                                data: {
                                    id: id,
                                    type: action
                                },
                                dataType: 'json',
                                success: function(response) {

                                    $(the).closest("tr").fadeOut(200, function() {
                                        $(this).remove();
                                    });
                                    Swal.fire("Delete", "Application deleted successfully", "success");
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Cancelled',
                                'Your imaginary file is safe.',
                                'error'
                            )
                        }
                    });
                } else {

                    $.ajax({

                        url: '{{ route('applicant-action') }}',
                        type: 'post',
                        data: {
                            id: id,
                            type: action
                        },
                        dataType: 'json',
                        success: function(response) {

                            $(the).closest("tr").fadeOut(200, function() {
                                $(this).remove();
                            });
                            Swal.fire("Pending", "Application info return to pending list", "success");
                        }
                    });
                }


            }
        </script>

    </div>

</div>

@include('layouts.footer')
<!------------------Large modal ---------------->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Send Mail To Applicants</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  id="MyPopup" >

                {{ csrf_field() }}

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="title" class="">Subject</label>
                                <input name="subject" id="subject" placeholder="Subject" value="Confirmation | Preliminary Hiring Process" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="Description" class="">Message</label>
                                <textarea class="form-control" id="message" name="message"></textarea>
                                <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
                                <script>
                                    CKEDITOR.replace('message');
                                </script>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer" style="display: flex;">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="close">Close</button>
                <button type="submit" class="btn btn-primary" onclick="send_function()">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {

        function send_function(){
            $("#MyPopup").html('<center><p>Please wait mail is sending.... </p><strong>Note:</strong> If mail are sent it wiil auto close.</center>');
            $("#send").remove();
            $("#close").remove();
        }
    });
</script>
{{-- <div class="body-block-example-2 d-none" style="cursor: default;">
    <div class="loader">
        <div class="ball-pulse-sync">
            <div class="bg-success"></div>
            <div class="bg-success"></div>
            <div class="bg-success"></div>
        </div>
    </div>
</div>
<svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;"><defs id="SvgjsDefs1002"></defs><polyline id="SvgjsPolyline1003" points="0,0"></polyline><path id="SvgjsPath1004" d="M0 0 "></path></svg> --}}
<!------------------Large modal ---------------->

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

                    url: '{{ route("shortlist-applicants-data") }}',

                    type: 'POST',

                    data: function(d) {

                        d._token = "{{ csrf_token() }}";

                    }

                },

                columns: [

                    {

                        data: 'select',

                        name: 'select',

                        searchable: false,

                    },

                    {

                        data: 'name',

                        name: 'name',

                        searchable: true

                    },
                    {

                        data: 'email',

                        name: 'email',

                        searchable: true,

                    },
                    {

                        data: 'full_address',

                        name: 'full_address',

                        searchable: true

                    },
                    {

                        data: 'work_experience',

                        name: 'work_experience',

                        searchable: true,


                    },
                    {

                        data: 'phone',

                        name: 'phone',

                        searchable: true,

                    },
                    {

                        data: 'time_available',

                        name: 'time_available',

                        searchable: true,

                    },
                    {

                        data: 'mail',

                        name: 'mail',

                        searchable: false,

                    },
                    {

                        data: 'status',

                        name: 'status',

                        searchable: false,

                    },
                    {

                        data: 'added_date',

                        name: 'added_date',

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
