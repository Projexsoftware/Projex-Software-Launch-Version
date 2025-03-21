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
<br><br>
<?php 
  
$current_role = 1;
  
$project_documents = get_project_documents($project_id, $current_role);
if(count($project_documents)>0){ 
echo "<ul class='list_container'>"; foreach($project_documents as $val){ ?>
                                                       <li> <img src="<?php echo IMG;?>icons/file.png">&nbsp;<?php echo $val['document'];?>&nbsp;&nbsp;&nbsp;&nbsp;<a title="Download" target="_blank" href="<?php echo SURL.'assets/project_plans_and_specifications/'.$val['document'];?>" target="_Blank"><img src="<?php echo IMG;?>icons/download.png"></a>
                                        </li><br><br>
                                                        <?php } echo "</ul>";} ?>
</div>
</body>
</html>
                                                        
                                                   