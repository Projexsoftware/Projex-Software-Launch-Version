<html>
<head>
<!-- Bootstrap core CSS     -->
    <link href="<?php echo SURL;?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo SURL;?>assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="toolbar">
<span style="font-size:20px;"><b>Project Name : </b><?php echo $project_name;?></span>
<?php 
$is_files = 0;
if(count($tasks)>0){
foreach($tasks as $val){
  
$current_role = 1;
  
$files = get_project_summary_files($val['project_id'], $val['task_id'], $current_role);
?>

                                        													
                                                        <?php if(count($files)>0){ 
$is_files = 1;
?>
<h5 style="color:#ffffff;background-color: #e91e63;font-size: 13px;
    padding: 5px 15px;border-radius: 12px;text-transform: uppercase;border-color:#e91e63;width:50%;"><?php echo $val['task_name'];?></h5>
<br/>

                                    <ul style="list-style:none;"><?php 
                                                            
                                                            foreach($files as $file){ ?><li style="padding-bottom:15px;"> 
                                                            <img src="<?php echo IMG;?>icons/file.png">&nbsp;&nbsp;<?php echo $file['file_original_name'];
                                                            if($current_role==1 || $current_role==2){ ?>
                                                            &nbsp;&nbsp;&nbsp;<a href="<?php echo SCURL;?>projects/download_file/<?php echo $file['file'];?>"><img title="Download" src="<?php echo IMG;?>icons/download.png"></a>
                                                            <?php 
                                                              if($file['uploaded_at']!=""){ 
                                                            ?>
                                            <br/>
                                            <p style="text-align:right;"><img title="Uploaded By" src="<?php echo IMG;?>icons/user.png">&nbsp;<?php echo get_user_info($file['uploaded_by']);?></p>
                                            &nbsp;&nbsp;&nbsp;<p style="text-align:right;"><img title="Uploaded At" src="<?php echo IMG;?>icons/clock.png">&nbsp;<?php echo date("d/m/Y h:i A", strtotime($file['uploaded_at']));?></p>
                                            <?php } 
                                            } ?>
                                                            </li><br/><br/><?php }
?></ul>
                                    
<?php 
}  
}
}
?>
</div>
</body>
</html>
                                                        
                                                   