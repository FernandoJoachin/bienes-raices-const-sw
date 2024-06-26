<div class="contenedor-propiedades">
  <?php foreach ($propiedades as $propiedad) { ?>
    <div class="propiedad">
      <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="<?php echo $propiedad->titulo; ?>">
      <div class="contenido-propiedad">
        <h3><?php echo $propiedad->titulo; ?></h3>
        <p class="precio">$<?php echo $propiedad->precio; ?></p>
        <ul class="iconos-caracteristicas">
          <li>
            <img class="icono" loading="lazy" src="/build/img/icono_wc.svg" alt="icono wc">
            <p><?php echo $propiedad->wc; ?></p>
          </li>
          <li>
            <img class="icono" loading="lazy" src="/build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
            <p><?php echo $propiedad->estacionamiento; ?></p>
          </li>
          <li>
            <img class="icono" loading="lazy" src="/build/img/icono_dormitorio.svg" alt="icono dormitorio">
            <p><?php echo $propiedad->habitaciones; ?></p>
          </li>
        </ul>
        <a href="/propiedad?id=<?php echo $propiedad->id; ?>" class="boton boton-amarillo-block">Ver propiedad</a>
      </div>
    </div>
  <?php }; ?>
</div>