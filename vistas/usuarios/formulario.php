<fieldset>
  <legend>Email y Contraseña</legend>

  <label for="email">E-mail</label>
  <input id="email" type="email" name="email" placeholder="Email del usuario" value="<?php echo limpiarHTML($usuario->email); ?>">

  <label for="password">Contraseña</label>
  <input id="password" type="password" name="password" placeholder="Contraseña del usuario">

  <label for="password">Confirmar Contraseña</label>
  <input id="c-password" type="password" name="c-password" placeholder="Confirmar Contraseña">
</fieldset>