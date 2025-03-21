              <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Notifications</h4>
                                </div>
<div class="card-content" style="padding:0px 15px 20px 20px;">
<?php $notifications = get_notifications($this->session->userdata("user_id"));
if(count($notifications)>0){
?>            
<?php foreach($notifications as $val){ 
if($this->session->userdata("user_id")==$val['user_id']){
 $name ="You have";
}
else{
$name = $val['first_name']." ".$val['last_name']." has";
}
?>
                                    <div class="alert alert-orange alert-with-icon notification_item" data-notify="container">
                                        <i class="material-icons" data-notify="icon">notifications</i>
                                        
                                        <a target="_Blank" href="<?php echo SURL;?>notifications/view/<?php echo $val['id'];?>"><span data-notify="message"><?php echo $name.$val['notification_text'].$val['project_name'];?>.</span></a>
                                    </div>
<?php } ?>           
                                    
                                    <?php if(count($notifications)>5){ ?><center><button id="load" class="btn btn-warning btn-fill">Load More</button></center><?php } ?>
<?php } else { ?>
 <span class="label label-danger">no Notifications Found</span>
<?php } ?>
                                </div>

                            </div>
                        </div>    
              </div>