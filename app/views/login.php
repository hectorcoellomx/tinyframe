<div>
    <div class="login">
        <span style="font-size: 17px;display: block;margin-bottom: 8px;">Login Example</span>
        <form action="login" method="post" enctype="multipart/form-data">
            <input type="text" id="email" name="email" placeholder="Email"><br>
            <input type="password" id="password" name="password" placeholder="Password"><br>
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
            <input type="submit" value="Login">
        </form>
    </div>
</div>