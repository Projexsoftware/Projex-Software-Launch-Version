<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%" >
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Component Image</th>
                <th>Component Name</th>
                <th>Description</th>
                <th>Unit of Measure</th>
                <th>Unit Cost</th>
                <th>Date</th>
            </tr>
            </thead>
                                                                   
            <tbody>
                                                                
                <?php 
                    if (count($supplier_components) > 0) {
                ?>
                <?php  
                $count =1; 
                foreach($supplier_components as $supplier_component) { ?>
                    <tr>
                        <td><?php echo $count;?></td>
                        <td><img style="width:50px!important;height:50px!important;" src="<?php if($supplier_component['image']!="") { echo COMPONENT_IMG.$supplier_component['image']; } else{ echo IMG.'image_placeholder.jpg'; }?>" class="img" /></td>
                        <td><?php echo $supplier_component['component_name'];?></td>
                        <td><?php echo $supplier_component['component_des'];?></td>
                        <td><?php echo $supplier_component['component_uom'];?></td>
                        <td><?php echo $supplier_component['component_uc'];?></td>
                        <td><?php echo date("d/M/Y", strtotime($supplier_component['date_created']));?></td>
                    </tr>
                    <?php $count++;
                    } 
                } else { ?>
                    <tr>
                        <td colspan="7"><?php echo 'No Components found for this supplier';?></td>
                    </tr>
                <?php } ?>
                                                                    
        </tbody>
</table>
<?php if($supplier_components){ ?>
<div class="row">
    <div class="col-md-12">
     <div class="form-footer">
        <form id="" name="" action="<?php echo base_url(); ?>reports/export_supplier_components" method="post" class="print">
            <a href="javascript:window.print()" class="btn btn-success no_print">Print</a>
            <input type="hidden" id="report_type" name="report_type" value="">
            <input type="hidden" id="report_supplier_id" name="report_supplier_id" value="">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To Excel" onclick="changeComponentReportType('excel');">
            <input class="btn btn-success no_print" type="submit" id="" name="" value="Export To PDF" onclick="changeComponentReportType('pdf');">
        </form>
    </div>
</div>
</div>
<?php } ?>