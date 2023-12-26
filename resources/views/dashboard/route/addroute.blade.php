@section('Applications-li', 'mm-active')
@section('Applications-ul', 'mm-show')
@section('route-create', 'mm-active')
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
                                <i class="lnr-users opacity-6"></i>
                            </span>
                            <span class="d-inline-block">Add New Bus Route</span>
                        </div>
                        <div class="page-title-subheading opacity-10">
                            <nav class="" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i aria-hidden="true" class="fa fa-users-cog"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Dashboards</a>
                                    </li>
                                    <li class="active breadcrumb-item" aria-current="page">
                                        Add New Route
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

                    <form method="post" action="{{ route('route.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @include("layouts.includes.flash")

                        <div class="card-body ">
                            <div class="section">
                                <h5 class="card-title" style="margin-top: 7px;">Fill Up Route
                                    Details : </h5>
                                <div class="form-row">
                                    <div class="form-group form-line-height col-lg-4 col-md-12">
                                        <label class="input-label">Route Name <span
                                                class="important text-danger">*</span></label>
                                        <input class="form-control" type="text" name="route_name"
                                            placeholder="Route Name" value="{{ old('route_name') }}" required>

                                    </div>
                                    <div class="form-group form-line-height col-lg-4 col-md-12">
                                        <label class="input-label">Route Code <span
                                                class="important text-danger">*</span></label>
                                        <input class="form-control" type="text" name="route_code"
                                            placeholder="Route Code" value="{{ old('route_code') }}" required>
                                    </div>
                                    <div class="form-group form-line-height col-lg-4 col-md-12">
                                        <label class="input-label">Route Details <span
                                                class="important text-danger">*</span></label>
                                        <input class="form-control" type="text" name="route_details"
                                            placeholder="Route Details" value="{{ old('route_details') }}" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group form-line-height col-lg-4 col-md-12">
                                        <label class="input-label">Start Time Slot </label>
                                        <input class="form-control" type="text" name="start_time_slot"
                                            placeholder="Start Time Slot" value="{{ old('start_time_slot') }}">

                                    </div>
                                    <div class="form-group form-line-height col-lg-4 col-md-12">
                                        <label class="input-label">Departure Time Slot <span
                                                class="important">*</span></label>
                                        <input class="form-control" type="text" name="departure_time_slot"
                                            placeholder="Departure Time Slot" value="{{ old('departure_time_slot') }}"
                                            required>
                                    </div>
                                    <div class="form-group form-line-height col-lg-4 col-md-12">
                                        <label class="input-label">Route Map Url <span
                                                class="important text-danger">*</span></label>
                                        <input class="form-control" type="text" data-toggle="datepicker"
                                            name="route_map_url " placeholder="Route Map Url"
                                            value="{{ old('route_map_url') }}" required>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="form-row text-center">
                            <div class="offset-4 col-md-4">
                                <div class="position-relative form-group" id="submit_button">

                                    <input value="Submit" id="date"
                                        class="btn-wide mb-2 mr-2 mt-3 btn btn-shadow btn-gradient-info btn-lg"
                                        type="submit">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

</div>

@include('layouts.footer')
