<table id="completedJobsCashTransfers" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        							<thead>
                                        								<tr>
                                        									<th>S.No</th>
                                                                            <th>Cash Transfer #</th>
                                                                            <th>Project Name</th>
                                                                            <th>Supplier Name</th>
                                                                            <th>Transfer Amount</th>
                                                                            <th>Comment</th>
                                                                            <th>Created Date</th>
                                                                            <th>Actions</th>
                                        								</tr>
                                        							</thead>
                                        							<tbody>
<?php $count = 1;
                        
                        foreach ($cash_transfers as $key => $val) { ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $val['id']; ?></td>
                                <td><?php echo $val['project_title']; ?></td>
                                
                                <td><?php echo $val['supplier_name']; ?></td>
                                <td><?php echo number_format($val['transfer_amount'],2,'.',''); ?></td>
                                <td><?php echo $val['comment']; ?></td>
                                <td><?php echo date("d-M-Y", strtotime($val['created_date'])); ?></td>
                                <td class="text-right">
                                    <a class="btn btn-warning btn-icon btn-simple" href="<?php echo SURL;?>cash_transfers/view_cash_transfer/<?php echo $val['id'];?>"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                            <?php $count++;
                        } ?>
                        </tbody>
                </table>