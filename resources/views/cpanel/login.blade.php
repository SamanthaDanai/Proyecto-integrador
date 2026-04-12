<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión - ITSSMT</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Fondo de campus personalizado */
            background: url('{{ asset('assets/images/itsmt.jpg') }}') center/cover no-repeat;
        }

        /* Capa oscura superpuesta para que resalte la tarjeta */
        .overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(31, 54, 74, 0.4);
            z-index: 1;
        }

        /* Diseño de Tarjeta estilo Glassmorphism */
        .login-card {
            background: rgba(20, 20, 20, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 400px;
            z-index: 2;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .login-card h3 {
            color: white;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-size: 1.3rem;
        }

        .login-card img {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }

        /* Inputs estilizados */
        .input-group-custom {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 0.25rem 1rem;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }
        .input-group-custom:focus-within {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
        .input-group-custom i {
            color: #6b7280;
            font-size: 1.2rem;
        }
        .input-group-custom input {
            border: none;
            background: transparent;
            width: 100%;
            padding: 0.6rem 0.6rem;
            font-size: 0.95rem;
            color: #1f2937;
            outline: none;
        }

        /* Botón Iniciar Sesión */
        .btn-login {
            background: #007bff;
            color: white;
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .forgot-link {
            text-align: center;
            display: block;
            margin-top: 1rem;
            color: #60a5fa;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }
        .forgot-link:hover {
            color: #93c5fd;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="overlay"></div>

    <div class="login-card">
        <h3>
            <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" alt="Logo ITSSMT">
            <span>Actividades<br>Extraescolares</span>
        </h3>

        @if($errors->any())
            <div class="alert alert-danger py-2" style="font-size:0.85rem; border-radius: 8px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <!-- Campo Correo con Validación Regex Solicitada -->
            <div class="input-group-custom">
                <i class="mdi mdi-email-outline"></i>
                <input type="text" name="correo" placeholder="Correo institucional" required 
                       pattern="^[a-zA-Z0-9_.-]{8}@[a-z]{7}\.[a-z]{5}\.[a-z]{2}$" 
                       title="Ejemplo: i2224002@smartin.tecnm.mx"
                       value="{{ old('correo') }}">
            </div>

            <div class="input-group-custom mb-1">
                <i class="mdi mdi-lock-outline"></i>
                <input type="password" name="contrasena" id="passwordField" placeholder="Contraseña" required>
                <i class="mdi mdi-eye-outline" id="togglePassword" style="cursor: pointer; opacity: 0.6;"></i>
            </div>
            <div class="text-danger mb-4 text-start mt-1" style="font-size: 0.75rem; padding-left: 5px; opacity: 0.9;">
                <i class="mdi mdi-information-outline"></i> Formato Obligatorio: 8 Letras, 1 Número, 1 Símbolo Especial.
            </div>

            <button type="submit" class="btn-login">Iniciar sesión</button>

            <a href="#" class="forgot-link">¿Olvidé contraseña?</a>
        </form>
    </div>

    <script>
        // Lógica visual para ver/ocultar contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordField');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('mdi-eye-off-outline');
            this.classList.toggle('mdi-eye-outline');
        });
    </script>
</body>
</html>
