                                                <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td><b>Project Log</b></td>
                                                                <td colspan="4"><center><b><?php echo $project_name;?></b></center></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Date</b></td>
                                                                <td><b>User</b></td>
                                                                <td><b>Entity Type</b></td>
                                                                <td><b>Notes</b></td>
                                                                <td><b>Image</b></td>
                                                            </tr>
                                                        </thead>
                                                         <tbody class="project-logs-container">
                                                             <?php 
                                                                if(count($project_logs)>0){
                                                                foreach($project_logs as $val){ ?>
                                                                <tr>
                                                                    <td><?php echo date("d/m/Y", strtotime($val['date']));?></td>
                                                                    <td><?php echo get_user_name($val["user_id"]);?></td>
                                                                    <td><?php echo $val['entity_type'];?></td>
                                                                    <td><?php echo $val['notes'];?></td>
                                                                    <td align="center">
                                                                     <?php if($val['image']!=""){ ?>
                                                                      <img style="width:200px;height:150px;" src="<?php echo SURL.'assets/scheduling/project_logs/'.$val['image'];?>"> 
                                                                      <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php } } else{ ?>
                                                                <tr><td colspan="5">No Project Logs Found!</td></tr>
                                                                <?php } ?>
                                                         </tbody>
                                                     </table>
                                                     <?php if(count($project_logs)>0){?>
                                                        <form action="<?php echo SCURL.'reports/export';?>" method="post">
                                                            <input type="hidden" name="project_id" value="<?php echo $project_id;?>">
                                                            <input type="hidden" name="project_start_date" value="<?php echo $from;?>">
                                                            <input type="hidden" name="project_end_date" value="<?php echo $to;?>">
                                                            <input type="hidden" name="summary_type" value="log">
                                                            <input type="submit" class="btn btn-rose" value="Export As PDF">
                                                        </form>
                                                     <?php } ?>


                                                        
                                                   