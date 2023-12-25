@section('registered-drivers', 'mm-active')
@section('Applications-li', 'mm-active')
@section('Applications-ul', 'mm-show')
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

                                <i class="lnr-users opacity-6"></i>

                            </span>

                            <span class="d-inline-block">Registered Drivers</span>

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

                                        Registered Drivers

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
                            <th>Driver Code</th>
                            <th>Driver Name</th>
                            <th>Email </th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>License Number</th>
                            <th>Nid Number</th>
                            <th>Date Of Birth</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($allDrivers as $singledriver)

                        <tr>
                            <td>D-{{ $singledriver->driver->id }}</td>
                            <td>{{ $singledriver->name }}</td>
                            <td>{{ $singledriver->email }}</td>
                            <td>{{ $singledriver->mobile }}</td>
                            <td>{{ $singledriver->driver->address??'None' }}</td>
                            <td>{{ $singledriver->driver->license_number??'None' }}</td>
                            <td>{{ $singledriver->driver->nid_number }}</td>
                            <td>{{ $singledriver->driver->date_of_birth }}</td>
                            <td>{{ $singledriver->is_active }}</td>
                            <td>{{ $singledriver->created_at}}</td>
                            <td>{{-- <a href="javascript:void(0);" class="btn-shadow btn btn-sm btn-warning" title=""><i
                                        class="fa fa-edit"></i></a> --}}
                                <a href="/driver-delete/{{$singledriver->id }}" class="btn-shadow btn btn-danger"
                                    title="Driver Remove"><i class="fa fa-trash"></i></a>
            </div>
            </td>
            </tr>

            @endforeach
            </tbody>
            </table>
            <div class="d-felx justify-content-center pull-right">
                {{ $allDrivers->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>

</div>

</div>
{{-- <script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    function ajaxStatus(id, the, action) {

        Swal.fire({
                        title: 'Are you sure?',
                        text: 'This employee activity will effected !',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({

                                url: '{{ route('applicant-action') }}',
                                type: 'post',
                                data: {
                                    id: id,
                                    type: 'status',
                                    action: action

                                },
                                dataType: 'json',
                                success: function(response) {

                                   if(response.action=='1'){
                                      Swal.fire("Active", "Applicants activity changed successfully", "success");
                                      $('#process_data_table').DataTable().ajax.reload();
                                    }else if(response.action=='0'){
                                        Swal.fire("Inactive", "Applicants activity changed successfully", "success");
                                        $('#process_data_table').DataTable().ajax.reload();
                                    }else{
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

                    url: '{{ route("hired-employee-data") }}',

                    type: 'POST',

                    data: function(d) {

                        d._token = "{{ csrf_token() }}";

                    }

                },

                columns: [

                    {

                        data: 'EmpCode',

                        name: 'EmpCode',

                        searchable: true,

                    },

                    {

                        data: 'IDCardNumber',

                        name: 'IDCardNumber',

                        searchable: true

                    },
                    {

                        data: 'FullName',

                        name: 'FullName',

                        searchable: true

                    },
                    {

                        data: 'Email',

                        name: 'Email',

                        searchable: true,

                    },
                    {

                        data: 'PresentAddress',

                        name: 'PresentAddress',

                        searchable: true

                    },

                    {

                        data: 'Phone',

                        name: 'Phone',

                        searchable: true,

                    },
                    {

                        data: 'status',

                        name: 'status',

                        searchable: false,

                    },
                    {

                        data: 'DateCreated',

                        name: 'DateCreated',

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
--}}
