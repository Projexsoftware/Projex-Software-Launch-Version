<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">menu_book</i>
                                    </div>
                                    <div class="card-content">
                                    <h4 class="card-title">Allocate Price Book Request</h4>
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
        
                                    <div class="col-md-12">
                                        <table class="table">
							
							<tbody>
							    
                            <?php  
                                
                                $company_info = get_price_book_supplier_info($price_book_request['from_user_id']);
                            		
                            	?>
								<tr>
								    <td><b>Date Request Made : </b></td>
									<td><?php echo date("d/M/Y", strtotime($price_book_request['created_date']));?></td>
								</tr>
								<tr>
								    <td><b>Status : </b></td>
									<td style="padding-top:30px;"><?php if($price_book_request['status'] == 0){
									   echo '<span class="label label-warning">Pending</span>';   
									  } else if($price_book_request['status'] == 1){
									   echo '<span class="label label-success">Accepted</span>'; 
									   echo '&nbsp;<span class="label label-warning">Price book pending</span><br/><br/>';
									   
									  }
									  else if($price_book_request['status'] == 2){
									   echo '<span class="label label-success">Price book has been uploaded into components</span>'; 
									  }
									  else{
									      echo '<span class="label label-danger">Declined</span>'; 
									  }
									  
									  ?></td>
								</tr>
								</tbody>
								</table>
						
						
                                    </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">info</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Company Details</h4>
                                	<table class="table">
							
							<tbody>
                                 <tr>
								    <td style="width:180px;"><b>Company Logo : </b></td>
									<td><img style="width:180px;" src="<?php echo SURL .'/assets/company/thumbnail/'.$company_info['com_logo'];?>"></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Company Name : </b></td>
									<td><?php echo $company_info['com_name'];?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Company Website : </b></td>
									<td><?php echo $company_info['com_website'];?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Company Email : </b></td>
									<td><?php echo $company_info['com_email'];?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Company Contact Number : </b></td>
									<td><?php echo $company_info['com_phone_no'];?></td>
								</tr>
							</tbody>
						</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">person</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">User Details</h4>
                                	<table class="table">
							
							<tbody>
                            <?php  
                                
                                $user_info = get_price_book_supplier_info($price_book_request['from_user_id']);
                            		
                            	?>
								<tr>
								    <td style="width:180px;"><b>User Full Name : </b></td>
									<td><?php echo $user_info['user_fname']." ".$user_info['user_lname'];?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>User Email : </b></td>
									<td><?php echo $company_info['user_email'];?></td>
								</tr>
							</tbody>
						</table>
			</div>
		</div>
	</div>
