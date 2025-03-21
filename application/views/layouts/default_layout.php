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
	<script>
      var base_url = "<?php echo SURL ?>";
    </script> 
</head>

<body>
    <div class="wrapper">
        <?php echo $sidebar;?>
		<div class="main-panel">
            <?php echo $header;?>
            <div class="content">
                <div class="container-fluid">
                    <?php echo $content;?>
                </div>
            </div>
            <?php echo $footer;?>
        </div>
    </div>
</body>
<?php echo $footer_script;?>
</html>