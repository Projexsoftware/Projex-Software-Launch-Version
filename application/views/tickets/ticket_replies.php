<?php if(count($ticket_replies)>0){ foreach($ticket_replies as $val){ 
                                                    $user_detail = get_sender_details($val["from_id"], $val["from_id_role"]);
                                                    
                                                    if($val["from_id"]==$this->session->userdata("user_id") && $val["from_id_role"]=="user"){
                                                        $class ="col-md-8 col-md-offset-4";
                                                    }
                                                    else{
                                                        $class="col-md-12";
                                                    }
                                                    if($val["from_id_role"]=="user"){
                                                        $image_src = SURL."assets/profile_images/";
                                                    }else{
                                                        $image_src = SURL."assets/images/profile_images/";
                                                    }
                                                    ?>
<div class="<?php echo $class;?>" style="margin-bottom:20px;">
<div class="col-md-6">
<div class="user-block clearfix"> <?php if($user_detail["image"]==""){ ?> <img src="<?php echo SURL;?>assets/img/no_image.png" alt="User Avatar"> <?php } else { ?> <img src="<?php echo $image_src.$user_detail["image"];?>" alt="User Avatar"> <?php } ?>
    <div class="detail"> <strong><?php echo $user_detail["first_name"]." ".$user_detail["last_name"];?></strong>
    </div>
  </div>
</div>
<div class="col-md-6" style="margin-top:10px;"><span class="fa fa-calendar"></span>&nbsp;<?php echo date("d-M-Y h:i a", strtotime($val["ticket_created_date"]));?> <b>(<?php echo get_time_diff($val["ticket_created_date"]);?>)</b></div>

<div class="col-md-12" style="margin-top:10px;">
    
    <?php 
    
    $ticket_reply_files = get_ticket_reply_files($val["id"]);
    
    if(count($ticket_reply_files)>0){ ?>
					    <ul class="file_img">
					   <?php foreach($ticket_reply_files as $file){ $exts = array('gif', 'png', 'jpg'); 
					   $ticket_reply_file = explode('.', $file['ticket_file']);
                       if(in_array(end($ticket_reply_file), $exts)){
					   ?>
					   <li><img class="myImg" original_img="<?php echo SURL;?>assets/tickets/<?php echo $file['ticket_file'] ;?>" src="<?php echo SURL;?>assets/tickets/thumbnail/<?php echo $file['ticket_file'] ;?>">
					   </li>
					   <?php } else{ ?>
					   <li><a target="_Blank" href="<?php echo SURL;?>assets/tickets/<?php echo $file['ticket_file'] ;?>"><?php echo $file['ticket_file'] ;?></a></li>
					   <?php } } ?>
					   </ul>
					   <br/><br/>
					   <?php } ?>
	
    <?php echo $val["ticket_body"];?></div>
</div>

<?php }
}
else{
    echo "<span class='label label-danger'>No reply added yet</span>";
}
?>