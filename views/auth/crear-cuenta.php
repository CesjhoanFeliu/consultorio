<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>



<form method="POST" action="/crear-cuenta" class="formulario">
    <div class="campo">
        <label for="nombre" class="">Nombre</label>
        <input onkeypress="return ' CáéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ'.includes(event.key)" type="text" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?php echo s($usuario->nombre); ?>" class="">
  
</div>
<div class="campo">
        <label for="apellido" class="">Apellido</label>
        <input onkeypress="return ' áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ'.includes(event.key)" type="text" id="apellido" name="apellido" placeholder="Tu Apellido" value="<?php echo s($usuario->apellido); ?>" class="">
</div>
<div class="campo">
        <label for="telefono" class="">Teléfono</label>
        <input onkeypress="return '0123456789'.includes(event.key)" type="tel" id="telefono" name="telefono" placeholder="Tu Teléfono" value="<?php echo s($usuario->telefono); ?>" class="">
</div>
<div class="campo">
        <label for="email" class="">E-mail</label>
        <input type="email" id="telefono" name="email" placeholder="Tu E-mail" value="<?php echo s($usuario->email); ?>" class="">
</div>
<div class="campo">
        <label for="password" class="">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu Contraseña" class="">
</div>
<input type="submit" value="Crear Cuenta" class="boton" >
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>