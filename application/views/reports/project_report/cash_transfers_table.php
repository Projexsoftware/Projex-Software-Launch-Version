<table id="cash_transfers_table" class="table table-bordered table-striped table-hover dataTable">
		        		<thead>
                        <tr>
                            <th>Cash Transfer #</th>
                            <th>Supplier Name</th>
                            <th>Transfer Amount</th>
                            <th>Comment</th>
                            <th>Created Date</th>
                            <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                       </thead>
		        		<tbody>
		        		    <?php if(count($cash_transfers)>0){ ?>
		        		    <?php $count = 1;
                        foreach ($cash_transfers as $key => $val) { ?>
                            <tr>
                                <td><?php echo $val['id']; ?></td>
                                <td><?php echo $val['supplier_name']; ?></td>
                                <td><?php echo number_format($val['transfer_amount'],2,'.',''); ?></td>
                                <td><?php echo $val['comment']; ?></td>
                                <td><?php echo date("d-M-Y", strtotime($val['created_date'])); ?></td>
                                <td class="text-right">
                                    <a target="_Blank" class="btn btn-simple btn-icon btn-warning" href="<?php echo SURL.'cash_transfers/view_cash_transfer_details/' . $val['id'] ?>"><i class="material-icons">edit</i></a>
                                </td>
                            </tr>
    <?php $count++;
} 
}
?>
		        		   
		        		    
		        		</tbody>
		        		</table>