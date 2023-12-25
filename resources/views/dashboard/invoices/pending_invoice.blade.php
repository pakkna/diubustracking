@section('Applications-li', 'mm-active')
@section('Applications-ul', 'mm-show')
@section('pending-invoices-list', 'mm-active')
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

                            <span class="d-inline-block">Pending Invoice</span>

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

                                        Filter Pending Invoice List

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

                            <th>Invoice Number</th>
                            <th>Order Number</th>
                            <th>Task Number</th>
                            <th>Customer Name</th>
                            <th>Customer Mobile</th>
                            <th>Inv Date</th>
                            <th>Total Items</th>
                            <th>Total Cost</th>
                            <th>Vat </th>
                            <th>Gross Rate</th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_header">Invoice Item Details :</h5>
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

                dom: 'lfrtip',

                ajax: {

                    url: '{{ route("pending.invoice.data") }}',

                    type: 'POST',

                    data: function(d) {

                        d._token = "{{ csrf_token() }}";

                    }

                },

                columns: [
                    {

                        data: 'InvoiceNumber',

                        name: 'InvoiceNumber',

                        searchable: true

                    },
                    {

                        data: 'OrderNumber',

                        name: 'OrderNumber',

                        searchable: true

                    },
                    {

                        data: 'TaskNumber',

                        name: 'TaskNumber',

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

                        data: 'InvDate',

                        name: 'InvDate',

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

                        searchable: false,

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
    });

    function get_item_detsils_html(params) {
            $.post('{{ route('orderItem.list') }}', {_token:'{{ csrf_token() }}', id:params}, function(data){
                $('#model_body').empty();
                $('#model_body').html(data);
                $('#modal_header').text('Estimation Item Details:');
            });
    }
    function get_assign_cleaner_html(params) {
            $.post('{{ route('Task.Assigned.Cleaners.list') }}', {_token:'{{ csrf_token() }}', TaskId:params}, function(data){
                $('#model_body').empty();
                $('#model_body').html(data);
                $('#modal_header').text('Task Assign Cleaners Details:');
            });
    }
    function get_user_payment_log_html(params) {
            $.post('{{ route('Task.Payment.Log') }}', {_token:'{{ csrf_token() }}', InvoiceId:params}, function(data){
                $('#model_body').empty();
                $('#model_body').html(data);
                $('#modal_header').text('Invoice Payment Log:');
            });
    }
    function card_payment(params) {
        $('#mymodal').modal('hide');
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to pay for this Invoice?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Confirm it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('{{ route('card-payment') }}', {_token:'{{ csrf_token() }}', InvoiceId:params}, function(response){
                    //if(response.success == true){
                        Swal.fire(response.title, response.msg , response.alert);
                        $('#process_data_table').DataTable().ajax.reload();
                    //}
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'You have denied to payment!',
                        'error'
                    );
                }
            });
    }
</script>
