<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">money</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title"><?php echo $timesheet_items[0]['user_fname']." ".$timesheet_items[0]['user_lname']; ?>'s Timesheet</h4>
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
                                    
                                        <div class="col-md-12">
                                            <form id="timesheet_form" method="post" action="<?php echo base_url() . 'timesheets/approved_timesheet_process' ?>">
          <input type="hidden" name="timesheet_id" id="timesheet_id" value="<?php echo $timesheet_items[0]['timesheet_id'];?>">
                <table class="table table-striped table-bordered" id="dataTable1">
                    <thead>
                        <tr>
                            <th colspan="8"><center><h3><img src="<?php echo SURL;?>/assets/img/time_sheet_icon.gif"  style="margin-bottom:4px;width:25px;height:25px;"> TIMESHEET</h3></center></th>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <!--<th>Staff Name</th>-->
                            <th>Project</th>
                            <th>Stage</th>
                            <th>Details</th>
                            <th>Submitted Hours</th>
                            <th>Approved Hours</th>
                            <th>Cost</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;
                        if(count($timesheet_items)>0){
                            $total_submitted_hours = 0;
                            $total_approved_hours = 0;
                            $total_subtotal = 0;
                        foreach ($timesheet_items as $key => $val) {
                           $total_submitted_hours +=$val['submitted_hours'];
                           $total_approved_hours +=$val['approved_hours'];
                           $total_subtotal +=$val['subtotal'];
                        ?>
                        <input type="hidden" name="timesheet_item_id[]" value="<?php echo $val['id'];?>">
                            <tr>
                                
                                <td><?php echo date("d-M-Y", strtotime($val['date'])); ?></td>
                                <!--<td><?php echo $val['user_fname']." ".$val['user_lname']; ?></td>-->
                                <td><?php echo $val['project_title']; ?></td>
                                <td>
                                    <?php echo $val['stage_name']; ?>
                                </td>
                                <td><?php echo $val['details']; ?></td>
                                <td class="text-right"><?php echo $val['submitted_hours']; ?></td>
                                <td class="text-right">
                                    <?php if($val['timesheet_status']=="Pending"){ ?>
                                    <input class="form-control approved_hours" type="text" name="approved_hours[]" id="approved_hours<?php echo $val['id'];?>" required value="<?php echo $val['approved_hours']; ?>" onchange="calculate_subtotal(<?php echo $val['id'];?>);">
                                    <?php } else{ echo $val['approved_hours'];?>
                                    <input class="form-control approved_hours" type="hidden" name="approved_hours[]" id="approved_hours<?php echo $val['id'];?>" required value="<?php echo $val['approved_hours']; ?>" onchange="calculate_subtotal(<?php echo $val['id'];?>);"> <?php }?>
                                    </td>
                                <td class="text-right">
                                    <?php if($val['timesheet_status']=="Pending"){ ?>
                                    <input class="form-control" type="text" name="cost[]" id="cost<?php echo $val['id'];?>" value="<?php echo $val['cost']; ?>" required onchange="calculate_subtotal(<?php echo $val['id'];?>);">
                                    <?php } else{ echo $val['cost']; ?>
                                    <input class="form-control" type="hidden" name="cost[]" id="cost<?php echo $val['id'];?>" value="<?php echo $val['cost']; ?>" required onchange="calculate_subtotal(<?php echo $val['id'];?>);">
                                    <?php }?>
                                    
                                    </td>
                                <td class="text-right">
                                    <?php if($val['timesheet_status']=="Pending"){ ?>
                                    <input class="form-control subtotal_amount" type="text" readonly name="subtotal[]" id="subtotal<?php echo $val['id'];?>" value="<?php echo $val['subtotal']; ?>">
                                    <?php } else{ echo $val['subtotal']; ?>
                                    <input class="form-control subtotal_amount" type="hidden" readonly name="subtotal[]" id="subtotal<?php echo $val['id'];?>" value="<?php echo $val['subtotal']; ?>">
                                    <?php } ?></td>
                                </tr>
                            <?php $count++;
                        } ?>
                        <tr>
                            <td colspan="4"><b>Total</b></td>
                            <td class="text-right"><b><?php echo number_format($total_submitted_hours, 2, ".", "");?></b></td>
                            <td class="text-right total_approved_hours"><b><?php echo number_format($total_approved_hours, 2, ".", "");?></b></td>
                            <td></td>
                            <td class="text-right total_subtotal"><b>$<?php echo number_format($total_subtotal, 2, ".", ",");?></b></td>
                        </tr>
                        <?php if($val['timesheet_status']=='Pending'){ 
                    
                                    if(in_array(108, $this->session->userdata("permissions"))) {
                                    
                        ?>
                        <tr>
                            <td colspan="10" class="text-right"><input type="submit" value="Approve" class="btn btn-primary"></td>
                        </tr>
                        <?php } } }?>
                    </tbody>
                </table>
            </form>
<?php if($timesheet_items[0]['timesheet_status']!="Pending"){ ?>
      <div class="project_container_for_invoice">
                 <center><h3>INVOICE ALLOCATION</h3></center>
                <BR/>
 <table class="table table-striped table-bordered dataTable">
                    <thead>
                       
                        <tr>
                            <th>Project</th>
                            <th>Hours Worked</th>
                            <th>Cost Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
 <?php if(count($projects)>0){ foreach($projects as $project){ ?>
                            <tr>
                                <td><?php echo $project['project_title']; ?></td>
                                <td class="text-right"><?php echo $project['worked_hours'];?></td>
                                <td class="text-right">$<?php echo number_format($project['cost_subtotal'],2,".",",");?></td>
                                <td>
                                <?php 
                                 if(in_array(107, $this->session->userdata("permissions"))) {
                                $is_invoiced = check_is_invoiced($project['project_id'], $timesheet_items[0]['timesheet_id']);
                                if(count($is_invoiced)==0){
                                ?> 
                                    <form action="<?php echo SURL;?>timesheets/add_invoice" method="post">
                                      <input type="hidden" name="timesheet_id" value="<?php echo $timesheet_items[0]['timesheet_id'];?>">
                                      <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                                      <input type="hidden" name="project_title" value="<?php echo $project['project_title']; ?>">
                                      <input type="hidden" name="worked_hours" value="<?php echo $project['worked_hours']; ?>">
                                      <input type="hidden" name="cost_subtotal" value="<?php echo $project['cost_subtotal']; ?>">
                                      <input type="submit" class="btn btn-primary btn-sm" value="Add Supplier Invoice">
                                    </form>
                                <?php } else{ ?>
                                    <a class="btn btn-info btn-sm" href="<?php echo SURL;?>supplier_invoices/viewinvoice/<?php echo $is_invoiced['supplier_invoice_id'];?>" target="_Blank">Update Supplier Invoice</a>
                               <?php }} ?>
                                </td>
                            </tr>
                            <?php $count++;
                        } ?>
                        <?php  } ?>
                    </tbody>
                </table>
    </div>
    <?php } ?>
    </form><div class="form-footer">
            <br/><center><a class="btn btn-warning" href="<?php echo SURL;?>timesheets">Back To Manage Timesheets</a></center>
            </div>
                                        </div>
                            </div>
                        </div>
                    </div>