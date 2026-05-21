<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Participantes - {{ $actividad->nombre }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    
    <style>
        :root {
            --color-navy: #1F364A;
            --color-teal: #386173;
            --color-green: #B8D67A;
            --color-text: #1e293b;
            --color-muted: #64748b;
            --color-border: #cbd5e1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--color-text);
            background: #ffffff;
            line-height: 1.5;
            padding: 2rem;
        }

        /* Barra de control visible solo en pantalla */
        .no-print-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(31, 54, 74, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .btn-print {
            background: var(--color-green);
            color: var(--color-navy);
        }

        .btn-print:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Encabezado del Reporte */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid var(--color-navy);
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-container img {
            height: 60px;
            width: auto;
        }

        .institution-title h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--color-navy);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .institution-title p {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--color-teal);
        }

        .report-meta-info {
            text-align: right;
        }

        .report-meta-info h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--color-teal);
            margin-bottom: 5px;
        }

        .report-meta-info p {
            font-size: 0.85rem;
            color: var(--color-muted);
            font-weight: 500;
        }

        /* Ficha del Evento */
        .event-sheet {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .sheet-item {
            display: flex;
            flex-direction: column;
        }

        .sheet-item span.label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--color-muted);
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .sheet-item span.val {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-navy);
        }

        /* Tabla de Participantes */
        .participants-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3rem;
        }

        .participants-table th {
            background: var(--color-navy);
            color: white;
            font-weight: 600;
            text-align: left;
            padding: 10px 12px;
            font-size: 0.9rem;
            text-transform: uppercase;
            border: 1px solid var(--color-navy);
        }

        .participants-table td {
            padding: 10px 12px;
            border: 1px solid var(--color-border);
            font-size: 0.95rem;
        }

        .participants-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .col-idx { width: 5%; text-align: center; }
        .col-control { width: 15%; font-weight: 600; }
        .col-name { width: 30%; font-weight: 500; }
        .col-career { width: 20%; }
        .col-email { width: 18%; font-size: 0.85rem !important; }
        .col-signature { width: 12%; text-align: center; }

        /* Firmas al calce */
        .signature-footer {
            margin-top: 5rem;
            display: flex;
            justify-content: space-around;
        }

        .signature-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 250px;
        }

        .signature-line {
            width: 100%;
            border-top: 2px solid var(--color-navy);
            margin-bottom: 8px;
        }

        .signature-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-navy);
            text-align: center;
        }

        .signature-subtitle {
            font-size: 0.8rem;
            color: var(--color-muted);
            text-align: center;
        }

        /* Ajustes de Impresión */
        @media print {
            body {
                padding: 0;
                font-size: 11pt;
            }

            .no-print-bar {
                display: none !important;
            }

            .event-sheet {
                background: none !important;
                border: 1px solid #cbd5e1 !important;
            }

            .participants-table th {
                background-color: #1F364A !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .participants-table tr:nth-child(even) {
                background-color: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Barra superior de control (se oculta al imprimir) -->
    <div class="no-print-bar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="mdi mdi-printer-check" style="font-size: 1.5rem; color: var(--color-green);"></i>
            <span style="font-weight: 700; font-size: 1.1rem;">Vista previa de Impresión</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="javascript:window.history.back();" class="btn btn-back">
                <i class="mdi mdi-arrow-left"></i> Volver
            </a>
            <button onclick="window.print();" class="btn btn-print">
                <i class="mdi mdi-printer"></i> Imprimir / Guardar PDF
            </button>
        </div>
    </div>

    <!-- Encabezado Oficial -->
    <header class="report-header">
        <div class="logo-container">
            <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" alt="ITSSMT Logo">
            <div class="institution-title">
                <h1>Inst. Tecnológico Superior de San Martín Texmelucan</h1>
                <p>Sistema del Portal de Actividades Extraescolares</p>
            </div>
        </div>
        <div class="report-meta-info">
            <h2>Lista de Participantes</h2>
            <p>Fecha de Generación: {{ date('d/m/Y H:i') }}</p>
        </div>
    </header>

    <!-- Ficha del Evento -->
    <section class="event-sheet">
        <div class="sheet-item">
            <span class="label">Nombre del Evento</span>
            <span class="val">{{ $actividad->nombre }}</span>
        </div>
        <div class="sheet-item">
            <span class="label">Área / Lugar</span>
            <span class="val">{{ $actividad->area ? $actividad->area->nombre : 'General' }}</span>
        </div>
        <div class="sheet-item">
            <span class="label">Horario</span>
            <span class="val">{{ $actividad->horario ?? 'Por definir' }}</span>
        </div>
        <div class="sheet-item" style="grid-column: span 2;">
            <span class="label">Descripción</span>
            <span class="val" style="font-size: 0.9rem; font-weight: 400;">{{ $actividad->descripcion ?? 'Sin descripción.' }}</span>
        </div>
        <div class="sheet-item">
            <span class="label">Total Participantes</span>
            <span class="val">{{ $participantes->count() }} alumnos</span>
        </div>
    </section>

    <!-- Tabla de Alumnos -->
    <table class="participants-table">
        <thead>
            <tr>
                <th class="col-idx">#</th>
                <th class="col-control">No. Control</th>
                <th class="col-name">Nombre Completo</th>
                <th class="col-career">Carrera</th>
                <th class="col-email">Correo Institucional</th>
                <th class="col-signature">Firma</th>
            </tr>
        </thead>
        <tbody>
            @forelse($participantes as $index => $p)
                <tr>
                    <td class="col-idx">{{ $index + 1 }}</td>
                    <td class="col-control">{{ $p->num_control }}</td>
                    <td class="col-name">{{ $p->nombre }} {{ $p->apat }} {{ $p->amet }}</td>
                    <td class="col-career">{{ $p->carrera ?? 'Sin carrera' }}</td>
                    <td class="col-email">{{ $p->correo_inst }}</td>
                    <td class="col-signature"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: var(--color-muted);">
                        No hay alumnos inscritos en este evento actualmente.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Firmas oficiales -->
    <footer class="signature-footer">
        <div class="signature-block">
            <div class="signature-line"></div>
            <span class="signature-title">Docente Responsable</span>
            <span class="signature-subtitle">{{ Auth::user()->nombre }} {{ Auth::user()->apat }}</span>
        </div>
        
        <div class="signature-block">
            <div class="signature-line"></div>
            <span class="signature-title">Sello Institucional</span>
            <span class="signature-subtitle">Extraescolares</span>
        </div>
    </footer>

    <!-- Lanzar impresión al cargar -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
