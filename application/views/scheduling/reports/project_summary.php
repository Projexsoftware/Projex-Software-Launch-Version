<div class="loader">
   <center>
       <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading..">
   </center>
</div>
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">assessment</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Reports</h4>
                                        <form id="ProjectSummaryForm" method="POST" action="">
                                        <div class="form-group label-floating">
                                            <select id="project_id" name="project_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Project" data-live-search="true">
                                                        
                                                        <?php if(count($projects)>0){
                                                        foreach($projects as $val){
                                                        ?>
                                                        <option value="<?php echo $val['project_id'];?>"><?php echo $val['project_title'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
					                    </div>
					                    <div class="datepicker-section">
                                            <div class="form-group label-floating">
                                                <input class="form-control datepicker project_start_date" type="text" name="start_date" id="start_date" required="true" value="<?php if(isset($param) && $param!=""){ echo $param; }else{ echo date('d/m/Y'); }?>" placeholder="From"/>
                                                <?php echo form_error('start_date', '<div class="custom_error">', '</div>'); ?>
        					                </div>
                                            <div class="form-group label-floating">
                                                <input class="form-control datepicker" type="text" name="end_date" id="end_date" required="true" value="<?php if(isset($param) && $param!=""){ echo $param; }else{ echo date('d/m/Y'); }?>" placeholder="To"/>
                                                <?php echo form_error('end_date', '<div class="custom_error">', '</div>'); ?>
        					                </div>
    									</div>
                                        <div class="form-group label-floating">
                                            <select id="summary_type" name="summary_type" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Report Type" data-live-search="true">
                                                        <option value="documents">DOCUMENTS</option>
                                                        <option value="checklist">CHECKLIST</option>
                                                        <option value="notes">NOTES</option>
                                                        <option value="images">IMAGES</option>
                                                        <option value="files">FILES</option>
                                                        <option value="log">PROJECT LOG</option>
                                                        
                                                    </select>
                                            <?php echo form_error('summary_type', '<div class="custom_error">', '</div>'); ?>
					</div>
										
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-warning btn-fill view_project_summary">View Report</button>
                                        </div>
                                        </form>
                                    </div>
                                
                            </div>
                        <div class="project_summary_container"></div>
                        </div>
                    </div>
                