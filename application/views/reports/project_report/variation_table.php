<table <?php if($type=="normal"){ ?> id="partstable" <?php } else if($type=="suppinvo"){ ?> id="partstable2" <?php } else if($type=="supcredit"){ ?> id="partstable4" <?php } else{ ?> id="partstable3" <?php } ?>class="table table-bordered table-striped table-hover">
		        		<thead>
		        			<th>No</th>
                            <th>Project Name </th> 
                            <th>Variation Number </th> 
                            <th>Variation Subtotal </th>
							<th>Variation Contract Price </th>
                            <th>Initiated Version</th>
                            <th>Variation Description</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th class="disabled-sorting text-right">Actions</th>
		        		</thead>
		        		<tbody>
		        		    <?php if(isset($variations) && count($variations)>0){ ?>
		        		    <?php $count = 1;
                        foreach ($variations as $project) { ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $project->project_title; ?></td>
                                <td><?php echo $project->var_number; ?></td>
                                <td><?php echo '$'.number_format((($project->project_subtotal1)*($project->tax/100))+$project->project_subtotal1,2, '.', ''); ?></td>
								<td><?php echo '$'.number_format($project->project_contract_price,2, '.', ''); ?></td>
                                <td><?php echo $project->variation_name; ?></td>
                                <td><?php echo $project->variation_description; ?></td>
                                <td><?php echo date("d-M-Y", strtotime($project->created_date)); ?></td>
                                <td><?php if ($project->status == "PENDING") { 
                                    ?><span class="label label-danger">
                                    <?php } if ($project->status == "ISSUED") { 
                                    ?><span class="label label-warning">
                                    <?php } if ($project->status == "APPROVED") { 
                                    ?><span class="label label-info">
                                    <?php } if ($project->status == "SALES INVOICED") { 
                                    ?><span class="label label-primary">
                                    <?php } if ($project->status == "PAID") { 
                                    ?><span class="label label-success">
                                    <?php } ?>
                                    <?php echo $project->status ?> </span>
                                        
                                    <?php if ($project->var_type == "purord") { 
                                    ?>&nbsp;<span class="label label-primary"> <?php echo 'From Purchase Order'; ?> </span>
                                    <?php } ?>
                                    <?php if ($project->var_type == "supcredit") { 
                                    ?>&nbsp;<span class="label label-info"> <?php echo 'From Supplier Credit' ?> </span>
                                    <?php } ?>
                                        
                                </td>
                               <td class="text-right">
                                    <a target="_Blank" href="<?php echo base_url(); ?>project_variations/view_variation/<?php echo $project->id; ?>" class="btn btn-simple btn-icon btn-warning"><i class="material-icons">edit</i></a>

                                </td>




                            </tr>
    <?php $count++;
} ?>
		        		    <?php }
		        		    ?>
		        		    
		        		    
		        		</tbody>
		        		</table>