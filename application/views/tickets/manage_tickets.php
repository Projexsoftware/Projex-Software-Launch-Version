<style>
    .btn-group-sm .btn-fab{
  position: fixed !important;
  right: 29px;
}
.btn-group .btn-fab{
  position: fixed !important;
  right: 30px;
}
.btn-default{
      background-color: #ddd!important;
}
#main{
  bottom: 20px;
}
#draft{
  bottom: 80px
}
#mail{
  bottom: 125px
}
#sms{
  bottom: 175px
}
#autre{
  bottom: 220px
}
.btn.btn-fab i.material-icons, .input-group-btn .btn.btn-fab i.material-icons {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-12px,-12px);
    -ms-transform: translate(-12px,-12px);
    -o-transform: translate(-12px,-12px);
    transform: translate(-12px,-12px);
    line-height: 24px;
    width: 24px;
    color:#000!important;
}
.btn.btn-fab, .input-group-btn .btn.btn-fab {
    border-radius: 50%;
    font-size: 24px;
    height: 56px;
    margin: auto;
    min-width: 56px;
    width: 56px;
    padding: 0;
    overflow: hidden;
    -webkit-box-shadow: 0 1px 1.5px 0 rgba(0,0,0,.12), 0 1px 1px 0 rgba(0,0,0,.24);
    box-shadow: 0 1px 1.5px 0 rgba(0,0,0,.12), 0 1px 1px 0 rgba(0,0,0,.24);
    position: relative;
    line-height: normal;
}
    .edit-input {
       display:none;
       width:200px;
    }
    .edit{
        cursor:pointer;
    }
    .project_container_for_invoice{
        border:2px solid #ddd;
        padding:25px;
    }
     .form-group{
    margin-top: 20px;
  }
  .label-info{
      background-color:#5cb85c;
  }
  
  #componentCostModal .modal-content{
    background-color: #2B333C;
    color: #fff;
    border: 1px solid #fb6752;
  }
  #componentCostModal .modal-footer{
      border-top:0;
  }
  .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{
      background-color: #fc8675!important;
    color: #fff;
    border: 1px solid #fc8675!important;
  }
</style>
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">help</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Manage Tickets</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(99, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>tickets/add_ticket" class="btn btn-info"><i class="material-icons">add</i> Add Ticket</a><br><br>
                                        <?php } ?>
                                        <?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
									</div>
									 <div id="loading-overlay">
                                       <div class="loading-icon"></div>
                                    </div>
                                    	<?php
                                    	    
                            				$read_tickets = 0;
                            				$unread_tickets = 0;
                            				
					                        if(count($tickets)>0){
					                            
                            					$last_reply = get_last_reply($tickets[0]['id']);
                            					
                            					foreach($tickets as $val) {
                            					    if($val["is_read"]==0 && $last_reply["from_id_role"]!="user"){
                            					       $unread_tickets++; 
                            					    }
                            					    else{
                            					        $read_tickets++;
                            					    }
                            					}
					                        }
					                 ?>
                                     <div class="material-datatables">
                                         <p>Total Tickets : <span class="label label-info"><?php echo count($tickets);?></span>&nbsp;&nbsp;&nbsp;&nbsp;Read Tickets : <span class="label label-success"><?php echo $read_tickets;?></span>&nbsp;&nbsp;&nbsp;&nbsp;Unread Tickets : <span class="label label-danger"><?php echo $unread_tickets;?></span></p>
					
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                									<th>Ticket #</th>
                									<th>Title</th>
                                                    <th>Priority</th>
                									<th>Category</th>
                                                    <th>Created Date</th>
                                                    <th>Last Reply</th>
									                <th>Status</th>
                                                    <th class="disabled-sorting text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    						<?php 
                    						    $i=1;
                                                foreach($tickets As $key=>$val) { 
                                                    $class = "";
                                                    if($val["is_read"]==0 && $last_reply["from_id_role"]!="user"){
                                                        $class="class='unread'";
                                                    }
                                                ?>
                                                <tr class="row_<?php echo $val['id'];?> <?php echo $class;?>">
                                                    <td><?php echo $i;?></td>
                                                    <td>#<?php echo $val["id"];?></td>
                									<td><?php echo $val["ticket_title"];?></td>
                                                    <td><?php echo $val["ticket_priority"];?></td>
                                                    <td><?php echo $val["ticket_category"];?></td>
                                                    <td><?php echo date('d/m/Y',strtotime($val['ticket_created_date'])); ?></td>
                                                    <td><?php if($val["ticket_updated_date"]!=""){echo date("d/m/Y h:i a", strtotime($val["ticket_updated_date"]));}?></td>
                									<td>
                    									<?php if($val["ticket_status"] == "New"){?><span class="label label-info">New</span><?php } 
                    									else if($val["ticket_status"] == "In Progress"){?><span class="label label-warning">In Progress</span><?php }
                    									else {?>
                    									<span class="label label-success">Closed</span>
                    									<?php } ?>
                									</td>
                                                    <td class="text-right">
                                                        <a href="<?php echo SURL;?>tickets/view/<?php echo $val["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">pageview</i></a>
                                                    </td>
                                                </tr>
                                                <?php 
												$i++;
												} ?>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
    
                                             </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->
