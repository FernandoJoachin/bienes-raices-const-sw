<h2 class="dashboard__heading"><?php echo $titulo;?></h2>
<?php
  $mensaje = mostrarNotificacion(intval($_GET['resultado'] ?? 0));
  if ($mensaje) { ?>
    <p class="alerta exito"><?php echo limpiarHTML($mensaje); ?></p>
  <?php }; ?>
<div class="dashboard__contenedor-boton">
    <a href="/admin/usuarios/crear" class="boton boton-amarillo"><li class="fa-solid fa-circle-plus"></li> Ir a Crear usuario</a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($usuarios)){?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table_th">ID</th>
                    <th scope="col" class="table_th">Email</th>
                    <th scope="col" class="table_th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($usuarios as $usuario){?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?= $usuario->id; ?>
                        </td>
                        <td class="table__td">
                            <?= $usuario->email?>
                        </td>
                        <td class="table__td--acciones">
                            <form class="w-100" method="POST" action="/admin/usuarios/eliminar">
                                <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
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
        <p class="text-center">No hay usuarios aún</p>
    <?php }?>
</div>

<?php
 echo $paginacion;
?>