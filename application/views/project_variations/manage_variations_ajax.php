<?php 
                                            						$i=1;
                                                                    foreach($variations as $variation) {?>
                                                                    <tr class="row_<?php echo $variation["id"];?>">
                                                                        <td><?php echo $i;?></td>
                                                                        <td><?php echo get_project_name($variation["project_id"]); ?></td>
                                                                        <td><?php echo $variation["var_number"]; ?></td>
                                                                        <td><?php echo '$'.number_format($variation["project_subtotal3"],2, '.', ''); ?></td>
                                                                        <td><?php echo '$'.number_format($variation["project_contract_price"],2, '.', ''); ?></td>
                                                                        <td><?php echo $variation["variation_name"]; ?></td>
                                                                        <td><?php echo $variation["variation_description"]; ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($variation["created_date"])); ?></td>
                                                                        <td>
                                                                        <?php if ($variation["status"] == "PENDING") { 
                                                                            ?><span class="label label-warning"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "ISSUED") { 
                                                                            ?><span class="label label-warning"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "APPROVED") { 
                                                                            ?><span class="label label-success"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "SALES INVOICED") { 
                                                                            ?><span class="label label-primary"><?php echo $variation["status"] ?> </span>
                                                                            <?php } else if ($variation["status"] == "PAID") { 
                                                                            ?><span class="label label-success"><?php echo $variation["status"] ?> </span>
                                                                            <?php } ?>
                                                                                
                                                                            <?php if ($variation["var_type"] == "purord") { 
                                                                            ?>&nbsp;<span class="label label-primary"> <?php echo 'From Purchase Order'; ?> </span>
                                                                            <?php } ?>
                                                                            <?php if ($variation["var_type"] == "suppinvo") { 
                                                                            ?>&nbsp;<span class="label label-info"> <?php echo 'From Supplier Invoice' ?> </span>
                                                                            <?php } ?>
                                                                            <?php if ($variation["var_type"] == "supcredit") { 
                                                                            ?>&nbsp;<span class="label label-info"> <?php echo 'From Supplier Credit' ?> </span>
                                                                            <?php } ?>
                                                                            <?php if ($variation["var_type"] == "salecredit") { 
                                                                            ?>&nbsp;<span class="label label-info"> <?php echo 'From Sales Credit' ?> </span>
                                                                            <?php } ?>
                                        								</td>
                                                                        <td class="text-right" >
                                                                           <?php if(in_array(6, $this->session->userdata("permissions")) || in_array(8, $this->session->userdata("permissions"))) {?>
                                                                           <a href="<?php echo SURL;?>project_variations/view_variation/<?php echo $variation["id"];?>" class="btn btn-simple btn-warning btn-icon edit"><i class="material-icons">edit</i></a>
                                                                           <?php } ?>
                                                                        </td>
                    
                                                                    </tr>
                                                                    <?php 
                    												$i++;
                    												} ?>