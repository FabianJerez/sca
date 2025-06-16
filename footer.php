<?php
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/config.php';
}
?>

<footer>
    <div class="footer-section">
        <h3>SOBRE SCA SOFTWARE</h3>
        <p>Empresa líder en soluciones de Desarrollo Electrónico, Fabricación de Máquina CNC y Pantógrafos Láser.</p>
    </div>
    <div class="footer-section">
        <h3>SOLUCIONES</h3>
        <p><a href="<?= BASE_URL ?>soporte.php">Soporte técnico</a></p>
    </div>
    <div class="footer-section">
        <h3>CONTACTO</h3>
        <p>Teléfono: (+54) 113792-0557</p>
        <p>Email: scadaniel@hotmail.com</p>
    </div>
    <div class="footer-section newsletter">
        <h3>NEWSLETTER</h3>
        <p>Mantenete actualizado de nuestras novedades y ofertas especiales del mes!!!</p>
        <input type="email" placeholder="Dirección de E-Mail">
        <button>Suscribirme</button>
    </div>
</footer>

<div class="social-icons">
    <a href="#"><img src="<?= BASE_URL ?>img/facebook.svg" alt="Facebook"></a>
    <a href="#"><img src="<?= BASE_URL ?>img/instagram.svg" alt="Instagram"></a>
    <a href="#"><img src="<?= BASE_URL ?>img/whatsapp.svg" alt="WhatsApp"></a>
</div>
