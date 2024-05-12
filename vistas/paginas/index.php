<main class="contenedor seccion">
  <h1>Más Sobre Nosotros</h1>
  <?php include_once "iconos.php"; ?>
</main>

<section class="seccion contenedor">
  <h1>Casas y Departamentos en Venta</h1>

  <?php
  include_once "listadoPropiedades.php";
  ?>

  <div class="ver-todas alinear-derecha">
    <a class="boton-verde" href="/propiedades">Ver todas</a>
  </div>
</section>

<section class="img-contacto">
  <h2>Encuentra la casa de tus sueños</h2>
  <p>Llena el formulario de contacto y un asesor se pondrá en contacto contigo a la brevedad</p>
  <a class="boton-amarillo" href="contacto">Contáctanos</a>
</section>

<div class="contenedor seccion seccion-inferior">
  <section class="blog">
    <h3>Nuestro blog</h3>
    <?php
    include_once "listadoArticulos.php";
    ?>
  </section>

  <section class="testimoniales">
    <h3>Testimoniales</h3>
    <div class="testimonial">
      <blockquote>
        El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cumple con todas mis expectativas.
      </blockquote>
      <p>- Fernando Joachín Prieto</p>
    </div>
  </section>
</div>