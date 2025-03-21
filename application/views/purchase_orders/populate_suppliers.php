<?php $count = 1; ?>
<?php $populateany=false; 
  $testing = array();
?>

<?php foreach ($porder AS $key => $val): ?>

<?php $suppid = $val['costing_supplier']; $suppidcheck=0;?>
<?php $stages_curr = $val['stages']; ?>
	<?php $count = count($stages_curr);?>
	<?php foreach ($stages_curr AS $st => $stg): ?>
	<?php $stageid = $stg['stage_id'];?>
		<?php $populate=false; ?>
		<?php $parts = $stg['parts']; 

 
		?>
		<?php 
		foreach ($parts AS $pt => $pts): ?>
			<?php
			if($pts['costing_quantity']!= $pts['ordered_quantity']){

				if($suppidcheck === 0){
					            $sup_id = $val['costing_supplier']."_".$stg['stage_id'];

                                if(!(in_array($sup_id, $testing))){
					            $testing[] = $sup_id;
                                ?>
                                <input type="hidden" name="suppliers[]" value="<?php echo $val['costing_supplier'] ?>">
                                <input type="hidden" name="mstage<?php echo $val['costing_supplier'].'[]'?>" value="<?php echo $stg['stage_id']?>">
                                <?php
                               }
                                }
                           
                            	if($count==1){
                        
                                    $suppidcheck++;
                                }    
                           
                                $populate=true;
			
                                $populateany=true;
                         
                        }
  			    
			?>
			
		<?php endforeach; ?>
	
		<?php
		if(!$populate)
			continue;
		?>
	
	
	
		<input type="hidden" name="<?='stagesupplier'.$suppid.$stageid.'[]'?>" value="<?= $val['costing_supplier']?>">
		<input type="hidden" name="<?='stage_id'.$suppid.$stageid.'[]'?>" value="<?= $stg['stage_id']?>">
	
		<table id="partstable" class="table table-no-bordered">
			<thead>
			    <tr>
			        <td colspan="10"><?= $val['supplier_name'] ?></td>
			    </tr>
			     <tr>
			        <td colspan="10">	<?= $stg['stage_name'] ?></td>
			    </tr>
				<tr>
					<th>Stage</th>
					<th>Part</th>
					<th>Component</th>
					<th>Supplier</th>
					<!--<th>Supplier Code</th>-->
					<th>QTY</th>
					<th>Unit Of Measure</th>
					<th>Unit Cost</th>
					<th>Line Total</th>
                                        <th>Margin %</th>
                                        <th>Line Total with Margin</th>
                          


				</tr>
			</thead>
			<tbody >
				
				<?php $parts = $stg['parts']; ?>
				<?php foreach ($parts AS $pt => $pts): ?>

                                        <?php if($pts['costing_quantity'] != $pts['ordered_quantity']){ ?>

					<tr id="trnumber<?php echo $count ?>" class="locked" tr_val="<?php echo $count ?>">

						<input type="hidden" name="<?='costing_part_id'.$suppid.$stageid.'[]'?>" value="<?= $pts['costing_part_id'] ?> ">

						<td>
			                <input type="hidden" name="<?='stage'.$suppid.$stageid.'[]'?>" value="<?= $pts['stage_id']?>" id="stagefield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" >
                            <?php
                                echo $pts['stage_name'];    
                            ?>
						</td>

						<td><input type="hidden" name="<?='part'.$suppid.$stageid.'[]'?>" id="partfield<?php echo $count ?>" value="<?php echo $pts['costing_part_name']; ?>" rno ='<?php echo $count ?>' class="form-control" /><?php echo $pts['costing_part_name']; ?></td>
						<td>
                            <input type="hidden" name="<?='component'.$suppid.$stageid.'[]'?>" value="<?= $pts['component_id']?>" id="componentfield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" onchange="return componentval(this);" >
                            <?php
                                echo $pts['component_name'];    
                            ?>
						</td>
						<td>
							<input type="hidden"  name="<?='supplier_id'.$suppid.$stageid.'[]'?>" id="supplierfield<?php echo $count ?>" rno ='<?php echo $count ?>' >
                            <?php
                                echo $pts['supplier_name'];     
                            ?>
						</td>
						<td>
							<div class="manualfield" id="manualfield<?php echo $count ?>">
								<input  type="hidden" name="<?='manualqty'.$suppid.$stageid.'[]'?>" rno ='<?php echo $count ?>' id="manualqty<?php echo $count ?>" type="text" name="" class="qty form-control" value="<?php echo $pts['costing_quantity'] - $pts['ordered_quantity']?>" onchange="calculateTotal(this.getAttribute('rno'))"/>
                                <?php echo $pts['costing_quantity'] - $pts['ordered_quantity']?>
                            </div>
							<div class="formulafield" id="formulafield<?php echo $count ?>" style="<?php if ($pts['quantity_type'] == 'formula') {
								echo "display:none";
							} else {
								echo "display:none";
							} ?>">
								<div class=""> <a class="btn btn-primary btn-small" id="model<?php echo $count ?>" data-toggle="modal" role="button" title="_stage_<?php echo $count ?>" href="#simpleModal" rno= '<?php echo $count ?>' onclick="return modelid(this.title, this.getAttribute('rno'));">Create Formula</a>
									<h4 id="viewquanity<?php echo $count ?>" class="viewquanity" ></h4>
									<input class="form-control formula" rno ='<?php echo $count ?>' type="hidden" value="<?php echo $pts['quantity_formula']; ?>" name="<?='formula'.$suppid.$stageid.'[]'?>" id="formula_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
									<input class="form-control formulaqty <?php if ($pts['quantity_type'] == "formula") {
										echo "formulaqtty";
									} ?> "  rno ='<?php echo $count ?>' type="hidden" value="<?php echo $pts['quantity_formula']; ?>" name="<?='formulaqty'.$suppid.$stageid.'[]'?>" id="formulaqty_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
									<input class="form-control formulatext"  rno ='<?php echo $count ?>' type="hidden" value="<?php echo $pts['formula_text']; ?>" name="<?='formulatext'.$suppid.$stageid.'[]'?>" id="formulatext_stage_<?php echo $count ?>" title="<?php echo $count ?>" alt="<?php echo $count ?>">
								</div>
							</div>
						</td>

						<td><input type="hidden" name="<?='uom'.$suppid.$stageid.'[]'?>" id="uomfield<?php echo $count ?>" rno ='<?php echo $count ?>' value="<?php echo $pts['costing_uom'] ?>" class="form-control" width="5" /><?php echo $pts['costing_uom'] ?></td>
                                                <td><input type="hidden" name="<?='ucost'.$suppid.$stageid.'[]'?>" id="ucostfield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" value="<?php echo $pts['costing_uc'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo number_format($pts['costing_uc'], 2, '.', ''); ?></td>
                                                <td><input type="hidden" name="<?='linttotal'.$suppid.$stageid.'[]'?>"  rno ='<?php echo $count ?>' id="linetotalfield<?php echo $count ?>" class="form-control" value="<?php echo ($pts['costing_quantity'] - $pts['ordered_quantity'])*$pts['costing_uc'] ?>" /><?php echo number_format(($pts['costing_quantity'] - $pts['ordered_quantity'])*$pts['costing_uc'], 2, '.', '');  ?></td>
                                                <td><input type="hidden" name="<?='margin'.$suppid.$stageid.'[]'?>" id="ucostfield<?php echo $count ?>" rno ='<?php echo $count ?>' class="form-control" value="<?php echo $pts['margin'] ?>" onchange="calculateTotal(this.getAttribute('rno'))"/><?php echo $pts['margin'] ?></td>
                                                <td><input type="hidden" name="<?='margintotal'.$suppid.$stageid.'[]'?>"  rno ='<?php echo $count ?>' id="linetotalfield<?php echo $count ?>" class="form-control" value="<?php echo (($pts['costing_quantity'] - $pts['ordered_quantity'])*$pts['costing_uc'])*((100+$pts['margin'])/100) ?>" /><?php echo number_format((($pts['costing_quantity'] - $pts['ordered_quantity'])*$pts['costing_uc'])*((100+$pts['margin'])/100), 2, '.', '');  ?></td>



					</tr>
                                        <?php }?>
					<?php $count++ ?>
				<?php endforeach; ?>

			</tbody>
		</table>
	
	
	
	<?php endforeach; ?>
<?php endforeach; ?>
<input type="hidden" name="populateany" id="populateany" value="<?= ($populateany)?  1:  0;?>">
	
