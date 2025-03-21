<table class="table table-bordered table-striped table-hover">
                        <thead>
                            <th><input class="select_all" type="checkbox"></th>
                            <th>Stage</th>
                            <th>Part</th>
                            <th>Component</th>
                            <?php if($type!="checklist"){ ?>
        	    			<th>Document</th>
        	    			<?php } else{ ?>
        	    			<th>Checklist</th>
        	    			<?php } ?>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>

                            <?php 
                            if(count($prjprts)>0){
                            foreach ($prjprts As $key => $prjprt) {
                           
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
                                <?php if($type=="checklist"){ ?>
                               
                               <?php 
                                                $checklists = get_checklist_items_for_builders($prjprt->component_id);

                                                $existing_checklist = "";
                                                if(count($checklists)>0){
                                                ?>
                                                <ul style="margin-left:25px;">
                                                <?php
                                                    foreach($checklists as $checklist){ 
                                                    $existing_checklist .=$checklist['checklist'].",";
                                                  ?>
                                                      <li checklist="<?php echo $checklist['checklist'];?>"><?php echo $checklist['checklist'];?></li>
                                                  <?php } ?>
                                                  </ul>
                                                  <?php
                                                   } 
                                    
                                } else {
                                 $component_document = is_component_have_documents($prjprt->component_id, $type);
                                                  ?>
                                <?php if($type=="specification" && $component_document["specification"]!=""){ ?>
                                
                                <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/specification/<?php echo $component_document["specification"];?>"><?php echo $component_document["specification"];?></a>
                         
                               <?php $fileextension= explode(".", $component_document["specification"]);
                                   if($fileextension[1]=="pdf"){
                                   ?>
                                   <br/><br/>
                                   <iframe src="<?php echo SURL;?>assets/component_documents/specification/<?php echo $component_document["specification"];?>" style="width:718px; height:400px;" frameborder="0"></iframe>
                               <?php } } else if($type=="warranty" && $component_document["warranty"]!=""){ ?>
                                   <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/warranty/<?php echo $component_document["warranty"];?>"><?php echo $component_document["warranty"];?></a>
                               <?php $fileextension= explode(".", $component_document["warranty"]);
                                   if($fileextension[1]=="pdf"){
                                   ?>
                                   <br/><br/>
                                   <iframe src="<?php echo SURL;?>assets/component_documents/warranty/<?php echo $component_document["warranty"];?>" style="width:718px; height:400px;" frameborder="0"></iframe>
                               <?php } } else if($type=="installation" && $component_document["installation"]!=""){ ?>
                                   <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/installation/<?php echo $component_document["installation"];?>"><?php echo $component_document["installation"];?></a>
                                 <?php $fileextension= explode(".", $component_document["installation"]);
                                   if($fileextension[1]=="pdf"){
                                   ?>
                                   <br/><br/>
                                   <iframe src="<?php echo SURL;?>assets/component_documents/installation/<?php echo $component_document["installation"];?>" style="width:718px; height:400px;" frameborder="0"></iframe>
                               <?php } } else if($type=="maintenance" && $component_document["maintenance"]!=""){ ?>
                                   <a target="_Blank" href="<?php echo SURL;?>assets/component_documents/maintenance/<?php echo $component_document["maintenance"];?>"><?php echo $component_document["maintenance"];?></a>
                               
                               <?php $fileextension= explode(".", $component_document["maintenance"]);
                                   if($fileextension[1]=="pdf"){
                                   ?>
                                   <br/><br/>
                                   <iframe src="<?php echo SURL;?>assets/component_documents/maintenance/<?php echo $component_document["maintenance"];?>" style="width:718px; height:400px;" frameborder="0"></iframe>
                               <?php }
                               } } ?>
                            </td> 
                        </tr>
                        <?php $count ++ ?>         
                        <?php } } else{ ?>
                        <?php if($type!="checklist"){ ?>
                        <tr><td colspan="5">No Documents Found</td></tr>
                        <?php } else{ ?>
                        <tr><td colspan="5">No Checklist Found</td></tr>
                        <?php } } ?>
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