<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Transportistas</title>

  <!-- Font Awesome Icons -->
  <!--<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">-->
  <!-- Theme style -->
  <!--<link rel="stylesheet" href="dist/css/adminlte.min.css">-->
  <!-- Google Font: Source Sans Pro -->
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
<link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
      </ul>

    <!-- SEARCH FORM -->
    <div class="inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup="busca" v-model="buscar" type="search" placeholder="Buscar" aria-label="Buscar">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="busca">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
</div>

   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="./img/bus.png" alt="AdminLTE Logo" class="brand-image  elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Transporte Público</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./img/admin.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{Auth::user()->name}}
            <p>{{Auth::user()->type}}</p>
            
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <router-link to="/Escritorio" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt text-blue"></i>
                  <p>
                    Escritorio
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/Perfil" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Perfil
                  </p>
                </router-link>
              </li>
              
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
            <i class="fas fa-shuttle-van"></i>
              <i class="nav-icon"></i>
              <p>
                Transporte
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/unidades" class="nav-link ">
                <i class="fas fa-address-card"></i>
                  <p>Unidades de transporte</p>
                </a>
              </li>
              <li class="nav-item">
              <router-link to="/lineas" class="nav-link">
                  <i class="fas fa-subway"></i>
                  <p>
                    Lineas de transporte
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/personas" class="nav-link">
                <i class="fas fa-users"></i>
                  <p>Choferes</p>
                </a>
                </router-link >
              </li>
              <li class="nav-item">
              <router-link to="/sindicatos" class="nav-link">
               
                <i class="fas fa-paste"></i>
                  <p>Sindicatos</p>
                
                </router-link >
              </li>
              
              <li class="nav-item">
              <router-link to="/reportes" class="nav-link">
               
               <i class="fas fa-paste"></i>
                 <p>Reportes</p>
               
               </router-link >
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link ">
            <i class="fas fa-shuttle-van"></i>
              <i class="nav-icon"></i>
              <p>
                Insumos
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/proveedores" class="nav-link">
               
               <i class="fas fa-paste"></i>
                 <p>Proveedores</p>
               
               </router-link >
              </li>
              <li class="nav-item">
              <router-link to="/insumos" class="nav-link">
               
               <i class="fas fa-paste"></i>
                 <p>Registro de Insumos</p>
               
               </router-link >
              </li>
              <li class="nav-item">
              <router-link to="/ingreso" class="nav-link">
               
               <i class="fas fa-paste"></i>
                 <p>Ingreso de Insumos</p>
               
               </router-link >
              </li>
              <li class="nav-item">
              <router-link to="/ventas" class="nav-link">
               
               <i class="fas fa-paste"></i>
                 <p>Venta de Insumos</p>
               
               </router-link >
              </li>
            </ul>
            </li>
          @can('isAdmin')
              <li class="nav-item">
              <router-link to="/usuarios" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Usuarios
                  </p>
                </router-link>
              </li>
           
              <li class="nav-item">
              <router-link to="/dev" class="nav-link">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                    Desarrollador
                  </p>
                </router-link>
              </li>
              @endcan

          <li class="nav-item">
          <!--para cerrar sesion -->
                <a class="nav-link" href="{{ route('logout') }}" 
                  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off"></i>
                  <p>
                  {{ __(' Cerrar Sesion') }}
                  </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf </form>
              </li>
     
        </ul>
       
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      
      <router-view></router-view>
      <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Registro de Transportistas
    </div>
    <!-- Default to the left -->
    <strong>Derechos de autor &copy; 2018 <a href="https://adminlte.io">Anderson Quintero</a>.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->
<script>
@auth 
  window.user = @json(auth()->user());
@endauth
</script>


<script src="/js/app.js"></script>

</body>
</html>