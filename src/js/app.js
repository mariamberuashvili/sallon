let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
};


document.addEventListener('DOMContentLoaded', function () {
  
    const paginaCitas = document.querySelector('.pagina-citas');
    if (!paginaCitas) return;

    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion();
    tabs();
    botonesPaginador();
    paginaSiguiente();
    paginaAnterior();

    consultarAPI();

    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();

    mostrarResumen();
}


function mostrarSeccion() {
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) seccionAnterior.classList.remove('mostrar');

    const seccion = document.querySelector(`#paso-${paso}`);
    if (seccion) seccion.classList.add('mostrar');

    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) tabAnterior.classList.remove('actual');

    const tab = document.querySelector(`[data-paso="${paso}"]`);
    if (tab) tab.classList.add('actual');

    botonesPaginador();
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    if (!botones.length) return;

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            e.preventDefault();
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const botonSiguiente = document.querySelector('#siguiente');
    const botonAnterior = document.querySelector('#anterior');

    if (botonAnterior) botonAnterior.classList.toggle('ocultar', paso === pasoInicial);
    if (botonSiguiente) botonSiguiente.classList.toggle('ocultar', paso === pasoFinal);

    if (paso === pasoFinal) mostrarResumen();
}


function paginaAnterior() {
    const botonAnterior = document.querySelector('#anterior');
    if (!botonAnterior) return;

    botonAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;
        mostrarSeccion();
    });
}

function paginaSiguiente() {
    const botonSiguiente = document.querySelector('#siguiente');
    if (!botonSiguiente) return;

    botonSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;
        mostrarSeccion();
    });
}


function idCliente() {
    const input = document.querySelector('#id');
    if (input) cita.id = input.value;
}

function nombreCliente() {
    const input = document.querySelector('#nombre');
    if (input) cita.nombre = input.value;
}

async function consultarAPI() {
    try {
        const res = await fetch(`${APP_URL}/api/servicios`);
        if (!res.ok) throw new Error(`Error ${res.status}`);
        const servicios = await res.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.error(error);
    }
}


function mostrarServicios(servicios) {
    const contenedor = document.querySelector('#servicios');
    if (!contenedor) return;

    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const div = document.createElement('DIV');
        div.classList.add('servicio');
        div.dataset.idServicio = id;

        div.innerHTML = `<p class="nombre-servicio">${nombre}</p>
                         <p class="precio-servicio">€${precio}</p>`;

        div.addEventListener('click', () => toggleServicio(servicio, div));

        contenedor.appendChild(div);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    if (!divServicio) return;

    if (servicios.some(agregado => agregado.id === id)) {
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    if (!inputFecha) return;

    inputFecha.addEventListener('input', function (e) {
        const dia = new Date(e.target.value).getUTCDay();
        if ([0, 6].includes(dia)) {
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    if (!inputHora) return;

    inputHora.addEventListener('input', function (e) {
        const hora = parseInt(e.target.value.split(':')[0]);
        if (hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora No Válida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
        }
    });
}


function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) alertaPrevia.remove();

    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta', tipo);

    const referencia = document.querySelector(elemento);
    if (!referencia) return;

    referencia.appendChild(alerta);

    if (desaparece) {
        setTimeout(() => alerta.remove(), 3000);
    }
}


function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');
    if (!resumen) return;

    while (resumen.firstChild) resumen.removeChild(resumen.firstChild);

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de Servicios, Fecha y Hora', 'error', '.contenido-resumen', false);
        return;
    }

    const { nombre, fecha, hora, servicios } = cita;

    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    servicios.forEach(servicio => {
        const { precio, nombre } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> €${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        resumen.appendChild(contenedorServicio);
    });

    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    const fechaObj = new Date(fecha);
    const fechaUTC = new Date(Date.UTC(
        fechaObj.getFullYear(),
        fechaObj.getMonth(),
        fechaObj.getDate() + 2
    ));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}


async function reservarCita() {
    const { nombre, fecha, hora, servicios, id } = cita;

    if (!fecha || !hora || servicios.length === 0) {
        mostrarAlerta('Faltan datos de Servicios, Fecha o Hora', 'error', '.contenido-resumen');
        return;
    }

    const idServicios = servicios.map(servicio => servicio.id);

    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuario_id', id);

   
    idServicios.forEach(idServicio => datos.append('servicios[]', idServicio));

   try {
        const res = await fetch(`${APP_URL}/api/citas`, { method: 'POST', body: datos });
        const resultado = await res.json();


        if (resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu cita fue creada correctamente'
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al guardar la cita'
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
        });
    }
}
