<div class="scrollbar-sidebar ps ps--active-y">

    <div class="app-sidebar__inner">

        <ul class="vertical-nav-menu metismenu">
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
                <a href="{{URL('/pending-applicants-list')}}" aria-expanded="true"
                    class="@yield('pending-applicants-list')">
                    <i class="metismenu-icon pe-7s-next-2"></i>
                    Register Daffodil Bus
                </a>
            </li>
            <li>
                <a href="{{URL('/applicants-shortlist')}}" aria-expanded="true" class="@yield('applicants-shortlist')">
                    <i class="metismenu-icon pe-7s-car"></i>
                    Daffodil Bus List
                </a>
            </li>
            <li>
                <a href="{{URL('/add-cleaner')}}" aria-expanded="true" class="@yield('add-cleaner')">
                    <i class="metismenu-icon pe-7s-network"></i>
                    Add Bus Route
                </a>
            </li>
            <li>
                <a href="{{URL('/hired-employes-list')}}" aria-expanded="true" class="@yield('hired-employes-list')">
                    <i class="metismenu-icon pe-7s-way"></i>
                    Bus Route List
                </a>
            </li>
            </li>
            <li class="app-sidebar__heading">Assign Bus To Driver</li>

            <li>
                <a href="{{URL('/assign-tasks-view')}}" aria-expanded="true" class="@yield('assign-tasks-view')">
                    <i class="metismenu-icon pe-7s-pin"></i>
                    Assign Bus To Driver
                </a>

            </li>
            <li>
                <a href="{{URL('/pending-estimation-list')}}" aria-expanded="true"
                    class="@yield('pending-estimation-list')">
                    <i class="metismenu-icon pe-7s-note2"></i>
                    Assing Bus Driver list
                </a>

            </li>
            <li>
                <a href="{{URL('/completed-tasks')}}" aria-expanded="true" class="@yield('completed-task')">
                    <i class="metismenu-icon pe-7s-info"></i>
                    Unassign Bus List
                </a>

            </li>
            <li class="app-sidebar__heading">Bus Schedule Info</li>
            <li>
                <a href="{{URL('/expense-category-list')}}" aria-expanded="true"
                    class="@yield('expense-category-list')">
                    <i class="metismenu-icon pe-7s-alarm"></i>
                    Add Bus Time Schedule
                </a>
            </li>
            <li>
                <a href="{{URL('/expense-list-view')}}" aria-expanded="true" class="@yield('expense-list-view')">
                    <i class="metismenu-icon pe-7s-tools"></i>
                    Show All Time Schedules
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
