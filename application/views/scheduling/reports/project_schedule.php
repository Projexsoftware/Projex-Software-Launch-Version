<div class="loader">
   <center>
       <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading..">
   </center>
</div>
<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">schedule</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Project Schedule</h4>
                                        <form id="ProjectScheduleForm" method="POST" action="">
                                        <div class="form-group label-floating">
                                            <select id="project_id" name="project_id" required="true" class="selectpicker" data-style="select-with-transition" title="Choose Project" data-live-search="true">
                                                        
                                                        <?php if(count($projects)>0){
                                                        foreach($projects as $val){
                                                        ?>
                                                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                        <?php } } ?>
                                                    </select>
                                            <?php echo form_error('project_id', '<div class="custom_error">', '</div>'); ?>
					                    </div>
					                    <div class="form-group label-floating">
                                                <input type="text" class="form-control pull-left" name="daterange" id="daterange" value="" required="true"/>
                                        </div>
                                        <div class="form-footer text-right">
                                            <button type="button" class="btn btn-warning btn-fill view_project_schedule">View Schedule</button>
                                        </div>
                                        </form>
                                </div>
                            </div>
                            <div class="card project_schedule_chart"style="display:none;">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">schedule</i>
                                    </div>
                                    <div class="card-content">
                                        <div id="project_schedule_container"></div>
                                        <a class="btn btn-warning btn-schedule-export" style="display:none;"><i class="material-icons">get_app</i> Export As PDF</a>
                                    </div>
                        </div>
                        </div>
                    </div>
                