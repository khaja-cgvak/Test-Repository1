<?php //echo $sheetstatus[0]['status'];die;?>
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
    <header class="panel-heading">
        <div class="row clearfix">
          <div class="col-sm-4"><strong><?php echo $title; ?></strong></div>
          <div class="col-sm-4"><strong>Process:</strong>&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" class="proshtstatus" value="1" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  }  ?>>Enabled</label><label class="radio-inline"><input type="radio" class="proshtstatus" value="0" name="optradio" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==0) { echo 'checked="checked"'; }  } ?>>Disabled</label>
          <!-- <input data-id="0" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-size="mini" type="checkbox" id="toggle-two" <?php if(isset($sheetstatus[0]['status'])) { if(($sheetstatus[0]['status'])==1) { echo 'checked="checked"'; }  } else{ echo 'checked="checked"'; } ?> > --></div>
          <div class="col-sm-4 text-right">
          <a href="<?php echo site_url('projects/'.$this->uri->segment(2).'/'.$this->uri->segment(3)); ?>" class="pull-left" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'style="pointer-events: none"'; }  } ?>><button type="button" class="btn btn-primary btn-xs">Add New</button></a>
          <?php 
            $sheetnumber=1;
            if(isset($prcdata['sheetnumber']))
            {

              $sheetnumber=$prcdata['sheetnumber'];
            }
            
            echo $this->Common_model->displaySheetNum(PRJPRCLST,intval($sheetnumber),$masterprcid);
          ?></div>
        </div>
      </header>
      <div class="panel-body">
        <form method="POST" name="adduser" action=""  enctype="multipart/form-data"   class="addusernew processForm">
      
        <div class="row">
        <div class="col-sm-12">
        <div class="">
        <div class="row form-group clearfix">
                  <div class="col-sm-4"><strong>Project Name:</strong> <?php echo $prodata['projectname']; ?></div>
                  <!-- <div class="col-sm-3"><input type="file" name="import"></div> -->
                  <!-- <div class="col-sm-4">
                    <div class="row clearfix">
                      <div class="col-sm-3"><label><strong>Ref:</strong><span class="mandatory"> *</span></label></div>
                      <div class="col-sm-9">
                        <input type="text" name="reportref" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> value="<?php echo set_value('reportref', (isset($prcdata['referenceno'])) ? $prcdata['referenceno'] : ''); ?>">
                        <?php echo form_error('reportref', '<div class="form-error">', '</div>'); ?>
                      </div>
                    </div>
                  </div> -->
                  <div class="col-sm-4"><strong>Project Number:</strong> <?php echo $prodata['projectnumber']; ?></div>
                  <div class="col-sm-4">
                    <div class="row clearfix">
                      <div class="col-sm-4"><label><strong>System:</strong><span class="mandatory"> *</span></label></div>
                      <div class="col-sm-8">
                        <select name="projsystem" id="projsystem" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
                    <option value="">Please Select</option>                 
                    <?php 
                      $allsystems=$this->MProject->getSystems($proid);
                      $projectsystemid=0;
                      if($this->session->userdata('system_value'))
                      {
                        
                        $projectsystemid = $this->session->userdata('system_value');
                        //echo $projectsystemid;die;
                      }

                      else if(isset($_POST['projsystem']))
                      {
                        
                        $projectsystemid=$this->input->post('projsystem');
                      }
                      else if(isset($prcdata['system']))
                      {
                        
                        $projectsystemid=$prcdata['system'];
                      }
                      else
                      {

                      }
                      if(isset($sidemenu_sub_enable)) 
                      { 
                          if(($sidemenu_sub_enable)==0) 
                        { 
                            $enabled = 'disabled'; 
                          }  
                        else
                        {
                        $enabled = ''; 
                        }
                        } 
                      if($allsystems->num_rows()>0)
                      {
                        $allsystems_data=$allsystems->result_array();
                        foreach ($allsystems_data as $sd_key => $sd_value) {
                          $selected='';
                          //if(isset($prcdata['projectsystemid']))
                          //{
                            if($sd_value['id']==$projectsystemid)
                            {
                              $selected=' selected="selected" ';
                            }
                          //} 
                            //echo $projectsystemid;die;                      
                          echo '<option '.$enabled.' value="'.$sd_value['id'].'" '.$selected.'>'.$sd_value['systemname'].'</option>';
                        }
                      }

                      #echo '<pre>'; print_r($allsystems->result_array()); echo '</pre>';
                    ?>
                  </select>
                        <!--<input type="text" name="projsystem" class="form-control" value="<?php echo set_value('projsystem', (isset($prcdata['system'])) ? $prcdata['system'] : ''); ?>"> -->
                        <?php echo form_error('projsystem', '<div class="form-error">', '</div>'); ?>
                      </div>
                    </div>                  
                  </div>
                </div>

                <?php
                  /*$getProcesSecCat=$this->Common_model->getProcesSecCatByPrcId(5);
                  if($getProcesSecCat->num_rows()>0)
                  {
                    $getProcesSecCat_data=$getProcesSecCat->result_array();
                    foreach ($getProcesSecCat_data as $key => $value) {
                      
                    }
                  }*/

                  $procesSecCatid=5;
                  $getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($procesSecCatid);
                  $getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
                  
                  if($getProcesSecByCatid->num_rows()>0)
                  {
                    ?>
                    <div class="row form-group clearfix">
                      <div class="col-sm-12">
                        <h5><strong>FAN:</strong></h5>
                            <table class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th width="33%">Item</th>
                                  <th width="33%" class="text-center">Static Check</th>
                                  <th width="34%" class="text-center">Comments</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                              foreach ($getProcesSecByCatid_data as $key1 => $value1) {
                              
                              $commAirPreCommopt='';
                          $commAirPreCommcmd='';
                          $procesSectionId=0; 

                          $option1='';
                          $option2='';
                          $option3='';

                          if(intval($prcessid)!=0)
                          {
                            $processMasterdetails=$this->MProject->getFanPrefDetails($prcessid,$value1['id'],1);
                            if(!empty($processMasterdetails))
                            {
                              if($processMasterdetails->num_rows()>0)
                              {
                                $processMasterdata=$processMasterdetails->result_array();
                                
                                $commAirPreCommopt=$processMasterdata[0]['staticcheck'];
                                $commAirPreCommcmd=$processMasterdata[0]['comments'];
                                $procesSectionId=$processMasterdata[0]['id'];

                                if($commAirPreCommopt==1)
                                {
                                  $option1='checked="checked"';
                                }
                                elseif($commAirPreCommopt==2)
                                {
                                  $option2='checked="checked"';
                                }
                                elseif($commAirPreCommopt==3)
                                {
                                  $option3='checked="checked"';
                                }
                                else
                                {

                                }

                              }
                            }
                          }
                          $numcheck='';
                          if($value1['datatype']=='number')
                          {
                            $numcheck='num_'.intval($value1['numberofdecimal']).'decimal';
                          }
                              ?>
                                <tr>
                                  <td width="33%" class="text-left"><?php echo $value1['sectionname']; ?><span class="pull-right"><?php echo $value1['sectionuom']; ?></span><span class="clearfix"></span></td>
                                  <td width="33%" class="text-center">
                                  <input type="text" class="form-control <?php echo $numcheck; ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commAirPreCommopt<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('commAirPreCommopt'.$procesSecCatid.'_'.$value1['id'], (isset($commAirPreCommopt)) ? $commAirPreCommopt : ''); ?>" />
                                  </td>
                                  <td width="34%"><input type="text" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commAirPreCommcmd<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('commAirPreCommcmd'.$procesSecCatid.'_'.$value1['id'], (isset($commAirPreCommcmd)) ? $commAirPreCommcmd : ''); ?>" />
                                    <input type="hidden" name="procesSection<?php echo $procesSecCatid; ?>[]" value="<?php echo $value1['id']; ?>" />
                                    <input type="hidden" name="procesSectionId<?php echo $value1['id']; ?>" value="<?php echo $procesSectionId; ?>" />
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>                  
                              </tbody>
                            </table>
                            <input type="hidden" value="<?php echo $procesSecCatid; ?>" name="processSecCatid[]" />
                      </div>
                    </div>
                    <?php
                  }

                  $procesSecCatid=6;
                  $getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($procesSecCatid);
                  $getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
                  
                  if($getProcesSecByCatid->num_rows()>0)
                  {
                    ?>
                    <div class="row form-group clearfix">
                      <div class="col-sm-12">
                        <h5><strong>MOTOR:</strong></h5>
                            <table class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th width="33%">Item</th>
                                  <th width="33%" class="text-center">Static Check</th>
                                  <th width="34%" class="text-center">Comments</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                              foreach ($getProcesSecByCatid_data as $key1 => $value1) {
                              
                              $commAirPreCommopt='';
                          $commAirPreCommcmd='';
                          $procesSectionId=0; 

                          $option1='';
                          $option2='';
                          $option3='';

                          if(intval($prcessid)!=0)
                          {
                            $processMasterdetails=$this->MProject->getFanPrefDetails($prcessid,$value1['id'],1);
                            if(!empty($processMasterdetails))
                            {
                              if($processMasterdetails->num_rows()>0)
                              {
                                $processMasterdata=$processMasterdetails->result_array();
                                
                                $commAirPreCommopt=$processMasterdata[0]['staticcheck'];
                                $commAirPreCommcmd=$processMasterdata[0]['comments'];
                                $procesSectionId=$processMasterdata[0]['id'];

                                if($commAirPreCommopt==1)
                                {
                                  $option1='checked="checked"';
                                }
                                elseif($commAirPreCommopt==2)
                                {
                                  $option2='checked="checked"';
                                }
                                elseif($commAirPreCommopt==3)
                                {
                                  $option3='checked="checked"';
                                }
                                else
                                {

                                }

                              }
                            }
                          }
                          $numcheck='';
                          if($value1['datatype']=='number')
                          {
                            $numcheck='num_'.intval($value1['numberofdecimal']).'decimal';
                          }
                              ?>
                                <tr>
                                  <td width="33%" class="text-left"><?php echo $value1['sectionname']; ?><span class="pull-right"><?php echo $value1['sectionuom']; ?></span><span class="clearfix"></span></td>
                                  <td width="33%" class="text-center">
                                  <input type="text" class="form-control <?php echo $numcheck; ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commAirPreCommopt<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('commAirPreCommopt'.$procesSecCatid.'_'.$value1['id'], (isset($commAirPreCommopt)) ? $commAirPreCommopt : ''); ?>" />
                                  </td>
                                  <td width="34%"><input type="text" class="form-control" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commAirPreCommcmd<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('commAirPreCommcmd'.$procesSecCatid.'_'.$value1['id'], (isset($commAirPreCommcmd)) ? $commAirPreCommcmd : ''); ?>" />
                                    <input type="hidden" name="procesSection<?php echo $procesSecCatid; ?>[]" value="<?php echo $value1['id']; ?>" />
                                    <input type="hidden" name="procesSectionId<?php echo $value1['id']; ?>" value="<?php echo $procesSectionId; ?>" />
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>                  
                              </tbody>
                            </table>
                            <input type="hidden" value="<?php echo $procesSecCatid; ?>" name="processSecCatid[]" />             
                      </div>
                    </div>
                    <?php
                  }

                  $procesSecCatid=7;
                  $getProcesSecByCatid=$this->Common_model->getProcesSecByCatid($procesSecCatid);
                  $getProcesSecByCatid_data=$getProcesSecByCatid->result_array();
                  
                  if($getProcesSecByCatid->num_rows()>0)
                  {
                    ?>
                    <div class="row form-group clearfix">
                      <div class="col-sm-12">
                        <h5><strong>PERFORMANCE:</strong></h5>
                            <table class="table table-bordered table-striped" id="fan-performancelist">
                              <thead>
                                <tr>
                                  <th width="33%">Item</th>
                                  <th width="23%" class="text-center">Design Data</th>
                                  <th width="22%" class="text-center">Test Data No.1</th>
                                  <th width="22%" class="text-center">Test Data No.2</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                              foreach ($getProcesSecByCatid_data as $key1 => $value1) {
                              
                              $commAirPreCommopt='';
                              $commAirPreCommtestdata='';
                              $commAirPreCommtestdata1='';
                          $commAirPreCommcmd='';
                          $procesSectionId=0; 

                          $option1='';
                          $option2='';
                          $option3='';

                          if(intval($prcessid)!=0)
                          {
                            $processMasterdetails=$this->MProject->getFanPrefDetails($prcessid,$value1['id'],1);
                            if(!empty($processMasterdetails))
                            {
                              if($processMasterdetails->num_rows()>0)
                              {
                                $processMasterdata=$processMasterdetails->result_array();
                                
                                $commAirPreCommopt=$processMasterdata[0]['staticcheck'];
                                $commAirPreCommtestdata=$processMasterdata[0]['testdata'];
                                $commAirPreCommtestdata1=$processMasterdata[0]['testdata1'];

                                $testdata_ans=$processMasterdata[0]['testdata_ans'];
                                $testdata1_ans=$processMasterdata[0]['testdata1_ans'];

                                $commAirPreCommcmd=$processMasterdata[0]['comments'];
                                $procesSectionId=$processMasterdata[0]['id'];

                                if($commAirPreCommopt==1)
                                {
                                  $option1='checked="checked"';
                                }
                                elseif($commAirPreCommopt==2)
                                {
                                  $option2='checked="checked"';
                                }
                                elseif($commAirPreCommopt==3)
                                {
                                  $option3='checked="checked"';
                                }
                                else
                                {

                                }

                              }
                            }
                          }
                          $numcheck='';
                          if($value1['datatype']=='number')
                          {
                            $numcheck='num_'.intval($value1['numberofdecimal']).'decimal';
                          }
                              ?>
                                <tr class="fanperformancelisttr">
                                  <td width="33%" class="text-left"><?php echo $value1['sectionname']; ?><span class="pull-right"><?php echo $value1['sectionuom']; ?></span><span class="clearfix"></span></td>
                                  <td width="23%" class="text-center">
                                  <input type="text" class="form-control commAirPreCommopt <?php echo $numcheck; ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commAirPreCommopt<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('commAirPreCommopt'.$procesSecCatid.'_'.$value1['id'], (isset($commAirPreCommopt)) ? $commAirPreCommopt : ''); ?>" />
                                  </td>
                                  <td width="22%">
                                    <?php if($key1==0) { ?>
                                      <div class="row clearfix"><div class="col-sm-6">
                                    <?php } ?>
                                    <input type="text" class="form-control commAirPreCommtestdata <?php if($key1==0) { echo $numcheck; } ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commAirPreCommtestdata<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('commAirPreCommtestdata'.$procesSecCatid.'_'.$value1['id'], (isset($commAirPreCommtestdata)) ? $commAirPreCommtestdata : ''); ?>" />  
                                    <?php if($key1==0) { ?>
                                      </div>
                                      <div class="col-sm-6">
                                      <input type="text" readonly class="form-control testdata_ans" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="testdata_ans<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('testdata_ans'.$procesSecCatid.'_'.$value1['id'], (isset($testdata_ans)) ? $testdata_ans : ''); ?>" />
                                      </div>
                                      </div>
                                    <?php } ?>
                                  </td>
                                  <td width="22%">
                                  <?php if($key1==0) { ?>
                                      <div class="row clearfix"><div class="col-sm-6">
                                    <?php } ?>
                                  <input type="text" class="form-control commAirPreCommtestdata1 <?php if($key1==0) { echo $numcheck; } ?>" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commAirPreCommtestdata1<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('commAirPreCommtestdata1'.$procesSecCatid.'_'.$value1['id'], (isset($commAirPreCommtestdata1)) ? $commAirPreCommtestdata1 : ''); ?>" />
                                  <?php if($key1==0) { ?>
                                      </div>
                                      <div class="col-sm-6">
                                      <input type="text" readonly class="form-control testdata1_ans" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="testdata1_ans<?php echo $procesSecCatid.'_'.$value1['id']; ?>" placeholder="" value="<?php echo set_value('testdata1_ans'.$procesSecCatid.'_'.$value1['id'], (isset($testdata1_ans)) ? $testdata1_ans : ''); ?>" />
                                      </div>
                                      </div>
                                    <?php } ?>
                                    <input type="hidden" name="procesSection<?php echo $procesSecCatid; ?>[]" value="<?php echo $value1['id']; ?>" />
                                    <input type="hidden" name="procesSectionId<?php echo $value1['id']; ?>" value="<?php echo $procesSectionId; ?>" />
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>                  
                              </tbody>
                            </table>  
                            <input type="hidden" value="<?php echo $procesSecCatid; ?>" name="processSecCatid[]" />           
                      </div>
                    </div>
                    <?php
                  }
                ?>

                <div class="row form-group clearfix">
                  <div class="col-sm-12">
                    <label><strong>Comments:</strong></label>
                    <textarea class="form-control" name="commaircomments" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>><?php echo set_value('commaircomments', (isset($prcdata['comments'])) ? $prcdata['comments'] : ''); ?></textarea>
                  </div>
                </div>

                <div class="row form-group clearfix">
                  <div class="col-sm-4">                  
                    <label><strong>Engineer:</strong><span class="mandatory"> *</span></label>
                    <select class="form-control" name="commairreptenggsign" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?>>
                      <option value="">Please Select</option>
                      <?php
                        $commairreptenggsign=0;
                        if(isset($_POST['commairreptenggsign']))
                        {
                          $commairreptenggsign=$this->input->post('commairreptenggsign');
                        }
                        elseif(isset($prcdata['engineerid']))
                        {
                          $commairreptenggsign=$prcdata['engineerid'];
                        }
                        elseif(isset($_SESSION['commAir_syscert_slected_engineer']))
                        {
                          $commairreptenggsign=$_SESSION['commAir_syscert_slected_engineer'];
                        }
                        else{
                          
                        }
                                                if(isset($sidemenu_sub_enable)) 
                        { 
                          if(($sidemenu_sub_enable)==0) 
                          { 
                          $enabled = 'disabled'; 
                          }  
                          else
                          {
                          $enabled = ''; 
                          }
                        }                         
                        if(!empty($engdata))
                        {
                          foreach ($engdata as $eng_key => $eng_value) {
                            $selected='';
                            if(($eng_value['userid']==$commairreptenggsign))
                            {
                              $selected=' selected="selected" ';
                            }
                            echo '<option '.$enabled.' value="'.$eng_value['userid'].'" '.$selected.'>'.$eng_value['firstname'].' '.$eng_value['lastname'].'</option>';
                          }
                        }
                      ?>
                    </select>
                            <?php echo form_error('commairreptenggsign', '<div class="form-error">', '</div>'); ?>
                  </div>
                  <div class="col-sm-4">
                    <label><strong>Date:</strong><span class="mandatory"> *</span></label>
                    <input type="text" class="form-control datepicker" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'readonly="true"'; }  } ?> name="commairreptenggdate" placeholder="" value="<?php echo set_value('commairreptenggdate', (isset($prcdata['reportdate'])) ? date(DT_FORMAT,strtotime($prcdata['reportdate'])) : date(DT_FORMAT)); ?>" />
                            <?php echo form_error('commairreptenggdate', '<div class="form-error">', '</div>'); ?>
                  </div>
                  
                </div>


                  </div>          
          </div>
        </div>
        <footer class="panel-footer text-right bg-light lter"> 
        <input type="hidden" name="shtenadis" class="shtenadis" value="<?php echo set_value('shtenadis', (isset($sheetstatus[0]['status'])) ? $sheetstatus[0]['status'] : '1'); ?>" />
          <input type="hidden" name="existid" value="<?php echo $this->uri->segment(4); ?>" />

          <input type="hidden" name="projectid" id="projectid" value="<?php echo $proid; ?>">
          <input type="hidden" name="sheetid" id="sheetid" value="<?php echo $prcessid; ?>">

          <input type="submit" name="submit" value="Submit" class="btn btn-success btn-sm submit-btn addnew" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
          <input type="submit" name="cancel" value="Cancel" class="btn btn-danger btn-sm submit-btn cancel" <?php if(isset($sidemenu_sub_enable)) { if(($sidemenu_sub_enable)==0) { echo 'disabled="disabled"'; }  } ?>>
          
        </footer>

      </form>
      </div>
      
    </section>
  </section>
</section>
