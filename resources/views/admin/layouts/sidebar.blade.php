<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('theme/admin/assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('theme/admin/assets/images/logo-light.png') }}" alt=""
                            height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route("admin.dashboard") }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                            </a>
                            
                        </li> <!-- end Dashboard Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="ri-shopping-bag-2-line"></i> <span data-key="t-apps">Quản lý sản phẩm</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarApps">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route("admin.products.index") }}" class="nav-link" data-key="t-chat"> Danh sách sản phẩm </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route("admin.products.create") }}" class="nav-link" data-key="t-chat"> Thêm mới sản phẩm </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarCalendar" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarCalendar"
                                            data-key="t-calender">
                                           <i class="ri-layout-masonry-line"></i> Danh mục sản phẩm
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarCalendar">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="{{ route("admin.products.catalogues.index") }}" class="nav-link"
                                                        data-key="t-main-calender"> Danh sách danh mục </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route("admin.products.catalogues.create") }}" class="nav-link"
                                                        data-key="t-month-grid"> Thêm danh mục </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>


                                    
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                                <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Layouts</span> <span
                                    class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="layouts-horizontal.html" target="_blank" class="nav-link"
                                            data-key="t-horizontal">Horizontal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="layouts-detached.html" target="_blank" class="nav-link"
                                            data-key="t-detached">Detached</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="layouts-two-column.html" target="_blank" class="nav-link"
                                            data-key="t-two-column">Two Column</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="layouts-vertical-hovered.html" target="_blank" class="nav-link"
                                            data-key="t-hovered">Hovered</a>
                                    </li>
                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->


                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>