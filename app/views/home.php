
<?php if($logged==1) { ?>
    <a href="./" class="btntop">Logout</a>
<?php } else {?>
    <a href="./login" class="btntop">Login example</a>
<?php } ?>

<div class="center">
    <?php echo ($logged==1) ? "Welcome." : $app . " " . $message; ?>
</div>