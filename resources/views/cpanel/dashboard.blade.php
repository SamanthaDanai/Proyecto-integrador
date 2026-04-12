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
    }
    .kpi-card .icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 3rem;
        opacity: 0.3;
    }
    .kpi-card h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
    }
    .kpi-card p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }
    .bg-gradient-1 { background: linear-gradient(45deg, #FF512F, #DD2476); }
    .bg-gradient-2 { background: linear-gradient(45deg, #1D976C, #93F9B9); color: #1a1a2e; }
    .bg-gradient-3 { background: linear-gradient(45deg, #4facfe, #00f2fe); }
    .bg-gradient-4 { background: linear-gradient(45deg, #667eea, #764ba2); }
    .bg-gradient-5 { background: linear-gradient(45deg, #FFB75E, #ED8F03); }
    .bg-gradient-6 { background: linear-gradient(45deg, #11998e, #38ef7d); }
    .bg-gradient-7 { background: linear-gradient(45deg, #8E2DE2, #4A00E0); }

    .kpi-h3-small { font-size: 1.8rem !important; }
    
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
</style>
@endpush

@section('content')
<div class="container-fluid mt-3" id="dashboard-content">
    
    <!-- KPIs -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-1 shadow-sm">
                <i class="mdi mdi-account-multiple icon"></i>
                <p>Total Usuarios</p>
                <h3>{{ $totalUsuarios }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-2 shadow-sm">
                <i class="mdi mdi-calendar-check icon" style="color: #1a1a2e;"></i>
                <p style="color: #1a1a2e;">Total Actividades</p>
                <h3 style="color: #1a1a2e;">{{ $totalActividades }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-3 shadow-sm">
                <i class="mdi mdi-account-star icon"></i>
                <p>Tipos de Usuario</p>
                <h3>{{ $totalTipos }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="kpi-card bg-gradient-4 shadow-sm">
                <i class="mdi mdi-gender-male-female icon"></i>
                <p>Género Mayoritario</p>
                <h3>{{ $generoPred->genero ?? 'N/A' }}</h3>
            </div>
        </div>
    </div>

    <!-- KPIs Row 2 -->
    <div class="row">
        <!-- Turno Mayoritario -->
        <div class="col-md-4 col-sm-6">
            <div class="kpi-card bg-gradient-5 shadow-sm">
                <i class="mdi mdi-weather-sunny icon"></i>
                <p>Turno Mayoritario</p>
                <h3>{{ $turnoPred->turno ?? 'N/A' }}</h3>
            </div>
        </div>
        <!-- Actividad Mayoritaria -->
        <div class="col-md-4 col-sm-6">
            <div class="kpi-card bg-gradient-6 shadow-sm">
                <i class="mdi mdi-trophy icon"></i>
                <p>Actividad Más Popular</p>
                <h3 class="kpi-h3-small">{{ Str::limit($actividadPred->actividad_extraescolar ?? 'N/A', 15) }}</h3>
            </div>
        </div>
        <!-- Carrera Mayoritaria -->
        <div class="col-md-4 col-sm-12">
            <div class="kpi-card bg-gradient-7 shadow-sm">
                <i class="mdi mdi-school icon"></i>
                <p>Carrera Mayoritaria</p>
                <h3 class="kpi-h3-small">{{ Str::limit($carreraPred->carrera ?? 'N/A', 15) }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row">
        <!-- Usuarios por Carrera -->
        <div class="col-lg-6">
            <div class="card card-chart" id="cardChartCarrera">
                <div class="card-header">
                    <h5 class="card-title">Usuarios por Carrera</h5>
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

        <!-- Usuarios por Generación -->
        <div class="col-lg-6">
            <div class="card card-chart" id="cardChartGeneracion">
                <div class="card-header">
                    <h5 class="card-title">Usuarios por Generación</h5>
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
    </div>

    <!-- Charts Row 2 -->
    <div class="row">
        <!-- Usuarios por Género -->
        <div class="col-md-4">
            <div class="card card-chart" id="cardChartGenero">
                <div class="card-header">
                    <h5 class="card-title">Usuarios por Género</h5>
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

        <!-- Usuarios por Turno -->
        <div class="col-md-4">
            <div class="card card-chart" id="cardChartTurno">
                <div class="card-header">
                    <h5 class="card-title">Usuarios por Turno</h5>
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

        <!-- Usuarios por Tipo -->
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

    <!-- Charts Row 3 -->
    <div class="row">
        <!-- Actividades más populares -->
        <div class="col-12">
            <div class="card card-chart" id="cardChartActividad">
                <div class="card-header">
                    <h5 class="card-title">Usuarios por Actividad Extraescolar</h5>
                    <button class="btn btn-outline-danger btn-pdf" id="btnPdfActividad">
                        <i class="mdi mdi-file-pdf-box me-1"></i> PDF
                    </button>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 350px;">
                        <canvas id="chartActividad"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- html2canvas and jsPDF for PDF export -->
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

    // Función para generar PDF con Tabla e Imagen
    function generarPDFConTabla(elementId, filename, data, headers, keys) {
        // Encontrar el contenedor de la gráfica
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
                
                // Siempre generamos en 'p' (Portrait) para acomodar tabla e imagen
                const doc = new jsPDF('p', 'mm', 'a4');
                const pw = doc.internal.pageSize.getWidth();
                const ph = doc.internal.pageSize.getHeight();
                
                // --- 1. TÍTULO Y FECHA ---
                doc.setFontSize(16);
                doc.setTextColor(40);
                doc.text("Reporte: " + filename, 14, 20);
                
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
                    headStyles: { fillColor: [220, 53, 69] }, // Rojo (danger)
                    styles: { fontSize: 11, cellPadding: 3 }
                });
                
                // Saber dónde terminó la tabla (coordenada Y)
                let finalY = doc.lastAutoTable.finalY + 10;
                
                // --- 3. IMAGEN DE LA GRÁFICA ---
                const imgW = canvas.width;
                const imgH = canvas.height;
                
                // Calcular espacio disponible abajo de la tabla
                const spaceLeft = ph - finalY - 15;
                
                // Escalar imagen para que encaje en el ancho, manteniendo proporciones
                const w = pw - 28; // Márgenes laterales
                const h = (imgH * w) / imgW;
                
                // Si la imagen no cabe en el espacio que sobra, agregamos nueva hoja
                if (h > spaceLeft) {
                    doc.addPage();
                    finalY = 20; // Empezar arriba en la nueva hoja
                }
                
                doc.addImage(imgData, 'JPEG', 14, finalY, w, h);
                
                // Guardar PDF
                doc.save(filename.replace(/ /g, '_') + '.pdf');
                
            }).catch(err => {
                console.error("Error al generar PDF: ", err);
                btn.style.display = 'inline-block';
                alert("Hubo un error al generar el PDF.");
            });
        }, 100);
    }
</script>
@endpush
