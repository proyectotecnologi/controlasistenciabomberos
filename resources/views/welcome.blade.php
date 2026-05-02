<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Asistencias - Biométrico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);
        }
        .gradient-secondary {
            background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
        }
        .fingerprint-illustration {
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.3);
        }
        .stat-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-br from-slate-50 to-blue-50">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-fingerprint text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">BioTecRoland</span>
                    </div>
                </div>
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-8">
                    <a href="#" class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Inicio</a>
                    <a href="#funciones" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Funciones</a>
                    <a href="#beneficios" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Beneficios</a>
                    <a href="#contacto" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Contacto</a>
                    <a href="{{route('login')}}" class="ml-8 gradient-bg text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:shadow-lg transition duration-300 transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>Acceder
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-block">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-6">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Sistema Seguro y Confiable
                        </span>
                    </div>
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block">Control de Asistencias</span>
                        <span class="block bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">con Tecnología Biométrica</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 sm:text-xl max-w-2xl">
                        Gestiona la asistencia de tu personal de forma automática, precisa y en tiempo real con nuestro sistema de identificación biométrica y RFID.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{route('login')}}" class="gradient-bg flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-lg text-white hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <i class="fas fa-rocket mr-2"></i> Comenzar Ahora
                        </a>
                        <a href="#demo" class="flex items-center justify-center px-8 py-4 border-2 border-blue-600 text-base font-medium rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition duration-300">
                            <i class="fas fa-play-circle mr-2"></i> Ver Demo
                        </a>
                    </div>
                    <div class="mt-10 flex items-center gap-8 justify-center lg:justify-start text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Sin instalación compleja</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Soporte 24/7</span>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="float-animation relative z-10 bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-auto">
                        <div class="text-center">
                            <div class="w-32 h-32 mx-auto gradient-bg rounded-full flex items-center justify-center mb-6 fingerprint-illustration">
                                <i class="fas fa-fingerprint text-white text-6xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Registro en 2 segundos</h3>
                            <p class="text-gray-600 mb-6">Identificación biométrica instantánea</p>
                            <div class="space-y-4">
                                <div class="flex items-center bg-green-50 p-4 rounded-lg">
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <div class="ml-4 text-left">
                                        <p class="text-sm font-semibold text-gray-900">Juan Pérez</p>
                                        <p class="text-xs text-gray-600">Entrada: 08:00 AM</p>
                                    </div>
                                    <span class="ml-auto text-xs text-green-600 font-medium">Puntual</span>
                                </div>
                                <div class="flex items-center bg-blue-50 p-4 rounded-lg">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <div class="ml-4 text-left">
                                        <p class="text-sm font-semibold text-gray-900">María García</p>
                                        <p class="text-xs text-gray-600">Entrada: 08:05 AM</p>
                                    </div>
                                    <span class="ml-auto text-xs text-blue-600 font-medium">Activo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-10 -left-10 w-72 h-72 bg-blue-200 rounded-full opacity-20 blur-3xl"></div>
                    <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-indigo-200 rounded-full opacity-20 blur-3xl"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="gradient-bg py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="stat-card rounded-xl p-6 text-center text-white">
                    <div class="text-4xl font-bold mb-2">99.9%</div>
                    <div class="text-sm opacity-90">Precisión</div>
                </div>
                <div class="stat-card rounded-xl p-6 text-center text-white">
                    <div class="text-4xl font-bold mb-2">&lt;2s</div>
                    <div class="text-sm opacity-90">Tiempo de registro</div>
                </div>
                <div class="stat-card rounded-xl p-6 text-center text-white">
                    <div class="text-4xl font-bold mb-2">10K+</div>
                    <div class="text-sm opacity-90">Usuarios activos</div>
                </div>
                <div class="stat-card rounded-xl p-6 text-center text-white">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-sm opacity-90">Disponibilidad</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="funciones" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2">Características</h2>
                <p class="text-4xl font-extrabold text-gray-900 mb-4">
                    Sistema completo de control
                </p>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Todo lo que necesitas para gestionar la asistencia de tu equipo de manera eficiente
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 gradient-bg rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-fingerprint text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Identificación Biométrica</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistema de huella dactilar de alta precisión que garantiza la identidad única de cada funcionario, eliminando suplantaciones.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 gradient-secondary rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-id-card text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tarjetas RFID</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Integración con tarjetas de proximidad RFID para un registro rápido y sin contacto, ideal para entornos de alto tráfico.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Reportes en Tiempo Real</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Visualiza estadísticas de asistencia, puntualidad y horas trabajadas con dashboards interactivos y exportables.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Alertas Automáticas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Notificaciones instantáneas por tardanzas, ausencias o irregularidades en los registros de asistencia.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-cloud text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Almacenamiento en la Nube</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Todos tus datos seguros y accesibles desde cualquier lugar, con copias de seguridad automáticas.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gradient-to-br from-violet-50 to-purple-50 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-gradient-to-r from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">App Móvil</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Accede al sistema desde tu smartphone para consultar asistencias, aprobar permisos y revisar reportes.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div id="beneficios" class="py-20 bg-gradient-to-br from-slate-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase mb-2">Beneficios</h2>
                    <h3 class="text-4xl font-extrabold text-gray-900 mb-6">
                        Optimiza la gestión de tu personal
                    </h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Elimina el fraude de asistencia</h4>
                                <p class="text-gray-600">La identificación biométrica garantiza que solo el empleado registrado pueda marcar su asistencia.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Ahorra tiempo en procesos</h4>
                                <p class="text-gray-600">Automatiza el cálculo de horas trabajadas, horas extras y genera reportes de nómina al instante.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">Toma decisiones informadas</h4>
                                <p class="text-gray-600">Accede a métricas y análisis detallados sobre asistencia, puntualidad y productividad del equipo.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 mb-2">DASHBOARD EN VIVO</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                                    <span class="font-medium text-gray-900">Personal presente</span>
                                    <span class="text-2xl font-bold text-blue-600">47/50</span>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">
                                    <span class="font-medium text-gray-900">Asistencia puntual</span>
                                    <span class="text-2xl font-bold text-green-600">94%</span>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-orange-50 rounded-lg">
                                    <span class="font-medium text-gray-900">Tardanzas hoy</span>
                                    <span class="text-2xl font-bold text-orange-600">3</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-500 mb-3">ÚLTIMOS REGISTROS</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-700">Ana Martínez</span>
                                    <span class="text-gray-500">08:00 AM</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Entrada</span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-700">Carlos López</span>
                                    <span class="text-gray-500">08:03 AM</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Entrada</span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-700">Laura Rodríguez</span>
                                    <span class="text-gray-500">08:15 AM</span>
                                    <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs">Tardanza</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="gradient-bg py-20">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">
                ¿Listo para modernizar tu sistema de asistencia?
            </h2>
            <p class="text-xl text-blue-100 mb-10">
                Únete a cientos de empresas que ya confían en nuestra tecnología biométrica
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{route('login')}}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-lg text-blue-600 bg-white hover:bg-gray-50 transition duration-300 transform hover:scale-105">
                    <i class="fas fa-user-plus mr-2"></i> Crear Cuenta Gratis
                </a>
                <a href="#contacto" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-blue-600 transition duration-300">
                    <i class="fas fa-phone mr-2"></i> Contactar Ventas
                </a>
            </div>
            <p class="mt-6 text-sm text-blue-100">
                <i class="fas fa-lock mr-1"></i> Sin tarjeta de crédito requerida • Instalación en 24 horas
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">Producto</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Funciones</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Precios</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Integraciones</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">API</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">Soporte</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Documentación</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Guías</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Centro de ayuda</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">Empresa</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Nosotros</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Casos de éxito</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Carreras</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Privacidad</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Términos</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Seguridad</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-fingerprint text-white"></i>
                        </div>
                        <span class="text-lg font-bold text-white">BioAttendance</span>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
                <p class="mt-6 text-center text-gray-400 text-sm">
                    &copy; 2024 BioAttendance. Todos los derechos reservados. Sistema de control de asistencias biométrico.
                </p>
            </div>
        </div>
    </footer>

    <!-- Floating Action Button -->
    <div class="fixed bottom-6 right-6">
        <a href="#contacto" class="gradient-bg w-16 h-16 rounded-full flex items-center justify-center text-white shadow-2xl hover:shadow-3xl transform hover:scale-110 transition duration-300">
            <i class="fas fa-headset text-2xl"></i>
        </a>
    </div>
</body>
</html>