<div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">info</i>
                                </div>
                        <div class="card-content">
                        <div class="panel-group" id="Ticket" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingClient">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#Ticket" href="#TicketDescription" aria-controls="ClientDescription" aria-expanded="true">
                                                    <br>
                                                    <h4 class="panel-title text-red">
                                                        Ticket Info	
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="TicketDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingClient">
                                                <div class="panel-body project_team_container">
                                                    <i class="fa fa-calendar"></i> <?php echo ' '.date('d/m/Y',strtotime($ticket_detail['ticket_created_date'])); ?>
                                                    <div class="pull-right" style="margin-bottom:20px">
                                                        
                                                        <?php if($ticket_detail['ticket_status']=="New"){ ?>
                                                        <span class="label label-success"><?php echo $ticket_detail['ticket_status'];?></span>
                                                        <?php } else{ ?>
                                                        <span class="label label-danger"><?php echo $ticket_detail['ticket_status'];?></span>
                                                        <?php } ?>
                                                    </div>
                                                       <div class="table-responsive">
                                                          <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Ticket Title</h4>
                                                        <?php echo $ticket_detail['ticket_title'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Ticket Priority</h4>
                                                        <span class="label label-info"><?php echo $ticket_detail["ticket_priority"];?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <ul class="file_img">
                                    					    <?php foreach($ticket_files as $file){ 
                                    					   $exts = array('gif', 'png', 'jpg'); 
                                    					   $file_extension = explode('.', $file['ticket_file']);
                                                           if(in_array(end($file_extension), $exts)){
                                    					   ?>
                                    					   <li><img class="myImg" original_img="<?php echo SURL;?>assets/tickets/<?php echo $file["ticket_file"] ;?>" src="<?php echo SURL;?>assets/tickets/thumbnail/<?php echo $file["ticket_file"] ;?>">
                                    					   </li>
                                    					   <?php } else{ ?>
                                    					   <li><a target="_Blank" href="<?php echo SURL;?>assets/tickets/<?php echo $file["ticket_file"] ;?>"><?php echo $file["ticket_file"] ;?></a></li>
                                    					   <?php } } ?>
                                    					  </ul>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div id="myModal" class="modal">

                                                          <!-- The Close Button -->
                                                          <span class="close">&times;</span>
                                                        
                                                          <!-- Modal Content (The Image) -->
                                                          <img class="modal-content" id="img01">
                                                        
                                                          <!-- Modal Caption (Image Text) -->
                                                          <div id="caption"></div>
                                                        </div>
                                                        					   
                                                        					    
                                                        					    
                                                        						<?php echo $ticket_detail["ticket_body"];?>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
                            <!--  end card  -->
                        </div>
                        
                        <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">info</i>
                            </div>
                        <div class="card-content">
                        <div class="panel-group" id="address" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingAddress">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#address" href="#addressDescription" aria-controls="addressDescription" aria-expanded="true">
                                                    <br>
                                                    <h4 class="panel-title">
                                                        Ticket Details
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="addressDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingAddress">
                                                <div class="panel-body">
                                                 	
                                                       <div class="table-responsive">
                                                            <table class="table">
					        <tr>
					             <td align="center"><b>Ticket # : </b></td>
					            <td><?php echo $ticket_detail["id"];?></td>
					        </tr>
					        <tr>
					            <td align="center"><b>Client : </b></td>
					            <td><?php echo $this->session->userdata("first_name")." ".$this->session->userdata("last_name");?></td>
					        </tr>
					        <tr>
					            <td align="center"><b>Email : </b></td>
					            <td><?php echo $this->session->userdata("email");?></td>
					        </tr>
					        <tr>
					            <td align="center"><b>Category : </b></td>
					            <td><?php echo $ticket_detail["ticket_category"];?></td>
					        </tr>
					        <tr>
					            <td align="center"><b>Status : </b></td>
					            <td>
					                <?php if($ticket_detail["ticket_status"] == "New"){?><span class="label label-info">New</span><?php } 
									else if($ticket_detail["ticket_status"] == "In Progress"){?><span class="label label-warning">In Progress</span><?php }
									else {?>
									<span class="label label-success">Closed</span>
									<?php } ?>
					            </td>
					       </tr>
					        <tr>
					            <td align="center"><b>Created : </b></td>
					            <td><?php echo date("d-M-Y", strtotime($ticket_detail["ticket_created_date"]));?><br/><?php echo date("h:i a", strtotime($ticket_detail["ticket_created_date"]));?></td>
					        </tr>
					        <tr>
					            <td align="center"><b>Last Updated : </b></td>
					            <td><?php if($ticket_detail["ticket_updated_date"]!=""){ echo date("d-M-Y", strtotime($ticket_detail["ticket_updated_date"]));?><br/><?php echo date("h:i a", strtotime($ticket_detail["ticket_updated_date"]));}?></td>
					        </tr>
					    </table>
                                                        </div>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
					
						</div>
						
						<div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">reply</i>
                                </div>
                        <div class="card-content">
                        <div class="panel-group" id="Replies" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingReplies">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#Replies" href="#TicketReplies" aria-controls="ClientDescription" aria-expanded="true">
                                                    <br>
                                                    <h4 class="panel-title text-red">
                                                        Ticket Replies	
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="TicketReplies" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingReplies">
                                                <div class="panel-body replies_container">
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
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
                            <!--  end card  -->
                        </div>
                        
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">reply</i>
                                </div>
                        <div class="card-content">
                        <div class="panel-group" id="ReplyToTicket" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div id="loading-overlay">
                                                <div class="loading-icon"></div>
                                            </div>
                                            <div class="panel-heading" role="tab" id="headingReply">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#ReplyToTicket" href="#TicketReply" aria-controls="TicketReply" aria-expanded="true">
                                                    <br>
                                                    <h4 class="panel-title text-red">
                                                        Reply To Ticket
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="TicketReply" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingReply">
                                                <div class="panel-body">
                                                    <form id="myAwesomeDropzone" class="form-horizontal form-border dropzone" style="margin:0px 25px;" action="<?php echo SURL;?>tickets/upload_ticket_file/reply" method="post" enctype="multipart/form-data">
						 
                                                        <div class="dropzone-previews"></div>
                            							
                                                    
                            						</form>
                            						<form id="reply_form" action="" method="post" enctype="multipart/form-data">
                            			            <input type="hidden" name="ticket_files[]" id="ticket_files" value="">
                            			            <input type="hidden" name="ticket_parent" id="ticket_parent" value="<?php echo $ticket_detail['id'];?>">
                            			             <input type="hidden" name="ticket_title" id="ticket_title" value="<?php echo $ticket_detail['ticket_title'];?>">
                            			              <input type="hidden" name="ticket_priority" id="ticket_priority" value="<?php echo $ticket_detail['ticket_priority'];?>">
                            			               <input type="hidden" name="ticket_category" id="ticket_category" value="<?php echo $ticket_detail['ticket_category'];?>">
                            				          
                            							<textarea class="form-control ckeditor" rows="5" name="ticket_body" id="ticket_body" required="true"></textarea>
                                                      
                        
                           	<?php
                                    if(in_array(104, $this->session->userdata("permissions"))) {
                                    ?>
                        	<div class="form-group">
									<button style="width:100%;" class="btn btn-success reply_to_ticket" type="submit" name="reply_to_ticket">Reply</button>
							</div>
							<?php } ?>
						</form>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
                            <!--  end card  -->
                        </div>
</div>