<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Control de Asistencia Biométrico</title>

    <!-- Google Font: Inter (Modern font) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- jQuery -->
    <script src="{{ asset('/plugins/jquery/jquery.js') }}"></script>
    <!-- Datatables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

    <style>
        :root {
            --primary-color: #3B82F6;
            --primary-dark: #1E40AF;
            --secondary-color: #8B5CF6;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --dark-bg: #1E293B;
            --sidebar-bg: #0F172A;
            --text-light: #94A3B8;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
        }

        /* Navbar Moderna */
        .main-header.navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            border: none;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
        }

        .main-header .navbar-nav .nav-link {
            color: white !important;
            transition: all 0.3s ease;
        }

        .main-header .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .navbar .brand-link-custom {
            color: white !important;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        /* Sidebar Moderna */
        .main-sidebar {
            background: var(--sidebar-bg) !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .brand-link {
            background: var(--dark-bg) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 20px !important;
        }

        .brand-text {
            color: white !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            text-align: center;
            line-height: 1.4;
        }

        .brand-image {
            border: 3px solid var(--primary-color) !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        /* User Panel Mejorado */
        .user-panel {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 20px 10px !important;
        }

        .user-panel img {
            border: 3px solid var(--primary-color) !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            transition: transform 0.3s ease;
        }

        .user-panel img:hover {
            transform: scale(1.05);
        }

        .user-panel .info a {
            color: white !important;
            font-weight: 500;
        }

        /* Sidebar Menu */
        .nav-sidebar .nav-link {
            border-radius: 8px;
            margin: 4px 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            color: var(--text-light) !important;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(59, 130, 246, 0.1) !important;
            color: white !important;
            transform: translateX(5px);
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .nav-sidebar .nav-link i {
            margin-right: 10px;
            font-size: 16px;
        }

        /* Treeview */
        .nav-treeview .nav-link {
            padding-left: 48px !important;
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 14px;
        }

        .nav-treeview .nav-link:hover {
            color: white !important;
            background: rgba(59, 130, 246, 0.08) !important;
        }

        .nav-treeview .nav-link.active {
            background: rgba(59, 130, 246, 0.15) !important;
            color: var(--primary-color) !important;
            font-weight: 500;
        }

        /* Badges personalizados */
        .badge {
            border-radius: 12px;
            padding: 4px 10px;
            font-weight: 600;
            font-size: 11px;
        }

        .badge-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        .badge-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }

        /* Dropdown mejorado */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        /* Content Wrapper */
        .content-wrapper {
            background: transparent !important;
            padding: 20px;
        }

        /* Footer */
        .main-footer {
            background: white;
            border-top: 1px solid #E5E7EB;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px 12px 0 0;
            margin: 20px 20px 0 20px;
        }

        /* Botón cerrar sesión */
        .nav-link[style*="background-color: #c52510"] {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%) !important;
            color: white !important;
            border-radius: 8px !important;
            margin: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link[style*="background-color: #c52510"]:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        /* Reportes destacados */
        .nav-link[style*="background-color: #17a2b8"] {
            background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%) !important;
            color: white !important;
            border-radius: 8px !important;
            margin: 8px;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
        }

        .nav-link[style*="background-color: #17a2b8"]:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 16px rgba(6, 182, 212, 0.4);
        }

        /* Control Sidebar */
        .control-sidebar {
            background: var(--sidebar-bg) !important;
        }

        /* Mejoras responsive */
        @media (max-width: 768px) {
            .brand-text {
                font-size: 12px !important;
            }

            .user-panel img {
                width: 70px !important;
                height: 70px !important;
            }
        }

        /* Scrollbar personalizado */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.8);
        }

        /* Animación de entrada */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-wrapper>.content {
            animation: slideIn 0.4s ease-out;
        }

        /* Indicador activo en menú */
        .nav-item.menu-open>.nav-link {
            background: rgba(59, 130, 246, 0.12) !important;
        }

        /* Iconos con gradiente */
        .nav-sidebar .nav-link.active i {
            color: white !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link brand-link-custom">
                        SISTEMA DE CONTROL DE ASISTENCIA
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Buscar..."
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <div class="media">
                                <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Llamame cuando puedas...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Hace 4 horas</p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Ver todos los mensajes</a>
                    </div>
                </li>

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notificaciones</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 nuevos mensajes
                            <span class="float-right text-muted text-sm">3 min</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 solicitudes de amistad
                            <span class="float-right text-muted text-sm">12 horas</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 nuevos reportes
                            <span class="float-right text-muted text-sm">2 días</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="{{ url('/images/bomberos.jpg') }}" alt="Logo"
                        class="brand-image img-circle elevation-3" style="width: 70px; height: 70px; opacity: 1;">
                    <span class="brand-text">SISTEMA DE CONTROL<br>DE ASISTENCIA</span>
                </div>
            </a>
            {{-- @dump(Auth::user()->fotografia) --}}
            <!-- Sidebar -->
            {{-- @php
                $url = asset('storage/' . Auth::user()->fotografia);
            @endphp
            <a href="{{ $url }}" target="_blank">Abrir imagen</a> --}}

            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
                    <div class="image">
                        <img src="{{ asset('storage/' . Auth::user()->fotografia) }}" class="img-circle elevation-2"
                            alt="User Image" style="width: 90px; height: 90px; object-fit: cover;">
                        {{-- @dump(Auth::user()->fotografia) --}}
                    </div>
                    <div class="info mt-2">
                        <a href="#" class="d-block text-center">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">


                        <li class="nav-header">Usuarios</li>
                        @can('usuarios')
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon bi bi-person-fill-add"></i>
                                    <p>
                                        Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('usuarios/create') }}" class="nav-link">
                                            <i class="bi bi-person-plus-fill"></i>
                                            <p>Nuevo usuario</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('usuarios') }}" class="nav-link">
                                            <i class="bi bi-person-vcard"></i>
                                            <p>Listado de usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link">
                                            <i class="bi bi-shield-check"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('divisions')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-diagram-3-fill"></i>
                                    <p>
                                        División
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('divisions/create') }}" class="nav-link">
                                            <i class="bi bi-plus-circle-fill"></i>
                                            <p>Nueva división</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('divisions') }}" class="nav-link">
                                            <i class="bi bi-list-ul"></i>
                                            <p>Listado de división</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('miembros')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>
                                        Funcionarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('miembros/create') }}" class="nav-link">
                                            <i class="bi bi-person-plus-fill"></i>
                                            <p>Nuevo Funcionario</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('miembros') }}" class="nav-link">
                                            <i class="bi bi-person-lines-fill"></i>
                                            <p>Listado de Funcionarios</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan


                        <li class="nav-header">Control</li>
                        @can('asistencias')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-fingerprint"></i>
                                    <p>
                                        Asistencias Manual
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('marcar_asistencia') }}" class="nav-link">
                                            <i class="bi bi-clock-history"></i>
                                            <p>Marcar asistencia</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan



                        @can('asistencias')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>
                                        Asistencia Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('lista_usuarios_asistencias') }}" class="nav-link">
                                            <i class="bi bi-card-list"></i>
                                            <p>Ver historial de asistencias</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan


                        <li class="nav-header">Permisos</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-key-fill"></i> <!-- icono actualizado -->
                                <p>
                                    Permisos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('lista_permisos') }}" class="nav-link">
                                        <i class="bi bi-card-list"></i>
                                        <p>Generar permiso</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-header">Penalizaciones</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-shield-lock-fill"></i>
                                <!-- icono de seguridad/penalización -->
                                <p>
                                    Tolerancias
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('vista_tolerancia') }}" class="nav-link">
                                        <i class="bi bi-list-check"></i> <!-- icono de lista con check -->
                                        <p>Administrar tolerancias</p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('lista_memorandum')}}" class="nav-link">
                                        <i class="bi bi-file-earmark-text"></i> <!-- icono de documento -->
                                        <p>Memorandum</p>
                                    </a>
                                </li>
                            </ul>
                        </li>




                        {{-- @can('asistencias')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-calendar-check-fill"></i>
                                    <p>
                                        Asistencias Ingreso
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('asistencias/create') }}" class="nav-link">
                                            <i class="bi bi-clock-history"></i>
                                            <p>Control Asistencia Ingreso</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('asistencias') }}" class="nav-link">
                                            <i class="bi bi-card-checklist"></i>
                                            <p>Listado de asistencias</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('asistenciasalidas')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-calendar-x-fill"></i>
                                    <p>
                                        Asistencias Salida
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('asistenciasalidas/create') }}" class="nav-link">
                                            <i class="bi bi-box-arrow-right"></i>
                                            <p>Control Asistencia Salida</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('asistenciasalidas') }}" class="nav-link">
                                            <i class="bi bi-list-check"></i>
                                            <p>Listado de asistencias</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan --}}



                        {{-- ROLNALD --}}
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link" style="background-color: #17a2b8; color: white;">
                                <i class="nav-icon bi bi-file-earmark-bar-graph-fill"></i>
                                <p>
                                    Reportes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('asistenciasalidas/reportes') }}" class="nav-link">
                                        <i class="bi bi-printer-fill"></i>
                                        <p>Reporte de Asistencias</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}



                        {{-- NUEVA FUNCION --}}
                        <li class="nav-header">Reportes</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" style="background-color: #17a2b8; color: white;">
                                <i class="nav-icon bi bi-file-earmark-bar-graph-fill"></i>
                                <p>
                                    Reportes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('vistar_reporte_mensual') }}" class="nav-link">
                                        <i class="bi bi-printer-fill"></i>
                                        <p>Reporte de Mensual</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" style="background-color: #17a2b8; color: white;">
                                <i class="nav-icon bi bi-file-person-fill"></i>
                                <p>
                                    Reporte de Funcionarios
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('miembros/reportes') }}" class="nav-link">
                                        <i class="bi bi-printer-fill"></i>
                                        <p>Reporte de Miembros</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item mt-3">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                style="background-color: #c52510">
                                <i class="nav-icon bi bi-power"></i>
                                <p>Cerrar Sesión</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                <strong>Versión</strong> 2.0
            </div>
            <strong>Copyright &copy; 2024 <a href="#">Sistema de Control Biométrico</a>.</strong> Todos los
            derechos reservados.
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
</body>

</html>
