<?php
$operators_array = ["+", "-", "*", "/", "(", ")", "a", "s", "c", "t"];
?>
    <div class="modal-body">
        <div class="row">
                    <div class="col-md-12">
                        <div class="material-datatables">
                                        <ul class="nav nav-pills nav-pills-success">
                                            <li class="active"><a href="#formulaTab" data-toggle="tab">Update Formula</a></li>
                                            <li><a href="#testFormulaEditTab" id="testFormulaTab" mode="Edit" data-toggle="tab">Test Formula</a></li>
                                            <?php if(in_array(80, $this->session->userdata("permissions"))) {?>
                                            <li><a href="#takeoffdataTab" data-toggle="tab">Add New Take Off Data</a></li>
                                            <?php } ?>
                                        </ul>
                                    	<div class="tab-content">
                                    	    <div class="tab-pane active" id="formulaTab">
                                                <div class="row">
                                                  <div class="col-md-12 update_formula_container">
                                                    <p class="existing_formula"><?php echo $formula_text;?></p>
                                                    <p class="formula-created" style="display:none">Formula Updated, Click "Next" to proceed</p>
                                                    <p class="formula-error" style="display:none">Please Update Formula</p>
                                        			<div id="updateoperator0" style="display:none;">
                                                      <label for="operator0">Operator</label>
                                                      <div class="form-group">
                                                        <select class="form-control" name="operator" id="operator0" my-check='updatesereal0'>
                                                          <option value="+">+</option>
                                                          <option value="-">−</option>
                                                          <option value="*">×</option>
                                                          <option value="/">÷</option>
                                                          <option value="(">(</option>
                                                          <option value=")">)</option>
                                                          <option value="a">&radic;</option>
                                                          <option value="s">sin</option>
                                                          <option value="c">cos</option>
                                                          <option value="t">tan</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                        			
                                        			<div id="updatetakeOffData0" style="display:none;">
                                                      <label for="takeoffdata0">Take Off Data Name</label>
                                                      <div class="form-group">
                                                        <select  name="takeoffdata" id="takeoffdata0" my-check='updatesereal0'>
                                                          <?php 
                                                          foreach ($takeoffdatas as $takeoffdata) {
                                        
                                                            ?>
                                                            <option tod_id='<?php echo $takeoffdata["takeof_id"]?>' value="<?php echo $takeoffdata["takeof_id"]?>" title="<?php echo $takeoffdata['takeof_name']; ?>"><?php echo $takeoffdata["takeof_name"]; ?></option>
                                                            <?php } ?>
                                                          </select>
                                                        </div>
                                                      </div>
                                                   
                                                    <div id="updatenumber0" style="display:none;">
                                                        <label for="takeoffdata_number0">Number</label>
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" id="takeoffdata_number0" name="takeoffdata_number" value="" my-check='updatesereal<?php echo $serealcount;?>'>
                                                        </div>
                                                      </div>
                                                    
                                                    <?php $formula_array = explode(",", $formula);
                                                    
                                                    $serealcount = 1;
                                                    
                                                    $has_operator = false;
                                                    $has_takeoffdata = false;
                                                    $has_number = false;
                                                    
                                                    $operator_num = 1;
                                                    $takeoffdata_num = 1;
                                                    $number_num = 1;
                                                    
                                                    for($i=0;$i<count($formula_array);$i++){
                                                        
                                                    if($formula_array[$i]!=""){
                                                    ?>
                                        
                                                    <?php if(in_array($formula_array[$i], $operators_array)){ 
                                                    $has_operator = true;
                                                    ?>    
                                                    <div id="updateoperator<?php echo $operator_num;?>" class="updateoperator">
                                                      <label for="operator<?php echo $operator_num;?>">Operator</label>
                                                      <div class="form-group">
                                                        <select class="form-control formula_field" name="operator" id="operator<?php echo $operator_num;?>" my-check='updatesereal<?php echo $serealcount;?>'>
                                                          <option value="+" <?php if($formula_array[$i]=="+"){ ?> selected <?php } ?> >+</option>
                                                          <option value="-" <?php if($formula_array[$i]=="-"){ ?> selected <?php } ?> >−</option>
                                                          <option value="*" <?php if($formula_array[$i]=="*"){ ?> selected <?php } ?> >×</option>
                                                          <option value="/" <?php if($formula_array[$i]=="/"){ ?> selected <?php } ?> >÷</option>
                                                          <option value="(" <?php if($formula_array[$i]=="("){ ?> selected <?php } ?> >(</option>
                                                          <option value=")" <?php if($formula_array[$i]==")"){ ?> selected <?php } ?> >)</option>
                                                          <option value="a" <?php if($formula_array[$i]=="a"){ ?> selected <?php } ?> >&radic;</option>
                                                          <option value="s" <?php if($formula_array[$i]=="s"){ ?> selected <?php } ?> >sin</option>
                                                          <option value="c" <?php if($formula_array[$i]=="c"){ ?> selected <?php } ?> >cos</option>
                                                          <option value="t" <?php if($formula_array[$i]=="t"){ ?> selected <?php } ?> >tan</option>
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <?php $operator_num++;
                                                    } ?>
                                                    <?php if(substr($formula_array[$i], 0, 1) == "|"){ 
                                                    $has_takeoffdata = true;
                                                    ?>
                                                    <div id="updatetakeOffData<?php echo $takeoffdata_num;?>" class="updatetakeOffData">
                                                      <label for="takeoffdata<?php echo $takeoffdata_num;?>">Take Off Data Name</label>
                                                      <div class="form-group">
                                                        <select class="selectpicker formula_field" data-live-search="true" data-style="select-with-transition" name="takeoffdata" id="takeoffdata<?php echo $takeoffdata_num;?>" my-check='updatesereal<?php echo $serealcount;?>'>
                                                          <?php 
                                                          foreach ($takeoffdatas as $takeoffdata) {
                                        
                                                            ?>
                                                            <option tod_id='<?php echo $takeoffdata["takeof_id"]?>' <?php if($formula_array[$i]=="|".$takeoffdata["takeof_id"]){ ?> selected <?php } ?>value="<?php echo $takeoffdata["takeof_id"]?>" title="<?php echo $takeoffdata["takeof_name"]; ?>"><?php echo $takeoffdata["takeof_name"]; ?></option>
                                                            <?php } ?>
                                                          </select>
                                                        </div>
                                                      </div>
                                                    <?php  $takeoffdata_num++;
                                                    } ?>
                                                    <?php if(is_numeric($formula_array[$i])){ 
                                                    $has_number = true;
                                                    ?>
                                                    <div id="updatenumber<?php echo $number_num;?>" class="updatenumber">
                                                        <label for="takeoffdata_number<?php echo $number_num;?>">Number</label>
                                                        <div class="form-group">
                                                          <input type="number" class="form-control formula_field" id="takeoffdata_number<?php echo $number_num;?>" name="takeoffdata_number" value="<?php echo $formula_array[$i];?>" my-check='updatesereal<?php echo $serealcount;?>'>
                                                        </div>
                                                      </div>
                                                    <?php $number_num++;
                                                    } ?>
                                                    <?php $serealcount++;} } ?>
                                                      <div id="updateformulavalue"> </div>
                                                      <span id="updateformulainput" style="display:none;"></span> <span id="updateformula" style="display:none;"></span> <span id="updateformulatext" class="label label-info" style="font-size:13px;"></span>
                                                      <div class="actions" style="min-height: 43px;margin-top:18px;">
                                                        <div class="col-md-12 no-padding">
                                                        <div class="col-md-4" style="padding-left: 0px;">
                                                          <button onclick="return update_addMoreoperators();" type="button" class="btn btn-sm btn-warning clone"> <i class="fa fa-plus-circle"></i> Add More Operators </button>
                                                        </div>
                                                        <div class="col-md-4" style="padding-left: 0px;">
                                                          <button onclick="return update_addMoreTakeoff();" style="margin-left:18px;" type="button" class="btn btn-sm btn-warning clone"> <i class="fa fa-plus-circle"></i> Add More Take Off Data</button>
                                                        </div>
                                                        <div class="col-md-4" style="padding-left: 0px;">
                                                          <button onclick="return update_addMoreNumber();" style="margin-left:50px;" type="button" style="margin-left:18px;" class="btn btn-sm btn-warning clone"> <i class="fa fa-plus-circle"></i> Add Number </button>
                                                        </div>
                                                        <div class="col-md-12 no-padding">
                                                            <div class="col-md-4" style="padding-left: 0px;">
                                                                <button onclick="return update_popup_remove_operator();" <?php if($has_operator == true){ ?> style="margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: block;" <?php } else{ ?>  style="margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" <?php } ?> type="button" class="btn btn-sm btn-danger remove_operator"> <i class="fa fa-close"></i> Remove Operator </button>
                                                            </div>
                                                            <div class="col-md-4" style="padding-left: 0px;">
                                                                <button onclick="return update_popup_remove_takeoff();" <?php if($has_takeoffdata == true){ ?> style="margin-left:18px;margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: block;" <?php } else{ ?>  style="margin-left:18px;margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" <?php } ?> type="button" class="btn btn-sm btn-danger remove_takeoff"> <i class="fa fa-close"></i> Remove Take Off Data</button>
                                                            </div>
                                                            <div class="col-md-4" style="padding-left: 0px;">
                                                                <button onclick="return update_popup_remove_number();" <?php if($has_number == true){ ?> style="margin-left:50px;margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: block;" <?php } else{ ?>  style="margin-left:50px;margin-top:10px;margin-right: 5px;margin-bottom: 10px; display: none;" <?php } ?> type="button" class="btn btn-sm btn-danger remove_number"> <i class="fa fa-close"></i> Remove Number </button>
                                                            </div>
                                                        </div>
                                        
                                                      </div>
                                        
                                                    </div>
                                        
                                                    <!-- /.col --> 
                                                  </div>
                                                </div>
                                                   <div class="modal-footer">
                                                      <input id="updatemodelnumber" value="1" type="hidden" name="modelnumber" />
                                                      <input id='updatemodelforrow' type='hidden' value='1' name='modelforrow'>
                                            		  <div class="checkbox" style="text-align:left;margin-left:10px;">
                                            		  <label><input type="checkbox" name="is_rounded" id="is_rounded_update" value="1" <?php if($is_rounded==1){ ?> checked <?php } ?>>Rounded up to a whole integer</label>
                                                      </div>
                                            		  <button class="btn btn-sm btn-warning" data-dismiss="modal" style="margin-top:10px;">Next</button>
                                                      <button class="btn btn-success btn-sm" onclick="return GetUpdateFormula();" style="margin-top:10px;">Save changes</button>
                                                    </div>
                                            </div>
                                            <div class="tab-pane" id="testFormulaEditTab">
                                    	        <div class="row">
                                    	            <div class="col-md-12">
                                    	                <div id="computedFormulaTextEdit" class="label label-info"></div>
                                    	                <div style="font-size:13px;margin-top:15px;">Formula Results: <span id="computedFormulaEdit"></span></div>
                                    	                <form id="testFormulaFormEdit" method="post" action="">
                                        	                <table class="table">
                                                                <tbody>
                                                                        <tr class="actionRow">
                                                                            <td colspan="2" style="text-align: center"><a href="javascript:void(0)" class="btn btn-warning" onclick="testFormula('Edit')">Test Formula</a></td>
                                                                       
                                                                        </tr>
                                                                </tbody>
                                                        
                                                            </table>
                                                        </form>
                                    	            </div>
                                    	        </div>
                                    	    </div>
                                            <div class="tab-pane" id="takeoffdataTab">
                                                <form id="updateTakeoffdataForm" method="POST" action="">
                                                    <div class="card-content">
                                                        <div class="col-md-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    Take off Data Name
                                                                    <small>*</small>
                                                                </label>
                                                                <input class="form-control" type="text" name="name" id="name" required="true" uniqueTakeoffdata="true" value="<?php echo set_value('name')?>"/>
                                                                <?php echo form_error('name', '<div class="custom_error">', '</div>'); ?>
                    					                    </div>
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    Take off Data Description
                                                                </label>
                                                                <textarea class="form-control" name="description" id="description"><?php echo set_value('description')?></textarea>
                                                                <?php echo form_error('description', '<div class="custom_error">', '</div>'); ?>
                    					                    </div>
                                                            <div class="form-group label-floating">
                                								<select class="selectpicker" data-style="select-with-transition" title="Status *" data-size="7" name="takeof_status" id="takeof_status" required="true">
                                                                    <option disabled> Choose Status</option>
                                									<option value="1" selected>Current</option>
                                									<option value="0">Inactive</option>
                                                                </select>
                                                            </div>
                    										
                                                            <div class="form-footer text-right">
                                                                <?php if(in_array(80, $this->session->userdata("permissions"))) {?>
                                                                <button type="button" class="btn btn-warning btn-fill add-takeoffdataBtn">Add</button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                        </div>
                    </div>
        </div>
    </div>