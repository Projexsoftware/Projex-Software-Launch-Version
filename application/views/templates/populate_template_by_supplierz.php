 <table id="dataTableTemplates" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Supplier Name</th>
                                                    <th>Template Name</th>
                                                    <th>Template Description</th>
                                                    <th>Status</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                             <tbody>
                                            <?php  $count =1; if(isset($templates)){ foreach($templates as $templ) { 
                                                $template_request_info = get_template_request_info($templ->template_id);
                                            ?>
                                                <tr>
                                                    <td><?php echo $count;?></td>
                                                    <td><?php echo $templ->com_name;?></td>
                                                    <td><?php echo $templ->template_name;?></td>
                                                    <td><?php echo substr($templ->template_desc,0,100);?></td>
                                                    <td><?php if(count($template_request_info)>0 && $template_request_info['status']==0){?>
                                                    <span class="label label-warning">Request Sent</span>
                                                    <?php } else if(count($template_request_info)>0 && $template_request_info['status']==1){?>
                                                    <span class="label label-success">Request Approved</span>
                                                    <?php } else if(count($template_request_info)>0 && $template_request_info['status']==-1){?>
                                                    <span class="label label-danger">Request Declined</span>
                                                    <?php } else if(count($template_request_info)>0 && $template_request_info['status']==2){ ?> 
                                                    <span class="label label-success">Imported</span> <?php } else{?><span class="label label-danger">Not Sent Yet</span> 
                                                    <?php } ?></td>
                                                    <td class="text-right">
                                                    <?php $is_request_sent = is_request_sent($templ->template_id);
                                                    if($is_request_sent==0){
                                                    ?>
                                                    <input type="submit" id="sendRequestBtn" class="btn btn-success btn-sm" value="Send Request" onclick="select_template(<?php echo $templ->template_id;?>, <?php echo $templ->supplier_id;?>);"/>
                                                    <?php } else{
                                                    if(count($template_request_info)>0 && $template_request_info['status']==1){ ?>
                                                    <a href="<?php echo SURL;?>setup/import_supplierz_template/<?php echo $templ->template_id;?>" class="btn btn-success btn-sm">Import</a>
                                                    
                                                    <?php } else if(count($template_request_info)>0 && $template_request_info['status']==2){?>
                                                    <a target="_Blank" href="<?php echo SURL;?>setup/edit_template/<?php echo $template_request_info['imported_template_id'];?>" class="btn btn-success btn-sm">View</a>
                                                    <?php } } ?>
                                                    </td>
                                                </tr>
                                            <?php $count++;} }?>
                                            </tbody>
                                        </table>