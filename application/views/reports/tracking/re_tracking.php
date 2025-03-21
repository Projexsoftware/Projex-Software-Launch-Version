<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Tracking Report</h4> 
                                    <div class="toolbar">
                                        <?php if(in_array(49, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>reports/add_tracking" class="btn btn-info"><i class="material-icons">add</i> Add Tracking Report</a>
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
									<div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                    
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    	<div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                   <tr>
                                                                        <th>No</th>
                                                                        <th>Project Name</th>
                                                                        <th>Group name</th>
                                                                        <th>Total Casting Parts</th>
                                                                        <th>Date</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                   
                                                                <tbody>
                                <?php  $count =1; foreach($tracking_reports as $report) { 
                                    $costing_ids = explode(',', $report->costing_part_ids);
                                ?>
                                <tr class="row_<?php echo $report->id;?>">
                                    <td><?php echo $count;?></td>
                                    <td><?php echo $report->project_title;?></td>
                                    <td><?php echo $report->title;?></td>
                                    <td><?php echo count($costing_ids);?></td>                                   
                                    <td><?php echo date("d-M-Y", strtotime($report->created_date));?></td>                            
                                    <td class="text-right">
                                    <a href="<?php echo SURL;?>reports/tracking_report/<?php echo $report->id;?>" class="btn btn-success btn-simple btn-icon"><i class="material-icons">preview</i></a>
                                    <?php
                                    if(in_array(50, $this->session->userdata("permissions"))) {
                                    ?>
                                    <a href="<?php echo SURL;?>reports/edit_tracking_report/<?php echo $report->id;?>" class="btn btn-warning btn-simple btn-icon"><i class="material-icons">edit</i></a>
                                    <?php } ?>
                                    <?php
                                     if(in_array(51, $this->session->userdata("permissions"))) {
                                    ?>
                                    <a onclick="demo.showSwal('warning-message-and-confirmation', 'reports/delete_tracking', <?php echo $report->id;?>)" class="btn btn-simple btn-danger btn-icon"><i class="material-icons">delete</i></a>
                                                     
                                    <?php } ?>
                                    </td>
                                </tr>
                            <?php $count++;} ?>
                            </tbody>
                                                            </table>
                                                        </div>
                                                </div>
                                        </div>
                                        
                                </div>
		</div>
    </div>
</div>
