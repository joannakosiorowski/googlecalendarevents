<div class="page-wrap">
    <div class="app-sidebar colored">
        <div class="sidebar-header">
            <a class="header-brand" href="">
                <div class="logo-img"> 
                </div>
                <span class="text text-center">Panel</span>
            </a>
            <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
            <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
        </div>
        
        <div class="sidebar-content">
            <div class="nav-container">
                <nav id="main-menu-navigation" class="navigation-main">
                    <div class="nav-lavel text-center"></div>
                    <div class="nav-item active">
                        <a href="" data-toggle="modal" data-target="#holidayModal"><i class="fa fa-plane" aria-hidden="true"></i><span>Święta</span></a>
                    </div>
                   

                    <div class="nav-item active">
                        <a href="{{route('adddate')}}"><i class="fa fa-globe" aria-hidden="true"></i><span>Twoje urlopy</span></a>
                    </div>
                    <div class="nav-lavel text-center">Admin</div>
                    <div class="nav-item active">
                        <a href="{{route('holidayjackpot')}}"><i class="fa fa-archive" aria-hidden="true"></i><span>Pula urlopowa</span></a>
                    </div>

                    
                    <div class="nav-item active">
                        <a href="{{route('manageholidays')}}"><i class="fa fa-address-book" aria-hidden="true"></i><span>Zarządzaj urlopami</span></a>
                    </div>

                    
                    <div class="nav-item active">
                        <a href="{{route('report')}}"><i class="fa fa-sticky-note" aria-hidden="true"></i><span>Raport</span></a>
                    </div>

                    <div class="nav-item active">
                        <a href="{{route('workhours')}}"><i class="fa fa-hourglass" aria-hidden="true"></i><span>Godziny</span></a>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <style>
        #app-notifications-list {
          background-color: #303030;
          color: white;
          font-family: Arial;
        }
        .inputDate {
            border: none;
            border-bottom: 1px solid #1F194C;
            border-radius: 0%;
        }
      </style>


@include('modals/nationalholidays') 