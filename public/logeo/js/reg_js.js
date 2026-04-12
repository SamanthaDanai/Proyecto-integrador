const ccontrol= document.getElementById('control');

const cpaterno= document.getElementById('apat');
cpaterno.addEventListener("keypress", soloLetras);

const cmaterno= document.getElementById('amat');
cmaterno.addEventListener("keypress", soloLetras);

const cnombre= document.getElementById('nombre');
cnombre.addEventListener("keypress", soloLetras);

const carrera= document.getElementById('carrera');
const actextra= document.getElementById('actextra');
const horario= document.getElementById('horario');

//Evento para limpiar las cajas cuando el usuario escribe algo
document.querySelectorAll("input, select").forEach(input => {
    input.addEventListener("input", function() {
        this.classList.remove("is-valid");
        this.classList.remove("is-invalid");
    });
});

ccontrol.addEventListener("input", controlTec)

const formRegistro = document.querySelector("form");
formRegistro.addEventListener("submit", function(event) {
    let formValido = true;
    
    if(!validarControl(ccontrol)) formValido = false;
    if(!validarCampo(cpaterno)) formValido = false;
    if(!validarCampo(cmaterno)) formValido = false;
    if(!validarCampo(cnombre)) formValido = false;
    if(!validarRadio("genero")) formValido = false;
    if(!validarSeleccion(carrera)) formValido = false;
    if(!validarRadio("turno")) formValido = false;
    if(!validarSeleccion(actextra)) formValido = false;
    if(!validarSeleccion(horario)) formValido = false;
    if(!validarRadio("disca")) formValido = false;

    if (!formValido) {
        alert("Formulario inválido. Por favor, revise los campos marcados.");
        event.preventDefault();
    }
});

//Validación caracteres
function soloLetras(event) {
    event.target.value = event.target.value.replace(/[^a-zA-ZáÁéÉíÍóÓúÚ\s]/g, "");
}
function soloNumeros(event) {
    event.target.value = event.target.value.replace(/[^0-9]/g, "");
}

function controlTec(event)
{
    let valor = event.target.value.toLowerCase();
    valor = valor.replace(/[^a-z0-9]/g, "");
    if (valor.length > 9) valor = valor.slice(0, 9);
    event.target.value = valor;
}

// Validación de control TECNM (1 letra + 8 números)
function validarControl(elemento){
    elemento.value = elemento.value.toLowerCase();
    let padre = elemento.parentElement;

    const regex = /^[a-zA-Z]\d{8}$/;

    if(elemento.value.trim() === "") {
        elemento.classList.remove("is-valid");
        elemento.classList.add("is-invalid");
        padre.querySelector(".invalid-feedback").innerText = "Campo obligatorio";
        return false;

    } else if(!regex.test(elemento.value)){
        elemento.classList.remove("is-valid");
        elemento.classList.add("is-invalid");
        padre.querySelector(".invalid-feedback").innerText = "Debe ser 1 letra + 8 números. Ej: i22240029";
        return false;
    } 
    elemento.classList.remove("is-invalid");
    elemento.classList.add("is-valid");
    padre.querySelector(".valid-feedback").innerText = "Correcto!";
    return true;
}

// Validación general de campo de texto
function validarCampo(elemento) {
    if(elemento.value.trim() === "") {
        elemento.classList.remove("is-valid");
        elemento.classList.add("is-invalid");
        return false;
    } else {
        elemento.classList.remove("is-invalid");
        elemento.classList.add("is-valid");
        return true;
    }
}

// Validación radio
function validarRadio(nombre) {
    const radioButtons = document.querySelectorAll(`input[name="${nombre}"]`);
    let seleccionado = [...radioButtons].some(r => r.checked);
    radioButtons.forEach(r => r.classList.toggle("is-invalid", !seleccionado));
    return seleccionado;
}

// Validación select
function validarSeleccion(elemento) {
    if(elemento.value == "") {
        elemento.classList.remove("is-valid");
        elemento.classList.add("is-invalid");
        return false;
    } else {
        elemento.classList.remove("is-invalid");
        elemento.classList.add("is-valid");
        return true;
    }
}

// Validación correo institucional TECNM
function validaCorreo(elemento)
{
    const regexCorreo = /^[a-zA-Z]\d{8}@smartin\.tecnm\.mx$/;
    const padre = elemento.parentElement;

    if(!regexCorreo.test(elemento.value)) {
        elemento.classList.remove("is-valid");
        elemento.classList.add("is-invalid");
        padre.querySelector(".invalid-feedback").innerText = "Formato inválido. Ej: i22240029@smartin.tecnm.mx";
        return false;
    }
    elemento.classList.remove("is-invalid");
    elemento.classList.add("is-valid");
    padre.querySelector(".valid-feedback").innerText = "Correo válido";
    return true;
}

// Delegación para eliminar y editar usuario
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('tbody').addEventListener('click', function(e) {
        
        if (e.target.closest('.btn-danger')) {
            const fila = e.target.closest('tr');
            const num_control = fila.querySelector('td').innerText;
            if (confirm('¿Seguro que deseas eliminar este usuario?')) {
                fetch('eliminar_usuario.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'num_control=' + encodeURIComponent(num_control)
                })
                .then(res => res.text())
                .then(res => {
                    if (res.trim() === 'OK') {
                        fila.remove();
                        alert('Usuario eliminado correctamente');
                    } else {
                        alert('Error al eliminar: ' + res);
                    }
                });
            }
        }

        if (e.target.closest('.btn-primary')) {
            const fila = e.target.closest('tr');
            const num_control = fila.querySelector('td').innerText;
            fetch('obtener_usuario.php?num_control=' + encodeURIComponent(num_control))
                .then(res => res.json())
                .then(data => {
                    document.getElementById('control').value = data.num_control;
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apat').value = data.apat;
                    document.getElementById('amat').value = data.amat;
                    document.querySelector(`input[name="genero"][value="${data.genero}"]`).checked = true;
                    document.getElementById('turno').value = data.turno;
                    document.getElementById('correo_inst').value = data.correo_inst;
                    document.getElementById('carrera').value = data.carrera;
                    document.getElementById('generacion').value = data.generacion;
                    document.getElementById('actextra').value = data.actextra;
                    document.getElementById('horario').value = data.horario;

                    document.getElementById('control').readOnly = true;
                    let modal = new bootstrap.Modal(document.getElementById('modalNuevo'));
                    modal.show();
                });
        }
    });
});

// Guardar usuario
document.addEventListener('DOMContentLoaded', function() {
    const formEstudiante = document.getElementById('formEstudiante');
    if (formEstudiante) {
        formEstudiante.addEventListener('submit', function(event) {
            event.preventDefault();
            const datos = new FormData(this);
            fetch('guardar_usuario.php', { method: 'POST', body: datos })
            .then(res => res.text())
            .then(res => {
                if (res.trim() === 'OK') {
                    alert('Usuario guardado correctamente');
                    location.reload();
                } else {
                    alert('Error al guardar: ' + res);
                }
            });
        });
    }

    const nuevoEstudiante = document.getElementById('nuevoEstudiante');
    if (nuevoEstudiante) {
        nuevoEstudiante.addEventListener('click', function() {
            document.getElementById('formEstudiante').reset();
            document.getElementById('control').readOnly = false;
        });
    }
});
