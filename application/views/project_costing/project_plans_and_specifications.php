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
              .dropzone .dz-default.dz-message span{
    font-size:15px!important;
}
.dropzone {
    min-height: 115px!important;
}
          </style> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">house</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Project Plans & Specifications</h4>
				                    	<div class="form-group label-floating">
                								<?php echo $project_name['project_title']; ?>
                                        </div>
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
                                        <ul class="nav nav-pills nav-pills-warning">
                                            <li><a href="<?php echo SURL.'project_costing/edit_project_costing/'.$project_id;?>">Project Costing</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/specifications/'.$project_id;?>">Specifications</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/allowances/'.$project_id;?>">Allowances</a></li>
                                            <li class="active"><a href="#plansSpecifications" data-toggle="tab">Plans and Specifications</a></li>
                                            <li><a href="<?php echo SURL.'project_costing/create_documents/'.$project_id;?>">Create Documents</a></li>
                                            <!--<li><a href="<?php echo SURL.'project_costing/estimate_request/'.$project_id;?>">Estimate Request <font color="red">"fees apply"</font></a></li>-->
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="plansSpecifications">
                                    	        <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
                                                <div class="form-group label-floating">
                                                    <div class="col-md-2"><label>Upload Documents :</label></div>
        				        <div class="col-md-10">
                                                    
                                                    <form id="myAwesomeDropzone" class="form-horizontal no-margin form-border dropzone" action="<?php echo SURL;?>project_costing/upload_documents" method="post" enctype="multipart/form-data">
                                                        <div class="dropzone-previews"></div>
						                            </form>
						                            </div>
                                                </div>
                                                <form method="post" action="<?php echo SURL;?>project_costing/save_documents" onsubmit="return ValidateDocumentForm();">
                            					    <input type="hidden" name="project_id" value="<?php echo $project_id;?>">
                            					    <div class="row">
                            					        <div class="form-group label-floating">
                                    					    <div class="col-md-2" style="margin-top:10px;text-align:right;"><label>Upload As :</label></div>
                                    				        <div class="col-md-10">
                                    					    <div class="radio">
                                    					         <label><input type="radio" name="privacy_options" checked value="0"> Private</label>
                                    					    </div>
                                    					    <div class="radio">
                                    					         <label><input type="radio" name="privacy_options" value="1"> Share</label>
                                    					    </div>
                                    					    </div>
                            					        </div>
                            					    </div>
                            					   <br/>
                            					    <div class="form-group row">
                            								
                                                            <div class="col-lg-12 pull-left">
                                                                
                                                                <button class="btn btn-success" type="submit" name="upload_document" value="submit">Save Documents</button>
                                                                <a href="<?php echo SURL;?>project_costing" class="btn btn-danger" style="margin-left:10px;">Close</a>
                            								    <input type="hidden" name="is_submit" id="is_submit" value="add">
                            									
                            								</div><!-- /.col -->
                            							</div>
                            						</form>
                            					<?php } ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">folder</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Uploaded Documents</h4>
				                    	
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                       <form id="form_documents" method="post">
						                            <input type="hidden" name="project_id" value="<?php if(count($plans_and_specifications)>0){ echo $plans_and_specifications[0]["project_id"]; }?>">
						        <table class="table table-striped table-no-bordered table-hover">
						            <thead>
						                <tr>
						                    <th>
						                        <input type="checkbox" class="select_all">
						                    </th>
						                    <th>
						                        Document
						                    </th>
						                    <th>
						                        Privacy Type
						                    </th>
						                    <th>
						                        Action
						                    </th>
						                </tr>
						            </thead>
						            <tbody class="documents_container">
						            <?php if(count($plans_and_specifications)>0){ foreach($plans_and_specifications as $val){ ?>
						            <tr>
						                <td>
						                    <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
						                    <input id="<?php echo $val["id"];?>" type="checkbox" name="selected_items[]" value="<?php echo $val["id"];?>" class="selected_items">
						                    <?php } ?>
						                </td>
						                <td>
						                    <?php echo $val["document"];?>
						                </td>
						                <td>
						                         <?php if($val["privacy"] ==0){ ?>
						                         <span class="label label-primary"><i class="fa fa-lock"></i> Private</span>
						                         <?php } if($val["privacy"] ==1){ ?>
						                         <span class="label label-warning"><i class="fa fa-share"></i> Shared</span>
						                         <?php } ?>
						                </td>
						                <td>
						                         <a class="btn btn-success btn-sm" href="<?php echo SURL.'project_costing/download/'.$val["id"];?>"><i title="Download" class="material-icons">cloud_download</i> Download</a>
						                    
						                </td>
						            </tr>
						    <?php } ?>
						            <tr>
						                <td colspan="4">
						                    <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
						                    <a class="btn btn-primary set_as_private btn-sm"><i class="fa fa-lock"></i> Set As Private</a>
						                    <a class="btn btn-warning set_as_share btn-sm" style="margin-left:15px;"><i class="fa fa-share"></i> Set As Share</a>
						                    <a class="btn btn-danger delete_all btn-sm" style="margin-left:15px;"><i class="material-icons">delete</i> Delete All</a>
						                    <?php } ?>
						                </td>
						            </tr>
						   <?php }else{?>
						   <tr>
						                <td colspan="4">
						                    <h6>No Documents Found</h6>
						                </td>
						            </tr>
						   <?php } ?>
						            </tbody>
						        </table>
						</form>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                