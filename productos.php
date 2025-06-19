<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCA Automatizaciones - Productos</title>
    <link rel="stylesheet" href="css/headerfooter.css">
    <link rel="stylesheet" href="css/productos.css">
</head>

<?php include 'header.php' ?>

<body>
    <section class="products">
        <h2 class="products-title">Nuestros Productos</h2>
        <p class="products-description">
            Descubre nuestra selección de productos de alta calidad diseñados para optimizar tus procesos industriales.
            ¡Tecnología avanzada al servicio de tu creatividad y productividad!
        </p>
        <div class="product-list">
            <div class="product-item">
                <img src="img/k640.jpeg" alt="Pantógrafo Láser CO2">
                <div>
                    <h3>Pantógrafo Láser CO2</h3>
                    <p>Equipo de alta precisión para corte y grabado. Ideal para diversos materiales.</p>
                    <button onclick="showDetails('co2')">Saber Más</button>
                </div>
            </div>
            <div class="product-item">
                <img src="img/k6402 (1).jpeg" alt="Pantógrafo Láser Diodo">
                <div>
                    <h3>Pantógrafo Láser Diodo</h3>
                    <p>Tecnología avanzada para grabado detallado con eficiencia energética.</p>
                    <button onclick="showDetails('diode')">Saber Más</button>
                </div>
            </div>
            <div class="product-item">
                <img src="img/k440.jpeg" alt="Máquina CNC">
                <div>
                    <h3>Máquina CNC</h3>
                    <p>Fabricación personalizada con control numérico computarizado.</p>
                    <button onclick="showDetails('cnc')">Saber Más</button>
                </div>
            </div>
        </div>
    </section>

    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDetails()">×</span>
            <h3 id="modalTitle"></h3>
            <p id="modalDescription"></p>
            <p><strong>Stock Disponible:</strong> <span id="modalStock"></span></p>
            <p><strong>Postventa:</strong> Garantía y soporte técnico incluido.</p>
        </div>
    </div>

    <?php include 'footer.php' ?>

    <script>
        function showDetails(product) {
            const modal = document.getElementById('detailsModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalDescription = document.getElementById('modalDescription');
            const modalStock = document.getElementById('modalStock');

            let title, description, stock;
            switch (product) {
                case 'co2':
                    title = 'Pantógrafo Láser CO2';
                    description = 'Equipo de corte y grabado con tecnología CO2, perfecto para industrias textiles y metálicas.';
                    stock = '15 unidades';
                    break;
                case 'diode':
                    title = 'Pantógrafo Láser Diodo';
                    description = 'Ideal para grabados finos con bajo consumo energético.';
                    stock = '20 unidades';
                    break;
                case 'cnc':
                    title = 'Máquina CNC';
                    description = 'Máquina versátil para fabricación personalizada con alta precisión.';
                    stock = '10 unidades';
                    break;
            }

            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalStock.textContent = stock;
            modal.style.display = 'block';
        }

        function closeDetails() {
            document.getElementById('detailsModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('detailsModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>