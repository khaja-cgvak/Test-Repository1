<section class="vbox">
    <section class="scrollable padder">
        <section class="panel panel-default">
            <header class="panel-heading"><strong><?php echo $title; ?> </strong></header>
            <div class="panel-body">
                <form method="POST" name="adduser" action="" class="adddyform">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel-body">
                                <div class="row form-group clearfix">                                
                                    <div class="col-sm-4">
                                        <label>Process:<span class="mandatory"> *</span></label>
                                        <select class="form-control" name="procid" id="procid">
                                            <option value="">Select Process</option>
                                            <?php
                                                if(!empty($process_select))
                                                {
                                                    $optiongrp='';
                                                    foreach ($process_select as $key => $value) {
                                                        if(($optiongrp!=$value['process'] && $optiongrp!='' ) || ($optiongrp!='' && ($key)==count($process_select)))
                                                        {
                                                            echo '</optgroup>';
                                                        }

                                                        if($optiongrp!=$value['process'])
                                                        {
                                                            $optiongrp=$value['process'];
                                                            echo  '<optgroup label="'.$value['process'].'">';
                                                        }
                                                        if(!empty($value['subprocess']))
                                                        {
                                                            echo '<option value="'.$value['subid'].'">'.$value['subprocess'].'</option>';
                                                        }
                                                        
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Section:</label>
                                        <select class="form-control" name="parentid">
                                            <option>Select Section</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Section/Option Name:<span class="mandatory"> *</span></label>
                                        <input class="form-control" name="dyname" placeholder="" value="" type="text">
                                    </div>
                                </div>
                                <div class="row form-group clearfix">
                                    <div class="col-sm-4">
                                        <label>Order:<span class="mandatory"> *</span></label>
                                        <input class="form-control" name="dysort" placeholder="" value="" type="text">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Active<span class="mandatory"> *</span></label>
                                        <div>
                                            <label class="checkbox-inline">
                                            <input type="radio" name="status" value="1" <?php
                                                if (isset($projdata['isactive']) && $projdata['isactive'] == 1)
                                                {
                                                    echo 'checked';
                                                }
                                                else
                                                {
                                                    echo 'checked';
                                                }
                                                ?> /> Yes</label>
                                                <label class="checkbox-inline">
                                                <input type="radio" name="status" value="0"  <?php
                                                if (isset($projdata['isactive']) && $projdata['isactive'] == 0)
                                                {
                                                    echo 'checked';
                                                }
                                                ?>  /> No</label>
                                                       <?php echo form_error('status', '<div class="form-error">', '</div>'); ?>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>                  
                        </div>
                    </div>
                    <footer class="panel-footer text-right bg-light lter"> 
                        <input name="existid" value="1" type="hidden">
                        <input name="submit" value="Submit" class="btn btn-success btn-s-xs submit-btn addnew" type="submit">
                        <input name="cancel" value="Cancel" class="btn btn-danger btn-s-xs submit-btn cancel" type="submit"> 
                    </footer>

                </form>
            </div>
        </section>
    </section>
</section>