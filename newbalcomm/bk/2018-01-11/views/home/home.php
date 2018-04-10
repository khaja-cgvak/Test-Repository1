<section class="vbox">
    <section class="scrollable padder">
        <section class="panel panel-default">
            <header class="panel-heading"><b>Dashboard</b> </header>
            <div class="panel-body">
                <div class="">
					<table class="table table-striped m-b-none table-bordered dt-responsive nowrap" id="projectlist_home" width="100%">
						<thead>
							<tr>
								<th width="16%">Project Name</th>
								<th width="16%">Site Name</th>
								<th width="16%">Contact Name</th>
								<th width="16%">Project<br>Description</th>
								<th width="16%">Customer<br>Name</th>							
								<th width="20%">Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cuser=$this->session->userdata('userid');
        					$roleid=$this->session->userdata('userroleid');
	        					$this->db->select('p.*,u.custname,sn.sitename, cn.contactfirstname, cn.contactlastname');
	        					$this->db->join(CUSTOMER.' u','(u.id = p.userincharge)','left');
	        					if(($roleid!=1)&&($cuser!=1))
						        {
						        	$this->db->join(PROJURS.' pus','(p.id = pus.projid and pus.userid='.intval($cuser).')','left');
						        	$this->db->where('pus.userid',intval($cuser));
							    }
							    $this->db->join(CUSSITES.' sn','(sn.id = p.siteid)','left');
							    $this->db->join(CUSDETAILS.' cn','(cn.id = p.contactid)','left');
	        					$this->db->where('p.isdeleted','N');	        					
								$allprj=$this->db->get(PROJECTS.' p');

								$segarrval='projects/projview';
								$ckpermission=$this->Common_model->ckRolePermission($roleid,$segarrval);
								$ckpermproview=$ckpermission;

								if($allprj->num_rows()>0)
								{
									$allprjdata=$allprj->result_array();
									foreach ($allprjdata as $key => $value) {

										$percentage=$this->CHome->getProjectPrecentage($value['id']);
										$percentageclass="progress-bar-danger";
										$progressclass='';
										if($percentage>25 and $percentage<=50)
										{
											$percentageclass="progress-bar-info";            			
										}
										elseif($percentage>50 and $percentage<=75)
										{
											$percentageclass="progress-bar-warning";            			
										}
										elseif($percentage>75)
										{
											$percentage=100;
											$percentageclass="progress-bar-success";            			
										}
										else
										{
											$percentageclass="progress-bar-danger";
										}

										if(intval($percentage)==0)
										{
											$progressclass='color:#333;"';
										}

										$newpid=$this->Common_model->encodeid($value['id']);
										$action='';

					            		if($ckpermproview==true)
					                    {
					                        $action.='<a href="'.site_url('projects/projview/'.$newpid).'"  data-toggle="tooltip"  title="Project Process">';
					                    }

					                    $action.='<div class="progress" style="margin:10px 0px;">
										  <div class="progress-bar '.$percentageclass.' progress-bar-striped" role="progressbar" role="progressbar" aria-valuenow="70"
										  aria-valuemin="0" aria-valuemax="100" style="width:'.intval($percentage).'%;'.$progressclass.'">&nbsp;&nbsp;'.$percentage.'%&nbsp;&nbsp;</div>
										</div> ';
										if($ckpermproview==true)
					                    {
					                        $action.='</a>';
					                    }
					                    if($percentage<100)
					                    {
											echo '<tr>
												<td>'.$value['projectname'].'</td>
												<td>'.$value['sitename'].'</td>
												<td>'.$value['contactfirstname'].' '.$value['contactlastname'].'</td>
												<td>'.$value['projectdescription'].'</td>
												<td>'.$value['custname'].'</td>
												<td>'.$action.'</td>
											</tr>';
										}
									}
								}
							?>
						</tbody>
					</table>
				</div>
            </div>
        </section>
    </section>
</section>