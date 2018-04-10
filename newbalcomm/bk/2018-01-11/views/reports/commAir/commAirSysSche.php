<?php
	$prcdatas=$this->MProject->getCAsysschemenew($prcessid);
    $prcdata=$prcdatas[0];

$htmlnew='<table border="0" cellpadding="10" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th align="right" colspan="2" style="border:0px;"><strong>'.$title.'</strong></th>
		</tr>
	</thead>
</table><br>
<table border="1" cellpadding="10" cellspacing="0" width="100%">	
	<tbody>
		<tr>
			<td width="60%"><strong>Project:</strong>'.$prodata['projectname'].'</td>
			<td width="40%"><strong>Ref:</strong>'.$prcdata['referenceno'].'</td>
		</tr>
		<tr>
			<td width="60%"><strong>System:</strong>'; 
				$projectsystemid=$prcdata['system'];				
				$allsystems=$this->MReports->getSystemsbyid($proid,$projectsystemid);
				$htmlnew.=$allsystems[0]['systemname'];
			$htmlnew.='</td>
			<td width="40%">';

				$sheetnumber=$prcdata['sheetnumber'];
				$htmlnew.=$this->MReports->displaySheetNumText(PRJPRCLST,intval($sheetnumber),$masterprcid);
			$htmlnew.='</td>
		</tr>		
	</tbody>
</table><br>
';	
	$imgcnt=0;
	$mpdf->WriteHTML($htmlnew);	
			$getsysFiles=$this->MProject->getsysFilesPrzid(intval($prcessid),CASYSSCHE);  
			$getsysFilescnt=$getsysFiles->num_rows();
	        if($getsysFiles->num_rows()>0)
            {
                $getsysFilesdata=$getsysFiles->result_array();
                foreach ($getsysFilesdata as $key => $value) {
                								    	
                			if($value['filetype']!='application/pdf')
                	    	{
                	    		
                	    		$imgcnt++;
                	    		if(($key!=0)&&($getsysFilescnt!=($key+1)))
                				//if(($key!=0))
	        	    			{
                	    			$mpdf->WriteHTML('<pagebreak />');
                	    		}                	    		
                	    		//$mpdf->Image(base_url(UPATH.$value['filestorename']),0,0,210,297,'jpg','',true, true);

                	    		$htmlnew='<img id="img-upload" src="';
                	    		if(isset($value['filestorename'])&&(!empty($value['filestorename']))){							    		
                	    			$htmlnew.=base_url(UPATH.$value['filestorename']);
                	    		}
                	    		$htmlnew.='"   />';
                				$mpdf->WriteHTML($htmlnew);
                	    	}
                }
            }
     $htmlnew='<br>';
	$mpdf->WriteHTML($htmlnew);

	$getsysFiles=$this->MProject->getsysFilesPrzid(intval($prcessid),CASYSSCHE);  
	        if($getsysFiles->num_rows()>0)
            {
                $getsysFilesdata=$getsysFiles->result_array();
                foreach ($getsysFilesdata as $key => $value) {
        	    	{
        	    		if($value['filetype']=='application/pdf')
        	    		{

							$mpdf->SetImportUse();
							$pagecount = $mpdf->SetSourceFile(DROOT.UPATH.$value['filestorename']);
						    for ($i=1; $i<=$pagecount; $i++) {
						    	$mpdf->AddPage();
						        $import_page = $mpdf->ImportPage($i);
						        //$mpdf->AddPage('','NEXT-ODD','','','','','','','','','','','','','',-1,-1,-1,-1);
						        $mpdf->UseTemplate($import_page);
						    }
						    if(($getsysFilescnt==($key+1)))
						    {
						    	$mpdf->WriteHTML($key.'<pagebreak />');
						    }
						}
						//$pdf->Output();
        	    	}
                }
            }

	
$htmlnew1='<table border="1" cellpadding="10" cellspacing="0" width="100%">
	<tbody>
		<tr>
			<td width="40%"><strong>Engineer:</strong>&nbsp;';
				$getUserByid=$this->MReports->getUserByid($prcdata['engineerid']);
				$getUserByiddata=$getUserByid->result_array();
				$htmlnew1.=$getUserByiddata[0]['firstname'].' '.$getUserByiddata[0]['lastname'];
			$htmlnew1.='</td>
			<td width="60%"><strong>Date:</strong>&nbsp;'.date(DT_FORMAT,strtotime($prcdata['reportdate'])).'</td>
		</tr>
	</tbody>
</table>';
$mpdf->WriteHTML($htmlnew1);
//$mpdf->WriteHTML('<pagebreak />');
