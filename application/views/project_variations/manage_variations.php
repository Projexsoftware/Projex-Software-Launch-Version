<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">trending_down</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Project Variations</h4> 
                                    <div class="toolbar">
                                     <?php if(in_array(7, $this->session->userdata("permissions"))) {?>
                                        <a href="<?php echo SURL;?>project_variations/add_variation" class="btn btn-info"><i class="material-icons">add</i> Add Variation</a>
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
                                    <div class="material-datatables">
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li class="active"><a href="#activeProjectVariations" data-toggle="tab">Active</a></li>
                                            <li><a href="#completedProjectVariations" data-toggle="tab" onclick="get_completed_job_variations();">Completed</a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="activeProjectVariations">
                                            	 <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name </th> 
                                                                        <th>Variation Number </th> 
                                            							<th>Variation Subtotal </th>
                                            							<th>Variation Contract Price </th>
                                                                        <th>Initiated Version</th>
                                                                        <th>Variation Description</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                            						<?php 
                                            						$i=1;
                                                                    foreach($variations as $variation) {?>
                                                                    <tr class="row_<?php echo $variation["id"];?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><?php echo get_project_name($variation["project_id"]); ?></td>
                                                                        <td><?php echo $variation["var_number"]; ?></td>
                                                                        <td><?php echo '$'.number_format($variation["project_subtotal3"],2, '.', ''); ?></td>
                                                                        <td><?php echo '$'.number_format($variation["project_contract_price"],2, '.', ''); ?></td>
                                                                        <td><?php echo $variation["variation_name"]; ?></td>
                                                                        <td><?php echo $variation["variation_description"]; ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($variation["created_date"])); ?></td>
                                                                        <td>
                                                                        <?php if ($variation["status"] == "PENDING") { 
                                                                            ?><span class="label label-warning"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "ISSUED") { 
                                                                            ?><span class="label label-warning"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "APPROVED") { 
                                                                            ?><span class="label label-success"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "SALES INVOICED") { 
                                                                            ?><span class="label label-primary"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "PAID") { 
                                                                            ?><span class="label label-success"><?php echo $variation["status"] ?> </span>
                                                                            <?php } ?>
                                                                                
                                                                            <?php if ($variation["var_type"] == "purord") { 
                                                                            ?>&nbsp;<span class="label label-primary"> <?php echo 'From Purchase Order'; ?> </span>
                                                                            <?php } ?>
                                                                            <?php if ($variation["var_type"] == "suppinvo") { 
                                                                            ?>&nbsp;<span class="label label-info"> <?php echo 'From Supplier Invoice' ?> </span>
                                                                            <?php } ?>
                                                                            <?php if ($variation["var_type"] == "supcredit") { 
                                                                            ?>&nbsp;<span class="label label-info"> <?php echo 'From Supplier Credit' ?> </span>
                                                                            <?php } ?>
                                                                            <?php if ($variation["var_type"] == "salecredit") { 
                                                                            ?>&nbsp;<span class="label label-info"> <?php echo 'From Sales Credit' ?> </span>
                                                                            <?php } ?>
                                        								</td>
                                                                        <td class="text-right" >
                                                                            <?php if(in_array(6, $this->session->userdata("permissions")) || in_array(8, $this->session->userdata("permissions"))) {?>
                                                                           <a href="<?php echo SURL;?>project_variations/view_variation/<?php echo $variation["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                           <?php } ?>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>
                                                                </tbody>
                                                            </table>
                                            </div>
                                            <div class="tab-pane" id="completedProjectVariations">
                                                 <div class="loader">
                                                    <center>
                                                        <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                                    </center>
                                                </div>
                                            	 <table id="completedJobsVariations" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Project Name </th> 
                                                                        <th>Variation Number </th> 
                                            							<th>Variation Subtotal </th>
                                            							<th>Variation Contract Price </th>
                                                                        <th>Initiated Version</th>
                                                                        <th>Variation Description</th>
                                                                        <th>Created Date</th>
                                                                        <th>Status</th>
                                                                        <th class="disabled-sorting text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="completed_variations">
                                            						
                                                                </tbody>
                                                            </table>
                                            </div>
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