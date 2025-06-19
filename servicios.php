<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - SCA Automatizaciones</title>
    <link rel="stylesheet" href="css/servicios.css">
    <link rel="stylesheet" href="css/headerfooter.css">
</head>

<?php include "header.php"; ?>

<body>

    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-item" id="item1">
                <!-- <img src="./img/k6401.jpeg" alt="Pantógrafo Láser K640"> -->
                <div class="carousel-text">
                    <h3>Pantógrafo Láser CO2 de Alta Precisión</h3>
                    <p>Corte y grabado de materiales con tecnología láser avanzada.</p>
                    <button>Descubre Más</button>
                </div>
            </div>
            <div class="carousel-item" id="item2">
                <!-- <img src="./img/maquina cnc.jpg" alt="Máquina CNC"> -->
                <div class="carousel-text">
                    <h3>Máquinas CNC para Producción Industrial</h3>
                    <p>Soluciones personalizadas para fresado y corte de precisión.</p>
                    <button>Ver Detalles</button>
                </div>
            </div>
            <div class="carousel-item" id="item3">
                <!-- <img src="sistema-electronico.jpg" alt="Sistema Electrónico"> -->
                <div class="carousel-text">
                    <h3>Sistemas Electrónicos Inteligentes</h3>
                    <p>Automatización avanzada con integración IoT.</p>
                    <button>Explorar Soluciones</button>
                </div>
            </div>
            <div class="carousel-item" id="item4">
                <!-- <img src="servicio-tecnico.jpg" alt="Servicio Técnico"> -->
                <div class="carousel-text">
                    <h3>Soporte Técnico Especializado</h3>
                    <p>Mantenimiento y repuestos con garantía postventa.</p>
                    <button>Contactar Ahora</button>
                </div>
            </div>
        </div>
        <div class="carousel-nav">
            <button onclick="prevSlide()">◄</button>
            <button onclick="nextSlide()">►</button>
        </div>
    </div>


    <div class="services-container">
        <h1 class="services-title">Servicios</h1>
        <p class="services-description">
            En SCA Automatizaciones ofrecemos soluciones integrales para satisfacer las necesidades de nuestros clientes.
            Contamos con un equipo especializado que garantiza la calidad en cada servicio, respaldado por nuestra atención
            técnica postventa.
        </p>
        <ul class="services-list">
            <li>
                <img src="./img/soporte.webp" alt="Soporte Técnico">
                <div>
                    <span>Soporte Técnico:</span> Asistencia especializada para resolver cualquier inconveniente con nuestros productos.
                </div>
            </li>
            <li>
                <img src="./img/iot.jpg" alt="Desarrollos IOT">
                <div>
                    <span>Desarrollos IOT:</span> Soluciones innovadoras basadas en Internet de las Cosas para optimizar procesos.
                </div>
            </li>
            <li>
                <img src="./img/desaAMedida.webp" alt="Desarrollo a Medida">
                <div>
                    <span>Desarrollo a Medida:</span> Proyectos personalizados según las necesidades específicas de tu empresa.
                </div>
            </li>
        </ul>
    </div>
</body>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-item');
    const totalSlides = slides.length;

    function showSlide(index) {
        const carousel = document.querySelector('.carousel');
        carousel.style.transform = `translateX(-${index * 100}%)`;
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    // Rotación automática
    setInterval(nextSlide, 5000);
</script>

<?php include "footer.php"; ?>

</html>