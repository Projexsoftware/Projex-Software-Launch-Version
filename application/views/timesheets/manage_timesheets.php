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
                                    <i class="material-icons">schedule</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Manage Timesheets</h4> 
                                    <div class="toolbar">
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
                                    <div class="material-datatables">
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li>
                                              <a href="#draft_timesheet" data-toggle="tab">
                                                <i class="fa fa-edit"></i> Draft (<?php echo count($draft_timesheets);?>)
                                              </a>
                                           </li>
                                           <li class = "active">
                                              <a href = "#pending_timesheet" data-toggle = "tab">
                                                <i class="fa fa-clock-o"></i> Pending (<?php echo count($pending_timesheets);?>)
                                              </a>
                                           </li>
                                           <li><a href = "#approved_timesheet" data-toggle = "tab"><i class="fa fa-thumbs-up"></i> Approved (<?php echo count($approved_timesheets);?>)</a>
                                           </li>
                                           <li><a href = "#invoiced_timesheet" data-toggle = "tab"><i class="fa fa-usd"></i> Invoiced (<?php echo count($invoiced_timesheets);?>)</a>
                                           </li>
                                        </ul>
                        			<div id = "myTabContent" class = "tab-content">
    <div class = "tab-pane fade" id = "draft_timesheet">
               <?php if(in_array(107, $this->session->userdata("permissions"))) { ?>
               <br/>
               <a href="<?php echo SURL;?>timesheets/add_timesheet" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add New Timesheet</a>
               <?php } ?>
               <br/><br/><br/>
                <table class="table table-striped dataTable" id="draft_dataTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Staff Name</th>
                            <th>Status</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                        if(count($draft_timesheets)>0){
                        foreach ($draft_timesheets as $key => $val) {
                        ?>
                            <tr>
                                
                                <td><?php echo date("d-M-Y", strtotime($val['created_at'])); ?></td>
                                <td><?php echo $val['user_fname']." ".$val['user_lname']; ?></td>
                                <td><?php if($val['status']=="Pending"){ echo "<span class='label label-danger'>".$val['status']."</span>";} else{ echo "<span class='label label-warning'>".$val['status']."</span>";  } ?></td>
                                <td class="text-right"><a class="btn btn-warning btn-sm" href="<?php echo SURL;?>timesheets/update_timesheet/<?php echo $val['id'];?>">Update Timesheet</a></td>
                            </tr>
                            <?php $count++;
                        } ?>
                        <?php  } ?>
                    </tbody>
                </table>
   </div>
   <div class = "tab-pane fade in active" id = "pending_timesheet">
               <br/>
                <table class="table table-striped dataTable" id="pending_dataTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Staff Name</th>
                            <th>Status</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                        if(count($pending_timesheets)>0){
                        foreach ($pending_timesheets as $key => $val) {
                        ?>
                            <tr>
                                
                                <td><?php echo date("d-M-Y", strtotime($val['created_at'])); ?></td>
                                <td><?php echo $val['user_fname']." ".$val['user_lname']; ?></td>
                                <td><?php if($val['status']=="Pending"){ echo "<span class='label label-danger'>".$val['status']."</span>";} else{ echo "<span class='label label-warning'>".$val['status']."</span>";  } ?></td>
                                <td class="text-right"><a class="btn btn-warning btn-sm" href="<?php echo SURL;?>timesheets/view/<?php echo $val['id'];?>">View Timesheet</a></td>
                            </tr>
                            <?php $count++;
                        } ?>
                        <?php  } ?>
                    </tbody>
                </table>
   </div>
   <div class = "tab-pane fade" id = "approved_timesheet">
       <br/>
      <table class="table table-striped dataTable" id="approved_dataTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Staff Name</th>
                            <th>Status</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                    </thead>
                     <tbody>
                        <?php $count = 1;
                        if(count($approved_timesheets)>0){
                        foreach ($approved_timesheets as $key => $val) {
                        ?>
                            <tr>
                                
                                <td><?php echo date("d-M-Y", strtotime($val['created_at'])); ?></td>
                                <td><?php echo $val['user_fname']." ".$val['user_lname']; ?></td>
                                <td><?php if($val['status']=="Pending"){ echo "<span class='label label-danger'>".$val['status']."</span>";} else{ echo "<span class='label label-info'>".$val['status']."</span>";  } ?></td>
                                <td class="text-right"><a class="btn btn-warning btn-sm" href="<?php echo SURL;?>timesheets/view/<?php echo $val['id'];?>">View Timesheet</a></td>
                            </tr>
                            <?php $count++;
                        } ?>
                        <?php  } ?>
                    </tbody>
                </table>
   </div>
   <div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="btn-group-sm hidden" id="mini-fab">
        <div class="btn-fab">
        <a href="#" class="btn btn-default btn-fab" data-toggle="tooltip" data-placement="left" data-title="<?php echo count($draft_timesheets);?>" data-original-title="" title="<?php echo count($draft_timesheets);?>"  id="draft">
          <i class="fa fa-edit">
          </i>
        </a>
        </div>
        <div class="btn-fab">
        <a href="#" class="btn btn-danger btn-fab" data-toggle="tooltip" data-placement="left" data-title="<?php echo count($pending_timesheets);?>" data-original-title="" title="<?php echo count($pending_timesheets);?>"  id="mail">
          <i class="fa fa-clock-o">
          </i>
        </a>
        </div>
        <div class="btn-fab">
        <a href="#" class="btn btn-warning btn-fab" data-toggle="tooltip" data-placement="left" data-title="<?php echo count($approved_timesheets);?>" data-original-title="<?php echo count($approved_timesheets);?>" title="<?php echo count($approved_timesheets);?>" id="sms">
          <i class="fa fa-thumbs-up"></i>
        </a>
        </div>
        <div class="btn-fab">
         <a href="#" class="btn btn-info btn-fab" data-toggle="tooltip" data-placement="left" data-title="<?php echo count($invoiced_timesheets);?>" data-original-title="<?php echo count($invoiced_timesheets);?>" title="<?php echo count($invoiced_timesheets);?>" id="autre">
          <i class="fa fa-usd">
          </i>
        </a>
        </div>
      </div>
      <div class="btn-group">
        <a href="javascript:void(0)" class="btn btn-success btn-fab" id="main" data-toggle="tooltip" data-placement="left" data-original-title="Timesheet Stats" data-title="Timesheet Stats">
          <i class="fa fa-info">
            
          </i>
        </a>
      </div>
    </div>
  </div>
</div>
    <div class = "tab-pane fade" id = "invoiced_timesheet">
       <br/>
      <table class="table table-striped dataTable" id="invoiced_dataTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Staff Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                     <tbody>
                        <?php $count = 1;
                        if(count($invoiced_timesheets)>0){
                        foreach ($invoiced_timesheets as $key => $val) {
                        ?>
                            <tr>
                                
                                <td><?php echo date("d-M-Y", strtotime($val['created_at'])); ?></td>
                                <td><?php echo $val['user_fname']." ".$val['user_lname']; ?></td>
                                <td><?php if($val['status']=="Pending"){ echo "<span class='label label-danger'>".$val['status']."</span>";} else{ echo "<span class='label label-info'>".$val['status']."</span>";  } ?></td>
                                <td><a class="btn btn-warning btn-sm" href="<?php echo SURL;?>timesheets/view/<?php echo $val['id'];?>">View Timesheet</a></td>
                            </tr>
                            <?php $count++;
                        } ?>
                        <?php  } ?>
                    </tbody>
                </table>
   </div>
</div>
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
