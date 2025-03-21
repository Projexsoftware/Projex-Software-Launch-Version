
          <style>
              .templates_table .form-control{
                  background-image: none;
                  border:1px solid #ccc!important;
                  padding:5px;
                  margin-top:12px;
              }
             .form-group.is-focused .templates_table .form-control{
                  background-image: none!important;
              }
              .part-form-control{
                  width:200px;
              }
              .uom-form-control, .uc-form-control{
                width:100px;
              }
              .no-padding{
                  padding:0px!important;
              }
              .comments, .status, .include, .boom_mobile{
                display:none;
              }
              .table_project_name{ text-align:center; width:100%; background-color: #f56700; color:#fff; padding:10px 0;font-weight:bold;}
              .homeworx_logo{
                  /*margin-top:25px;*/
                  text-align:center;
              }
              
              
              @media print {
                @page { size: landscape; }
            	.notprint{
                    display: none !important;
                }
              }
          </style> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon notprint" data-background-color="orange">
                                        <i class="material-icons">house</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Report</h4>
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
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                        <ul class="nav nav-pills nav-pills-warning notprint">
                                            <li><a href="<?php echo SURL.'project_costing/edit_project_costing/'.$project_id;?>">Project Costing</a></li>
                                            <li <?php if($type == "specifications"){ ?> class="active" <?php } ?>><a href="<?php echo SURL.'project_costing/specifications/'.$project_id;?>">Specifications</a></li>
                                            <li <?php if($type == "allowances"){ ?> class="active" <?php } ?>><a href="<?php echo SURL.'project_costing/allowances/'.$project_id;?>">Allowances</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/plans_and_specifications/'.$project_id;?>">Plans and Specifications</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/create_documents/'.$project_id;?>">Create Documents</a></li>
                                              <!--<li><a href="<?php echo SURL.'project_costing/estimate_request/'.$project_id;?>">Estimate Request <font color="red">"fees apply"</font></a></li>-->
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="projectCosting">
                                                <?php if($company_info["com_logo"]!=""){ ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-3 homeworx_logo">
                                                        <img style="width:100%;height:100px;" src="<?php echo trim(SURL).'/assets/company/'.trim($company_info["com_logo"]);?>">
                                                    </div>
                                                </div>
                                                <?php } else{ ?>
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-3 homeworx_logo">
                                                        <img src="<?php echo SURL; ?>assets/img/homeworx_logo.png">
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                 <div class="row">
                                                    <div class="col-md-12">
                                                        <h4 class="table_project_name">
                                	    				Project Name:
                                	    				<?php echo $project_name['project_title']; ?>
                                	    				<br/>
                                	    				Project Address:
                                	    				<?php 
                                	    					echo $project_info['street_pobox'] . ' ' .
                                	    					$project_info['suburb'] . ', ' .
                                	    					$project_info['project_address_city'] . ', ' .
                                							$project_info['project_address_state'] . ', ' .
                                							$project_info['project_address_country'] . ', ' .
                                							$project_info['project_zip'];
                                	    				?>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <!--<div class="row">
                                                    <div class="col-sm-12">
                                	    				<h4 class="pro_address">
                                	    				Project Address:
                                	    				<?php 
                                	    					echo $project_info['street_pobox'] . ' ' .
                                	    					$project_info['suburb'] . ', ' .
                                	    					$project_info['project_address_city'] . ', ' .
                                							$project_info['project_address_state'] . ', ' .
                                							$project_info['project_address_country'] . ', ' .
                                							$project_info['project_zip'];
                                	    				?>
                                	    				</h4>
                                    				</div>
                                                </div>-->
                                                <div class="form-group label-floating">
                                                    <div class="table-responsive">
                                                                 <table id="partstable" class="table sortable_table table-border templates_table partstable">
                                                                   <thead>
                                                                       <th>Stage</th>
                                                                       <th>Part</th>
                                                                       <th>Comment</th>
                                                                       <th>Component</th>
                                                                       <th>Image</th>
                                                                   </thead>
                                                                   <tbody>
                                                                        
                                                                        <?php 
                                                                        foreach ($prjprts As $key => $prjprt) {?>
                                                                        <tr>
                                                                            <td>
                                                                                    <?php echo $prjprt->stage_name;?>
                                                                           </td>
                                                                           <td>
                                                                               <?php echo $prjprt->costing_part_name; ?>
                                                                           </td>
                                                                            <td>
                                                                               <?php echo $prjprt->comment;?>
                                                                            </td>
                                                                            <td>
                                                                                    <?php echo $prjprt->component_name;?>
                                                                           </td>
                                                                           <td>
                                                                            <?php if($prjprt->component_image!=""){?>
                                                                               <img src="<?php echo base_url('assets/components/thumbnail/'.$prjprt->component_image);?>" style="width: 80px; height: 50px;">
                                                                               <?php } else{ ?>
                                                                               <img src="<?php echo base_url('assets/img/image_placeholder.jpg');?>" style="width: 80px; height: 50px;">
                                                                               <?php } ?>
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
                            </div>
                        </div>
                        <div class="col-md-12 notprint">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                            <a href="javascript:window.print()" class="btn btn-warning btn-fill">Print</a>
                                            <a href="<?php echo SURL;?>project_costing/export_excel/<?php echo $type;?>/<?php echo $project_id;?>" class="btn btn-warning btn-fill">Export To Excel</a>
                                            <a href="<?php echo SURL;?>project_costing/export_pdf/<?php echo $type;?>/<?php echo $project_id;?>" class="btn btn-warning btn-fill">Export To PDF</a>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                