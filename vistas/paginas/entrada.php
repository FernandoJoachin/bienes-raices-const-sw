<main class="contenedor seccion contenido-centrado">
  <h1><?php echo $articulo->titulo; ?></h1>
  <picture>
    <img loading="lazy" src="/imagenes/<?php echo $articulo->imagen; ?>" alt="<?php echo $articulo->titulo; ?>">
  </picture>
  <div class="resumen-blog">
    <p class="informacion-meta">
      Escrito el:
      <span><?php echo $articulo->fecha; ?></span>
      por:
      <span><?php echo $articulo->autor; ?></span>
    </p>
    <p><?php echo $articulo->contenido; ?></p>
  </div>
</main>