</div>
<?php if(count($supplier_info)>0){ ?>
<div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">airport_shuttle</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Supplier Details</h4>
                                	<table class="table">
							
							<tbody>
								<tr>
								    <td style="width:180px;"><b>Supplier Name : </b></td>
									<td><?php echo $supplier_info['supplier_name']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Supplier Email : </b></td>
									<td><?php echo $supplier_info['supplier_email']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Supplier Phone : </b></td>
									<td><?php echo $supplier_info['supplier_phone']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Supplier Website : </b></td>
									<td><?php echo $supplier_info['supplier_web']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b> Supplier Contact Person : </b></td>
									<td><?php echo $supplier_info['supplier_contact_person']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Supplier Contact Person Mobile : </b></td>
									<td><?php echo $supplier_info['supplier_contact_person_mobile']?></td>
								</tr>
								<tr>
								    <td colspan="2"><legend>Address</legend></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Street : </b></td>
									<td><?php echo $supplier_info['street_pobox']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Suburb : </b></td>
									<td><?php echo $supplier_info['suburb']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>City : </b></td>
									<td><?php echo $supplier_info['supplier_city']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Region : </b></td>
									<td><?php echo $supplier_info['supplier_state']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Country : </b></td>
									<td><?php echo $supplier_info['supplier_country']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>ZIP Code : </b></td>
									<td><?php echo $supplier_info['supplier_zip']?></td>
								</tr>
								<tr>
								    <td colspan="2"><legend>Postal Address</legend></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Street : </b></td>
									<td><?php echo $supplier_info['post_street_pobox']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Suburb : </b></td>
									<td><?php echo $supplier_info['post_suburb']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>City : </b></td>
									<td><?php echo $supplier_info['supplier_postal_city']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Region : </b></td>
									<td><?php echo $supplier_info['supplier_postal_state']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>Country : </b></td>
									<td><?php echo $supplier_info['supplier_postal_country']?></td>
								</tr>
								<tr>
								    <td style="width:180px;"><b>ZIP Code : </b></td>
									<td><?php echo $supplier_info['supplier_postal_zip']?></td>
								</tr>
								
							</tbody>
						</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">assignment_turned_in</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Allocate Section</h4>
                        <?php if($price_book_request['allocate_price_book_id']==0){ ?>
						<form id="AllocateForm" action="<?php echo SURL;?>supplierz/allocate_price_book_process" method="post">
						    <input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $price_book_request['from_user_id'];?>">
						     <input type="hidden" name="request_id" id="request_id" value="<?php echo $price_book_request['id'];?>">
						     <input type="hidden" name="company_id" id="company_id" value="<?php echo $price_book_request['company_id'];?>">
						     
						    <div class="row">
						         <label class="col-md-2">Allocate Price Book <small>*</small></label>
			    <div class="col-md-10">
			        <select name="allocate_price_book_id" id="allocate_price_book_id" class="selectpicker" data-style="select-with-transition" title="Select Allocate Price Book" required="true">
			        <?php foreach($price_book_list as $val){ ?>
			            <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
			       <?php } ?>
			    </select>
			        
			    </div>
						        
						    </div>
            					<br/>	    
            				<div class="row">
            						         <label class="col-md-2">Notes <small>*</small></label>
            			    <div class="col-md-10">
            			        <textarea id="notes" name="notes" class="form-control" placeholder="Add Notes Here" required="true"></textarea>
            			    </div>
            						        
            						    </div>
            				<br>
            				<?php if(count($supplier_info)==0){ ?>
			                <div class="row">
			                   <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Name
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_name" id="supplier_name" required="true" value="<?php echo $supplier_user_info['com_name'];?>" disabled/>
                                                    <?php echo form_error('supplier_name', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Email
                                                    <small>*</small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_email" id="supplier_email" required="true" email="true" value="<?php echo $supplier_user_info['user_email'];?>" disabled/>
                                                    <?php echo form_error('supplier_email', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Phone
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_phone" id="supplier_phone" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_phone']; } else{ echo $supplier_user_info['com_phone_no']; }?>"/>
                                                    <?php echo form_error('supplier_phone', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Website
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_web" id="supplier_web" validUrl="true" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_web']; } else{ echo $supplier_user_info['com_website']; }?>"/>
                                                    <?php echo form_error('supplier_web', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Contact Person
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_contact_person" id="supplier_contact_person" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_contact_person']; } else{ echo set_value('supplier_contact_person'); }?>"/>
                                                    <?php echo form_error('supplier_contact_person', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Supplier Contact Person Mobile
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_contact_person_mobile" id="supplier_contact_person_mobile" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_contact_person_mobile']; } else{ echo set_value('supplier_contact_person_mobile');}?>"/>
                                                    <?php echo form_error('supplier_contact_person_mobile', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="street_pobox" id="street_pobox" value="<?php if(count($supplier_info)>0){ echo $supplier_info['street_pobox']; } else{ echo set_value('street_pobox'); }?>"/>
                                                    <?php echo form_error('street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="suburb" id="suburb" value="<?php if(count($supplier_info)>0){ echo $supplier_info['suburb']; } else{ echo set_value('suburb'); }?>"/>
                                                    <?php echo form_error('suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_city" id="supplier_city" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_city']; } else{ echo set_value('supplier_city'); }?>"/>
                                                    <?php echo form_error('supplier_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_state" id="supplier_state" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_state']; } else{ echo set_value('supplier_state'); }?>"/>
                                                    <?php echo form_error('supplier_state', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_country" id="supplier_country" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_country']; } else{ echo set_value('supplier_country'); } ?>"/>
                                                    <?php echo form_error('supplier_country', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    <small></small>
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_zip" id="supplier_zip" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_zip']; } else{ echo set_value('supplier_zip'); } ?>"/>
                                                    <?php echo form_error('supplier_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><br/><legend>Postal Address</legend></div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Street
                                                    </label>
                                                    <input class="form-control" type="text" name="post_street_pobox" id="post_street_pobox" value="<?php if(count($supplier_info)>0){ echo $supplier_info['post_street_pobox']; } else{ echo set_value('post_street_pobox'); }?>"/>
                                                    <?php echo form_error('post_street_pobox', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Suburb
                                                    </label>
                                                    <input class="form-control" type="text" name="post_suburb" id="post_suburb" value="<?php if(count($supplier_info)>0){ echo $supplier_info['post_suburb']; } else{ echo set_value('post_suburb'); } ?>"/>
                                                    <?php echo form_error('post_suburb', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    City
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_city" id="supplier_postal_city" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_postal_city']; } else{ echo set_value('supplier_postal_city'); } ?>"/>
                                                    <?php echo form_error('supplier_postal_city', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Region
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_state" id="supplier_postal_state" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_postal_state']; } else{ echo set_value('supplier_postal_state'); } ?>"/>
                                                    <?php echo form_error('supplier_postal_state', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    Country
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_country" id="supplier_postal_country" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_postal_country']; } else{ echo set_value('supplier_postal_country'); } ?>"/>
                                                    <?php echo form_error('supplier_postal_country', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                    ZIP Code
                                                    </label>
                                                    <input class="form-control" type="text" name="supplier_postal_zip" id="supplier_postal_zip" value="<?php if(count($supplier_info)>0){ echo $supplier_info['supplier_postal_zip']; } else{ echo set_value('supplier_postal_zip'); } ?>"/>
                                                    <?php echo form_error('supplier_postal_zip', '<div class="custom_error">', '</div>'); ?>
    				                        	</div>
                                            </div>
                                        </div>
			               </div>
			               <?php } ?>
            			    <div class="row"><div class="col-md-12">
            			        <div class="form-footer text-right">
            			            <input type="submit" class="btn btn-success" value="Save">
            			            <a href="<?php echo SURL;?>supplierz/manage_allocate" class="btn btn-default">Close</a>
            			        </div>
            			        
            			    </div></div>
			    
			</form>
			<?php } else{?> 
			<table class="allocate_company_details" id="dataTable" width="500px">
							
							<tbody>
                            <?php  
                                
                                $price_book_info = get_price_book_name($price_book_request['allocate_price_book_id']);
                            		
                            	?>
								<tr>
								    <td style="width:180px;"><b>Allocate Price Book : </b></td>
									<td><a href="<?php echo SURL;?>supplierz/edit_price_book/<?php echo $price_book_request['allocate_price_book_id'];?>" target="_Blank"><i style="color:#6bafbd;" class="fa fa-book"></i> <?php echo $price_book_info['name'];?></a></td>
								</tr>
									<tr>
								    <td style="width:180px;"><b>Notes : </b></td>
									<td>	<i style="color:crimson;font-size:14px;" class="fa fa-file"></i> <?php echo $price_book_request['notes'];?></td>
								</tr>
							</tbody>
						</table>
			 <div class="row" style="margin-top:20px;"><div class="col-md-12" style="text-align:right;">
			       <a href="<?php echo SURL;?>supplierz/manage_allocate" class="btn btn-default">Close</a>
			    </div></div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
                                        

                
                