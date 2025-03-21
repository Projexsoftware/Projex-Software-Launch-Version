<div class="form-group">
        <label class="control-label">
            Designz Thumbnail
            <small>*</small>
        </label>
        <br><br>
        <img id="thumbnail" name="thumbnail" src="<?php echo count($thumbnail)>0?ASSETS.'designz_uploads/'.$thumbnail['file_name']:IMG.'placeholder.jpg';?>" alt="..." style="width:100px;height:100px;">
        <img id="plan_thumbnail" name="plan_thumbnail" src="<?php echo count($plan_thumbnail)>0?ASSETS.'designz_uploads/'.$plan_thumbnail['file_name']:IMG.'placeholder.jpg';?>" alt="..." style="width:100px;height:100px;">
</div>