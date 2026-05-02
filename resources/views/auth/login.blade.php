{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: red; color: white;">{{ __('Login') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('images/hospedajes-el-chalten.jpg') }}" alt="Imagen descriptiva" class="img-fluid" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>

                        <div class="col-md-8">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Correo Electronico</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - BioAttendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #EF4444 0%, #B91C1C 100%);
        }

        .gradient-hover {
            transition: all 0.3s ease;
        }

        .gradient-hover:hover {
            background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .pulse-ring {
            animation: pulse-ring 2s ease-out infinite;
        }

        .input-focus:focus {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        body {
            background: linear-gradient(135deg, #FEF2F2 0%, #FECACA 50%, #FCA5A5 100%);
            min-height: 100vh;
        }

        .text-gradient {
            background: linear-gradient(135deg, #EF4444 0%, #B91C1C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center">

            <!-- Left Side - Illustration (Hidden on mobile) -->
            <div class="hidden lg:flex flex-col items-center justify-center text-center">
                <div class="relative float-animation">
                    <!-- Floating circles background -->
                    <div class="absolute -top-20 -left-20 w-40 h-40 bg-red-200 rounded-full opacity-30 blur-2xl"></div>
                    <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-red-300 rounded-full opacity-30 blur-2xl">
                    </div>

                    <!-- Main illustration -->
                    <div class="relative z-10">
                        <div class="w-72 h-72 gradient-bg rounded-full flex items-center justify-center mb-8 relative">
                            <div class="absolute inset-0 rounded-full pulse-ring gradient-bg"></div>
                            <i class="fas fa-fingerprint text-white text-9xl relative z-10"></i>
                        </div>

                        <h2 class="text-3xl font-bold text-gray-800 mb-4">
                            Sistema de Control<br />de Asistencias
                        </h2>
                        <p class="text-gray-600 text-lg max-w-md">
                            Accede de forma segura con tu cuenta y gestiona la asistencia de tu equipo en tiempo real.
                        </p>

                        <!-- Features -->
                        <div class="mt-8 space-y-3 text-left max-w-sm mx-auto">
                            <div class="flex items-center text-gray-700">
                                <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-shield-alt text-white text-sm"></i>
                                </div>
                                <span>Seguridad de nivel empresarial</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-chart-line text-white text-sm"></i>
                                </div>
                                <span>Reportes en tiempo real</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-mobile-alt text-white text-sm"></i>
                                </div>
                                <span>Acceso desde cualquier dispositivo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full">
                <div class="bg-white rounded-2xl shadow-2xl p-8 sm:p-12">
                    <!-- Logo and Title -->
                    <div class="flex flex-col items-center mb-10">
                        <div class="w-40 h-50 rounded-xl flex items-center justify-center mb-4 ">
                            <img src="{{asset('images/policia bomberos.png')}}" alt="">
                        </div>
                        <h1 class="text-4xl font-bold text-gradient">
                            Policia Boliviana Biométric
                        </h1>
                        <p class="text-gray-600 mt-3 text-center text-lg">Inicia sesión en tu cuenta</p>
                    </div>

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        <!-- Email Input -->
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-red-500"></i>Correo electrónico
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" required
                                    class="input-focus block w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-lg focus:outline-none transition duration-200"
                                    placeholder="tu@email.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-red-500"></i>Contraseña
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="input-focus block w-full pl-12 pr-12 py-3.5 border border-gray-300 rounded-lg focus:outline-none transition duration-200"
                                    placeholder="••••••••">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center"
                                    onclick="togglePassword()">
                                    <i id="eye-icon" class="fas fa-eye text-gray-400 hover:text-red-500 transition-colors"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember"
                                    class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Recordarme
                                </label>
                            </div>
                            <a href="#" class="text-sm font-medium text-red-600 hover:text-red-500 transition">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full gradient-bg gradient-hover text-white font-semibold py-3.5 rounded-lg shadow-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Iniciar Sesión
                        </button>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">O continuar con</span>
                            </div>
                        </div>
                      
                    </form>

                    <div class="grid grid-cols-2 gap-4">
                        <button type="button"
                            class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 hover:border-red-200">
                            <i class="fab fa-google text-red-500 text-xl mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Google</span>
                        </button>
                        <button type="button"
                            class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200 hover:border-red-200">
                            <i class="fab fa-microsoft text-red-600 text-xl mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Microsoft</span>
                        </button>
                    </div>

                    <!-- Sign Up Link -->
                    <p class="mt-8 text-center text-sm text-gray-600">
                        ¿No tienes una cuenta?
                        <a href="#" class="font-medium text-red-600 hover:text-red-500 transition">
                            Regístrate gratis
                        </a>
                    </p>

                    <!-- Footer Links -->
                    <div class="mt-6 flex items-center justify-center space-x-4 text-xs text-gray-500">
                        <a href="#" class="hover:text-red-600 transition">Términos</a>
                        <span>•</span>
                        <a href="#" class="hover:text-red-600 transition">Privacidad</a>
                        <span>•</span>
                        <a href="#" class="hover:text-red-600 transition">Ayuda</a>
                    </div>
                </div>

                <!-- Mobile Only - Quick Features -->
                <div class="lg:hidden mt-6 bg-white/70 backdrop-blur-sm rounded-xl p-6 border border-red-100">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div
                                class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mx-auto mb-2 shadow-md">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <p class="text-xs text-gray-600">Seguro</p>
                        </div>
                        <div>
                            <div
                                class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mx-auto mb-2 shadow-md">
                                <i class="fas fa-bolt text-white"></i>
                            </div>
                            <p class="text-xs text-gray-600">Rápido</p>
                        </div>
                        <div>
                            <div
                                class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center mx-auto mb-2 shadow-md">
                                <i class="fas fa-mobile-alt text-white"></i>
                            </div>
                            <p class="text-xs text-gray-600">Móvil</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                eyeIcon.classList.add('text-red-500');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.remove('text-red-500');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>