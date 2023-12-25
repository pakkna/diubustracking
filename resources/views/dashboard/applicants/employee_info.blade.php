
@include('layouts.header')

@include('layouts.sidebar')

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
                            <span class="d-inline-block"> Employee Info</span>
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
                                        Cleaner Detiils
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Dashboard Row section -->
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">

                    <form method="post" action="#" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include("layouts.includes.flash")

                        <div class="card-body ">

                            <input class="form-control" type="text" name="useRole" value="{{ encrypt(3) }}" hidden required>
                            <div class="section">
                                <h5 class="card-title" style="margin-top: 7px;" id="tourist_no"> Employe Code : <b style="color: rgb(22, 22, 92);">{{ $employeInfo->EmpCode }} </b> <br><br>  ID Card Number : <b style="color: rgb(22, 22, 92)">{{ $employeInfo->IDCardNumber }} </b>
                                 </h5>
                                 <hr>
                                <div class="form-row">
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Cleaner Name <span class="important">*</span></label>
                                        <input class="form-control" type="text" name="name" value="{{ $employeInfo->FullName }}" placeholder="Full name"
                                            required>

                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Cleaner Email <span
                                                class="important">*</span></label>
                                        <input class="form-control" type="email" name="Email" value="{{ $employeInfo->Email }}"
                                            placeholder="Email address" required>

                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Father Name <span class="important">*</span></label>
                                        <input class="form-control" type="text" name="father"  value="{{ $employeInfo->FatherName }}" placeholder="Father name"
                                            required>

                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Mother Name <span class="important">*</span></label>
                                        <input class="form-control" type="text" name="mother" value="{{ $employeInfo->MotherName }}" placeholder="Mother name"
                                            required>

                                    </div>
                                </div>
                                <div class="form-row" >
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Contact-No <span class="important">*</span></label>
                                        <input class="form-control" type="text" name="phone"
                                            placeholder="Contact Number " value="{{ $employeInfo->Phone }}" required>
                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Present Address <span
                                                class="important">*</span></label>
                                        <input class="form-control" type="textarea" name="present_address"
                                            placeholder="Present Address" value="{{ $employeInfo->PresentAddress }}" required>
                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Permanent Address</label>
                                        <input class="form-control" type="textarea" name="permanent_address" value="{{ $employeInfo->permanenetAddress }}"
                                            placeholder="Permanent Address" required>
                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Marital Status <span
                                                class="important">*</span></label>
                                        <select class="form-control" id="marital_status" name="marital_status">
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Date of Birth <span
                                                class="important">*</span></label>
                                        <input class="form-control" type="text" data-toggle="datepicker" name="dob"
                                            placeholder="Date of Birth" value="{{ date('m/d/Y', strtotime($employeInfo->DOB)) }}" required>
                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">Sex <span class="important">*</span></label>
                                        <select class="form-control" id="sex" name="sex">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>

                                    </div>
                                    <div class="form-group form-line-height col-lg-3 col-md-12">
                                        <label class="input-label">National ID / Passport<span
                                                class="important">*</span></label>
                                        <input class="form-control" type="textarea" name="doc_no" value="{{ $employeInfo->PassportNumber }}"
                                            placeholder="National ID/ Passport">
                                    </div>
                                     <div class="custom-file form-line-height col-lg-3 col-md-12 mt-4">
                                        <input type="file" class="custom-file-input"  name="image" id="validatedCustomFile" >
                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                      </div>
                                      <script>
                                        // Add the following code if you want the name of the file appear on select
                                        $(".custom-file-input").on("change", function() {
                                          var fileName = $(this).val().split("\\").pop();
                                          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                        });

                                        $('#marital_status option[value="{{$employeInfo->MaritalStatus}}"]').attr('selected','selected');

                                        $('#sex option[value="{{$employeInfo->Sex}}"]').attr('selected','selected');
                                      </script>
                                </div>

                            </div>

                        </div>

                        {{-- <div class="form-row text-center">
                            <div class="offset-4 col-md-4">
                                <div class="position-relative form-group" id="submit_button">

                                    <input value="Submit" id="date"
                                        class="btn-wide mb-2 mr-2 mt-3 btn btn-shadow btn-gradient-info btn-lg"
                                        type="submit">
                                </div>
                            </div>
                        </div> --}}

                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
</div>
@include('layouts.footer')

