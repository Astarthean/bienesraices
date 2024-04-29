<?php 
require 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Contacto</h1>
    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen contacto">
    </picture>
</main>

<h2>Rellena el formulario de Contacto</h2>

<form class="formulario" action="">
    <fieldset>
        <legend>Información Personal</legend>

        <label for="nombre">Nombre</label>
        <input type="text" placeholder="Tu Nombre" id="nombre">

        <label for="email">Email</label>
        <input type="email" placeholder="Tu Email" id="email">

        <label for="telefono">Teléfono</label>
        <input type="tel" placeholder="Tu Teléfono" id="telefono">

        <label for="mensaje">Mensaje</label>
        <textarea id="mensaje" name="mensaje"></textarea>
    </fieldset>

    <fieldset>
        <legend>Información sobre Propiedad</legend>

        <label for="opciones">Vende o Compra</label>
        <select id="opciones">
            <option value="" disabled selected>-- Seleccione --</option>
            <option value="compra">Compra</option>
            <option value="vende">Vende</option>
        </select>

        <label for="presupuesto">Cantidad</label>
        <input type="number" placeholder="Tu Precio o presupuesto" id="presupuesto">
    </fieldset>

    <fieldset>
        <legend>Contacto</legend>
        <p>Como desea ser contactado</p>
        <div class="forma-contacto">
            <label for="contactar-telefono">Teléfono</label>
            <input name="contacto" type="radio" value="telefono" id="contactar-telefono">

            <label for="contactar-email">Email</label>
            <input name="contacto" type="radio" value="email" id="contactar-email">
        </div>

        <p>Si eligió teléfono, elija fecha y hora para ser contactado</p>
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha">

        <label for="hora">Hora</label>
        <input type="time" id="hora" min="09:00" max="18:00">
    </fieldset>

    <input type="submit" value="Enviar" class="boton-verde">
</form>

<?php
incluirTemplate('footer');
?>