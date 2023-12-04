<h2 class="dashboard__heading"><?php echo $titulo;?></h2>
<?php
  $mensaje = mostrarNotificacion(intval($_GET['resultado'] ?? 0));
  if ($mensaje) { ?>
    <p class="alerta exito"><?php echo limpiarHTML($mensaje); ?></p>
  <?php }; ?>
<div class="dashboard__contenedor-boton">
    <a href="/admin/vendedores/crear" class="boton boton-amarillo"><li class="fa-solid fa-circle-plus"></li> Ir a Crear Vendedores</a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($vendedores)){?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table_th">ID</th>
                    <th scope="col" class="table_th">Nombre</th>
                    <th scope="col" class="table_th">Teléfono</th>
                    <th scope="col" class="table_th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($vendedores as $vendedor){?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?= $vendedor->id; ?>
                        </td>
                        <td class="table__td">
                            <?= $vendedor->nombre . " " . $vendedor->apellido; ?>
                        </td>
                        <td>$<?= $vendedor->telefono; ?></td>
                        <td class="table__td--acciones">
                            <a class="boton-azul-block w-100" href="/admin/vendedores/actualizar?id=<?php echo $vendedor->id; ?>"> <i class="fa-solid fa-user-pen"></i> Actualizar</a>
                            <form class="w-100" method="POST" action="/admin/vendedores/eliminar">
                                <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
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
        <p class="text-center">No hay vendedores aún</p>
    <?php }?>
</div>

<?php
 echo $paginacion;
?>