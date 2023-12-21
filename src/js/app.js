let step = 1;
const initialStep = 1;
const finalStep = 3;

const appointment = {
  id: "",
  name: "",
  date: "",
  time: "",
  services: [],
};

document.addEventListener("DOMContentLoaded", function () {
  startApp();
});

function startApp() {
  showSection();
  tabs(); // cambia seccion cuando se presionan los tabs
  paginationButtons(); // agrega o quita los botones del paginador
  nextPage();
  previousPage();

  queryAPI(); // consultar la API en el backend de PHP

  customerId();
  customerName(); // añadir el nombre de cliente al objeto cita
  selectDate(); // añade la fecha
  selectTime(); // añade la hora

  showSummary(); // resumen de la cita
}

function showSection() {
  // ocultar la seccion  que tenga la clase de mostrar
  const previousSection = document.querySelector(".show");
  if (previousSection) {
    previousSection.classList.remove("show");
  }

  // seleccionar la seccion con el paso...
  const stepSelector = `#step-${step}`;
  const section = document.querySelector(stepSelector);
  section.classList.add("show");

  // quitar la clase de actual al tab anterior
  const previousTab = document.querySelector(".actual");
  if (previousTab) {
    previousTab.classList.remove("actual");
  }

  // resaltar el tab actual
  const tab = document.querySelector(`[data-step="${step}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const buttons = document.querySelectorAll(".tabs button");

  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      step = parseInt(e.target.dataset.step);

      showSection();
      paginationButtons();
    });
  });
}

function paginationButtons() {
  const previousPage = document.querySelector("#previous");
  const nextPage = document.querySelector("#next");

  if (step === 1) {
    previousPage.classList.add("hide");
    nextPage.classList.remove("hide");
  } else if (step === 3) {
    previousPage.classList.remove("hide");
    nextPage.classList.add("hide");

    showSummary();
  } else {
    previousPage.classList.remove("hide");
    nextPage.classList.remove("hide");
  }

  showSection();
}

function previousPage() {
  const previousPage = document.querySelector("#previous");
  previousPage.addEventListener("click", function () {
    if (step <= initialStep) return;
    step--;

    paginationButtons();
  });
}

function nextPage() {
  const nextPage = document.querySelector("#next");
  nextPage.addEventListener("click", function () {
    if (step >= finalStep) return;
    step++;

    paginationButtons();
  });
}

async function queryAPI() {
  try {
    const url = "/api/services";
    const output = await fetch(url);
    const services = await output.json();
    showServices(services);
  } catch (error) {
    console.log(error);
  }
}

function showServices(services) {
  services.forEach((service) => {
    const { id, name, price } = service;

    const serviceName = document.createElement("P");
    serviceName.classList.add("service-name");
    serviceName.textContent = name;

    const servicePrice = document.createElement("P");
    servicePrice.classList.add("service-price");
    servicePrice.textContent = `$${price}`;

    const serviceDiv = document.createElement("DIV");
    serviceDiv.classList.add("service");
    serviceDiv.dataset.idService = id;
    serviceDiv.onclick = function () {
      selectService(service);
    };

    serviceDiv.appendChild(serviceName);
    serviceDiv.appendChild(servicePrice);

    document.querySelector("#services").appendChild(serviceDiv);
  });
}

function selectService(service) {
  const { id } = service;
  const { services } = appointment;
  // identificamos elemento que le damos click
  const serviceDiv = document.querySelector(`[data-id-service="${id}"]`);

  // comprobar si un servicio esta seleccionado
  if (services.some((added) => added.id === id)) {
    // eliminarlo
    appointment.services = services.filter((added) => added.id !== id);
    serviceDiv.classList.remove("selected");
  } else {
    // agregarlo
    appointment.services = [...services, service];
    serviceDiv.classList.add("selected");
  }
}

function customerId() {
  appointment.id = document.querySelector("#id").value;
}

function customerName() {
  appointment.name = document.querySelector("#name").value;
}

function selectDate() {
  const inputDate = document.querySelector("#date");
  inputDate.addEventListener("input", function (e) {
    const day = new Date(e.target.value).getUTCDay();

    if ([0].includes(day)) {
      e.target.value = "";
      showAlert("Domingos no hay citas disponibles", "error", ".form");
    } else {
      appointment.date = e.target.value;
    }
  });
}

function selectTime() {
  const inputTime = document.querySelector("#time");
  inputTime.addEventListener("input", function (e) {
    const timeAppointment = e.target.value;
    const time = timeAppointment.split(":")[0];

    if (time < 8 || time > 20) {
      e.target.value = "";
      showAlert("Horario no disponible", "error", ".form");
    } else {
      appointment.time = e.target.value;
    }
  });
}

function showAlert(message, type, element, disappear = true) {
  // prevenir duplicar alerta
  const previousAlert = document.querySelector(".alert");
  if (previousAlert) {
    previousAlert.remove();
  }
  // crear alerta
  const alert = document.createElement("DIV");
  alert.textContent = message;
  alert.classList.add("alert");
  alert.classList.add(type);

  const reference = document.querySelector(element);
  reference.appendChild(alert);

  if (disappear) {
    // eliminar alerta
    setTimeout(() => {
      alert.remove();
    }, 2500);
  }
}

function showSummary() {
  const summary = document.querySelector(".summary-content");

  // Limpiar el contenido
  while (summary.firstChild) {
    summary.removeChild(summary.firstChild);
  }

  if (
    Object.values(appointment).includes("") ||
    appointment.services.length === 0
  ) {
    showAlert(
      "Debes elegir servicios, fecha y hora",
      "error",
      ".summary-content",
      false
    );

    return;
  }

  // formatear el Div de resumen
  const { name, date, time, services } = appointment;

  // heading resumen servicios
  const servicesHeading = document.createElement("H3");
  servicesHeading.textContent = "Resumen de los Servicios";
  summary.appendChild(servicesHeading);

  // iterando y mostrando los servicios
  services.forEach((service) => {
    const { id, name, price } = service;
    const serviceContainer = document.createElement("DIV");
    serviceContainer.classList.add("service-container");

    const serviceText = document.createElement("P");
    serviceText.textContent = name;

    const servicePrice = document.createElement("P");
    servicePrice.innerHTML = `<span>Precio:</span> $${price}`;

    serviceContainer.appendChild(serviceText);
    serviceContainer.appendChild(servicePrice);

    summary.appendChild(serviceContainer);
  });

  // heading resumen cita
  const appointmentHeading = document.createElement("H3");
  appointmentHeading.textContent = "Resumen de la Cita";
  summary.appendChild(appointmentHeading);

  const customerName = document.createElement("P");
  customerName.innerHTML = `<span>Nombre:</span> ${name}`;

  // formatear fecha
  const objectDate = new Date(date);
  const month = objectDate.getMonth();
  const day = objectDate.getDate() + 2;
  const year = objectDate.getFullYear();

  const utcDate = new Date(Date.UTC(year, month, day));

  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const formatedDate = utcDate.toLocaleDateString("es-CO", options);

  const appointmentDate = document.createElement("P");
  appointmentDate.innerHTML = `<span>Fecha:</span> ${formatedDate}`;

  const appointmentTime = document.createElement("P");
  appointmentTime.innerHTML = `<span>Hora:</span> ${time} Horas`;

  // boton para crear una cita
  const bookButton = document.createElement("BUTTON");
  bookButton.classList.add("button");
  bookButton.textContent = "Reservar Cita";
  bookButton.onclick = bookAppointment;

  summary.appendChild(customerName);
  summary.appendChild(appointmentDate);
  summary.appendChild(appointmentTime);

  summary.appendChild(bookButton);
}

async function bookAppointment() {
  const { id, date, time, services } = appointment;
  const servicesId = services.map((service) => service.id);

  const data = new FormData();
  data.append("date", date);
  data.append("time", time);
  data.append("userId", id);
  data.append("services", servicesId);

  try {
    // peticion hacia la API
    const url = "/api/appointment";
    const response = await fetch(url, {
      method: "POST",
      body: data,
    });

    const output = await response.json();
    console.log(output.output);

    if (output.output) {
      Swal.fire({
        icon: "success",
        title: "Cita Creada",
        text: "Tu cita fue creada correctamente!",
        button: "OK",
      }).then(() => {
        setTimeout(() => {
          window.location.reload();
        }, 3000);
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Error al guardar la cita!",
    });
  }
}
