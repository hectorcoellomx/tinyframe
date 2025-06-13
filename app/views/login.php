<div>
    <div class="login">
        <span style="font-size: 17px;display: block;margin-bottom: 8px;">Login Example</span>
        <form action="login" method="post" enctype="multipart/form-data">
            <input type="text" id="email" name="email" placeholder="Email"><br>
            <input type="password" id="password" name="password" placeholder="Password"><br>
            <?php
                
                $errors = get_errors();

                if($errors){
                    echo "<ul class='errors'>";
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

<style>
    .login{
        position: absolute;
        width: 400px;
        left: 50%;
        top: 20%;
        margin-left: -200px;
        text-align: center;
        background-color: white;
        padding: 48px 20px 50px;
        border-radius: 4px;
        font-size: 16px;
    }

    .login input[type=text],
    .login input[type=password]{
        border: 1px solid #e6e6e6;
        padding: 7px 12px;
        border-radius: 3px;
        background: #f0eeee;
        width: 200px;
        margin-top: 8px;
        margin-bottom: 15px;
    }

    .login input[type=submit]{
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 10px;
    }

    .errors{
        list-style: none;
        padding: 0;
        margin: 0;
        color: red;
    }

    .errors li{
        margin: 0;
        padding: 0;
    }

</style>