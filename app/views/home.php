
<?php echo ($logged==1) ? '<a href="./" class="btntop">Logout</a>' : '<a href="./login" class="btntop">Login example</a>'; ?>
    
<div class="center">
    <?php echo ($logged==1) ? "Welcome." : "TinyFrame (".$version.") " . "<br>It is an MVC microframework<br>For small projects and REST APIs."; ?>
</div>

<style>
    .btntop{
        font-size: 13px; 
        float: right; 
        margin: 15px 20px; 
        z-index: 99;
        position: relative;
    }
    .center {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
    }
</style>