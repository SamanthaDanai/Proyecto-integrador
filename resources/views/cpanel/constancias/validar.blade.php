<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Constancia Oficial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
        .card-valid { background: #fff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .bg-valid { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
        .bg-invalid { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }
        .icon-circle { width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; background: white; }
        .icon-circle i { font-size: 50px; }
        .text-valid { color: #059669; }
        .text-invalid { color: #dc2626; }
        .info-label { font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
        .info-value { font-size: 1.1rem; color: #1e293b; font-weight: 700; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8 col-lg-5">
            
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" alt="Logo ITSSMT" style="height: 70px;">
                <h5 class="mt-3 text-secondary fw-bold">Sistema de Actividades Extraescolares</h5>
            </div>

            <div class="card card-valid">
                @if($esValida)
                    <div class="bg-valid p-4 text-center">
                        <div class="icon-circle shadow-sm mb-3">
                            <i class="mdi mdi-check-decagram text-valid"></i>
                        </div>
                        <h3 class="fw-bold mb-1">Constancia Válida</h3>
                        <p class="mb-0 opacity-75">Este documento es auténtico y oficial.</p>
                    </div>
                    <div class="p-4 p-md-5">
                        <div class="info-label">Folio de Validación</div>
                        <div class="info-value text-success font-monospace fs-4">{{ $folio }}</div>

                        <div class="info-label mt-4">Nombre del Estudiante</div>
                        <div class="info-value">{{ mb_strtoupper($usuario->nombre . ' ' . $usuario->apat . ' ' . $usuario->amat) }}</div>

                        <div class="info-label">Número de Control</div>
                        <div class="info-value">{{ $usuario->num_control }}</div>

                        <div class="info-label">Carrera</div>
                        <div class="info-value">{{ mb_strtoupper($usuario->carrera) }}</div>

                        <div class="info-label">Estado de Créditos</div>
                        <div class="info-value"><span class="badge bg-success px-3 py-2 rounded-pill"><i class="mdi mdi-check-circle me-1"></i> Acreditación Completa (1.0)</span></div>

                        <hr class="my-4 text-muted">
                        <div class="text-center text-muted small">
                            Verificado el {{ date('d/m/Y') }} a las {{ date('H:i') }} hrs.<br>
                            Departamento de Actividades Extraescolares
                        </div>
                    </div>
                @else
                    <div class="bg-invalid p-4 text-center">
                        <div class="icon-circle shadow-sm mb-3">
                            <i class="mdi mdi-close-octagon text-invalid"></i>
                        </div>
                        <h3 class="fw-bold mb-1">Documento Inválido</h3>
                        <p class="mb-0 opacity-75">Registro no encontrado o incompleto.</p>
                    </div>
                    <div class="p-4 p-md-5 text-center">
                        <p class="text-muted fs-5">El número de control consultado no cuenta con una constancia de liberación válida o fue revocada por el departamento de extraescolares.</p>
                        <a href="/" class="btn btn-outline-danger mt-3 rounded-pill px-4">Regresar al portal principal</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</body>
</html>
