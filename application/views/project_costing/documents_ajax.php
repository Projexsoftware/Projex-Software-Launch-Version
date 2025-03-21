<?php if(count($plans_and_specifications)>0){ foreach($plans_and_specifications as $val){ ?>
						            <tr class="row_<?php echo $val["id"];?>">
						                <td><input id="<?php echo $val["id"];?>" type="checkbox" name="selected_items[]" value="<?php echo $val["id"];?>" class="selected_items">
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
						    <?php }  ?>
						    <tr>
						                <td colspan="4">
						                    <a class="btn btn-primary set_as_private btn-sm"><i class="fa fa-lock"></i> Set As Private</a>
						                    <a class="btn btn-warning set_as_share btn-sm" style="margin-left:15px;"><i class="fa fa-share"></i> Set As Share</a>
						                    <a class="btn btn-danger delete_all btn-sm" style="margin-left:15px;"><i class="material-icons">delete</i> Delete All</a>
						                </td>
						            </tr>
						   <?php }else{?>
						   <tr>
						                <td colspan="4">
						                    <h6>No Documents Found</h6>
						                </td>
						            </tr>
						   <?php } ?>