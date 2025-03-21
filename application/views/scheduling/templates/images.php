<div id="images_container<?php echo $item_id;?>">
<?php $task_images = get_template_task_images($template_id, $item_id);?>
<a class="btn btn-info btn-round" data-toggle="modal" data-target="#addImageModal<?php echo $item_id;?>">Images <span class="badge count<?php echo $item_id;?>"><?php echo count($task_images);?></span>
                                       <b class="caret"></b></a>
                                        <!-- Images modal -->
                                            <div class="modal fade" id="addImageModal<?php echo $item_id;?>" tabindex="-1" role="dialog" aria-labelledby="myImageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
<h5 class="modal-title" id="myImageModalLabel"><?php echo get_task_name($task_id);?> Images</h5>                                                        </div>
                                                        <div class="modal-body">
                                                        <?php if(count($task_images)>0){ ?>
                                                        <div class="row">
                                                        <?php foreach($task_images as $val){ ?>
                                                        <div class="col-md-6">
                                                        <div class="card card-product">
                                <div class="card-image" data-header-animation="true">
                                       <a href="#pablo">
                                            <img class="img" src="<?php echo TEMPLATE_TASK_PATH.'images/'.$val['file'];?>">
                                       </a>
                                </div>
                                <div class="card-content">
                                    <div class="card-actions">
                                       <a rel="tooltip" data-placement="bottom" title="Download" class="btn btn-success btn-simple btn-icon" href="<?php echo SURL;?>buildz/templates/download_image/<?php echo $val['file'];?>"><i class="material-icons">file_download</i></a>
                                       <span rel="tooltip" data-placement="bottom" title="Delete" rowno="<?php echo $item_id;?>" id="<?php echo $val['id'];?>" class="remove_image btn btn-simple btn-danger btn-icon"><i class="material-icons">close</i></span>
                                    </div>
                                    <h4 class="card-title"><?php echo $val["description"];?></h4>
                                </div>
                            </div>
                            </div>
                            <?php } ?>
                                                        </div>
                                                        <?php }?>
<div class="card">
                                <div class="card-header card-header-icon" data-background-color="blue">
                                    <i class="material-icons">attach_file</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Upload New Image</h4> 
                                    <div class="toolbar">
<form rowno="<?php echo $item_id;?>" class="upload_task_image" name="ImagesForm<?php echo $item_id;?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="image_item_id" value="<?php echo $item_id;?>">
<input type="hidden" name="image_template_id" value="<?php echo $template_id;?>">
                                                <div class="form-group label-floating">
												<input class="form-control" type="text" name="image_description" id="image_description<?php echo $item_id;?>" value="" placeholder="Image Description"/>
											    <p class="image_description_error<?php echo $item_id;?> text-danger"></p>
											    </div>
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-info btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" id="task_image<?php echo $item_id;?>" name="task_image" />
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    <p class="image_error<?php echo $item_id;?> text-danger"></p>
                                                </div>
                                            </div>
<div class="form-footer text-right">
                                            <div class='progress progress-line-success' id="progressDivId<?php echo $item_id;?>">
                                                <div class='progress-bar progress-bar-success' id='progressBar<?php echo $item_id;?>'>0%</div>
                                            </div>
                                            <button id="btn-upload-image<?php echo $item_id;?>" type="submit" class="btn btn-info btn-fill">Upload</button>
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
                                            