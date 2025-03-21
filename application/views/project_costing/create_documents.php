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
            .form-inline .bootstrap-select.btn-group, .form-horizontal .bootstrap-select.btn-group, .form-group .bootstrap-select.btn-group{
                margin-top:0px;
            }
            .select-with-transition{
                padding-top:0px;
            }
            .custom_label{
                padding-top:5px;
            }
          </style> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">house</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Create Documents</h4>
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
                                            <li><a href="<?php echo SURL.'project_costing/plans_and_specifications/'.$project_id;?>">Plans and Specifications</a></li>
                                            <li class="active"><a href="#createDocuments" data-toggle="tab">Create Documents</a></li>
                                              <!--<li><a href="<?php echo SURL.'project_costing/estimate_request/'.$project_id;?>">Estimate Request <font color="red">"fees apply"</font></a></li>-->
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="createDocuments">
                                    	        <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
                                                <form action="<?php echo SURL ?>project_costing/create_documents_pdf/<?php echo $project_id;?>" enctype="multipart/form-data"  id="CreateDocumentsForm" method="POST">
                    <input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id;?>">
	<div class="row form-group">
	        <label class="col-md-2">Project <font color="red">*</font></label>
            <div class="col-md-10">
                <?php echo $project_name['project_title']; ?>
            </div>
    </div>	
    <div class="row form-group">
	        <label class="col-md-2 custom_label">Document Type <font color="red">*</font></label>
            <div class="col-md-10 suppliers_container">
                <select class="selectpicker search_options" name="document_type" id="document_type" required data-style="select-with-transition" title="Select Document Type *" data-live-search="true" data-size="7">
                  <option value="specification" selected>Specification/Technical</option>
                  <option value="warranty">Warranty</option>
                  <option value="installation">Installation</option>
                  <option value="maintenance">Maintenance</option>
                  <option value="checklist">Checklist</option>
                </select> 
            </div>
    </div>
    <div class="row form-group">
    <div id="loading-overlay">
                       <div class="loading-icon"></div>
                    </div>
                    <div class="components_container">
                    <table class="table table-striped table-no-bordered table-hover">
                        <thead>
                            <th><input class="select_all" type="checkbox"></th>
                            <th>Stage</th>
                            <th>Part</th>
                            <th>Component</th>
                            <th>Document</th>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>

                            <?php 
                            if(count($prjprts)>0){
                            foreach ($prjprts As $key => $prjprt) { 
                            $component_document = is_component_have_documents($prjprt->component_id, $type);
                            ?>

                            <tr id="trnumber<?php echo $count ?>" tr_val="<?php echo $count ?>">
                                <td><input class="selected_component" type="checkbox" name="selected_components[]" id="selected_component<?php echo $prjprt->costing_part_id;?>" value="<?php echo $prjprt->costing_part_id;?>"></td>
                                <td>
                                    <?php echo $prjprt->stage_name;?>
                               </td>
                               <td>
                                   <?php echo $prjprt->costing_part_name; ?>
                              </td>  
                                                      
                            <td> 
                                <?php echo $prjprt->component_name;?>                           
                            </td>
                           
                            <td>
                                 <?php if($type=="specification" && $component_document["specification"]!=""){ ?>
                                
                                <a target="_Blank" href="<?php echo base_url();?>assets/component_documents/specification/<?php echo $component_document["specification"];?>"><?php echo $component_document["specification"];?></a>
                                <!--<iframe src="<?php echo base_url();?>assets/component_documents/specification/<?php echo $component_document["specification"];?>" title="<?php echo $component_document["specification"];?>" width="100%">
</iframe>-->
                               <?php } ?>
                            </td> 
                        </tr>
                        <?php $count ++ ?>         
                        <?php } } else{ ?>
                        <tr><td colspan="5">No Documents Found</td></tr>
                        <?php } ?>

                    </tbody>
                </table>
      <?php
      if(in_array(4, $this->session->userdata("permissions"))) {
          
      if(count($prjprts)>0){
      ?>
        <div class="actions">
            <div class="input-group">
                <input type="hidden" id="type" name="type" value="<?php echo $type; ?>"/>
                <input type="submit" class="btn btn-success" value="Export as PDF"> 
            </div>
        </div>
<?php } } ?>
</div>
    </div>
    </form>
                            					<?php } ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    
                