<table id="credit_notes_table" class="table table-bordered table-striped table-hover" style="text-align:left;">
		        		<thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Supplier Credit #</th>
                            <th>Project Name</th>
                            <th>Supplier Name</th>
                            <th>Supplier Credit Refrence</th>
                            <th>Credit Amount</th>
                            <th>Credit Date</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                       </thead>
		        		<tbody>
                        <?php $count = 1;
                        
                        foreach ($credit_notes as $p => $po) { ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $po['id']; ?></td>
                                <td><?php echo $project_info["project_title"]; ?></td>
                                
                                <td><?php echo $po['supplier_name']; ?></td>
                                <td><?php echo $po['supplierrefrence']; ?></td>
                                <td><?php echo number_format($po['invoice_amount'],2,'.',''); ?></td>
                                <td><?php echo date("d-M-Y", strtotime(str_replace("/", "-", $po['invoice_date']))); ?></td>
                                 
                                <td><?php echo date("d-M-Y", strtotime($po['created_date'])); ?></td>
                                <td>
                                    
                                    
                                    <?php if ($po['status'] == "Pending") { 
                                    ?><span class="label label-danger"><?php echo $po['status'];?> </span>
                                    <?php } if ($po['status'] == "Approved") { 
                                    ?><span class="label label-info"><?php echo $po['status'];?> </span>
                                    <?php } if ($po['status'] == "Allocated") { 
                                    ?><span class="label label-success"><?php echo $po['status'];?> </span>
                                    <?php } ?>
                               
                                </td>
                                <td  class="text-right">
                                    <a target="_Blank" href="<?php echo SURL.'supplier_credits/viewcredit/' . $po['id'] ?>" class="btn btn-simple btn-icon btn-warning"><i class="material-icons">edit</i></a>

                                </td>
                            </tr>
                            <?php $count++;
                        } ?>
                    </tbody>
		        		</table>