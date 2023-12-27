<div class="scrollbar-sidebar ps ps--active-y">

    <div class="app-sidebar__inner">

        <ul class="vertical-nav-menu metismenu">
            <li class="app-sidebar__heading">Dashbaord Overview</li>
            <li>
                <a href="{{URL('/dashboard')}}" aria-expanded="true" class="@yield('dashboard')">
                    <i class="metismenu-icon pe-7s-home"></i>
                    Dashbaord
                </a>
            </li>
            <li class="app-sidebar__heading">Driver Information</li>
            <li>
                <a href="{{URL('/driver-registration')}}" aria-expanded="true" class="@yield('driver-registration')">
                    <i class="metismenu-icon pe-7s-note"></i>
                    Driver Registration
                </a>
            </li>
            <li>
                <a href="{{URL('/registered-drivers')}}" aria-expanded="true" class="@yield('registered-drivers')">
                    <i class="metismenu-icon pe-7s-note2"></i>
                    Registered Drivers
                </a>
            </li>
            <li class="app-sidebar__heading">Bus & Routes Info</li>
            <li>
                <a href="{{URL('/bus-registration')}}" aria-expanded="true" class="@yield('bus-registration')">
                    <i class="metismenu-icon pe-7s-car"></i>
                    Add Bus & List
                </a>
            </li>
            <li>
                <a href="{{URL('/route-create')}}" aria-expanded="true" class="@yield('route-create')">
                    <i class="metismenu-icon pe-7s-network"></i>
                    Add Bus Route
                </a>
            </li>
            <li>
                <a href="{{URL('/route-list')}}" aria-expanded="true" class="@yield('route-list')">
                    <i class="metismenu-icon pe-7s-way"></i>
                    Bus Route List
                </a>
            </li>
            </li>
            <li class="app-sidebar__heading">Assign Bus To Driver</li>

            <li>
                <a href="{{URL('/assgin-bus')}}" aria-expanded="true" class="@yield('assgin-bus')">
                    <i class="metismenu-icon pe-7s-pin"></i>
                    Assign Bus To Driver
                </a>

            </li>
            <li>
                <a href="{{URL('/assign-route-list')}}" aria-expanded="true" class="@yield('assign-route-list')">
                    <i class="metismenu-icon pe-7s-note2"></i>
                    Assingned Route Bus list
                </a>

            </li>
            <li>
                <a href="{{URL('/unassign-bus-list')}}" aria-expanded="true" class="@yield('unassign-bus-list')">
                    <i class="metismenu-icon pe-7s-info"></i>
                    Unassign Bus List
                </a>

            </li>
            <li class="app-sidebar__heading">App User Info</li>
            <li>
                <a href="{{URL('/registered-app-users')}}" aria-expanded="true" class="@yield('registered-app-users')">
                    <i class="metismenu-icon pe-7s-users"></i>
                    App Users
                </a>
            </li>


        </ul>
    </div>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>

    <div class="ps__rail-y" style="top: 0px; height: 196px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 35px;"></div>
    </div>

</div>



</div>
