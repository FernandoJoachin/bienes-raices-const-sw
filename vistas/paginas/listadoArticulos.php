<?php foreach($articulos as $articulo){?>
    <article class="entrada-blog">
    <div class="img">
      <picture>
        <img loading="lazy" src="/imagenes/<?php echo $articulo->imagen; ?>" alt="<?php echo $articulo->titulo; ?>">
      </picture>
    </div>
    <div class="texto-entrada">">
      <a href="/entrada?id=<?php echo $articulo->id; ?>">
        <h4><?php echo $articulo->titulo; ?></h4>
        <p class="informacion-meta">
          Escrito el:
          <span><?php echo $articulo->fecha; ?></span>
          por:
          <span><?php echo $articulo->autor; ?></span>
        </p>
        <p><?php echo $articulo->descripcion; ?>.</p>
      </a>
    </div>
  </article>
<?php }?>