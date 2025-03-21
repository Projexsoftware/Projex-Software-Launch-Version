<html>
<head>
<!-- Bootstrap core CSS     -->
    <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo SURL;?>assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="toolbar">
<span style="font-size:20px;"><b>Project Name : </b><?php echo $project_name;?></span>
<?php 
$is_images = 0;
if(count($tasks)>0){
foreach($tasks as $val){
  
$current_role = 1;
  
$images = get_project_summary_images($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($images)>0){ 
?>
<h5 style="color:#ffffff;background-color: #e91e63;font-size: 13px;
    padding: 5px 15px;border-radius: 12px;text-transform: uppercase;border-color:#e91e63;width:50%;"><?php echo $val['task_name'];?></h5>
<div class="row">                                                       
                                                            <?php 
                                                            
                                                            foreach($images as $image){ ?>

                                            <div style="width:200px">
                                            <img style="margin-left:15px;display:inline;margin-bottom:25px;margin-top:15px;" width="200px" height="200px" class="img" src="<?php echo TASK_PATH.'images/'.$image['file'];?>">
                                            <?php 
                                            if($current_role==1 || $current_role==2){
                                            if($image['uploaded_at']!=""){ 
                                            ?>
                                            <p style="text-align:center"><a href="<?php echo SCURL;?>projects/download_image/<?php echo $image['file'];?>"><img src="<?php echo IMG;?>icons/download.png"></a></p>
                                            <h4 style="margin-left:15px;"><?php echo $image["description"];?></h4>
                                            <p style="margin-left:15px;"><img title="Uploaded By" src="<?php echo IMG;?>icons/user.png">&nbsp;<?php echo get_user_info($image['uploaded_by']);?></p>
                                            <p style="margin-left:15px;"><img title="Uploaded By" src="<?php echo IMG;?>icons/clock.png">&nbsp;<?php echo date("d/m/Y h:i A", strtotime($image['uploaded_at']));?></p>
                                            <?php } 
                                            } ?>
                                            </div>
                                                            <?php }
?>
</div>
<?php 
}  
}
}
?>
</div>
</div>
</div>
</div>                                                      </div>
                                                        
</body>
</html>                                           