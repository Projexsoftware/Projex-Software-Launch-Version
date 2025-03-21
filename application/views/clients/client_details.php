<div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">person</i>
                                </div>
                        <div class="card-content">
                        <div class="panel-group" id="Client" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingClient">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#Client" href="#ClientDescription" aria-controls="ClientDescription" aria-expanded="true">
                                                    <h4 class="panel-title text-red">
                                                        Client Details
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="ClientDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingClient">
                                                <div class="panel-body project_team_container">
                                                    <i class="fa fa-calendar"></i> <?php echo ' '.date('d/m/Y',strtotime($client_details['date_created'])); ?>
                                                    <div class="pull-right" style="margin-bottom:20px">
                                                        
                                                        <?php if($client_details['client_status']==1){ ?>
                                                        <span class="label label-success">Current</span>
                                                        <?php } else{ ?>
                                                        <span class="label label-danger">Inactive</span>
                                                        <?php } ?>
                                                    </div>
                                                       <div class="table-responsive">
                                                          <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">First Name1</h4>
                                                        <?= $client_details['client_fname1'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Surname 1</h4>
                                                        <?= $client_details['client_surname1'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">First Name2</h4>
                                                        <?= $client_details['client_fname2'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Surname 2</h4>
                                                        <?= $client_details['client_surname2'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Home Phone Primary</h4>
                                                        <?= $client_details['client_homephone_primary'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Home Phone Secondary</h4>
                                                        <?= $client_details['client_homephone_secondary'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Work Phone Primary</h4>
                                                        <?= $client_details['client_workphone_primary'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Work Phone Secondary</h4>
                                                        <?= $client_details['client_workphone_secondary'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Mobile Phone Primary</h4>
                                                        <?= $client_details['client_mobilephone_primary'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Mobile Phone Secondary</h4>
                                                        <?= $client_details['client_mobilephone_secondary'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Email Primary</h4>
                                                        <?= $client_details['client_email_primary'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Email Secondary</h4>
                                                        <?= $client_details['client_email_secondary'];?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                        <div class="col-md-4">
                            <?php $brand = '';
                                  $category = '';    
                             ?>
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">location_on</i>
                            </div>
                        <div class="card-content">
                        <div class="panel-group" id="address" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingAddress">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#address" href="#addressDescription" aria-controls="addressDescription" aria-expanded="true">
                                                    <h4 class="panel-title">
                                                        Address
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="addressDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingAddress">
                                                <div class="panel-body">
                                                 	
                                                       <div class="table-responsive">
                                                            <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Street</h4>
                                                        <?= $client_details['street_pobox'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Suburb</h4>
                                                        <?= $client_details['suburb'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">City</h4>
                                                        <?= $client_details['client_city'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Region</h4>
                                                        <?= $client_details['state'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Country</h4>
                                                        <?= $client_details['country'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">ZIP Code</h4>
                                                        <?= $client_details['client_zip'];?>
                                                    </td>
                                                
                                                </tr>
                                            </tbody>
                                        </table>
                                                        </div>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
						<div class="card">
						    <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">location_on</i>
                            </div>
                        <div class="card-content">
                        <div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingPostalAddress">
                                                <a class="" role="button" data-toggle="collapse" data-parent="#accordion4" href="#postalAddress" aria-controls="postalAddress" aria-expanded="true">
                                                    <h4 class="panel-title">
                                                        Postal Address
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="postalAddress" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingPostalAddress">
                                                <div class="panel-body">
                                                    <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Street</h4>
                                                        <?= $client_details['post_street_pobox'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Suburb</h4>
                                                        <?= $client_details['post_suburb'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">City</h4>
                                                        <?= $client_details['client_postal_city'];?>
                                                    </td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Region</h4>
                                                        <?= $client_details['pstate'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">Country</h4>
                                                        <?= $client_details['pcountry'];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="card-title">ZIP Code</h4>
                                                        <?= $client_details['client_postal_zip'];?>
                                                    </td>
                                                
                                                </tr>
                                            </tbody>
                                        </table>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
						<div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">note</i>
                            </div>
                        <div class="card-content">
                        <div class="panel-group" id="note" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingNote">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#note" href="#noteDescription" aria-controls="noteDescription" aria-expanded="true">
                                                    <h4 class="panel-title">
                                                        Notes
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="noteDescription" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingNote">
                                                <div class="panel-body">
                                                 	
                                                     <p><?php if($client_details["client_note"]!=""){ echo $client_details["client_note"]; } else{ echo "<span class='label label-success'>No notes added yet</span>";}?></p>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                        
							</div>
						</div>
						
						</div>
</div>
<!-- end row -->