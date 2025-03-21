<table id="sales_credits_table" class="table table-striped dataTable" style="text-align:left;">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Sales Credit #</th>
                            <th>Project Name</th>
                            <th>Reference</th>
                            <th>Subtotal</th>
                            <th>Tax Type</th>
                            <th>Tax</th>
                            <th>Total</th>
                            <th>Date</th>
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
                                <td><?php echo $po['project_title']; ?></td>
                                <td><?php echo $po['reference']; ?></td>
                                <td><?php echo number_format($po['subtotal'],2,'.',''); ?></td>
                                <td><?php echo $po['tax_type']; ?></td>
                                <td><?php echo number_format($po['tax'],2,'.',''); ?></td>
                                <td><?php echo number_format($po['total'],2,'.',''); ?></td>
                                <td><?php echo date("d-M-Y", strtotime(str_replace("/", "-", $po['date']))); ?></td>
                                 
                                <td><?php echo date("d-M-Y", strtotime($po['created_date'])); ?></td>
                                <td>
                                    <?php if ($po['status'] == "Pending") { 
                                    ?><span class="label label-danger"><?php echo $po['status'];?></span>
                                    <?php } if ($po['status'] == "Approved") { 
                                    ?><span class="label label-info"><?php echo $po['status'];?></span>
                                    <?php } if ($po['status'] == "Allocated") { 
                                    ?><span class="label label-success"><?php echo $po['status'];?></span>
                                    <?php } 
                                  ?>
                                </td>
                                <td class="text-right">
                                    <a target="_Blank" href="<?php echo base_url() . 'sales_credits_notes/viewsalescreditnote/' . $po['id'] ?>" class="btn btn-simple btn-icon btn-warning"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                            <?php $count++;
                        } ?>
                    </tbody>
                </table>