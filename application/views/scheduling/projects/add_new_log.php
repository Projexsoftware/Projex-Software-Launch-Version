<tr class="new_log_row row<?php echo $count;?>" rowno="<?php echo $count;?>">
    <td><?php echo $date;?></td>
    <td><?php echo $user;?></td>
    <td>Project Log</td>
    <td><textarea class="form-control" name="log_notes" id="log_notes<?php echo $count;?>" required="true" placeholder="Notes*"></textarea></td>
    <td>
        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
            <div class="fileinput-new thumbnail">
                <img src="<?php echo IMG;?>image_placeholder.jpg" alt="...">
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail"></div>
            <div>
                <span class="btn btn-info btn-round btn-file">
                <span class="fileinput-new">Select image</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" id="log_image<?php echo $count;?>" name="log_image" />
                </span>
                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                <p class="image_error<?php echo $count;?> text-danger"></p>
            </div>
        </div>
    </td>
</tr>
<tr class="row<?php echo $count;?>">
    <td colspan="5" align="right">
        <div class='progress progress-line-success' id="progressDivId<?php echo $count;?>">
            <div class='progress-bar progress-bar-success' id='progressLogBar<?php echo $count;?>'>0%</div>
        </div>
        <button id="btn-add-new-log<?php echo $count;?>" type="submit" class="btn btn-success btn-sm btn-fill">Add</button>
        <button rowno="<?php echo $count;?>" type="button" class="btn btn-sm btn-danger btn-fill btn-remove-new-log">Delete</button>
    </td>
</tr>