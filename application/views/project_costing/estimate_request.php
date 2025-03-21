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
                                        <h4 class="card-title">Estimate Request "fees apply"</h4>
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
                                            <li><a href="<?php echo SURL.'project_costing/create_documents/'.$project_id;?>">Create Documents</a></li>
                                            <li class="active"><a href="#estimateRequest" data-toggle="tab">Estimate Request <font color="red">"fees apply"</font></a></li>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="estimateRequest">
                                    	        <?php if(in_array(4, $this->session->userdata("permissions"))) {?>
                                                <form action="" enctype="multipart/form-data"  id="ProjectEstimateForm" method="POST">
                    <input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id;?>">
	<div class="row form-group">
	        <label class="col-md-2">Project <font color="red">*</font></label>
            <div class="col-md-10">
                <?php echo $project_name['project_title']; ?>
            </div>
    </div>	
    <div class="row form-group">
	        <label class="col-md-2 label_with_selectpicker">Preferred Suppliers <font color="red">*</font></label>
            <div class="col-md-10 suppliers_container">
                <select class="selectpicker search_options" name="supplier_id" id="supplier_id" required data-style="select-with-transition" title="Select Supplier *" data-live-search="true" data-size="7">
                  <option value="" >Select Supplier</option>
                  <?php foreach ($suppliers as $supplier) { ?>
                  <option value="<?php echo $supplier["supplier_id"]; ?>"><?php echo $supplier["supplier_name"]; ?></option>
                  <?php } ?>
                </select> 
            </div>
    </div>
    <div class="row form-group">
	        <label class="col-md-2">Description <font color="red">*</font></label>
            <div class="col-md-10 suppliers_container">
                <textarea class="form-control" name="description" id="description" required minlength="100"></textarea>
                <br/>
                <h6 class="text-success">Minimum <span id='remainingCharacters'>100</span> characters required.</h6>
            </div>
    </div>
    	<div class="row form-group">
	        <label class="col-md-2"></label>
            <div class="col-md-10 dropzone_error">
	           <div id="DropzoneContainer" class="dropzone" uniqueTask="true"></div>
	           <h6 class="text-success">Maximum 15MB File Size is allowed</h6>
	       </div>
	 </div>
    <div class="row form-group">
		<div class="col-md-12">
		    <div class="pull-right">
				<input id="send_for_estimate" class="btn btn-primary" type="button" value="Send for Estimate"/>
			</div>
			
                 <div class="clearfix"></div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
      <div class="clear"></div>
      <!-- /.padding-md --> 
    </div>
    </form>
                            					<?php } ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    
                