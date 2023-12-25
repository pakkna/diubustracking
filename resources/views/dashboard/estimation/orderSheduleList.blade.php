
<div class="main-card card">
    <div class="card-body">
        <table style="width: 100%;" class="table table-hover table-striped table-bordered">

            <thead>
                <tr>
                    <th>OrderNumber</th>
                    <th>Task Date</th>
                    <th>Task Time</th>
                    <th>Status</th>
                    @if(Auth::user()->model_id==1)
                    <th>Action</th>
                    @endif
                </tr>

            </thead>

            <tbody>
             @foreach ($data as $singleData)
                <tr>
                    <td>{{ $singleData->OrderNumber}}</td>

                    <td>{{ dateFormate($singleData->ScheduleDate) }}</td>
                    <td>{{ $singleData->ScheduleTime }}</td>
                    <td>@if($singleData->ScheduleStatus=="Pending")
                        <div class="badge badge-pill badge-danger pl-2 pr-2">{{ $singleData->ScheduleStatus }}</div>
                    @elseif($singleData->ScheduleStatus=="Completed")
                        <div class="badge badge-pill badge-success pl-2 pr-2">{{ $singleData->ScheduleStatus }}</div>
                    @else
                         <div class="badge badge-pill badge-info pl-2 pr-2">{{ $singleData->ScheduleStatus }}</div>
                    @endif
                    </td>
                    @if(Auth::user()->model_id==1 && $singleData->ScheduleStatus=="Pending")
                    <td>
                        <a href="/cleaner-list/{{$singleData->OrderId}}/{{ $singleData->OrderNumber }}/{{$singleData->Id}}/{{$singleData->ScheduleDate}}/{{$singleData->ScheduleTime}}/{{$singleData->CustomerId}}" class="btn-shadow btn btn-sm btn-primary" title="Get A Cleaner"><i class="fa fa-user"></i> Get Cleaner</a>
                    </td>
                    @endif
                </tr>

             @endforeach
            </tbody>

        </table>
    </div>
</div>
