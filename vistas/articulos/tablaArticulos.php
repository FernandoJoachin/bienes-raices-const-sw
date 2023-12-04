<h2 class="dashboard__heading"><?php echo $titulo;?></h2>
<?php
  $mensaje = mostrarNotificacion(intval($_GET['resultado'] ?? 0));
  if ($mensaje) { ?>
    <p class="alerta exito"><?php echo limpiarHTML($mensaje); ?></p>
  <?php }; ?>
<div class="dashboard__contenedor-boton">
    <a href="/admin/articulos/crear" class="boton boton-amarillo"><li class="fa-solid fa-circle-plus"></li> Ir a Crear Articulo</a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($articulos)){?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table_th">ID</th>
                    <th scope="col" class="table_th">Titulo</th>
                    <th scope="col" class="table_th">Autor</th>
                    <th scope="col" class="table_th">Imagen</th>
                    <th scope="col" class="table_th">fecha</th>
                    <th scope="col" class="table_th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($articulos as $articulo){?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?= $articulo->id; ?>
                        </td>
                        <td class="table__td">
                            <?= $articulo->titulo; ?>
                        </td>
                        <td class="table__td">
                            <?= $articulo->autor; ?>
                        </td>
                        <td class="table__td">
                            <?= $articulo->fecha; ?>
                        </td>
                        <td class="table__td">
                            <img class="img-tabla" src="/imagenes/<?= $articulo->imagen; ?>" alt="imagen" width="100" height="150">
                        </td>
                        <td class="table__td--acciones">
                            <a class="boton-azul-block w-100" href="/admin/articulos/actualizar?id=<?php echo $articulo->id; ?>"> <i class="fa-solid fa-user-pen"></i> Actualizar</a>
                            <form class="w-100" method="POST" action="/admin/articulos/eliminar">
                                <input type="hidden" name="id" value="<?php echo $articulo->id; ?>">
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
        <p class="text-center">No hay articulos aún</p>
    <?php }?>
</div>

<?php
 echo $paginacion;
?>