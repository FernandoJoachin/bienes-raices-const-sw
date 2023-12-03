<h2 class="dashboard__heading"><?php echo $titulo;?></h2>
<?php
  $mensaje = mostrarNotificacion(intval($_GET['resultado'] ?? 0));
  if ($mensaje) { ?>
    <p class="alerta exito"><?php echo limpiarHTML($mensaje); ?></p>
  <?php }; ?>
<div class="dashboard__contenedor-boton">
    <a href="/admin/propiedades/crear" class="boton boton-amarillo"><li class="fa-solid fa-circle-plus"></li> Ir a Crear Propiedad</a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($propiedades)){?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table_th">ID</th>
                    <th scope="col" class="table_th">Titulo</th>
                    <th scope="col" class="table_th">Imagen</th>
                    <th scope="col" class="table_th">Precio</th>
                    <th scope="col" class="table_th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($propiedades as $propiedad){?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?= $propiedad->id; ?>
                        </td>
                        <td class="table__td">
                            <?= $propiedad->titulo; ?>
                        </td>
                        <td class="table__td">
                            <img class="img-tabla" src="/imagenes/<?= $propiedad->imagen; ?>" alt="imagen" width="100" height="150">
                        </td>
                        <td>$<?= $propiedad->precio; ?></td>
                        <td class="table__td--acciones">
                            <a class="boton-azul-block w-100" href="/admin/propiedades/actualizar?id=<?php echo $propiedad->id; ?>"> <i class="fa-solid fa-user-pen"></i> Actualizar</a>
                            <form class="w-100" method="POST" action="/admin/propiedades/eliminar">
                                <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                                <button class="boton-rojo-block w-100" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php }?>    
            </tbody>
        </table>
    <?php } else{?>
        <p class="text-center">No hay propiedades aún</p>
    <?php }?>
</div>

<?php
 echo $paginacion;
?>