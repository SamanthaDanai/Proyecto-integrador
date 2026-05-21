@extends('cpanel.plantilla')

@section('title', 'Dashboard')

@push('styles')
<style>
    .kpi-card {
        border-radius: 12px;
        color: white;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .kpi-card .icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 3rem;
        opacity: 0.3;
    }
    .kpi-card h3 {
        font-size: 2.3rem;
        font-weight: 700;
        margin: 0;
    }
    .kpi-card p {
        font-size: 1.05rem;
        opacity: 0.9;
        margin-bottom: 0;
        font-weight: 500;
    }
    .bg-gradient-1 { background: linear-gradient(45deg, #FF512F, #DD2476); }
    .bg-gradient-2 { background: linear-gradient(45deg, #1D976C, #93F9B9); color: #1a1a2e; }
    .bg-gradient-3 { background: linear-gradient(45deg, #4facfe, #00f2fe); }
    .bg-gradient-4 { background: linear-gradient(45deg, #667eea, #764ba2); }
    .bg-gradient-5 { background: linear-gradient(45deg, #FFB75E, #ED8F03); }
    .bg-gradient-6 { background: linear-gradient(45deg, #11998e, #38ef7d); }
    .bg-gradient-7 { background: linear-gradient(45deg, #8E2DE2, #4A00E0); }
    .bg-gradient-red { background: linear-gradient(45deg, #ee0979, #ff6a00); }

    .kpi-h3-small { font-size: 1.7rem !important; }
    
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        margin-bottom: 1rem;
    }
    .card-chart {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .card-chart .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px 12px 0 0;
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-chart .card-title {
        margin: 0;
        font-weight: 600;
        color: #333;
    }
    .btn-pdf {
        padding: 0.25rem 0.6rem;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .btn-teal {
        background: linear-gradient(135deg, #386173, #1f364a) !important;
        border: none !important;
        color: white !important;
    }
    .btn-teal:hover {
        background: linear-gradient(135deg, #1f364a, #152432) !important;
        color: white !important;
    }
    .btn-teal.active {
        background: linear-gradient(135deg, #B8D67A, #8fb34d) !important;
        color: #1f364a !important;
    }
    .shadow-inner {
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-3" id="dashboard-content">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.4);">
                <div class="card-body d-flex flex-md-row flex-column justify-content-between align-items-center gap-3 py-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                            <i class="mdi mdi-chart-box-multiple-outline" style="color: #386173; font-size: 1.8rem;"></i>
                            Estadísticas de Actividades Extraescolares
                        </h4>
                        <p class="text-muted mb-0">Estás visualizando: <strong style="color: #386173;">{{ $periodoSeleccionado }}</strong></p>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2 p-1 bg-light shadow-inner" style="border-radius: 12px;">
                        @foreach($periodosConAlumnos as $p)
                        <a href="{{ route('resumen', ['periodo' => $p->generacion]) }}"
                           class="btn px-3 py-2 fw-bold text-decoration-none d-flex align-items-center gap-1 {{ $periodoSeleccionado == $p->generacion ? 'btn-teal active shadow-sm' : 'text-muted' }}"
                           style="border-radius: 10px; transition: all 0.3s ease; font-size: 0.85rem;">
                            <i class="mdi mdi-calendar-month-outline"></i>
                            {{ $p->generacion }}
                            <span class="badge {{ $periodoSeleccionado == $p->generacion ? 'bg-white text-dark' : 'bg-secondary' }} ms-1" style="font-size: 0.7rem;">{{ $p->total }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-1 shadow-sm">
                <i class="mdi mdi-account-multiple icon"></i>
                <p>Alumnos en Periodo</p>
                <h3>{{ $totalUsuarios }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-2 shadow-sm">
                <i class="mdi mdi-check-circle-outline icon" style="color: #1a1a2e;"></i>
                <p style="color: #1a1a2e;">Alumnos Aprobados</p>
                <h3 style="color: #1a1a2e;">{{ $totalAprobados }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-3 shadow-sm">
                <i class="mdi mdi-clock-outline icon"></i>
                <p>Alumnos Cursando</p>
                <h3>{{ $totalCursando }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-red shadow-sm">
                <i class="mdi mdi-alert-circle-outline icon"></i>
                <p>Alumnos Reprobados</p>
                <h3>{{ $totalReprobados }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-4 shadow-sm">
                <i class="mdi mdi-gender-male-female icon"></i>
                <p>Género Mayoritario</p>
                <h3>{{ $generoPred->genero ?? 'N/A' }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-5 shadow-sm" style="color: #1a1a2e;">
                <i class="mdi mdi-weather-sunny icon" style="color: #1a1a2e;"></i>
                <p style="color: #1a1a2e;">Turno Mayoritario</p>
                <h3 style="color: #1a1a2e;">{{ $turnoPred->turno ?? 'N/A' }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-6 shadow-sm" style="color: #1a1a2e;">
                <i class="mdi mdi-trophy icon" style="color: #1a1a2e;"></i>
                <p style="color: #1a1a2e;">Actividad Popular</p>
                <h3 class="kpi-h3-small" style="color: #1a1a2e;">{{ Str::limit($actividadPred->actividad_extraescolar ?? 'N/A', 13) }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-7 shadow-sm">
                <i class="mdi mdi-school icon"></i>
                <p>Carrera Mayoritaria</p>
                <h3 class="kpi-h3-small">{{ Str::limit($carreraPred->carrera ?? 'N/A', 13) }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-chart" id="cardChartCarrera">
                <div class="card-header">
                    <h5 class="card-title">Estudiantes por Carrera - Periodo {{ $periodoSeleccionado }}</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfCarrera">
                        <i class="mdi mdi-file-pdf-box me-1"></i> PDF
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartCarrera"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-chart" id="cardChartEstado">
                <div class="card-header">
                    <h5 class="card-title">Distribución de Estados</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfEstado">
                        <i class="mdi mdi-file-pdf-box"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartEstado"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-chart" id="cardChartGeneracion">
                <div class="card-header">
                    <h5 class="card-title">Estudiantes por Generación - Periodo {{ $periodoSeleccionado }}</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfGeneracion">
                        <i class="mdi mdi-file-pdf-box me-1"></i> PDF
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartGeneracion"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-chart" id="cardChartActividad">
                <div class="card-header">
                    <h5 class="card-title">Estudiantes por Actividad Extraescolar</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfActividad">
                        <i class="mdi mdi-file-pdf-box me-1"></i> PDF
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartActividad"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-chart" id="cardChartGenero">
                <div class="card-header">
                    <h5 class="card-title">Estudiantes por Género</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfGenero">
                        <i class="mdi mdi-file-pdf-box"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartGenero"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-chart" id="cardChartTurno">
                <div class="card-header">
                    <h5 class="card-title">Estudiantes por Turno</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfTurno">
                        <i class="mdi mdi-file-pdf-box"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartTurno"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-chart" id="cardChartTipo">
                <div class="card-header">
                    <h5 class="card-title">Usuarios por Tipo</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfTipo">
                        <i class="mdi mdi-file-pdf-box"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="chartTipo"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
    // Paleta de colores atractiva
    const colors = [
        'rgba(79, 172, 254, 0.8)',   // Azul claro
        'rgba(0, 242, 254, 0.8)',    // Cyan
        'rgba(255, 81, 47, 0.8)',    // Naranja rojizo
        'rgba(221, 36, 118, 0.8)',   // Rosa fuerte
        'rgba(29, 151, 108, 0.8)',   // Verde esmeralda
        'rgba(147, 249, 185, 0.8)',   // Verde claro
        'rgba(102, 126, 234, 0.8)',   // Indigo
        'rgba(118, 75, 162, 0.8)'     // Púrpura
    ];
    const borderColors = colors.map(c => c.replace('0.8', '1'));

    // Configuración general de Chart.js
    Chart.defaults.font.family = "'Inter', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
    Chart.defaults.color = '#666';

    // 1. Gráfica: Carrera (Barra Horizontal)
    const dataCarrera = @json($porCarrera);
    new Chart(document.getElementById('chartCarrera'), {
        type: 'bar',
        data: {
            labels: dataCarrera.map(d => d.carrera),
            datasets: [{
                label: 'Usuarios',
                data: dataCarrera.map(d => d.total),
                backgroundColor: colors[0],
                borderColor: borderColors[0],
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
    document.getElementById('btnPdfCarrera').onclick = () => {
        generarPDFConTabla('cardChartCarrera', 'Usuarios por Carrera', dataCarrera, ['Carrera', 'Total de Usuarios'], ['carrera', 'total']);
    };

    // 2. Gráfica: Generación (Barra Vertical)
    const dataGeneracion = @json($porGeneracion);
    new Chart(document.getElementById('chartGeneracion'), {
        type: 'bar',
        data: {
            labels: dataGeneracion.map(d => d.generacion),
            datasets: [{
                label: 'Usuarios',
                data: dataGeneracion.map(d => d.total),
                backgroundColor: colors[6],
                borderColor: borderColors[6],
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
    document.getElementById('btnPdfGeneracion').onclick = () => {
        generarPDFConTabla('cardChartGeneracion', 'Usuarios por Generación', dataGeneracion, ['Generación', 'Total de Usuarios'], ['generacion', 'total']);
    };

    // 3. Gráfica: Género (Doughnut)
    const dataGenero = @json($porGenero);
    new Chart(document.getElementById('chartGenero'), {
        type: 'doughnut',
        data: {
            labels: dataGenero.map(d => d.genero),
            datasets: [{
                data: dataGenero.map(d => d.total),
                backgroundColor: [colors[3], colors[0], colors[2]],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
    document.getElementById('btnPdfGenero').onclick = () => {
        generarPDFConTabla('cardChartGenero', 'Usuarios por Género', dataGenero, ['Género', 'Total de Usuarios'], ['genero', 'total']);
    };

    // 4. Gráfica: Turno (Pie)
    const dataTurno = @json($porTurno);
    new Chart(document.getElementById('chartTurno'), {
        type: 'pie',
        data: {
            labels: dataTurno.map(d => d.turno),
            datasets: [{
                data: dataTurno.map(d => d.total),
                backgroundColor: [colors[4], colors[2], colors[6]],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
    document.getElementById('btnPdfTurno').onclick = () => {
        generarPDFConTabla('cardChartTurno', 'Usuarios por Turno', dataTurno, ['Turno', 'Total de Usuarios'], ['turno', 'total']);
    };

    // 5. Gráfica: Tipo (Doughnut)
    const dataTipo = @json($porTipo);
    new Chart(document.getElementById('chartTipo'), {
        type: 'doughnut',
        data: {
            labels: dataTipo.map(d => d.id_tipo), 
            datasets: [{
                data: dataTipo.map(d => d.total),
                backgroundColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '50%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
    document.getElementById('btnPdfTipo').onclick = () => {
        const formattedDataTipo = dataTipo.map(d => ({ tipo: d.id_tipo, total: d.total }));
        generarPDFConTabla('cardChartTipo', 'Usuarios por Tipo', formattedDataTipo, ['Tipo', 'Total de Usuarios'], ['tipo', 'total']);
    };

    // 6. Gráfica: Actividades (Barra)
    const dataActividad = @json($porActividad);
    new Chart(document.getElementById('chartActividad'), {
        type: 'bar',
        data: {
            labels: dataActividad.map(d => d.actividad_extraescolar), 
            datasets: [{
                label: 'Usuarios',
                data: dataActividad.map(d => d.total),
                backgroundColor: colors,
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
    document.getElementById('btnPdfActividad').onclick = () => {
        const formattedDataActividad = dataActividad.map(d => ({ act: d.actividad_extraescolar, total: d.total }));
        generarPDFConTabla('cardChartActividad', 'Top Actividades Extraescolares', formattedDataActividad, ['Actividad', 'Total de Usuarios'], ['act', 'total']);
    };

    // 7. Gráfica: Distribución de Estados (Doughnut)
    const dataEstado = @json($porEstado);
    new Chart(document.getElementById('chartEstado'), {
        type: 'doughnut',
        data: {
            labels: dataEstado.map(d => d.estado),
            datasets: [{
                data: dataEstado.map(d => d.total),
                backgroundColor: [
                    'rgba(29, 151, 108, 0.8)',   // Verde
                    'rgba(79, 172, 254, 0.8)',   // Azul
                    'rgba(255, 81, 47, 0.8)'     // Rojo
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
    document.getElementById('btnPdfEstado').onclick = () => {
        generarPDFConTabla('cardChartEstado', 'Distribucion de Estados', dataEstado, ['Estado', 'Total de Alumnos'], ['estado', 'total']);
    };

    // Función para generar PDF con Tabla e Imagen
    function generarPDFConTabla(elementId, filename, data, headers, keys) {
        const element = document.getElementById(elementId);
        
        // Ocultar el botón temporalmente
        const btn = element.querySelector('.btn-pdf');
        btn.style.display = 'none';
        
        setTimeout(() => {
            html2canvas(element, {
                scale: 2,
                backgroundColor: '#ffffff',
                logging: false
            }).then(canvas => {
                btn.style.display = 'inline-block';
                
                const imgData = canvas.toDataURL('image/jpeg', 1.0);
                const { jsPDF } = window.jspdf;
                
                const doc = new jsPDF('p', 'mm', 'a4');
                const pw = doc.internal.pageSize.getWidth();
                const ph = doc.internal.pageSize.getHeight();
                
                // --- 1. TÍTULO Y FECHA ---
                doc.setFontSize(16);
                doc.setTextColor(40);
                doc.text("Reporte: " + filename + " - Periodo " + "{{ $periodoSeleccionado }}", 14, 20);
                
                doc.setFontSize(10);
                doc.setTextColor(100);
                const fecha = new Date().toLocaleString();
                doc.text("Generado el: " + fecha, 14, 26);
                
                // --- 2. TABLA DE DATOS ---
                const tableData = data.map(item => [item[keys[0]], item[keys[1]]]);
                
                doc.autoTable({
                    startY: 32,
                    head: [headers],
                    body: tableData,
                    theme: 'striped',
                    headStyles: { fillColor: [56, 97, 115] }, // Azul (teal) del ITSSMT
                    styles: { fontSize: 11, cellPadding: 3 }
                });
                
                let finalY = doc.lastAutoTable.finalY + 10;
                
                // --- 3. IMAGEN DE LA GRÁFICA ---
                const imgW = canvas.width;
                const imgH = canvas.height;
                
                const spaceLeft = ph - finalY - 15;
                const w = pw - 28; 
                const h = (imgH * w) / imgW;
                
                if (h > spaceLeft) {
                    doc.addPage();
                    finalY = 20; 
                }
                
                doc.addImage(imgData, 'JPEG', 14, finalY, w, h);
                
                // Guardar PDF
                doc.save(filename.replace(/ /g, '_') + '_Periodo_' + "{{ $periodoSeleccionado }}" + '.pdf');
                
            }).catch(err => {
                console.error("Error al generar PDF: ", err);
                btn.style.display = 'inline-block';
                alert("Hubo un error al generar el PDF.");
            });
        }, 100);
    }
</script>
@endpush