<main class="contenedor seccion contenido-centrado">
    <h1>¿Olvidaste tu contraseña?</h1>

<?php if ($mensajeResultado) { ?>
    <p class="alerta <?php echo ($enviado && $correcto) ? "exito" : "error"; ?>"> <?php echo $mensajeResultado; ?> </p>
<?php } ?>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>¡Restablécela!</legend>
            <label>Ingresa tu correo para enviarte las instrucciones<label>
                    <label for="email">E-mail</label>
                    <input id="email" type="email" name="email[email]" placeholder="Tu Email">
        </fieldset>
        <input class="boton boton-verde" type="submit" value="Enviar">
    </form>
</main>