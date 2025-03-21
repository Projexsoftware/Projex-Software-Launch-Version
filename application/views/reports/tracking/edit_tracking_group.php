<div id="row">
    <div class="col-md-12">
        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">report</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Update Tracking Report</h4> 
                                    <div class="toolbar">
                                        <?php
										if ($this->session->flashdata('err_message')) {
											?>
											<div class="alert alert-danger">
												<?php echo $this->session->flashdata('err_message'); ?>
											</div>
											<?php
										}

										if ($this->session->flashdata('ok_message')) {
											?>
											<div class="alert alert-success alert-dismissable">
												<?php echo $this->session->flashdata('ok_message'); ?>
											</div>
											<?php
										}
										?>
									</div>
									<div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                    </div>
                                    <form id="trackingForm" method="post" action="<?php echo base_url('reports/update_tracking_report/'.$tracking_item["id"]);?>" onsubmit="return validateForm()">
                                        <input type="hidden" name="tracking_report_id" id="tracking_report_id" value="<?php echo $tracking_item["id"];?>">
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Tracking Report Name <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $tracking_item["title"];?>" required uniqueEditTrackingReport="true">
                                                                <?php echo form_error('title', '<div class="custom_error">', '</div>'); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group label-floating col-md-12">
                                                            <label class="col-md-3 label_with_selectpicker">Select Project Costing for Tracking <small>*</small></label>
                                                            <div class="col-md-9">
                                                                <select class="selectpicker" data-style="select-with-transition" name="project_id" id="project_id" title="Select Project" data-live-search="true" required disabled>
                                                                 <?php foreach ($projects as $project) { ?>
                                                                <option value="<?php echo $project["project_id"]; ?>" <?php if($tracking_item["project_id"]==$project["project_id"]){ ?> selected <?php } ?> ><?php echo $project["project_title"]; ?></option>
                                                                <?php } ?>
                                                                </select>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">          
                                                    	<div id='newcdiv'>
                <div class="panel panel-default table-responsive">
                    <div class="table-responsive" >

                         <table id="partstable" class="table table-bordered table-striped table-hover">
                            <thead>
                              <tr>
                                <th><div class="checkbox"><label><input type="checkbox" class="select_all"></label></div></th>
                                <th>Stage</th>
                                <th>Part</th>
                                <th>Component</th>
                                <th>Supplier</th>
                                <th>QTY</th>
                                <th>Unit Of Measure</th>
                                <th>Unit Cost</th>
                                <th>Line Total</th>
                                <th>Margin %</th>
                                <th>Line Total with Margin</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $count = $counter + 1; ?>
