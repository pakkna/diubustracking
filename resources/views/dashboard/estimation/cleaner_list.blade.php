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

                            <span class="d-inline-block">Cleaner List</span>

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

                                        Filter Cleaner List

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
                <form method="post" action="{{route('assign.task.to.cleaner')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <table style="width: 100%;" id="cleaner_data_table"
                    class="table table-hover table-striped table-bordered">

                    <thead>

                        <tr>
                            <th>
                                <center>Select / Emp Code</center>
                            </th>
                            <th>ID Card Number</th>
                            <th>FullName</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>

                    </thead>

                </table>
                <input type="hidden" name="OrderId" value="{{$OrderId}}">
                <input type="hidden" name="TaskDate" value="{{$ScheduleDate}}">
                <input type="hidden" name="TaskTime" value="{{$ScheduleTime}}">
                <input type="hidden" name="CustomerId" value="{{$CustomerId}}">
                <input type="hidden" name="SheduleId" value="{{$SheduleId}}">
                <div class="text-left d-block p-3 card-footer text-center" id="all_approve">
                    <button class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-md" type="submit">
                        <span class="mr-2 opacity-7">
                            <i class="icon ion-ios-settings"></i>
                        </span>
                        <span class="mr-1">Submit Task</span>
                    </button>
                </div>
                </form>
            </div>

        </div>

    </div>

</div>

@include('layouts.footer')
<script type="text/javascript">
    $(document).ready(function () {

        var table =
            $('#cleaner_data_table').DataTable({


                processing: false,

                serverSide: true,

                paging: true,

                pageLength: 10,

                lengthChange: true,

                searching: true,

                ordering: true,

                info: true,

                autoWidth: false,

                dom: '<"#OrderNumber">frtip',

                ajax: {

                    url: '{{ route("free-getcleaner-list") }}',

                    type: 'POST',

                    data: function (d) {

                        d._token = "{{ csrf_token() }}";
                        d.OrderId = "{{ $OrderId }}";
                        d.SheduleId = "{{ $SheduleId }}";
                        d.ScheduleDate = "{{ $ScheduleDate }}";
                        d.ScheduleTime = "{{ $ScheduleTime }}";
                        d.CustomerId = "{{ $CustomerId }}";

                    }

                },

                columns: [

                    // {
                    //     render: function (data, type, row, meta) {
                    //       return meta.row + meta.settings._iDisplayStart + 1;
                    //     }
                    // },
                    {

                        data: 'select',

                        name: 'select',

                        searchable: false,

                    },
                    {

                        data: 'IDCardNumber',

                        name: 'IDCardNumber',

                        searchable: true,

                    },
                    {

                        data: 'FullName',

                        name: 'FullName',

                        searchable: true,

                    },
                    {

                        data: 'Email',

                        name: 'Email',

                        searchable: true

                    },
                    {

                        data: 'Phone',

                        name: 'Phone',

                        searchable: true,

                    }

                ]

            });

            $('#OrderNumber').html('Order Number: &nbsp&nbsp <span><strong>{{ $OrderNumber }}</strong></span>&nbsp | &nbsp &nbspTask Date: &nbsp&nbsp <span><strong>{{ dateFormate($ScheduleDate)}}</strong></span');




    });
</script>
