<?php 
$takeoffdatas = "";
$tdata = json_decode(@$projectCosting['takeoffdatas']);
if (count($ctakeoffdata) > 0) { ?>
<div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                     <div class="panel-group" id="accordionTakeoffdata" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOneTakeoffdata">
                                                <a role="button" data-toggle="collapse" data-parent="#accordionTakeoffdata" href="#collapseOneTakeoffdata" aria-controls="collapseOneTakeoffdata">
                                                    <h4 class="panel-title">
                                                        Take Off Data
                                                        <i class="material-icons">keyboard_arrow_down</i>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div id="collapseOneTakeoffdata" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOneTakeoffdata">
                                                <div class="panel-body">
                                                    <table class="table">
                                
                                <tbody>
                        		
                                    <?php 
                                    $i=0;
                                    foreach ($ctakeoffdata AS $key => $val) {
                                        $vv = 'td'.$val->takeof_id; 
                                        ?> 
                                        <tr class="tod_rows<?php if($i==(count($ctakeoffdata)-1)){?> last_takeoff_data<?php } ?>" tod_id='<?php echo $val->takeof_id?>'>
                                            <td><?php echo $val->takeof_name ?> <i class="fa fa-question-circle"  data-toggle="tooltip" title="<?php echo $val->takeof_des;?>"></i></td>
                                            <td><input class="form-control  caltakeofdata" type="text" name="todinput<?php echo $val->takeof_id?>" id="toffdata<?php echo $val->takeof_id?>" placeholder ="Enter Value" value="<?php echo @$tdata->$vv ?>"> </td>
                                        </tr>
                                    <?php 
                                    $takeoffdatas.=$val->takeof_id.",";
                                    $i++;
                                    }
                                    ?>
                                        <tr>
                                            <td colspan="2" style="text-align: center"><a href="javascript:void(0)" class="btn btn-warning" onclick="CalculateTakeoffData()">Calculate</a></td>
                                       
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
                <?php } ?>
                <input id="takeoffdatas" name="takeoffdatas" type="hidden" value="<?php echo $takeoffdatas ?>">
                