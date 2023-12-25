
<div class="main-card card">
    <div class="card-body">
        <table style="width: 100%;" id="process_data_table" class="table table-hover table-striped table-bordered">

            <thead>
                <tr>
                    <th>Emp Code</th>
                    <th>ID Card Number</th>
                    <th>Name</th>
                    <th>Date Assigned</th>
                    <th>Time Assigned</th>
                    <th>Is Accepted</th>
                    <th>Task Status</th>
                    <th id="action">Action</th>
                </tr>

            </thead>

            <tbody>
             @foreach ($data as $key=>$singleData)
                <tr> <?php $emp= \App\Models\EmployeInfo::where('Id',$singleData->EmployeeId)->first(); ?>
                    <td>{{$emp->EmpCode}}</td>
                    <td>{{$emp->IDCardNumber}}</td>
                    <td>{{$emp->FullName}}</td>
                    <td>{{ dateFormate($singleData->DateAssigned) }}</td>
                    <td><div class="badge badge-pill badge-warning"> {{ $singleData->TimeAssigned }}</div></td>
                    <td>@if($singleData->IsAccepted==1)
                        <div class="badge badge-pill badge-success">Yes</div>
                        @else
                        <div class="badge badge-pill badge-danger"> No</div>
                        @endif
                    </td>

                    <td><div class="badge badge-pill badge-info"> {{ $singleData->TaskStatus }}</div></td>
                    @if($singleData->TaskStatus!='Completed')
                    <td><button onclick="ajaxAction({{ $singleData->Id }},this,'cleaner-delete')" class="btn-shadow btn btn-sm btn-danger" title="Delete Cleaner"><i class="fa fa-trash"></i></button></td>
                    @else
                      @if($key==0)
                      <script>
                          $("#action").remove();
                      </script>
                      @endif

                    @endif
                </tr>

             @endforeach
            </tbody>

        </table>
    </div>
</div>
