<fieldset>
            <legend>Información General</legend>
            <label for="titutlo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

            <?php if($propiedad->imagen) : ?>
                <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-small">
            <?php endif; ?>

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>
            <label for="habitaciones">Habitaciones:</label>
            <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

            <label for="wc">Baños:</label>
            <input type="number" name="wc" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

            <label for="parking">Parking:</label>
            <input type="number" name="parking" id="parking" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->parking); ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <!-- <select name="vendedores_id" id="vendedor">
                <option value=""> -- Seleccione -- </option>
                <?php //while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php //echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value=" <?php //echo $vendedor['id'] ?> "> <?php //echo $vendedor['nombre'] . " " . $vendedor['apellido'];  ?> </option>
                <?php //endwhile; ?>
            </select> -->
        </fieldset>