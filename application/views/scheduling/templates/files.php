<div id="files_container<?php echo $item_id;?>">
<?php $task_files = get_template_task_files($template_id, $item_id);?>
<a class="btn btn-warning btn-round" data-toggle="modal" data-target="#addFileModal<?php echo $item_id;?>">Files <span class="badge count<?php echo $item_id;?>"><?php echo count($task_files);?></span>
                                       <b class="caret"></b></a>
                                        <!-- Files modal -->
                                            <div class="modal fade" id="addFileModal<?php echo $item_id;?>" tabindex="-1" role="dialog" aria-labelledby="myFileModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myFileModalLabel"><?php echo get_task_name($task_id);?> Files</h5>                                                        </div>
                                                        <div class="modal-body">
                                                        <?php if(count($task_files)>0){ echo "<ul class='list_container'>"; foreach($task_files as $val){ ?>
                                                       <li> <span class="btn btn-simple btn-icon"><i class="material-icons">insert_drive_file</i></span> <?php echo $val['file_original_name'];?><span rowno="<?php echo $item_id;?>" id="<?php echo $val['id'];?>" class="remove_file pull-right btn btn-simple btn-danger btn-icon"><i class="material-icons">close</i></span><span class="pull-right btn btn-simple btn-icon">|</span><a class="pull-right btn btn-success btn-simple btn-icon" href="<?php echo SURL;?>buildz/templates/download_file/<?php echo $val['file'];?>"><i class="material-icons">file_download</i></a></li>
                                                        <?php } echo "</ul>";} ?>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">attach_file</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Upload New File</h4> 
                                    <div class="toolbar">
<form rowno="<?php echo $item_id;?>" class="upload_task_file" name="FilesForm<?php echo $item_id;?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="file_item_id" value="<?php echo $item_id;?>">
<input type="hidden" name="file_template_id" value="<?php echo $template_id;?>">
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-warning btn-round btn-file">
                                                        <span class="fileinput-new">Select file</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="task_file<?php echo $item_id;?>" name="task_file" />
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    <p class="file_error<?php echo $item_id;?> text-danger"></p>
                                                </div>
                                            </div>
<div class="form-footer text-right">
                                            <div class='progress progress-line-success' id="progressFileDivId<?php echo $item_id;?>">
                                                <div class='progress-bar progress-bar-success' id='progressFileBar<?php echo $item_id;?>'>0%</div>
                                            </div>
                                            <button id="btn-upload" type="submit" class="btn btn-warning btn-fill">Upload</button>
                                        </div>
</form>
</div>
</div>
</div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end Files modal -->
</div>
                                            