<?php
//echo "<pre>";
//print_r($prjprts); exit;
?>
<?php 
$costing_parts_id = explode(",", $tracking_item["costing_part_ids"]); 
foreach ($prjprts As $key => $val) { 
$updated_quantity = get_recent_quantity($val->costing_part_id);

if(count($updated_quantity)>0){
       // if($updated_quantity['total']==$updated_quantity['updated_quantity'] && $updated_quantity['available_quantity']>0){
            if($updated_quantity['total']==$updated_quantity['updated_quantity']){
              $updated_quantity['total'] = 0;  
            }
            /*if($updated_quantity['available_quantity']==0){
                $costing_quantity = $updated_quantity['total'];
            }*/
            else{
                $costing_quantity = $val->costing_quantity+$updated_quantity['total'];
            }
}
else if(count($updated_quantity)==0 && $val->is_variated==1){
    $costing_quantity=0;
}
else{
   $costing_quantity = $val->costing_quantity;
}

?>

<tr id="trnumber<?php echo $count ?>" tr_val="<?php echo $count ?>">
    <td><div class="checkbox"><label><input type="checkbox" onclick="select_part()" name="select[]" id="select_<?php echo $count ?>" value="1" rno ='<?php echo $count ?>' class="selected_items" <?php if(in_array($val->costing_part_id, $costing_parts_id)){ ?> checked <?php } ?>/></label><input type="hidden" name="is_selected[]" value="0"></td>
    <td>
        <input type="hidden" name="costing_part_id[]" id="costing_part_id_<?php echo $count ?>" value="<?php echo $val->costing_part_id;?>" />
        <?php echo $val->stage_name;?>
        <input type="hidden" value="<?php echo $val->stage_id;?>" id="selectedstagefield<?php echo $count ?>">
    </td>

    <td>
        <?php echo $val->costing_part_name ?>
        <input type="hidden" name="part[]" id="partfield<?php echo $count ?>" value="<?php echo $val->costing_part_name ?>" rno ='<?php echo $count ?>' class="form-control" /></td>
    <td>
     <?php echo $val->component_name;?>
   <input type="hidden" value="<?php echo $val->component_id;?>" id="selectedcomponentfield<?php echo $count ?>">

</td>
<td>
   <?php echo $val->supplier_name;?>
<input type="hidden" value="<?php echo $val->costing_supplier;?>" id="selectedsupplierfield<?php echo $count ?>">
</td>   
        <td>
            <div class="manualfield" id="manualfield<?php echo $count ?>">
                <?php echo $costing_quantity ?>
                <input  name="manualqty[]" rno ='<?php echo $count ?>' id="manualqty<?php echo $count ?>" type="hidden" name="" class="qty form-control" value="<?php echo $costing_quantity ?>"/>
            </div>
            
        </td>

        <td>
            <?php echo $val->costing_uom; ?><input type="hidden" name="uom[]" id="uomfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $val->costing_uom; ?>" class="form-control" width="5" /></td>
        <td><?php echo number_format($val->costing_uc,2,'.',''); ?><input type="hidden" name="ucost[]" id="ucostfield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" value="<?php echo number_format($val->costing_uc,2,'.',''); ?>"></td>
        <td><?php echo number_format((float) $costing_quantity * (float) $val->costing_uc,2,'.',''); ?><input type="hidden" name="linttotal[]"  rno ='<?php echo $count ?>' id="linetotalfield<?php echo $count ?>" class="form-control" value="<?php echo number_format((float) $costing_quantity * (float) $val->costing_uc,2,'.',''); ?>"></td>


        <td>
            <?php echo number_format($val->margin,2,'.',''); ?><input type="hidden" name="margin[]" id="marginfield<?php echo $count ?>" rno ='<?php echo $count ?>' class='form-control' value='<?php echo number_format($val->margin,2,'.',''); ?>'>

        </td>
        <td>
            <?php echo number_format(($val->margin+((float)$costing_quantity * (float) $val->costing_uc)),2,'.',''); ?>
            <input type="hidden" name="margin_line[]"  rno ='<?php echo $count ?>' id="margin_linefield<?php echo $count ?>" class="form-control" value="<?php echo number_format(($val->margin+((float)$costing_quantity * (float) $val->costing_uc)),2,'.',''); ?>" /></td>
<td class="text-right">
   <!--  <a style="display:inline;float: left;" href="#" id="iconlock<?php echo $count ?>" rno ='<?php echo $count ?>' onclick="changeLockStatus(this.getAttribute('rno'))"><i class="fa fa-unlock"></i></a> -->
    <input type="hidden" name="is_line_locked[]" id="linelock<?php echo $count ?>" value="0">
    <ahref="javascript:void(0)" rno ='<?php echo $count ?>' class='deleterow btn btn-danger btn-simple btn-icon'><i class="material-icons">delete</i></a>
    <!-- <a title="_stage_<?php echo $count ?>" style="display:none;float: left;margin-left: 10px;" class="btn btn-primary btn-small" id="model<?php echo $count ?>" data-toggle="modal" role="button" href="#simpleModal" rno ='<?php echo $count ?>' onclick="return modelid(this.title, this.getAttribute('rno'));"><span <?php if (strtolower($val->quantity_type) == "formula" && $val->quantity_formula_text) { ?> data-toggle="tooltip" title="<?php echo str_replace('Formula : ', '', $val->quantity_formula_text);?>"
        
        <?php } ?>>f</span></a> -->
    </td>
</tr>
<?php $count ++ ?>
<?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">Total</td>
                                     <td colspan="4" id="total_count">0</td>
                                </tr>
                            </tfoot>
                          </table>                           
                    </div>

                </div>

            </div>
            <div class="row" style="margin-bottom:15px;">
            <div class="form-group col-lg-12">             
             
              <div class="col-lg-4 ">
                <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $tracking_item["total_amount"];?>" />
                 <input type="hidden" name="selected_costing_parts" id="selected_costing_parts" value="<?php echo $tracking_item["costing_part_ids"];?>" />
                <button type="submit" class="btn btn-success">Update Tracking Report</button>
                <!-- <a href="<?php //echo base_url('reports/re_tracking_report');?>" class="btn btn-success">View Report</a> -->
              </div>
            </div>
        </div>
                                                </div>
                                        </div>
                                    </form>
                                        
                                </div>
		</div>
    </div>
</div>
