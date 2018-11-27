<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Dashboard</title>

    <!-- Bootstrap core CSS-->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="{{asset('css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{asset('css/dataTables.bootstrap4.css')}}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">

     <script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    @yield('style')

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="{{ url('/') }}">Donate</a>

      @auth
      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>
      @endauth

      <!-- Navbar Search -->
      <form method="GET" action="{{url('doacoes/pesquisa/')}}" class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input style="width: 350px" name="termos" type="text" class="form-control" placeholder="Pesquisar..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-block" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Navbar -->
      @auth
      <ul class="navbar-nav ml-auto ml-md-0">
       <!--  <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link" href="#" role="button">
            <i class="fas fa-envelope fa-fw"></i>
            <span class="badge badge-danger">7</span>
          </a>
        </li> -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
            <span>{{Auth::user()->nome}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
  {{ __('Logout') }}</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>

          </div>
        </li>
      </ul>
      @else
        <ul class="navbar-nav ml-auto ml-md-0">
          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('login') }}" role="button">
              Entrar
            </a>
          </li>
          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('register') }}" role="button">
              Cadastre-se
            </a>
          </li>
        </ul>
      @endauth

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      @auth
        <ul class="sidebar navbar-nav toggled">
          <!-- <li class="nav-item">
            <a class="nav-link" href="index.html">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="{{url('/doacoes/create')}}">
              <i class="fas fa-bullhorn"></i>
              <span>Anunciar</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/usuarios/perfil/'.Auth::id())}}">
              <i class="fas fa-user-alt"></i>
              <span>Meu Perfil</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/doacoes/meus-anuncios')}}">
              <i class="fas fa-hand-holding-heart"></i>
              <span>Meus Anúncios</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/usuarios/mensagens')}}">
              <i class="fas fa-envelope fa-fw"></i>
              <span>Mensagens</span>
            </a>
          </li>
  
            @if(Auth::user()->nivel == 1)
              <li class="nav-item">
                <a class="nav-link" href="{{url('/doacoes/aguardando-aprovacao')}}">
                  <i class="far fa-clock"></i>
                  <span>Aguardando Aprovação</span>
                </a>
              </li>
            @endif
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-fw fa-folder"></i>
              <span>Pages</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
              <h6 class="dropdown-header">Login Screens:</h6>
              <a class="dropdown-item" href="login.html">Login</a>
              <a class="dropdown-item" href="register.html">Register</a>
              <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
              <div class="dropdown-divider"></div>
              <h6 class="dropdown-header">Other Pages:</h6>
              <a class="dropdown-item" href="404.html">404 Page</a>
              <a class="dropdown-item" href="blank.html">Blank Page</a>
            </div>
          </li> -->
        </ul>
      @endauth

      <div id="content-wrapper">

        <div class="container-fluid">

          @yield('content')

        </div>
        <!-- /.container-fluid -->

        <!-- @auth -->
          <!-- Sticky Footer -->
          <!-- <footer class="sticky-footer">
            <div class="container my-auto">
              <div class="copyright text-center my-auto">
                <span>Copyright © Your Website 2018</span>
              </div>
            </div>
          </footer> -->
        <!-- @else -->
          <!-- <footer class="not-auth-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2018</span>
            </div>
          </div>
        </footer> -->
       <!--  @endauth -->

      </div>
      <!-- /.content-wrapper -->

    </div>

    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
   <!--  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div> -->

    <!-- Bootstrap core JavaScript-->
    <!-- <script src="{{asset('js/jquery.min.js')}}"></script> -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin.min.js')}}"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        setTimeout(function(){
          $(".alert").fadeOut("slow");
        }, 5000);
      });

    </script>

    @yield('js')
  </body>

</html>
