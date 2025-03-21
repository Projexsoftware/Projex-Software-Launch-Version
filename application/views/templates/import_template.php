     <style>
         .checkbox .checkbox-material {
             top:1px;
         }
         .checkbox{
            display:inline; 
         }
         .table>thead>tr>th {
            font-size: 16px;
         }
         .error-container {
            color: red;
            margin-top: 10px;
        }
     </style>         
                <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">phonelink_setup</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Import Template</h4> 
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
									<div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                        <form id="TemplateDownloadForm" method="post" action="<?php echo SURL;?>setup/download_selected_templates">
                                        <div class="material-datatables templates_container">
                                        <table id="templatesTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Template Name</th>
                                                    <th>Template Description</th>
                                                    <th>Template Type</th>
                                                    <th>Image</th>
                                                    <th><div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="selectAll" id="selectAll" style="margin-top:-8px!important;">
                                                        </label>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                            <?php  if(isset($templates)){ foreach($templates as $templ) { 
                                                   $template_request_info = get_template_request_info($templ->template_id);
                                            ?>
                                                <tr>
                                                    <td><?php echo $templ->template_name;?></td>
                                                    <td><?php echo substr($templ->template_desc,0,100);?></td>
                                                    <td><?php echo ($templ->template_type == 0)?"Components":"Designz";?></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="selectTemplate" name="selectTemplate[]" id="selectTemplate<?php echo $templ->template_id;?>" atLeastOneChecked="true" value="<?php echo $templ->template_id;?>" style="margin-top:-8px!important;">
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } }?>
                                            <tr>
                                                <td colspan="5" class="text-right">
                                                <?php if(count($templates)>0){ ?>
                                                    <div id="error-container" class="error-container"></div>
                                                    <input type="submit" class="btn btn-warning" value="Import">
                                                <?php } ?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                        </form>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->