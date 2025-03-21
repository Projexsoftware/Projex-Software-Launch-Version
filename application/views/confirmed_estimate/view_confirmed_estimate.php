<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">person</i>
                                </div>
                        <div class="card-content">
                        <h4>Confirmed Estimate Details</h4>
                                            <div id="ClientDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingClient">
                                                <div class="project_team_container">
                                                    
                                                       <div class="table-responsive">
                                                          <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Project</h4>
                                                        <?php echo $confirm_estimate_details[0]->project_title;?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Supplier</h4>
                                                        <?php echo $confirm_estimate_details[0]->supplier_name;?>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td>
                                                        <h4 class="card-title">Created Date</h4>
                                                        <?php echo ' '.date('d/m/Y',strtotime($confirm_estimate_details[0]->created_at)); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Status</h4>
                                                        <?php if($confirm_estimate_details[0]->status==1){ ?>
                                                        <span class="label label-success">Sent</span>
                                                        <?php } else{ ?>
                                                        <span class="label label-danger">Returned</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                        <table class="table table-striped table-hover">
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
                  <tr>
                    <td><?php echo $count;?></td>
                    <td><?php echo $val->stage_name;?></td>
                    <td><?php echo $val->costing_part_name;?></td>
                    <td><?php echo $val->component_name;?></td>
                    <td><?php echo $val->costing_quantity;?></td>
                    <td><?php echo $val->costing_uom;?></td>
                    <td><?php echo $val->costing_uc;?></td>
                    <td><?php echo $val->line_cost;?></td>
                    <td><?php echo $val->user_notes;?></td>
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
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                        
</div>
<!-- end row -->