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
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Buscar">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="./img/bus.png" alt="AdminLTE Logo" class="brand-image  elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Transportistas</span>
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
                  <i class="nav-icon fas fa-tachometer-alt"></i>
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
                <a href="#" class="nav-link ">
                <i class="fas fa-address-card"></i>
                  <p>Transportistas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="fas fa-subway"></i>
                  <p>Lineas de transporte</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="fas fa-paste"></i>
                  <p>Sindicatos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="fas fa-bus-alt"></i>
                  <p>Insumos</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="fas fa-power-off"></i>
                  <p>
                   Cerrar Sesion
                  </p>
                </a>
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

<script src="/js/app.js"></script>
</body>
</html>