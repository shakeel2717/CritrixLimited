<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    {{-- <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script> --}}
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @yield('css')
</head>

<body class="bg-theme bg-theme10">
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">{{ 'Tradex' }}</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="menu-label">Overview</li>
                <li>
                    <a href="{{ route('user.dashboard.index') }}">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li class="menu-label">TOPUP Funds</li>
                <li>
                    <a href="{{ route('user.deposit.create') }}">
                        <div class="parent-icon"><i class='bx bx-wallet-alt'></i>
                        </div>
                        <div class="menu-title">Deposit</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.deposit.index') }}">
                        <div class="parent-icon"><i class='bx bx-file-find'></i>
                        </div>
                        <div class="menu-title">Deposit Statement</div>
                    </a>
                </li>
                <li class="menu-label">Business Trading</li>
                <li>
                    <a href="{{ route('user.plans.create') }}">
                        <div class="parent-icon"><i class='bx bx-credit-card'></i>
                        </div>
                        <div class="menu-title">All Plans</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.tree.index') }}">
                        <div class="parent-icon"><i class='bx bx-user'></i>
                        </div>
                        <div class="menu-title">My Tree</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.refferrals.index') }}">
                        <div class="parent-icon"><i class='bx bx-user-circle'></i>
                        </div>
                        <div class="menu-title">Direct Referrals</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.plans.index') }}">
                        <div class="parent-icon"><i class='bx bx-file-find'></i>
                        </div>
                        <div class="menu-title">All Plans Statement</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.history.index') }}">
                        <div class="parent-icon"><i class='bx bx-file-find'></i>
                        </div>
                        <div class="menu-title">Account Statement</div>
                    </a>
                </li>
                <li class="menu-label">Payout Funds</li>
                <li>
                    <a href="{{ route('user.withdraw.create') }}">
                        <div class="parent-icon"><i class='bx bx-money'></i>
                        </div>
                        <div class="menu-title">Request Withdraw</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.withdraw.index') }}">
                        <div class="parent-icon"><i class='bx bx-file-find'></i>
                        </div>
                        <div class="menu-title">Withdraw Statement</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.transfer.create') }}">
                        <div class="parent-icon"><i class='bx bx-wallet-alt'></i>
                        </div>
                        <div class="menu-title">P2P</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.network.index') }}">
                        <div class="parent-icon"><i class='bx bx-file-find'></i>
                        </div>
                        <div class="menu-title">Network Rewards</div>
                    </a>
                </li>
                <li class="menu-label">My Profile</li>
                <li>
                    <a href="{{ route('user.profile.index') }}">
                        <div class="parent-icon"><i class='bx bx-user'></i>
                        </div>
                        <div class="menu-title">My Account</div>
                    </a>
                </li>
            </ul>
        </div>
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="alert-count">{{ auth()->user()->notifications->count() }}</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">
                                        @forelse (auth()->user()->notifications()->take(5)->latest()->get() as $notification)
                                            <a class="dropdown-item" href="javascript:;" style="white-space: normal">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">
                                              {{ $notification->data['title'] ?? "Notification" }}
                                                        </h6>
                                                        <p class="msg-info text-whrap">{{ $notification->data['message'] }}</p>
                                                        <span
                                                            class="msg-time float-end">{{ $notification->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <a class="dropdown-item" href="javascript:;">
                                                <div class="d-flex align-items-center">
                                                    <div class="notify"><i class="bx bx-group"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="msg-name">No New Notifications</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforelse
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Notifications</div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('assets/images/avatar.png') }}"
                                class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                                <p class="designattion mb-0">{{ Auth::user()->email }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.profile.index') }}"><i
                                        class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('user.dashboard.index') }}"><i
                                        class='bx bx-home-circle'></i><span>Dashboard</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"
                                    onclick="document.getElementById('logoutForm').submit();"><i
                                        class='bx bx-log-out-circle'></i><span>Logout</span></a>
                            </li>
                            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <div class="page-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
        <div class="overlay toggle-icon"></div>
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <footer class="page-footer">
            <p class="mb-0">Copyright © {{ date('Y') }}. All right reserved.</p>
        </footer>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#Transaction-History').DataTable({
                lengthMenu: [
                    [6, 10, 20, -1],
                    [6, 10, 20, 'Todos']
                ]
            });
        });
    </script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        new PerfectScrollbar('.product-list');
        new PerfectScrollbar('.customers-list');
    </script>
    @yield('js')
    @include('inc.alert')
    <script src="//code.tidio.co/8scsj3wrpwmm7degtswnkxx15bxj2g2n.js" async></script>
</body>

</html>
