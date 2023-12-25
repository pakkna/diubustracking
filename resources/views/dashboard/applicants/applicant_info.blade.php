
    @include('layouts.header')

    @include('layouts.sidebar')
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
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
                                <span class="d-inline-block"> Cleaner Details</span>
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
                                            Update Cleaner
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

                        <form method="post" action="{{ route('application.submit') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include("layouts.includes.flash")

                            <div class="card-body ">

                                <input class="form-control" type="text" name="addcleaner" value="1" hidden required>
                                <div class="section">
                                    <h5 class="card-title" style="margin-top: 7px;" id="tourist_no">Fill Up With Cleaner
                                        Details : </h5>
                                    <div class=" form-row" style="margin-top: 15px;">
                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">Cleaner Name <span class="important">*</span></label>
                                            <input class="form-control" type="text" name="name" value="{{ $cleaner->name }}" placeholder="Full name"
                                                required>

                                        </div>
                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">Cleaner Email <span
                                                    class="important">*</span></label>
                                            <input class="form-control" type="email" name="email"
                                                placeholder="Email address" value="{{ $cleaner->email }}" required>

                                        </div>
                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">Contact-No <span class="important">*</span></label>
                                            <input class="form-control" type="text" name="phone"
                                                placeholder="Contact Number " value="{{ $cleaner->phone }}" required>
                                        </div>
                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">Cleaner Address <span
                                                    class="important">*</span></label>
                                            <input class="form-control" type="textarea" name="address" value="{{ $cleaner->address }}" placeholder="Address"
                                                required>

                                        </div>

                                    </div>
                                    <div class=" form-row">
                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">Street Address <span
                                                    class="important">*</span></label>
                                            <input class="form-control" type="textarea" name="street_address"
                                                placeholder="Street address" value="{{ $cleaner->street_address }}" required>
                                        </div>
                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">Road / Home No<span
                                                    class="important">*</span></label>
                                            <input class="form-control" type="textarea" name="address2" value="{{ $cleaner->address_line2 }}"
                                                placeholder="Road / Home ">
                                        </div>

                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">City <span class="important">*</span></label>
                                            <input class="form-control" type="text" name="city" placeholder="City" value="{{ $cleaner->city_name }}" required>
                                        </div>
                                        <div class="form-group form-line-height col-lg-3 col-md-12">
                                            <label class="input-label">State <span class="important">*</span></label>
                                            <select class="form-control" name="state" id="state">

                                                <option value="AB">Alberta</option>
                                                <option value="BC">British Columbia</option>
                                                <option value="MB">Manitoba</option>
                                                <option value="NB">New Brunswick</option>
                                                <option value="NL">Newfoundland and Labrador</option>
                                                <option value="NS">Nova Scotia</option>
                                                <option value="ON">Ontario</option>
                                                <option value="PE">Prince Edward Island</option>
                                                <option value="QC">Quebec</option>
                                                <option value="SK">Saskatchewan</option>
                                                <option value="NT">Northwest Territories</option>
                                                <option value="NU">Nunavut</option>
                                                <option value="YT">Yukon</option>
                                            </select>

                                            <script>
                                                $('#state option[value={{ $cleaner->state_name }}]').attr('selected','selected');
                                            </script>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12" style="font-size: 16px;">
                                            <label for="cleaningType" class="col-form-label">Working experience area <span
                                                    class="important">*</span></label>

                                        <?php $cleaning_type= explode(",",$cleaner->work_experience);


                                        ?>
                                            <div style="color:black;margin-top:5px;font-size: 18px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="cleaningtype[]"
                                                        id="deepCleaning1" value="House Cleaning"  <?php echo  in_array("House Cleaning",$cleaning_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning1"> House
                                                        Cleaning</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="cleaningtype[]"
                                                        id="deepCleaning2" value="Food Service"  <?php echo  in_array("Food Service",$cleaning_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning2"> Food
                                                        Service</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="cleaningtype[]"
                                                        id="deepCleaning3" value="Sales" <?php echo  in_array("Sales",$cleaning_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning3"> Sales</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="cleaningtype[]"
                                                        id="deepCleaning12" value="Manufacturing" <?php echo  in_array("Manufacturing",$cleaning_type)? "checked": "";?> >
                                                    <label class="form-check-label" for="deepCleaning12">
                                                        Manufacturing</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="cleaningtype[]"
                                                        id="deepCleaning4" value="Clerical" <?php echo  in_array("Clerical",$cleaning_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning4"> Clerical</label>
                                                </div>
                                                <div class="form-check form-check-inline" id="other">
                                                    <input class="form-check-input" type="checkbox" name="cleaningtype[]"
                                                        id="deepCleaning5" value="Other" <?php echo  in_array("Other",$cleaning_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning5"> Other</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class=" form-row">
                                        <div class="form-group form-line-height col-lg-4 col-md-12">
                                            <label class="input-label">If other, please specify working area </label>
                                            <input class="form-control" type="text" name="other_working_area"
                                                placeholder="Other working area" value="{{ $cleaner->other_experience }}">
                                        </div>
                                        <div class="form-group form-line-height col-lg-4 col-md-12">
                                            <label class="input-label">When will you be available?<span
                                                    class="important">*</span></label>
                                            <select class="form-control" name="time_available" id="time_available">
                                                <option value="Now">Now</option>
                                                <option value="Within 2 weeks of hire date">Within 2 weeks of hire date
                                                </option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <script>
                                                $('#time_available option[value={{$cleaner->time_available}}]').attr('selected','selected');
                                            </script>
                                        </div>

                                        <div class="form-group form-line-height col-lg-4 col-md-12">
                                            <label class="input-label">If other, When will you be available? </label>
                                            <input class="form-control" type="text" name="time_available_other"
                                                placeholder="If other specify available time" value="{{ $cleaner->time_duration_present_address }}">
                                        </div>


                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group form-line-height">
                                            <label for="Description" class="card-header ">Employment Background ? </label>
                                            <textarea class="form-control" id="background" name="em_background"
                                                placeholder="Write down your experience">{{ $cleaner->employment_background }}</textarea>

                                            <script>
                                                CKEDITOR.replace('background');
                                            </script>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative form-group form-line-height">
                                            <label for="Description" class="card-header ">Prior Work Experience ? </label>
                                            <textarea class="form-control" id="description" name="experience"
                                                placeholder="Write down your experience">{{ $cleaner->prior_experience }}</textarea>
                                            <script>
                                                CKEDITOR.replace('description');
                                            </script>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row">

                                        <?php $ql_type= explode(",",$cleaner->qualifications); ?>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label for="qualifications" class="col-form-label">Qualifications :</label>
                                            <div style="color:black;margin-top:5px;font-size:16px">
                                                <div class="form-check form-check-block">
                                                    <input class="form-check-input" type="checkbox" name="qualifications[]" id="deepCleaning6" value="1" <?php echo  in_array("1",$ql_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning6"> Valid Driver's License</label>
                                                </div>
                                                <div class="form-check form-check-block">
                                                    <input class="form-check-input" type="checkbox" name="qualifications[]" id="deepCleaning7" value="2" <?php echo  in_array("2",$ql_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning7"> Own Transportation (insurance required)</label>
                                                </div>
                                                <div class="form-check form-check-block">
                                                    <input class="form-check-input" type="checkbox" name="qualifications[]" id="deepCleaning8" value="3" <?php echo  in_array("3",$ql_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning8"> Are you able to perform typical tasks associated with cleaning duties (standing, bending, kneeling, and lifting up to 50 pounds)?</label>
                                                </div>
                                                <div class="form-check form-check-block">
                                                    <input class="form-check-input" type="checkbox" name="qualifications[]" id="deepCleaning9" value="4" <?php echo  in_array("4",$ql_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning9"> Have you ever been convicted of a criminal offense? (All employees are required to be bonded, and we will conduct a police background and driving check prior to hiring any candidate.)</label>
                                                </div>
                                                <div class="form-check form-check-block">
                                                    <input class="form-check-input" type="checkbox" name="qualifications[]" id="deepCleaning10" value="5" <?php echo  in_array("5",$ql_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning10"> Can you provide proof that you can work legally in this country?</label>
                                                </div>
                                                <div class="form-check form-check-block">
                                                    <input class="form-check-input" type="checkbox" name="qualifications[]" id="deepCleaning11" value="6" <?php echo  in_array("6",$ql_type)? "checked": "";?>>
                                                    <label class="form-check-label" for="deepCleaning11"> Others</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label for="em_background" class="col-form-label">(If anything else you would like to tell us):</label>
                                            <textarea class="form-control" id="comments" name="comments"
                                            placeholder="Comments, If anything else you would like to tell us.">{{ $cleaner->remarks }}</textarea>
                                            <script>
                                                CKEDITOR.replace('comments');
                                            </script>
                                           <br>
                                            <p style="color:black;margin:0px;" style="display: none;">
                                                (In submitting this application, Recheck your application your fields.)</p>

                                        </div>
                                    </div>

                                </div>

                            </div>



                            {{-- <div class="form-row text-center">
                                <div class="offset-4 col-md-4">
                                    <div class="position-relative form-group" id="submit_button">

                                      <input value="Update" id="date" class="btn-wide mb-2 mr-2 mt-3 btn btn-shadow btn-gradient-info btn-lg" type="submit"></div>
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


