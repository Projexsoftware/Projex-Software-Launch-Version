<?php 
$takeoffdatas = array();
if(count($etakeoffdata)>0){
    foreach($etakeoffdata as $val){
        $takeoffdatas[]= $val->takeof_id;
    }
}
if (count($ctakeoffdata) > 0) { ?>

                        		
                                    <?php 
                                    $i="a";
                                    foreach($ctakeoffdata AS $key => $val) {
                                        if(!in_array($val->takeof_id, $takeoffdatas)){
                                        $vv = 'td'.$val->takeof_id; 
                                        ?> 
                                        <tr class="tod_rows" tod_id='<?php echo $val->takeof_id?>'>
                                            <td><?php echo $val->takeof_name ?> <i class="fa fa-question-circle"  data-toggle="tooltip" title="<?php echo $val->takeof_des;?>"></i></td>
                                            <td><input class="form-control  caltakeofdata" type="text" name="todinput<?php echo $val->takeof_id?>" id="toffdata<?php echo $val->takeof_id?>" placeholder ="Enter Value" value=""> </td>
                                        </tr>
                                    <?php 
                                    $takeoffdatas.=$val->takeof_id.",";
                                    $i++;
                                    }
                                    }
}
                                    ?>