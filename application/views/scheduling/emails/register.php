<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Registration mail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<div>
    <p>
        Hello <?php echo $userName;?>,
    </p>
    <p>
    Thank you for the registration at 6ixTaxi.
</p>
<p>
    Please click on the link to activate your account <a href="<?php echo $link; ?>"><?php echo $link; ?></a>.
</p>
<p>Regards,</p>
6ixTaxi Team
</div>
</body>
</html>