                <form id="SalesReceiptForm" method="post" action="<?= SURL.'sales_invoices/exportinvoiceswizard2/' ?>" onsubmit="return validateform();">  
                    <input id="invoice_id" name="invoice_id" type="hidden" value="<?=$invoice_id ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="orange">
                                        <i class="material-icons">receipt</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Create CSV to Export Sales Invoices</h4>
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
                                        <div class="row">
                                             <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group label-floating col-md-12">
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" id="creatnewcsv" name="creatnewcsv" value="<?=(count($file_ids))?0:1?>" <?=(count($file_ids))?'':'checked'?> onchange="checkcreatnewreceipt(this.id)" > Create New CSV file
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php if(count($file_ids)): ?>
                                               <div class="form-group label-floating col-md-12">
                                                    <div class="checkbox">
                                                        <label>
                                                             <input type="checkbox" id="addtoexisting" name="addtoexisting" onchange="addtoexistingf(this.id)"  value="<?=(count($file_ids))?1:0?>" <?=(count($file_ids))?'checked':''?> />Add to existing CSV file
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group label-floating">
                                                    <div class="col-md-4"><label style="margin-top:25px;">File Number <small>*</small></label></div>
                                                    <div class="col-md-8">
                                                        <select name="file_id" id="file_id" class="selectpicker" data-style="select-with-transition">
                                                            <option value="0">Creat New CSV file</option>
                                                            <?php foreach ( $file_ids as $key => $id) :?> 
                                                            <option value="<?=$file_ids[$key]['id']?>" <?=($key==0)?'selected':''?>> <?= $file_ids[$key]['id']?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                 <?php endif; ?>
                                        </div>
                                    </div>
                                        <div class="loader">
                                            <center>
                                                <img class="loading-image" src="<?php echo IMG;?>search.gif" alt="loading.." width="100px">
                                            </center>
                                        </div>
                                         
			
                                    </div>
                            </div>
                        </div>
        
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="form-footer">
                                         <div class="pull-left">
                                                            <button type="submit" class="btn btn-success btn-fill">Add to CSV file</button>
                                                         </div>
                                                         <div class="pull-right">
                                                            <a href="javascript:void(0)" class="btn btn-warning btn-fill closeBtn">Close</a>
                                                      </div>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>
                
<script>
    function checkcreatnewreceipt(id) {

        if ($('#' + id).is(":checked")) {
            $('#' + id).val(1);
            <?php if (count($file_ids)){ ?>
            $('#addtoexisting').removeAttr('checked');
            $('#addtoexisting').val(0);
            $('#file_id').val(0);
            <?php  }  ?>
        } else {
            $('#' + id).val(0);
        }
    }

    function addtoexistingf(id){
        if ($('#' + id).is(":checked")) {
            $('#' + id).val(1);
            <?php if (count($file_ids)){ ?>
            $('#creatnewcsv').removeAttr('checked');
            $('#creatnewcsv').val(0);
             $('#file_id option:nth-child(2)').attr('selected', 'selected');
            <?php  }  ?>
        } else {
            $('#' + id).val(0);
        }

    }
    
    function validateform(){

        <?php if (count($file_ids)){ ?>

           var  a = $('#creatnewcsv').is(":checked");
           var  b = $('#addtoexisting').is(":checked");

            if (!(a || b) ) {
                swal({
                title: 'Error!',
                text: 'Please check either "Creat New CSV" or "Add to existing CSV"',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
                return false;
            }

            if(a && parseFloat($('#file_id').val()) ){
                swal({
                title: 'Error!',
                text: 'Please select "Create New CSV" from "File Number" dropdown',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
                return false;
            }

            if(b && !parseFloat($('#file_id').val()) ){
                swal({
                title: 'Error!',
                text: 'Please select file Number from "File Number" dropdown',
                type: 'warning',
                confirmButtonClass: "btn btn-warning",
                buttonsStyling: false
            }).catch(swal.noop);
                return false;
            }

        <?php  } else { ?>


            if (!$('#creatnewcsv').is(":checked") )
                {
                    swal({
                        title: 'Error!',
                        text: 'Please check "Create New CSV"',
                        type: 'warning',
                        confirmButtonClass: "btn btn-warning",
                        buttonsStyling: false
                    }).catch(swal.noop);
                    return false;
                }


        <?php  } ?>   


    }
</script>
                

                