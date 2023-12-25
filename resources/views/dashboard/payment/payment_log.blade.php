
<div class="main-card card">
    <div class="card-body">
        <table style="width: 100%;" id="process_data_table" class="table table-hover table-striped table-bordered">

            <thead>
                <tr>
                    {{-- <th>Invoice Number</th>
                    <th>Order Number</th>
                    <th>Customer Name</th> --}}
                    <th>Card Brand</th>
                    <th>Total Cost</th>
                    <th>Vat </th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>
             @foreach ($PaymentLog as $singleData)
                <tr>
                    <td>{{ $singleData->card_brand }}</td>
                   
                    <td>{{ $singleData->total_rate }}</td>
                    <td>{{ $singleData->total_vat }}</td>
                   
                    <td>{{ $singleData->seller_message }}</td>
                    <td>@if($singleData->payment_status=='failed')
                        <div class="badge badge-pill badge-danger">{{ $singleData->payment_status }}</div>
                        @else
                        <div class="badge badge-pill badge-success">{{ $singleData->payment_status }}</div>
                        @endif
                    </td>
                
                </tr>

             @endforeach
            </tbody>

        </table>
    </div>
</div>
