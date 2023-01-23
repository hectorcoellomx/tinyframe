<div>
    <div class="login">
        <h3>Login | <?php echo $app; ?></h3>
        <form action="login" method="post" enctype="multipart/form-data">
            <label for="email">Correo electrónico:</label><br>
            <input type="text" id="email" name="email"><br>
            <!--label for="file">Seleccionar archivo:</label><br>
            <input type="file" name="photo" id="file"><br><br-->
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password"><br>
            <?php
                
                $errors = get_errors();

                if($errors){
                    echo "<ul>";
                    foreach($errors as $error){
                        echo "<li><small>" . $error . ".</small></li>";
                    }
                    echo "</ul>";
                }
                
            ?>
            <input type="submit" value="Iniciar sesión">
        </form>
    </div>
</div>