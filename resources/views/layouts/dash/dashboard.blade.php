<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('Title')</title>
        {{-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" /> --}}
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        {{-- <link href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" /> --}}
        {{-- <link href="{{asset('js/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet" /> --}}
        <link rel="stylesheet" href="{{asset('assets/toastr/toastr.min.css')}}">
        <script src="{{asset('assets/fontawesome-free-6.1.1-web/css/all.css')}}" crossorigin="anonymous"></script>
    </head>
    {{-- style="font-family: Agency FB" --}}
    <body class="sb-nav-fixed" style="font-family:">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="{{route('dashboard')}}"><img src="{{asset('assets/images/FF_Comoros_(logo).png')}}" alt="logo" > FFC</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-success" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{route('users.show', Auth::user()->id)}}">Mon compte</a></li>
                        {{-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> --}}
                        <li><hr class="dropdown-divider" /></li>
                        <li><form action="{{route('logout')}}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">Déconncter</button>
                        </form></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Général</div>
                            <a class="nav-link" href="{{route('dashboard')}}">
                                <div class="sb-nav-link-icon"><i class="fa fa-dashboard"></i></div>
                                Dashboard
                            </a>
                            @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin'))
                                
                            
                            <a class="nav-link" href="{{route('saisons.index')}}">
                                <div class="sb-nav-link-icon"><i class="fa fa-tree"></i></div>
                                Saisons
                            </a>
                            <a class="nav-link" href="{{route('etats.index')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-earth-africa"></i></div>
                                Etats
                            </a>
                            <a class="nav-link" href="{{route('divisions.index')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-divide"></i></div>
                                Division
                            </a>
                            <a class="nav-link" href="{{route('championnats.index')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                                Championnats
                            </a>
                            @endif
                            

                            @if (Auth::user()->hasRole('Admin'))
                                <div class="sb-sidenav-menu-heading">Administration</div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                        Gestions des utilisateurs
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{route('users.index')}}">Utilisateurs</a>
                                        {{-- <a class="nav-link" href="">Rôles</a> --}}
                                    </nav>
                                </div>
                            @endif

                            @if (Auth::user()->hasRole('Chager competition'))
                                
                            <div class="sb-sidenav-menu-heading">Accès rapides</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#acces" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-star-of-life"></i></div>
                                Championnats
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="acces" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    {{-- <a class="nav-link" href="layout-sidenav-light.html">Champ2</a> --}}
                                    @foreach ($champs as $champ)
                                        <a class="nav-link" href="{{route('championnats.show', $champ->cid)}}">{{$champ->nom_championnat}}</a>
                                    @endforeach
                                </nav>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small text-success">Logged in as:</div>
                        {{Auth::user()->nom}} {{Auth::user()->prenom}} <br>
                        {{Auth::user()->email}} <br>
                        <span class="small text-success">Mes rôles:</span>
                        <p class="small text-info">
                           {{ implode(', ', Auth::user()->roles()->get()->pluck('nom_role')->toArray()) }}
                        </p>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">@yield('titre')</h1>
                        @yield('content')
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{asset('assets/jquery.min.js')}}"></script>
        <script src="{{asset('assets/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
        {{-- <script src="{{asset('assets/bootstrap/dist/js/bootstrap.min.js')}}"></script> --}}
        <script src="{{asset('js/scripts.js')}}"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> --}}
        {{-- <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script> --}}
        {{-- <script src="{{asset('js/datatables-simple-demo.js')}}"></script> --}}
        <script src="{{asset('assets/fontawesome-free-6.1.1-web/js/all.js')}}"></script>
        <script src="{{asset('assets/toastr/toastr.min.js')}}"></script>
        @include('admin.requete')
        @yield('scriptJs')
    </body>
</html>
