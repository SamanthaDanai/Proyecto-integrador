<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Constancia Oficial - {{ $usuario->num_control }}</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            background: white;
            padding: 2cm 2.5cm;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #1F364A;
            padding-bottom: 15px;
        }
        .header img { width: 85px; margin-bottom: 10px; }
        
        .folio-box {
            position: absolute;
            top: 50px;
            right: 50px;
            text-align: right;
            color: #1F364A;
        }
        .folio-label { font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .folio-number { font-size: 14px; font-weight: 800; font-family: monospace; color: #ef4444; }

        .inst-name { font-size: 18px; font-weight: bold; color: #1F364A; text-transform: uppercase; }
        .dept-name { font-size: 13px; color: #386173; font-weight: 600; }

        .main-title {
            font-size: 22px;
            font-weight: 800;
            text-align: center;
            margin: 35px 0;
            color: #1F364A;
            letter-spacing: 0.5px;
        }
        .content {
            font-size: 16px;
            line-height: 1.7;
            text-align: justify;
            color: #333;
        }
        .student-name {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 25px 0;
            color: #1F364A;
            background: #f8fafc;
            padding: 15px;
            border-radius: 10px;
        }
        .details-box {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px 20px;
            margin: 25px 0;
        }
        .details-box ul { margin: 10px 0 0 20px; padding: 0; }

        .footer-sec {
            margin-top: 80px;
            display: table;
            width: 100%;
        }
        .signature-col {
            display: table-cell;
            width: 70%;
            text-align: center;
            vertical-align: bottom;
        }
        .qr-col {
            display: table-cell;
            width: 30%;
            text-align: right;
            vertical-align: bottom;
        }
        .signature-line {
            width: 280px;
            border-top: 2px solid #1F364A;
            margin: 0 auto 10px auto;
        }
        .qr-code {
            width: 110px;
            height: 110px;
            border: 1px solid #ddd;
            padding: 5px;
            background: white;
        }

        .date-location {
            margin: 30px 0;
            text-align: right;
            font-size: 14px;
            font-style: italic;
        }
        
        @media print {
            body { background: white; }
            .btn-print { display: none; }
        }
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1F364A;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            z-index: 9999;
        }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">DESCARGAR CONSTANCIA OFICIAL (PDF)</button>

    @php
        // Generación de Folio Automático Seguro
        $year = date('Y');
        $hash = strtoupper(substr(md5($usuario->num_control . $year . 'ITSSMT-SECRET'), 0, 6));
        $folio = "EXT-{$year}-{$hash}";
        
        // URL para el QR usando QuickChart API (Enlace Web)
        $urlValidacion = route('validar.constancia', $usuario->num_control);
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($urlValidacion) . "&size=150&margin=1";
    @endphp

    <div class="container">
        <div class="folio-box">
            <div class="folio-label">Folio de Validación</div>
            <div class="folio-number">{{ $folio }}</div>
        </div>

        <div class="header">
            <img src="{{ asset('assets/images/logo-ITSSMT.webp') }}" alt="Logo">
            <div class="inst-name">Instituto Tecnológico Superior de San Martín Texmelucan</div>
            <div class="dept-name">DEPARTAMENTO DE ACTIVIDADES EXTRAESCOLARES</div>
        </div>

        <div class="main-title">CONSTANCIA DE LIBERACIÓN DE CRÉDITOS</div>

        <div class="content">
            <strong>A QUIEN CORRESPONDA:</strong><br><br>
            
            La Coordinación de Actividades Extraescolares del Instituto Tecnológico Superior de San Martín Texmelucan, hace constar que el (la) estudiante:<br>

            <div class="student-name">
                {{ mb_strtoupper($usuario->nombre . ' ' . $usuario->apat . ' ' . $usuario->amat) }}
            </div>
            
            Con número de control <strong>{{ $usuario->num_control }}</strong>, inscrito(a) en la carrera de <strong>{{ mb_strtoupper($usuario->carrera) }}</strong>, ha cumplido satisfactoriamente con la acreditación de <strong>dos (2) periodos</strong> de Actividades Extraescolares, conforme a los lineamientos vigentes del manual de lineamientos académico-administrativos.<br>

            <div class="details-box">
                <strong>Evidencias de Acreditación Registradas:</strong>
                <ul>
                    @foreach($usuario->historial_extraescolar as $index => $hist)
                        <li><b>Periodo {{ $index + 1 }}:</b> {{ $hist->actividadExtraescolar->nombre ?? 'Actividad' }} - Calificación Final: {{ number_format($hist->calificacion_final, 1) }}</li>
                    @endforeach
                </ul>
            </div>
            
            Por lo anterior, se le otorga el valor de <strong>1.0 crédito complementario</strong>, el cual es requisito indispensable para la continuación de su trámite de titulación integral.<br>

            <div class="date-location">
                San Martín Texmelucan, Puebla; a los {{ date('d') }} días del mes de 
                @php
                    $meses = ['01'=>'enero','02'=>'febrero','03'=>'marzo','04'=>'abril','05'=>'mayo','06'=>'junio','07'=>'julio','08'=>'agosto','09'=>'septiembre','10'=>'octubre','11'=>'noviembre','12'=>'diciembre'];
                    echo $meses[date('m')];
                @endphp 
                del año {{ date('Y') }}.
            </div>
        </div>

        <div class="footer-sec">
            <div class="signature-col">
                <div class="signature-line"></div>
                <div style="font-weight: bold; font-size: 14px; color: #1F364A; text-transform: uppercase;">
                    Jefatura del Departamento de Actividades Extraescolares
                </div>
                <div style="font-size: 11px; color: #666; margin-top: 5px;">
                    VALIDACIÓN ELECTRÓNICA MEDIANTE FOLIO: {{ $folio }}
                </div>
            </div>
            <div class="qr-col">
                <img src="{{ $qrUrl }}" class="qr-code" alt="QR Validation">
                <div style="font-size: 9px; color: #999; margin-top: 5px; text-align: right;">ESCANEÉ PARA VALIDAR</div>
            </div>
        </div>
    </div>

</body>
</html>
