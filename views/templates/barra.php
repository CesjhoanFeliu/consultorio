<div class="barra">
  <p class="">
    Hola
    <?php echo $nombre ?? "" ?>
  </p>
  <a href="/logout" class="boton">Cerrar Sesión</a>
</div>

<?php

if(isset($_SESSION["admin"])){   ?>
<div class="barra-servicios">
  <a class="boton" href="/admin">Ver Citas</a>
  <a class="boton" href="/servicios">Ver Servicios</a>
  <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
  <a class="boton" href="/servicios/reportes">Reportes</a>
</div>

<?php }
    
    
?>
