<div class="campo">
    <label for="nombre">Nombre</label>
    <input 
    onkeypress="return ' CáéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ'.includes(event.key)"
        type="text"
        id="nombre"
        placeholder="Nombre Servicio"
        name="nombre"
        value="<?php echo $servicio->nombre; ?>"
    />
</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input 
    onkeypress="return '0123456789'.includes(event.key)"
        type="number"
        id="precio"
        placeholder="Precio Servicio"
        name="precio"
        value="<?php echo $servicio->precio; ?>"
    />
</div>