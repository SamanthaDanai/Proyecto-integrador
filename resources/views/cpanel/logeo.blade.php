<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extraescolares</title>
    <link rel="icon" href="logeo/img/logo-ITSS.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/reg_css.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/reg_js.js" defer></script>
</head>

<body class="contenedor">

<header>
    <nav class="navbar w-100 h-100">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand text-white text-center">
                <img src="../img/logo-ITSS.png" width="45" height="40" class="d-inline-block">
                INSTITUTO TECNOLÓGICO SUPERIOR DE SAN MARTÍN TEXMELUCAN PUE.
            </a>
        </div>
    </nav>
</header>

<main class="completo">
    <div class="solicitud"><h3>Solicitud</h3></div>

    <!-- Mensaje -->
    <div class="row">
        <div class="offset-4 col-md-4">
                <?php
                if(isset($_GET["mensaje"])) {
                    echo "<p class='alert alert-info alert-dismissible fade show'>{$_GET["mensaje"]}
          <button type='button' class='btn-close' data-bs-dismiss='alert'></button></p>";
                }
                ?>
        </div>
    </div>

    <!-- Botones -->
    <div class="row">
        <div class="offset-8 col-md-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nuevo Estudiante</button>
            <button class="btn btn-danger" form="listaBorrado">Borrar Selección</button>
        </div>
    </div>

    <!-- Tabla -->
    <div class="row mt-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Seleccionar</td>
                    <td>No.control</td>
                    <td>Nombre</td>
                    <td>Apellido Paterno</td>
                    <td>Apellido Materno</td>
                    <td>Sexo</td>
                    <td>Turno</td>
                    <td>Correo Institucional</td>
                    <td>Carrera</td>
                    <td>Tipo</td>
                    <td>Generación</td>
                    <td>Acciones</td>
                </tr>
                </thead>

                <tbody>
                <form action="controlador.php" method="POST" id="listaBorrado">
                    <input name="ope" value="borrarUsuario" type="hidden">
                        <?php
                        $sql="SELECT num_control, nombre, apat, amat, sexo, turno, correo, carrera, id_tipo, generacion FROM usuario";
                        $resultado = $conexion->query($sql);

                        while($fila = $resultado->fetch_array())
                        {
                            echo "<tr>
                <td><input type='checkbox' name='selecionados[]' value='{$fila[0]}'></td>
                <td>{$fila[0]}</td>
                <td>{$fila[1]}</td>
                <td>{$fila[2]}</td>
                <td>{$fila[3]}</td>
                <td>{$fila[4]}</td>
                <td>{$fila[5]}</td>
                <td>{$fila[6]}</td>
                <td>{$fila[7]}</td>
                <td>{$fila[8]}</td>
                <td>{$fila[9]}</td>
                <td>
                  <button class='btn btn-info' data-id='{$fila[0]}'>E</button>
                  <a class='btn btn-danger' href='../controlador.php?ope=borrarUsuario&cod={$fila[0]}'>B</a>
                </td>
              </tr>";
                        }
                        ?>
                </form>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Nuevo estudiante -->
<div class="modal fade" id="modalNuevo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Nuevo Estudiante</h1>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form name="formulario" method="GET" action="../controlador.php" novalidate>

                    <input type="hidden" name="ope" value="nuevoUsuario">

                    <!-- No. Control -->
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="control" name="num_control" placeholder="22240029" required pattern="[0-9]{8}">
                        <label>No. Control</label>
                    </div>

                    <!-- Apellidos y Nombre -->
                    <div class="row mb-2">
                        <div class="col-md-4 form-floating">
                            <input type="text" class="form-control" id="apat" name="apat" placeholder="Apellido Paterno" required>
                            <label>Apellido Paterno</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <input type="text" class="form-control" id="amat" name="amat" placeholder="Apellido Materno" required>
                            <label>Apellido Materno</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                            <label>Nombre(s)</label>
                        </div>
                    </div>

                    <!-- Género -->
                    <label>Género</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" value="F" required>
                        <label class="form-check-label">Femenino</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="sexo" value="M" required>
                        <label class="form-check-label">Masculino</label>
                    </div>

                    <!-- Turno -->
                    <label>Turno</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="turno" value="Matutino" required>
                        <label class="form-check-label">Matutino</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="turno" value="Vespertino" required>
                        <label class="form-check-label">Vespertino</label>
                    </div>

                    <!-- Correo -->
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="correo" name="correo" required
                               pattern="[a-zA-Z]{1}[0-9]{8}@smartin\.tecnm\.mx" placeholder="i22240029@smartin.tecnm.mx">
                        <label>Correo Institucional</label>
                    </div>

                    <!-- Carrera -->
                    <select class="form-select mb-2" name="carrera" required>
                        <option value="">Selecciona carrera</option>
                        <option>ISC</option>
                        <option>Electromecánica</option>
                        <option>Industrial</option>
                        <option>IGE</option>
                        <option>Ambiental</option>
                        <option>Contador</option>
                        <option>Turismo</option>
                    </select>

                    <!-- Tipo usuario -->
                    <input type="hidden" name="id_tipo" value="Estudiante">

                    <!-- Generación -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="generacion" placeholder="2022-2026" required>
                        <label>Generación</label>
                    </div>

                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
</html>

