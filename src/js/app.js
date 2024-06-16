let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

function iniciarApp() {
  mostrarSeccion(); //Muestra y oculta las secciones
  tabs(); // Cambia la seccion cuando se hacen click en los tabs
  botonesPaginador(); //Paginacion agrega o quita los botones
  paginaSiguiente(); //Pagina Siguiente en el paginador
  paginaAnterior(); //Pagina Anterior en el paginador
  consultarAPI(); //Consulta la API
  idCliente();
  nombreCliente(); //Añade el nombre al arreglo
  seleccionarFecha(); //Añade la fecha de la cita al objeto
  seleccionarHora(); //Añade la hora de la cita al objeto
  mostrarResumen(); //Muestra el resumen de la cita
}

function mostrarSeccion() {
  //Remover Clase mostrar
  const seccionAnterior = document.querySelector(".mostrar");

  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  //Seleccionr la Seccion con el numero de paso
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar");

  //Quita la clase de acutal al tab anterior

  const tabAnterior = document.querySelector(".actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }

  //Resakta el tab actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const botones = document.querySelectorAll(".tabs button");
  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);

      mostrarSeccion();
      botonesPaginador();
    });
  });
}

function botonesPaginador() {
  const paginaAnterior = document.querySelector("#anterior");
  const paginaSiguiente = document.querySelector("#siguiente");

  if (paso === 1) {
    paginaAnterior.classList.add("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  } else if (paso === 3) {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
    mostrarResumen();
  } else if (paso === 2) {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }

  mostrarSeccion();
}

function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");
  paginaAnterior.addEventListener("click", function () {
    if (paso <= pasoInicial) return;
    paso--;
    botonesPaginador();
  });
}

function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");
  paginaSiguiente.addEventListener("click", function () {
    if (paso >= pasoFinal) return;
    paso++;
    botonesPaginador();
  });
}

async function consultarAPI() {
  try {
    const url = "/api/servicios";
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);
  } catch (error) {
    console.log(error);
  }
}

function mostrarServicios(servicios) {
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;

    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = `$${precio}`;

    const servicioDiv = document.createElement("DIV");
    servicioDiv.classList.add("servicio");
    servicioDiv.dataset.idServicio = id;
    servicioDiv.onclick = function () {
      seleccionarServicio(servicio);
    };

    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);

    document.querySelector("#servicios").appendChild(servicioDiv);
  });
}

function seleccionarServicio(servicio) {
  const { id } = servicio;
  const { servicios } = cita;

  //Identificar el elemento al que se le da click
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

  if (servicios.some((agregado) => agregado.id === id)) {
    //Eliminarlo
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    divServicio.classList.remove("seleccionado");
  } else {
    cita.servicios = [...servicios, servicio];
    divServicio.classList.add("seleccionado");
  }

  console.log(cita);
}

function idCliente() {
  cita.id = document.querySelector("#id").value;
}

function nombreCliente() {
  cita.nombre = document.querySelector("#nombre").value;
}

function seleccionarHora() {
  const inputHora = document.querySelector("#hora");
  inputHora.addEventListener("input", function (e) {
    const horaCita = e.target.value;
    const hora = horaCita.split(":")[0];
    if (hora < 8 || hora > 17) {
      e.target.value = "";
      mostrarAlerta(
        "Selecciona una hora entre las 8 AM y las 6 PM",
        "error",
        ".formulario"
      );
    } else {
      cita.hora = e.target.value;
      console.log(cita);
    }
  });
}

function seleccionarFecha() {
  const inputFecha = document.querySelector("#fecha");
  inputFecha.addEventListener("input", function (e) {
    const dia = new Date(e.target.value).getUTCDay();
    //No permite trabajar sabados o domingos con [6, 0]
    if ([6, 0].includes(dia)) {
      e.target.value = "";
      mostrarAlerta("Fines de semana no permitidos", "error", ".formulario");
    } else {
      cita.fecha = e.target.value;
    }
  });
}
function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
  //Previene que se genere más de una alerta
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }
  const alerta = document.createElement("div");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add(tipo);

  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);
  //Eliminar la alerta
  if (desaparece) {
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Faltan datos para su cita, compruebe nuevamente.",
      "error",
      ".contenido-resumen",
      false
    );
    return;
  }

  //Formatear el div de resumen

  const { nombre, fecha, hora, servicios } = cita;

  const nombreCliente = document.createElement("P");
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;
  //Formatear la fecha en español

  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(year, mes, dia));
  console.log(fechaUTC);
  const opciones = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const fechaFormateada = fechaUTC.toLocaleDateString("es-MX", opciones);

  const fechaCita = document.createElement("P");
  fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

  const horaCita = document.createElement("P");
  horaCita.innerHTML = `<span>Hora:</span> ${hora}`;

  const total = servicios.reduce(
    (total, servicio) => total + parseFloat(servicio.precio),
    0
  );
  const totalParrafo = document.createElement("P");
  totalParrafo.innerHTML = `<span>Total:</span> $${total}`;

  //heading para Servicios en resumen
  const headingServicios = document.createElement("H3");
  headingServicios.textContent = "Resumen de Servicios";
  resumen.appendChild(headingServicios);

  //Iterando y mostrando los servicios
  servicios.forEach((servicio) => {
    const { id, precio, nombre } = servicio;
    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicios");

    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio</span> $${precio}`;

    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);

    resumen.appendChild(contenedorServicio);
  });
  //heading para Cita en resumen
  const headingCita = document.createElement("H3");
  headingCita.textContent = "Resumen de Cita";
  resumen.appendChild(headingCita);
  resumen.appendChild(totalParrafo);
  //Boton para la cita

  const botonReservar = document.createElement("BUTTON");
  botonReservar.classList.add("boton");
  botonReservar.textContent = "Reservar Cita";
  botonReservar.onclick = reservarCita;

  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCita);
  resumen.appendChild(horaCita);

  resumen.appendChild(botonReservar);
}

async function reservarCita() {
  const { nombre, fecha, hora, servicios, id } = cita;

  const idServicios = servicios.map((servicio) => servicio.id);

  // console.log(idServicios);

  const datos = new FormData();

  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("usuarioId", id);
  datos.append("servicios", idServicios);

  // console.log([...datos]);
  try {
    const url = "/api/citas";

    const respuesta = await fetch(url, {
      method: "POST",
      body: datos,
    });

    const resultado = await respuesta.json();

    if (resultado.resultado) {
      Swal.fire({
        icon: "success",
        title: "Cita Creada",
        text: "Tu Cita fué creada correctamente 🙌🏻",
        buttton: "OK",
      }).then(() => {
        setTimeout(() => {
          window.location.reload();
        }, 3000);
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Ha ocurrido un error",
      text: "Ha ocurrido un error, intentalo nuevamente más tarde.",
    }).then(() => {
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    });
  }
  //peticion hacia la API
}
