
<div class="main-card card">
    <div class="card-body">
        <table style="width: 100%;" id="process_data_table" class="table table-hover table-striped table-bordered">

            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item Details</th>
                    <th>Quantity</th>
                    <th>Unit Rate</th>
                    <th>Total Rate</th>
                    {{-- <th>Status</th> --}}
                </tr>

            </thead>

            <tbody>
             @foreach ($data as $singleData)
                <tr>
                    <td>{{ $singleData->ItemName }}</td>
                    <td>@if(empty($singleData->ItemDetailTitle))
                            {{ $singleData->ItemName }}
                        @else
                        {{$singleData->ItemDetailTitle}}
                        @endif
                    </td>
                    <td>{{ $singleData->Quantity }}</td>
                    <td>{{ $singleData->UniteRate }}</td>
                    <td>{{ $singleData->TotalRate }}</td>
                    {{-- <td><div class="badge badge-pill badge-info">{{ $singleData->Status}}</div></td> --}}

                </tr>

             @endforeach
            </tbody>

        </table>
    </div>
</div>
