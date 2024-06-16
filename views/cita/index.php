<h1 class="nombre-pagina">Crear Nueva Cita</h1>


<p class="descripcion-pagina">Hola <?php echo $nombre ?? "" ?>, Por favor Elige tus servicios y coloca tus datos</p>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button class="" type="button" data-paso="2">Información Cita</button>
        <button class="" type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2 class="">Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
    <h2 class="">Tus Datos y Cita</h2>
    <p class="text-center">Coloca tus datos y fecha de tu cita</p>
    <form action="" class="formulario">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input id="nombre" type="text" placeholder="Tu Nombre" value="<?php echo $nombre ?>" disabled></input>
        </div>
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input id="fecha" type="date" min="<?php echo date('Y-m-d', strtotime('+1 day') );?>"></input>
        </div>
        <div class="campo">
            <label for="hora">Hora</label>
            <input id="hora" type="time"></input>
        </div>
        <input type="hidden" id="id" value="<?php echo $id; ?>">
    </form>
        
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
    <h2 class="">Resumen</h2>
    <p class="text-center">Verifica que la información sea correcta</p>
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
   <div class="barra"> <a href="/logout" class="boton-cs">Cerrar Sesión</a></div>
       
        
  
</div>




<?php  $script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>
"; ?>