<footer>
    <script src="js/scripts.js"></script>
    <div class="footer-container">
        <div class="footer-section">
            <h3>SOBRE SCA AUTOMATIZACIONES</h3>
            <p>Empresa líder en soluciones de Desarrollo Electronico, Fabricacion de Máquina CNC y Pantógrafos Láser.</p>
        </div>
        <div class="footer-section">
            <h3>SOLUCIONES</h3>
            <p><a href="soporte.html">Soporte técnico</a></p>
            <p><a href="asistencia.html">Desarrollos IOT</a></p>
        </div>
        <div class="footer-section">
            <h3>CONTACTO</h3>
            <p>Teléfono: (+54) 113792-0557</p>
            <p>Email: scadaniel@hotmail.com</p>
        </div>
        <div class="footer-section newsletter">
            <h3>NEWSLETTER</h3>
            <p>Mantenete actualizado de nuestras novedades y ofertas especiales del mes!!!</p>
            <form id="newsletterForm" action="/newsletter/formulario.php" method="post" onsubmit="return validateEmail()">
                <input type="email" id="emailInput" name="email" placeholder="Dirección de E-Mail" required>
                <p id="errorMessage" class="error-message">El email debe contener @ y .</p>
                <button type="submit" name="suscribe" value="suscribe">Suscribirme al Newsletter</button>
            </form>
        </div>
    </div>
    <div class="social-icons">
        <a href="#"><img src="./img/facebook.svg" alt="Facebook"></a>
        <a href="#"><img src="./img/instagram.svg" alt="Instagram"></a>
        <a href="#"><img src="./img/whatsapp.svg" alt="WhatsApp"></a>
    </div>
    <div class="copyright">
        <p>© 2025 SCA Automatizaciones. Todos los derechos reservados.</p>
    </div>
</footer>

<script>
    // Validación del email
    function validateEmail() {
        const emailInput = document.getElementById('emailInput');
        const errorMessage = document.getElementById('errorMessage');
        const email = emailInput.value;

        // Verifica que el email contenga @ y .
        if (email.includes('@') && email.includes('.')) {
            errorMessage.style.display = 'none';
            return true; // Permite enviar el formulario
        } else {
            errorMessage.style.display = 'block';
            return false; // Evita enviar el formulario
        }
    }
</script>

