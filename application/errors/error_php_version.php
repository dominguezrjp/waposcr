<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP Version Error</title>
    <link rel="stylesheet" type="text/css" href="<?= '../assets/css/404-css.css'; ?>">
</head>
<body>
     <div id="clouds">
        <div class="cloud x1"></div>
        <div class="cloud x1_5"></div>
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
    </div>
    <div class='c'>
        <div class='_404'>PHP Version Error</div>
        <hr>
        <br>
        <br>
        <div class='_1'><?php echo $heading = "PHP Version Error"; ?></div><br>
        
        <div class='_2'><?php echo "Your server php version is : <b>". phpversion(); ?></b></div><br>
        <div class='_2'><?php echo $message = "You need to use PHP Minimum <b>7.3</b> or above for Script to work! | Maximum version <b>8.1.16</b> Support"; ?></div><br>
    </div>
</body>
</html>