<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">recommended</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Update Confirm Estimate<div class="pull-right"><?php if($confirm_estimate_details[0]->status==1){ echo '<span class="label label-success">Sent</span>';} else{ echo '<span class="label label-danger">Returned</span>'; };?> </div>
           </h4>
                  
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">info</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Company Details</h4>
                <?php  
                $company_info = get_price_book_supplier_info($confirm_estimate_details[0]->company_id);
                ?>
                    <table class="table" width="500px">
                    							
                    							    <tbody>
                    								<tr>
                    								    <td style="width:180px;"><b>Company Logo : </b></td>
                    									<td><img style="width:180px;" src="<?php echo base_url() .'/assets/company/thumbnail/'.$company_info['com_logo'];?>"></td>
                    								</tr>
                    								<tr>
                    								    <td style="width:180px;"><b>Company Name : </b></td>
                    									<td><?php echo $company_info['com_name'];?></td>
                    								</tr>
                    								<tr>
                    								    <td style="width:180px;"><b>Company Website : </b></td>
                    									<td><?php echo $company_info['com_website'];?></td>
                    								</tr>
                    								<tr>
                    								    <td style="width:180px;"><b>Company Email : </b></td>
                    									<td><?php echo $company_info['com_email'];?></td>
                    								</tr>
                    								<tr>
                    								    <td style="width:180px;"><b>Company Contact Number : </b></td>
                    									<td><?php echo $company_info['com_phone_no'];?></td>
                    								</tr>
                    									
                    							</tbody>
                    						</table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">attach_file</i>
            </div>
            <div class="card-content">
                	<h4 class="card-title">Project Plans & Specifications</h4>
                <?php  
                $company_info = get_price_book_supplier_info($confirm_estimate_details[0]->company_id);
                ?>
                        	<div class="col-md-6"><h5 class="text-left"><b>Project :</b> <?php echo $confirm_estimate_details[0]->project_title;?></h5></div>
                            <div class="col-md-6 text-right"><button class="btn btn-info btn-sm" data-toggle="collapse" data-target="#plans_and_specifications">View Plans & Speifications</button></div>
                    
                    <div id="plans_and_specifications" class="collapse">
                
                    <table class="table">
                    						            <thead>
                    						                <tr>
                    						                    <th>
                    						                        S.No
                    						                    </th>
                    						                    <th>
                    						                        Document
                    						                    </th>
                    						                    <th class="disabled-sorting text-right">Action</th>
                    						                </tr>
                    						            </thead>
                    						            <tbody class="documents_container">
                    						            <?php $i=1; if(count($plans_and_specifications)>0){ foreach($plans_and_specifications as $document){ ?>
                    						            <tr>
                    						                <td>
                    						                     <?php echo $i;?>
                    						                </td>
                    						                <td>
                    						                    <?php echo $document->document;?>
                    						                </td>
                    						                <td  class="text-right">
                    						                        <a class="btn btn-icon btn-simple btn-download btn-success" href="<?php echo SURL.'confirm_estimate/download/'.$document->id;?>"><i title="Download" class="material-iocns">download</i></a>
                    						                     
                    						                </td>
                    						            </tr>
                    						    <?php $i++;} ?>
                    						   <?php }else{?>
                    						   <tr>
                    						                <td colspan="4">
                    						                    <h5>No Plans & Specifications Found</h5>
                    						                </td>
                    						            </tr>
                    						   <?php } ?>
                    						            </tbody>
                    						        </table>
                    </div>
                    </div>
                </div>
            </div>
</div>
<div class="row">
    <div class="col-md-12">
         <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                <i class="material-icons">info</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Component Details</h4>
                                <table class="table table-no-bordered">
                                                <thead>
                                                  <tr>
                                                    <th>S.No</th>
                                                    <th>Stage</th>
                                                    <th>Part</th>
                                                    <th>Component</th>
                                                    <th>QTY</th>
                                                    <th>Unit Of Measure</th>
                                                    <th>Unit Cost</th>
                                                    <th>Line Total</th>
                                                    <th>User Notes</th>
                                                    <th>Supplier Notes</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                if(count($confirm_estimate_details)>0){
                                                $count = 1;
                                                foreach($confirm_estimate_details as $val){?>
                                                  <input type="hidden" name="confirm_estimate_part_id[]" value="<?php echo $val->confirm_estimate_part_id;?>">
                                                  <tr>
                                                    <td><?php echo $count;?></td>
                                                    <td><?php echo $val->stage_name;?></td>
                                                    <td><?php echo $val->costing_part_name;?></td>
                                                    <td><?php echo $val->component_name;?></td>
                                                    <td><?php echo $val->costing_quantity;?></td>
                                                    <td><?php echo $val->costing_uom;?></td>
                                                    <td><?php echo $val->costing_uc;?></td>
                                                    <td><?php echo $val->line_cost;?></td>
                                                    <td><?php if($val->user_notes==""){ echo '<span class="label label-danger">Not Added Yet</span>';} else{ echo $val->user_notes; }?></td>
                                                    <td><?php if($val->supplier_notes==""){ echo '<span class="label label-danger">Not Added Yet</span>';} else{ echo $val->supplier_notes; }?></td>
                                                    </tr>
                                                <?php $count++; } } ?>
                                                </tbody>
                                                </table>
                               
            </div>

                </div>
        </div>
    </div>
</div>
                