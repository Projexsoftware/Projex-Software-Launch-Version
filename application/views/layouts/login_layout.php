<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo IMG;?>apple-icon.png" />
    <link rel="icon" type="image/png" href="<?php echo IMG;?>favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo DEFAULT_TITLE;?> - <?php echo $title;?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <?php echo $header_script;?>
    <style>
        .navbar .navbar-brand{
            color:#fff!important;
            position: relative;
            height: 50px;
            font-weight:300;
            line-height: 30px;
            padding: .625rem 0;
        }
        .navbar-nav {
            float:right;
            margin-top:15px;
        }
        .navbar-nav li a{
            color:#fff!important;
        }
        .navbar.navbar-transparent {
            background-color: transparent !important;
            box-shadow: none;
            padding-top: 25px!important;
            color: #fff;
        }
        .navbar .navbar-nav .nav-item .nav-link {
    position: relative;
    color: inherit;
    padding: .9375rem;
    font-weight: 400;
    font-size: 12px;
    text-transform: uppercase;
    border-radius: 3px;
    line-height: 20px;
}
    </style>
	<script>
      var base_url = "<?php echo SURL ?>";
    </script> 
</head>

<body class="off-canvas-sidebar">
    <?php echo $content;?>
</body>
<?php echo $login_footer_script;?>
</html>