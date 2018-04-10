var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

var toast_top_center = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
var searrolestatus='all';

function updatepad($)
    {
    	var winwid=$(this).width();
    	var page_footer=$('.page_footer').height();
    	var alerthei=($('#content .alert2.alert-success:first').height()*2);
    	
    	page_footerval=(page_footer*1.5);
    	if(winwid>767)
    	{
    		$('#content .scrollable.padder:first').css('margin-bottom',(page_footer+page_footerval+alerthei));
    	}
    	else
    	{
    		$('#content .scrollable.padder:first').css('margin-bottom',(0));
    	}
    }

function processMenuAction($)
{
	$('.processcarnavli').each(function(){
    	var inul=$(this).find('ul');
    	if(inul.length==0)
    	{
    		$(this).find('.processcarnav').remove();
    	}

    	var listItems = $(this).find(".active_a" ).closest('li');
		var indexlist=$(this).find(".active_a" ).closest('ul').find('li').index( listItems )+1;
		if(indexlist!=0)
		{
			$(this).find('.processcarnav').html(indexlist+' to '+$(inul).find('li').length);
		}
		else
		{
			$(this).find('.processcarnav').html('0 to '+$(inul).find('li').length);
		}
    });
}

var img_upload='';
if(document.getElementById('img-upload'))
{
	img_upload=document.getElementById('img-upload').getAttribute("src"); 
}
function readURL(input,$) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#img-upload').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
        $('#image-details').show();
    }
    //if($('#img-upload').attr('src')=="")
    else
    {
    	if(img_upload=="")
    	{
    		$('#image-details').hide();  
    		$('#img-upload').attr('src','');  	
    	}
    	else
    	{
    		$('#image-details').show();  
    		$('#img-upload').attr('src', img_upload);    		
    	}
    }

}

function projsystem_change($)
{
	$.ajax({
		type:'POST',
		url: base_url+"projects/getSysDrpOpt", 				
		data:{'sysid':$('#projsystem').val()},		
		dataType:'json',
		contentType: "application/x-www-form-urlencoded",
		async:false,
		success: function(result){			
			if(result.datacnt>0)
			{
				$('input[name="commairwitness"]').val(result.datas.witnessby);
				$('input[name="commaircmpy"]').val(result.datas.company);
				$('input[name="commairwitdate"]').val(result.datas.witnessdate);

				$('input[name="commairtestcomp"]').val(result.datas.testedby);
				$('input[name="commairsercontract"]').val(result.datas.contractor);
				$('input[name="commairtestcompdate"]').val(result.datas.testedate);
				$("#selected_engineer_id").val(result.datas.testedid);
			}
    	}
	});

}

function plotrcdtable1RightCal($)
{
	/* === Decimal ===
		
		total_velocity = 1
		average_velocity = 2
		actual_volume = 3

		plotrcddesign=0
		no_test_points=0

	*/

	//alert($('#plotrcdtable1 .volume[value!=""]').val().length);
	var totalvel_sum=0;
	var nonEmptyInputs = $('#plotrcdtable1 .volume').filter(function(){
		if((this.value!="")&&(this.value!=".")&&(this.value!="0"))
		{
			totalvel_sum+=parseFloat(this.value);
		}
    	return this.value.length > 0;
	});
	
	var flow_rate_m3_s	=	parseFloat($('.flow_rate_m3_s').val());
	var duct_area_m2	=	parseFloat($('.duct_area_m2').val());
	var no_test_points	=	nonEmptyInputs.length;
	var total_velocity	=	totalvel_sum.toFixed(1);
	var average_velocity=	(total_velocity/no_test_points).toFixed(2);
	var actual_volume	=	(average_velocity*duct_area_m2).toFixed(3);
	var plotrcddesign	=	((actual_volume/flow_rate_m3_s)*100).toFixed(0);

	if(flow_rate_m3_s==null || !$.isNumeric(flow_rate_m3_s))
	{
		total_velocity='';	
		average_velocity='';
		actual_volume='';
		plotrcddesign='';
		no_test_points='';
	}

	if(total_velocity==null || !$.isNumeric(total_velocity))
	{
		total_velocity='';
	}
	if(average_velocity==null || !$.isNumeric(average_velocity))
	{
		average_velocity='';
	}
	if(actual_volume==null || !$.isNumeric(actual_volume))
	{		
		actual_volume='';
	}
	if(plotrcddesign==null || !$.isNumeric(plotrcddesign))
	{
		plotrcddesign='';
		no_test_points='';
	}
	if(no_test_points==null || !$.isNumeric(no_test_points))
	{
		no_test_points='';
	}




	$('.total_velocity').val(total_velocity);
	$('.average_velocity').val(average_velocity);
	$('.no_test_points').val(no_test_points);
	$('.actual_volume').val(actual_volume);
	$('.plotrcddesign').val(plotrcddesign);

	//console.log(nonEmptyInputs);

}

function grillegridCal($)
{

	var totalvel_sum=0;

	$('#grillegrid .grillegridtr').each(function(key,value){
		var closest=$(this);

		var grilleno=$(closest).find('.grilleno');
		var grille_hood_size=$(closest).find('.grille_hood_size');
		var area=$(closest).find('.area');
		var design_volume=$(closest).find('.design_volume');
		var design_velocity=$(closest).find('.design_velocity');
		var final_velocity=$(closest).find('.final_velocity');
		var measured_volume=$(closest).find('.measured_volume');
		var correction_factor=$(closest).find('.correction_factor');
		var actual_volume=$(closest).find('.actual_volume');
		var design=$(closest).find('.design');

		var grilleno_val=$(grilleno).val();
		var grille_hood_size_val=$(grille_hood_size).val();
		var area_val=$(area).val();
		
		var design_volume_val=$(design_volume).val();
		var final_velocity_val=$(final_velocity).val();


		var design_velocity_val=(design_volume_val/area_val).toFixed(2);
		if(!$.isNumeric(design_velocity_val) || !$.isNumeric(design_volume_val))
		{
			design_velocity_val='';
		}	
		$(design_velocity).val(design_velocity_val);

		
		var measured_volume_val=(final_velocity_val*area_val).toFixed(3);
		if(!$.isNumeric(measured_volume_val) || !$.isNumeric(final_velocity_val))
		{
			measured_volume_val='';
		}
		else
		{
			totalvel_sum+=parseFloat(measured_volume_val);
		}
		$(measured_volume).val(measured_volume_val);

	});

	if(!$.isNumeric(totalvel_sum) || totalvel_sum==0)
	{
		totalvel_sum='';
	}

	$('.grillehoodtotal').val(totalvel_sum.toFixed(3));

	var grilleductotal=$('.grilleductotal').val();
	var grillehoodtotal=$('.grillehoodtotal').val();

	var measured_volume1=(grilleductotal/grillehoodtotal).toFixed(2);			
	if(!$.isNumeric(measured_volume1))
	{
		measured_volume1='';
	}
	$('.grillecorrfactor').val(measured_volume1);

	$('#grillegrid .grillegridtr').each(function(key,value){
		var closest=$(this);

		var grilleno=$(closest).find('.grilleno');
		var grille_hood_size=$(closest).find('.grille_hood_size');
		var area=$(closest).find('.area');
		var design_volume=$(closest).find('.design_volume');
		var design_velocity=$(closest).find('.design_velocity');
		var final_velocity=$(closest).find('.final_velocity');
		var measured_volume=$(closest).find('.measured_volume');
		var correction_factor=$(closest).find('.correction_factor');
		var actual_volume=$(closest).find('.actual_volume');
		var design=$(closest).find('.design');

		var grilleno_val=$(grilleno).val();
		var grille_hood_size_val=$(grille_hood_size).val();
		var area_val=$(area).val();
		
		var design_volume_val=$(design_volume).val();
		var final_velocity_val=$(final_velocity).val();

		var correction_factor_val=$('.grillecorrfactor').val();
		var measured_volume_val=measured_volume.val();

		if(!$.isNumeric(final_velocity_val))
		{
			correction_factor_val='';
		}

		$(correction_factor).val(correction_factor_val);
		

		var actual_volume_val=(measured_volume_val*correction_factor_val).toFixed(3);
		if(!$.isNumeric(actual_volume_val) || !$.isNumeric(final_velocity_val))
		{
			actual_volume_val='';
		}
		$(actual_volume).val(actual_volume_val);

		var design_val=((actual_volume_val/design_volume_val)*100).toFixed(0);
		if(!$.isNumeric(design_val) || !$.isNumeric(final_velocity_val))
		{
			design_val='';
		}
		$(design).val(design_val);
	});

}
function dirgrillegridCal($)
{
	var totalvel_sum=0;  

	var nonEmptyInputs = $('#dirgrillegrid .final_volume').filter(function(){
		if((this.value!="")&&(this.value!=".")&&(this.value!="0"))
		{
			totalvel_sum+=parseFloat(this.value);
		}
    	return this.value.length > 0;
	});

	$('#dirgrillegrid .dirgrillegridtr').each(function(){

		var ref_no=$(this).find('.ref_no');
		var grille_size=$(this).find('.grille_size');
		var design_volume=$(this).find('.design_volume');
		var final_volume=$(this).find('.final_volume');
		
		var actual_volume=$(this).find('.actual_volume');
		var record_percent=$(this).find('.record_percent');
		var setting=$(this).find('.setting');

		$('.grillehoodtotal').val(totalvel_sum.toFixed(1));

		var grillehoodtotal=$('.grillehoodtotal').val();
		var grilleductotal=$('.grilleductotal').val();
		var grillecorrfactor=(grilleductotal/grillehoodtotal).toFixed(2);
		if(!$.isNumeric(grillecorrfactor))
		{
			grillecorrfactor='';
		}
		$('.grillecorrfactor').val(grillecorrfactor);

		$('.correction_factor').val($('.grillecorrfactor').val());
		var correction_factor=$(this).find('.correction_factor');
		if(!$.isNumeric(final_volume.val()))
		{
			correction_factor.val('');
		}
		
		//alert(final_volume.val()+'*'+correction_factor.val());

		var actu_val=(final_volume.val()*correction_factor.val()).toFixed(1);
		
		if(!$.isNumeric(actu_val) || !$.isNumeric(final_volume.val()))
		{
			actu_val='';
		}

		$(actual_volume).val(actu_val);

		if(($.isNumeric(actual_volume.val()) && $.isNumeric(design_volume.val()))&&($.isNumeric(final_volume.val())))
		{
			$(record_percent).val(((actual_volume.val()/design_volume.val())*100).toFixed(0));
		}
		else
		{
			$(record_percent).val(0);			
		}
	});
}

function vlmCtrlCal($)
{
	$('#vlmctrlgrid .vlmctrlgridtr').each(function(){
		var min_vol_m3s=$(this).find('.min_vol_m3s').val();
		var min_flow_m3_s=$(this).find('.min_flow_m3_s').val();
		var min_percentage=((min_vol_m3s/min_flow_m3_s)*100).toFixed(0);

		

		if(!$.isNumeric(min_percentage) || !$.isNumeric(min_flow_m3_s))
		{
			min_percentage='';
		}

		$(this).find('.min_percentage').val(min_percentage);

		var max_vol_m3s=$(this).find('.max_vol_m3s').val();
		var max_flow_m3_s=$(this).find('.max_flow_m3_s').val();
		var max_percentage=((max_vol_m3s/max_flow_m3_s)*100).toFixed(0);
		if(!$.isNumeric(max_percentage) || !$.isNumeric(max_flow_m3_s))
		{
			max_percentage='';
		}
		$(this).find('.max_percentage').val(max_percentage);

	});
}



$(document).ready(function(){

	$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });

	$(document).on('click', '.privilagepanel .panel-heading span.clickable', function(e){
	    var $this = $(this);
		//alert($this);
		if(!$this.hasClass('panel-collapsed')) {
			$this.closest('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
		} else {
			$this.closest('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		}
	});

	$('body').delegate('.prvOptPageid','click',function(){
		if($(this).prop('checked'))
		{
			$(this).next('.prvOptPageids').val(1);
		}
		else
		{
			$(this).next('.prvOptPageids').val(0);
		}
	});
	
	if(document.getElementById('userlist_tables'))
	{		
		$.fn.dataTable.ext.errMode = 'none';
			var userlist_tables=$('#userlist_tables').DataTable( {
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
			"sPaginationType": "full_numbers",
			//"sPaginationType": "first_last_numbers",
			"ajax": { 
				url: base_url+"users/getallUsers"
			},
			oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ],
			"fnDrawCallback": function (oSettings) {
				$('[data-toggle="tooltip"]').tooltip(); 
			}
		} );
		
		//userlist_tables.ajax.reload();
	}
	
	// delete User
	$('body').delegate('.delete_user_acc','click',function(){
		var id=$(this).attr('data-id');

		$.ajax({
		  url: base_url + 'users/deleteuserscheck/' + id,
		  method: "POST",
		  async:false,
		  data: { id : id },
		  dataType: "html",
		  success:function(res){
		  	if($.isNumeric(res) && res>0)
		  	{
		  		bootbox.alert({				  
		  			message: "Unable to delete this User, it has been refered to Projects.",
				});
		  	}
		  	else
		  	{
		  		bootbox.confirm({
  					message: "Do you want to delete this user details?",
  					buttons: {
  						confirm: {
  							label: 'Yes',
  							className: 'btn-success'
  						},
  						cancel: {
  							label: 'No',
  							className: 'btn-danger'
  						}
  					},
  					callback: function (result) {
  						if(result==true)
  						{
  							window.location.href = base_url + 'users/delete_user/' + id;
  						}
  					}
  				});
		  	}
		  }
		});
	});
	
	
	/* ==================================== User Role ============================================ */
	
	if(document.getElementById('userroles_tables'))
	{	
		//searchfilterroles		
		$.fn.dataTable.ext.errMode = 'none';
			var userroles_tables=$('#userroles_tables').DataTable( {
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"sDom": "<'row'<'col-sm-4'l><'col-sm-4 searchfilterroles text-center'><'col-sm-4'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
			"sPaginationType": "full_numbers",
			//"sPaginationType": "first_last_numbers",
			"ajax": { 
				url: base_url+"roles/getallRoles",
				"data": function ( d ) {
	                d.rrolestatus=searrolestatus;
	                // d.custom = $('#myInput').val();
	                // etc
            	},
				//data:{'rrolestatus':$('#searrolestatus').val()},
				beforeSend: function (xhrObj) {
					var searchfilterroles=$('.searchfilterroles').html();
					if(searchfilterroles=="")
					{
						$searfilval='<label>Status:&nbsp;';
						$searfilval+='<select class="form-control input-sm" name="searrolestatus" id="searrolestatus">';
						$searfilval+='<option value="all">All</option>';
						$searfilval+='<option value="1" selected>Active</option>';
						$searfilval+='<option value="0">Inactive</option>';
						$searfilval+='</select>';
						$searfilval+='</label>';
						$('.searchfilterroles').html($searfilval);
					}
		        },
				dataSrc: function(d){					
					return d.data;    
			 }			 
			},
			//"sAjaxSource": base_url+"roles/getallRoles",
			"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ],
			 oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
			"fnDrawCallback": function (oSettings) {				
				$('[data-toggle="tooltip"]').tooltip(); 
			}
			/*"fnServerData": function ( sSource, aoData, fnCallback ) {
				aoData.push( { "name": "more_data", "value": "my_value" } );
				$.getJSON( sSource, aoData, function (json) { fnCallback(json) } );
			}*/
		} );

			$('body').delegate('#searrolestatus','change',function(){
				searrolestatus=$(this).val();
				var table = $('#userroles_tables').DataTable();
				table.ajax.reload();
			});
		
		//userlist_tables.ajax.reload();
	}
	
	// delete User Role
	$('body').delegate('.user_roles_acc','click',function(){
		var id=$(this).attr('data-id');

		$.ajax({
		  url: base_url + 'roles/deleterolecheck/' + id,
		  method: "POST",
		  async:false,
		  data: { id : id },
		  dataType: "html",
		  success:function(res){
		  	if($.isNumeric(res) && res>0)
		  	{
		  		bootbox.alert({				  
		  			message: "Unable to delete this Role, it has been refered to User(s).",
				});
		  	}
		  	else
		  	{
		  		bootbox.confirm({
		  			message: "Do you want to delete this role details?",
		  			buttons: {
		  				confirm: {
		  					label: 'Yes',
		  					className: 'btn-success'
		  				},
		  				cancel: {
		  					label: 'No',
		  					className: 'btn-danger'
		  				}
		  			},
		  			callback: function (result) {
		  				if(result==true)
		  				{
		  					 window.location.href = base_url + 'roles/delete_role/' + id;
		  				}
		  			}
		  		});
		  	}
		  }
		});
		return false;
	});
	
	
	/* =============================== Customer Section =============================== */
	
	if(document.getElementById('customerlist_tables'))
	{
		$.fn.dataTable.ext.errMode = 'none';
			var userroles_tables=$('#customerlist_tables').DataTable( {
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
			"sPaginationType": "full_numbers",
			//"sPaginationType": "first_last_numbers",
			"ajax": { 
				url: base_url+"customer/getallCustomers",
				dataSrc: function(d){
					
					return d.data;    
			 }
			},
			"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ],
			 oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
			"fnDrawCallback": function (oSettings) {
				$('[data-toggle="tooltip"]').tooltip(); 
			}
			  
		} );
	}

	if(document.getElementById('customercontactlist_tables'))
	{
		var cususerid=$('#userid').val();

		$.fn.dataTable.ext.errMode = 'none';
			var userroles_tables=$('#customercontactlist_tables').DataTable( {
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
			"sPaginationType": "full_numbers",
			//"sPaginationType": "first_last_numbers",
			"ajax": { 
				url: base_url+"customer/getallCustomersContacts/"+cususerid,
				dataSrc: function(d){
					
					return d.data;    
			 }
			},
			"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ],
			 oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
			"fnDrawCallback": function (oSettings) {
				$('[data-toggle="tooltip"]').tooltip(); 
			}
			  
		} );

		$('.addcustomercont').submit(function(){
			$('.form-error').remove();
			$('.has-error').removeClass('has-error');
			var custid=$(this).find('#custid').val();
			$.ajax({
			  url: base_url + 'customer/addeditcustomercont/' + custid,
			  method: "POST",
			  async:false,
			  data: $(this).serialize(),
			  dataType: "json",
			  success:function(res){
			  	if(res.action=='success')
			  	{
			  		toastr.success('',res.actmsg,toast_top_center);
			  		var table = $('#customercontactlist_tables').DataTable();
					table.ajax.reload();
					$('.btnreset').click();
					$('.form-error').remove();
					$('.has-error').removeClass('has-error');
			  		/*var table=$('#customercontactlist_tables').DataTable();
			  		table.fnDraw();*/
			  	}
			  	else
			  	{
			  		//<div class="form-error"></div>
			  		//toastr.error('',"",toast_top_center);
			  		$(res.actmsg).each(function(key,value){
			  			for (var key1 in value) {
					      //if (value.hasOwnProperty(key1)) 
					      if(value[key1]!="")
			  				{
			  					$('input[name="'+key1+'"]').after('<div class="form-error">'+value[key1]+'</div>');
			  					$('input[name="'+key1+'"]').closest('.col-sm-4').addClass('has-error');
			  				}
					    }
			  		});
			  	}
			  }
			});
			return false;
		});
		$('body').delegate('.editcuscontact','click',function(){
			//
			var custid=$('.addcustomercont #custid').val();
			var contid=$(this).attr('data-id');
				$.ajax({
				  url: base_url + 'customer/getcustomerContact/' + custid,
				  method: "POST",
				  async:false,
				  data: {'contid':contid,'custid':custid},
				  dataType: "json",
				  success:function(res){
				  	if(res.action=='success')
				  	{
				  		$(res.actmsg).each(function(key,value){			  			
				  			
				  			$('input[name="contactfirstname"]').val(value.contactfirstname);
				  			$('input[name="contactlastname"]').val(value.contactlastname);
				  			$('input[name="contactdesignation"]').val(value.contactdesignation);
				  			$('input[name="contactphone"]').val(value.contactphone);
				  			$('input[name="contactemailid"]').val(value.contactemailid);
				  			$('input[name="contactmobile"]').val(value.contactmobile);
				  			$('input[name="custcontid"]').val(contid);
				  		});
				  	}
				  	else
				  	{
				  		toastr.error('',res.actmsg,toast_top_center);
				  	}
				  }
				});
			return false;
		});
		$('body').delegate('.delcuscontact','click',function(){
			
			var custid=$('.addcustomercont #custid').val();
		  	var contid=$(this).attr('data-id');

			bootbox.confirm({
		  		message: "Do you want to delete this Contact?",
		  		buttons: {
		  			confirm: {
		  				label: 'Yes',
		  				className: 'btn-success'
		  			},
		  			cancel: {
		  				label: 'No',
		  				className: 'btn-danger'
		  			}
		  		},
		  		callback: function (result) {
		  			if(result==true)
		  			{
	  					$.ajax({
	  					  url: base_url + 'customer/delcustomerContact/' + custid,
	  					  method: "POST",
	  					  async:false,
	  					  data: {'contid':contid,'custid':custid},
	  					  dataType: "json",
	  					  success:function(res){
	  					  	var table = $('#customercontactlist_tables').DataTable();
							table.ajax.reload();	  					  	
	  					  }
	  					});
		  			}
		  		}
		  	});

		  	return false;
		});
	}

	if(document.getElementById('customersitelist_tables'))
	{
		var cususerid=$('#userid').val();

		$.fn.dataTable.ext.errMode = 'none';
			var userroles_tables=$('#customersitelist_tables').DataTable( {
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
			"sPaginationType": "full_numbers",
			//"sPaginationType": "first_last_numbers",
			"ajax": { 
				url: base_url+"customer/getallCustomersSites/"+cususerid,
				dataSrc: function(d){
					
					return d.data;    
			 }
			},
			"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ],
			 oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
			"fnDrawCallback": function (oSettings) {
				$('[data-toggle="tooltip"]').tooltip(); 
			}
			  
		} );

		$('.addcustomersite').submit(function(){
			$('.form-error').text('');
			$('.has-error').removeClass('has-error');
			var custid=$(this).find('#custid').val();
			$.ajax({
			  url: base_url + 'customer/addeditcustomersite/' + custid,
			  method: "POST",
			  async:false,
			  data: $(this).serialize(),
			  dataType: "json",
			  success:function(res){
			  	if(res.action=='success')
			  	{
			  		toastr.success('',res.actmsg,toast_top_center);
			  		var table = $('#customersitelist_tables').DataTable();
					table.ajax.reload();
					$('.btnreset').click();
					$('.form-error').val('');
					$('.has-error').removeClass('has-error');
			  		/*var table=$('#customercontactlist_tables').DataTable();
			  		table.fnDraw();*/
			  	}
			  	else
			  	{
			  		//<div class="form-error"></div>
			  		//toastr.error('',"",toast_top_center);
			  		$(res.actmsg).each(function(key,value){			  			
		  				if(value.sitename!="")
		  				{
		  					$('.sitename-error').text(value.sitename);
		  					$('sitename-error').closest('.col-sm-4').addClass('has-error');
		  				}
		  				if(value.siteaddress!="")
		  				{
		  					$('.siteaddress-error').text(value.siteaddress);
		  					$('siteaddress-error').closest('.col-sm-4').addClass('has-error');
		  				}

		  				if(value.sitecontacts!="")
		  				{
		  					$('.sitecontacts-error').text(value.sitecontacts);
		  					$('sitecontacts-error').closest('.col-sm-4').addClass('has-error');
		  				}
			  		});
			  	}
			  }
			});
			return false;
		});
		$('body').delegate('.editcussite','click',function(){
			//
			var custid=$('.addcustomersite #custid').val();
			$('.sitecontacts').prop('checked',false);
			$('input[name="sitename"]').val('');
			$('input[name="siteaddress"]').val('');

			var siteid=$(this).attr('data-id');
				$.ajax({
				  url: base_url + 'customer/getcustomerSite/' + custid,
				  method: "POST",
				  async:false,
				  data: {'siteid':siteid,'custid':custid},
				  dataType: "json",
				  success:function(res){
				  	if(res.action=='success')
				  	{
				  		$(res.actmsg).each(function(key,value){			  							  			
				  			$('input[name="sitename"]').val(value.sitename);				  							  			
				  			$('.siteaddress').val(value.siteaddress);
				  		});
				  		
				  		$(res.actmsg.contacts).each(function(key,value){			  							  			
				  			$('.sitecontacts[value="'+value+'"]').prop('checked',true);
				  		});
				  		$('#custsiteid').val(siteid);

				  	}
				  	else
				  	{
				  		toastr.error('',res.actmsg,toast_top_center);
				  	}
				  }
				});
			return false;
		});
		$('body').delegate('.delcussite','click',function(){
			
			var custid=$('.addcustomersite #custid').val();
		  	var siteid=$(this).attr('data-id');

			bootbox.confirm({
		  		message: "Do you want to delete this Site?",
		  		buttons: {
		  			confirm: {
		  				label: 'Yes',
		  				className: 'btn-success'
		  			},
		  			cancel: {
		  				label: 'No',
		  				className: 'btn-danger'
		  			}
		  		},
		  		callback: function (result) {
		  			if(result==true)
		  			{
	  					$.ajax({
	  					  url: base_url + 'customer/delcustomerSites/' + custid,
	  					  method: "POST",
	  					  async:false,
	  					  data: {'siteid':siteid,'custid':custid},
	  					  dataType: "json",
	  					  success:function(res){
	  					  	var table = $('#customersitelist_tables').DataTable();
							table.ajax.reload();	  					  	
	  					  }
	  					});
		  			}
		  		}
		  	});

		  	return false;
		});
	}

	
	
	// delete User Role
	$('body').delegate('.delete_customer_acc','click',function(){
		var id=$(this).attr('data-id');

		$.ajax({
		  url: base_url + 'customer/deletecutomercheck/' + id,
		  method: "POST",
		  async:false,
		  data: { id : id },
		  dataType: "html",
		  success:function(res){
		  	if($.isNumeric(res) && res>0)
		  	{
		  		bootbox.alert({				  
		  			message: "Unable to delete this Customer, it has been refered to Projects.",
				});
		  	}
		  	else
		  	{
			  	bootbox.confirm({
			  		message: "Do you want to delete this Customer details?",
			  		buttons: {
			  			confirm: {
			  				label: 'Yes',
			  				className: 'btn-success'
			  			},
			  			cancel: {
			  				label: 'No',
			  				className: 'btn-danger'
			  			}
			  		},
			  		callback: function (result) {
			  			if(result==true)
			  			{
			  				 window.location.href = base_url + 'customer/deletecustomer/' + id;
			  			}
			  		}
			  	});		  		
		  	}
		  }
		});

		
	});

	$('.phone-format').inputmask("9999999999");
	//$('.phone-format').inputmask("999-999-9999");
	//$('.email-format').inputmask('Regex', { regex: "[a-zA-Z0-9._%-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}" });
	$('.email-format').inputmask({
		mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
		greedy: false,
		onBeforePaste: function (pastedValue, opts) {
		  pastedValue = pastedValue.toLowerCase();
		  return pastedValue.replace("mailto:", "");
		},
		definitions: {
		  '*': {
			validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
			cardinality: 1,
			casing: "lower"
		  }
		}
	});
	$('.alphanumeric-format').inputmask({
		mask: "*{1,100}[a-zA-Z0-9]",
		greedy: false,
		onBeforePaste: function (pastedValue, opts) {
		  pastedValue = pastedValue.toLowerCase();
		  return pastedValue.replace("mailto:", "");
		},
		definitions: {
		  '*': {
			validator: "[0-9A-Za-z]",
			cardinality: 1
		  }
		}
	});

	/* =============================== Project Section =============================== */
	
	if(document.getElementById('projectlist_tables'))
	{
		$.fn.dataTable.ext.errMode = 'none';
			var userroles_tables=$('#projectlist_tables').DataTable( {
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
			"sPaginationType": "full_numbers",
			//"sPaginationType": "first_last_numbers",
			"ajax": { 
				url: base_url+"projects/getallProjects",
				dataSrc: function(d){
					
					return d.data;    
			 }
			},
			oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
			"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ],
			"fnDrawCallback": function (oSettings) {
				$('[data-toggle="tooltip"]').tooltip(); 
			}
			  
		} );
	}
	
	// delete Project
	$('body').delegate('.delete_project_acc','click',function(){
		//return false;
		var id=$(this).attr('data-id');

		    bootbox.confirm({
			message: "Do you want to delete this Project details?",
			buttons: {
				confirm: {
					label: 'Yes',
					className: 'btn-success'
				},
				cancel: {
					label: 'No',
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				if(result==true)
				{
					 window.location.href = base_url + 'projects/deleteProject/' + id;
				}
			}
		});
	});

	$('body').delegate('.delete_json_file','click',function(){
		//return false;
		var id=$(this).attr('data-id');

		    bootbox.confirm({
			message: "Do you really want to delete this File?",
			buttons: {
				confirm: {
					label: 'Yes',
					className: 'btn-danger'
				},
				cancel: {
					label: 'No',
					className: 'btn-success'
				}
			},
			callback: function (result) {
				if(result==true)
				{
					 window.location.href = base_url + 'OfflineData/delete_json_file/' + id;
				}
			}
		});
	});

	if(document.getElementById('design_measured'))
	{
		var design_measured=$('#design_measured tbody tr.design_measured_tr_0').html();
		$('body').delegate('.design_measured_add','click',function(){
			$('#design_measured tbody tr:last').after('<tr>'+design_measured+'</tr>');
			$('#design_measured tbody tr:last td:last').html('<div class="icon_list" style="width:auto;"><a href="#" data-toggle="tooltip" title="Remove Row" class="design_measured_tr_remove"><i class="fa fa-times" aria-hidden="true"></i></a></div>');
			$('#design_measured tbody tr:last [data-toggle="tooltip"]').tooltip(); 
		});
	}

	if(document.getElementById('cwwaterdiststrcd'))
	{
		$('.cwdesignmeasuredtrremove:first').remove();
		var cwwaterdiststrcd=$('.cwdesignmeasuredclonwtr').html();
		$('body').delegate('.design_measured_add','click',function(){
			$('#cwwaterdiststrcd tbody tr:last').after('<tr class="cwwaterdistxtrcdtr">'+cwwaterdiststrcd+'</tr>');
			$('#cwwaterdiststrcd tbody tr:last [data-toggle="tooltip"]').tooltip(); 

			$('#cwwaterdiststrcd tbody tr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
			$('#cwwaterdiststrcd tbody tr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
			$('#cwwaterdiststrcd tbody tr:last').find('.num_1decimal').inputmask({'mask':"9{0,10}.9{0,1}", greedy: false});
			$('#cwwaterdiststrcd tbody tr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});
		});
		$('body').delegate('.cwdesignmeasuredtrremove','click',function(){
			var closetr=$(this).closest('tr');
    		var gilleid=$(closetr).find('.cwdesignmeasured').val();
    		$(this).closest('tr').remove();
    		if(gilleid!=0)
    		{
    			$('.design_measured_add').after('<input type="hidden" name="grilledel[]" value="'+gilleid+'" />');
    		}
    		grillegridCal($);

			return false;
		});

		$('body').delegate('#cwwaterdiststrcd .cwwaterdistxtrcdtr input[type="text"]','blur',function(){
			
			var cwwaterdiststr=$(this).closest('tr');

			var deinforefnum=cwwaterdiststr.find('.deinforefnum');
			var deinfomanuf=cwwaterdiststr.find('.deinfomanuf');
			var deinfotype=cwwaterdiststr.find('.deinfotype');
			var deinfosizemm=cwwaterdiststr.find('.deinfosizemm');
			var deinfokvs=cwwaterdiststr.find('.deinfokvs');
			var deinforflowis=cwwaterdiststr.find('.deinforflowis');
			var deinfopdkpa=cwwaterdiststr.find('.deinfopdkpa');
			var measurpdkpa=cwwaterdiststr.find('.measurpdkpa');
			var measurflowis=cwwaterdiststr.find('.measurflowis');
			var measurpercen=cwwaterdiststr.find('.measurpercen');
			var measurregset=cwwaterdiststr.find('.measurregset');
			var measurbypasset=cwwaterdiststr.find('.measurbypasset');

			var deinforefnum_val=deinforefnum.val();
			var deinfomanuf_val=deinfomanuf.val();
			var deinfotype_val=deinfotype.val();
			var deinfosizemm_val=deinfosizemm.val();
			var deinfokvs_val=deinfokvs.val();
			var deinforflowis_val=deinforflowis.val();
			var deinfopdkpa_val='';
			var measurpdkpa_val=measurpdkpa.val();
			var measurflowis_val='';
			var measurpercen_val='';
			var measurregset_val=measurregset.val();
			var measurbypasset_val=measurbypasset.val();

			if($.isNumeric(deinforflowis_val))
			{
				//((F12*36)/E12)^2)

				var deinfopdkpa_val1=((deinforflowis_val*36)/deinfokvs_val);
				deinfopdkpa_val=(deinfopdkpa_val1*deinfopdkpa_val1).toFixed(3);
				if(!$.isNumeric(deinfopdkpa_val))
				{
					deinfopdkpa_val='';
				}
				deinfopdkpa.val(deinfopdkpa_val);
			}

			if($.isNumeric(measurpdkpa_val))
			{
				//(SQRT(H12))*E12/36)
				//5199749990
				//alert('(('+Math.sqrt(measurpdkpa_val)+'*'+deinfokvs_val+')/36)');				
				measurflowis_val=((Math.sqrt(measurpdkpa_val)*deinfokvs_val)/36);

				if(!$.isNumeric(measurflowis_val))
				{
					measurflowis_val='';
				}
				else
				{
					measurflowis_val=measurflowis_val.toFixed(3);
				}
				//5199749990
				$(measurflowis).val(measurflowis_val);
				

				//measurpercen				
				var measurpercen_val=(Math.sqrt((measurpdkpa_val/deinfopdkpa_val))*100);
				if($.isNumeric(measurpercen_val))
				{
					measurpercen_val=measurpercen_val.toFixed(0);
				}
				else
				{
					measurpercen_val='';
				}
				measurpercen.val(measurpercen_val);

			}

		});

	}

	if(document.getElementById('cwwaterdiststpicv'))
	{
		$('.cwdesignmeasuredpicvtrremove:first').remove();
		var cwwaterdiststpicv=$('.cwwaterdistpicvclonetr').html();
		$('body').delegate('.design_measured_PICV_add','click',function(){
			$('#cwwaterdiststpicv tbody tr:last').after('<tr class="cwwaterdistpicvrcdtr">'+cwwaterdiststpicv+'</tr>');
			$('#cwwaterdiststpicv tbody tr:last [data-toggle="tooltip"]').tooltip(); 

			$('#cwwaterdiststpicv tbody tr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
			$('#cwwaterdiststpicv tbody tr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
			$('#cwwaterdiststpicv tbody tr:last').find('.num_1decimal').inputmask({'mask':"9{0,10}.9{0,1}", greedy: false});
			$('#cwwaterdiststpicv tbody tr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});
		});
		$('body').delegate('.cwdesignmeasuredpicvtrremove','click',function(){
			var closetr=$(this).closest('tr');
    		var gilleid=$(closetr).find('.cwdesignmeasured').val();
    		$(this).closest('tr').remove();
    		if(gilleid!=0)
    		{
    			$('.design_measured_PICV_add').after('<input type="hidden" name="grilledel[]" value="'+gilleid+'" />');
    		}
    		grillegridCal($);

			return false;
		});

		$('body').delegate('#cwwaterdiststpicv .cwwaterdistpicvrcdtr input[type="text"]','blur',function(){
			var cwwaterdiststr=$(this).closest('tr');

			var deinforefnum=cwwaterdiststr.find('.deinforefnum');
			var deinfomanuf=cwwaterdiststr.find('.deinfomanuf');
			var deinfotype=cwwaterdiststr.find('.deinfotype');
			var deinfopicvset=cwwaterdiststr.find('.deinfopicvset');
			var deinfosizemm=cwwaterdiststr.find('.deinfosizemm');
			var deinfokvs=cwwaterdiststr.find('.deinfokvs');
			var deinforflowis=cwwaterdiststr.find('.deinforflowis');
			var deinfopdkpa=cwwaterdiststr.find('.deinfopdkpa');
			var measurpdkpa=cwwaterdiststr.find('.measurpdkpa');
			var measurflowis=cwwaterdiststr.find('.measurflowis');
			var measurpercen=cwwaterdiststr.find('.measurpercen');

			var deinforefnum_val=deinforefnum.val();
			var deinfomanuf_val=deinfomanuf.val();
			var deinfotype_val=deinfotype.val();
			var deinfopicvset_val=deinfopicvset.val();
			var deinfosizemm_val=deinfosizemm.val();
			var deinfokvs_val=deinfokvs.val();
			var deinforflowis_val=deinforflowis.val();
			var deinfopdkpa_val=deinfopdkpa.val();
			var measurpdkpa_val=measurpdkpa.val();
			var measurflowis_val=measurflowis.val();
			var measurpercen_val=measurpercen.val();

			//((T12*36)/Q12)^2)
			if($.isNumeric(deinforflowis_val))
			{
				deinfopdkpa_val1=((deinforflowis_val*36)/deinfokvs_val);
				deinfopdkpa_val=(deinfopdkpa_val1*deinfopdkpa_val1).toFixed(2);
			}
			if(!$.isNumeric(deinfopdkpa_val))
			{
				deinfopdkpa_val='';
			}
			deinfopdkpa.val(deinfopdkpa_val);

			if($.isNumeric(measurpdkpa_val))
			{
				//(SQRT(H12))*E12/36)
				//5199749990
				//alert('(('+Math.sqrt(measurpdkpa_val)+'*'+deinfokvs_val+')/36)');				
				measurflowis_val=((Math.sqrt(measurpdkpa_val)*deinfokvs_val)/36);

				if(!$.isNumeric(measurflowis_val))
				{
					measurflowis_val='';
				}
				else
				{
					measurflowis_val=measurflowis_val.toFixed(3);
				}
				//5199749990
				$(measurflowis).val(measurflowis_val);
				

				//measurpercen				
				var measurpercen_val=(Math.sqrt((measurpdkpa_val/deinfopdkpa_val))*100);
				if($.isNumeric(measurpercen_val))
				{
					measurpercen_val=measurpercen_val.toFixed(0);
				}
				else
				{
					measurpercen_val='';
				}
				measurpercen.val(measurpercen_val);

			}

		});

	}

	if(document.getElementById('cwdesignmeasuredhws'))
	{
		$('.cwdesignmeasuredhwstrremove:first').remove();
		var cwdesignmeasuredhws=$('.cwwaterhwscd_tr_clone').html();
		$('body').delegate('.cwdesignmeasuredhws_add','click',function(){
			$('#cwdesignmeasuredhws tbody tr:last').after('<tr>'+cwdesignmeasuredhws+'</tr>');
			$('#cwdesignmeasuredhws tbody tr:last [data-toggle="tooltip"]').tooltip(); 

			$('#cwdesignmeasuredhws tbody tr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
			$('#cwdesignmeasuredhws tbody tr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
			$('#cwdesignmeasuredhws tbody tr:last').find('.num_1decimal').inputmask({'mask':"9{0,10}.9{0,1}", greedy: false});
			$('#cwdesignmeasuredhws tbody tr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});
		});
		$('body').delegate('.cwdesignmeasuredhwstrremove','click',function(){
			var closetr=$(this).closest('tr');
    		var gilleid=$(closetr).find('.cwdesignmeasured').val();
    		$(this).closest('tr').remove();
    		if(gilleid!=0)
    		{
    			$('.cwdesignmeasuredhws_add').after('<input type="hidden" name="grilledel[]" value="'+gilleid+'" />');
    		}
    		grillegridCal($);

			return false;
		});

	}

	if(document.getElementById('wtflushvelodata'))
	{
		$('.wtflushvelotr_remove:first').remove();
		var wtflushvelodata=$('.wtflushvelotrclone').html();
		$('body').delegate('.wtflushvelo_add','click',function(){
			$('#wtflushvelodata tbody tr:last').after('<tr class="wtflushvelo">'+wtflushvelodata+'</tr>');
			$('#wtflushvelodata tbody tr:last [data-toggle="tooltip"]').tooltip(); 

			$('#wtflushvelodata tbody tr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
			$('#wtflushvelodata tbody tr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
			$('#wtflushvelodata tbody tr:last').find('.num_1decimal').inputmask({'mask':"9{0,10}.9{0,1}", greedy: false});
			$('#wtflushvelodata tbody tr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});
		});
		$('body').delegate('.wtflushvelotr_remove','click',function(){
			var closetr=$(this).closest('tr');
    		var gilleid=$(closetr).find('.cwdesignmeasured').val();
    		$(this).closest('tr').remove();
    		if(gilleid!=0)
    		{
    			$('.wtflushvelo_add').after('<input type="hidden" name="grilledel[]" value="'+gilleid+'" />');
    		}
    		grillegridCal($);
			return false;
		});

		$('body').delegate('#wtflushvelodata .wtflushvelo input[type="text"]','blur',function(){
			var cwwaterdiststr=$(this).closest('tr');

			var deinforefnum=cwwaterdiststr.find('.deinforefnum');
			var deinfomanuf=cwwaterdiststr.find('.deinfomanuf');
			var deinfotype=cwwaterdiststr.find('.deinfotype');
			var deinfosizemm=cwwaterdiststr.find('.deinfosizemm');
			var deinfokvs=cwwaterdiststr.find('.deinfokvs');
			var deinforflowis=cwwaterdiststr.find('.deinforflowis');
			var deinfopdkpa=cwwaterdiststr.find('.deinfopdkpa');
			var measurpdkpa=cwwaterdiststr.find('.measurpdkpa');
			var measurflowis=cwwaterdiststr.find('.measurflowis');
			var measurpercen=cwwaterdiststr.find('.measurpercen');

			var deinforefnum_val=deinforefnum.val();
			var deinfomanuf_val=deinfomanuf.val();
			var deinfotype_val=deinfotype.val();			
			var deinfosizemm_val=deinfosizemm.val();
			var deinfokvs_val=deinfokvs.val();
			var deinforflowis_val=deinforflowis.val();
			var deinfopdkpa_val=deinfopdkpa.val();
			var measurpdkpa_val=measurpdkpa.val();
			var measurflowis_val=measurflowis.val();
			var measurpercen_val=measurpercen.val();

			//((T12*36)/Q12)^2)

			if($.isNumeric(deinforflowis_val))
			{
				deinfopdkpa_val1=((deinforflowis_val*36)/deinfokvs_val);
				deinfopdkpa_val=(deinfopdkpa_val1*deinfopdkpa_val1).toFixed(2);
			}
			if(!$.isNumeric(deinfopdkpa_val))
			{
				deinfopdkpa_val='';
			}
			deinfopdkpa.val(deinfopdkpa_val);

			if($.isNumeric(measurpdkpa_val))
			{
				//(SQRT(H12))*E12/36)
				//5199749990
				//alert('(('+Math.sqrt(measurpdkpa_val)+'*'+deinfokvs_val+')/36)');				
				measurflowis_val=((Math.sqrt(measurpdkpa_val)*deinfokvs_val)/36);

				if(!$.isNumeric(measurflowis_val))
				{
					measurflowis_val='';
				}
				else
				{
					measurflowis_val=measurflowis_val.toFixed(3);
				}
				//5199749990
				$(measurflowis).val(measurflowis_val);
				

				//measurpercen				
				var measurpercen_val=(Math.sqrt((measurpdkpa_val/deinfopdkpa_val))*100);
				if($.isNumeric(measurpercen_val))
				{
					measurpercen_val=measurpercen_val.toFixed(0);
				}
				else
				{
					measurpercen_val='';
				}
				measurpercen.val(measurpercen_val);

			}

		});

	}


	$('body').delegate('.design_measured_tr_remove','click',function(){
		$(this).closest('tr').remove();
		return false;
	});

	$('.timepicker').datetimepicker({
		format: 'HH:mm'
	});
	$('.timepickerHH').datetimepicker({
		format: 'HH'
	});
	$('.timepickermm').datetimepicker({
		format: 'mm'
	});
	$('.datetimepicker').datetimepicker({
		format: 'DD MMM, YYYY HH:mm'
	});
	$('.datepicker').datetimepicker({
		format: 'DD MMM, YYYY'

	});

	/*$(document).on('dp.change', 'input.datepicker', function() {
	   alert('changed');
	});*/

	$('body').delegate('.timepicker,.datetimepicker,.datepicker','keypress',function(){
		return false;
	});

	$(document).on('click', '.browse', function(){
	  var file = $(this).parent().parent().parent().find('.file');
	  file.trigger('click');
	});
	$(document).on('change', '.file', function(){
	  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
	});

	if(document.getElementById('dyformdatalist'))
	{
		$('#dyformdatalist').DataTable({
			"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1] },
				{ "bSearchable": false, "aTargets": [ -1,-2] }
			],
			oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
		});
	}

	$('.adddyform #procid').change(function(){
		var parentid=parseInt($(this).val());
		$.ajax({
			async:false,
			dataType:'jsonp',
			data:{},
			url: base_url+"settings/getSectionByPid/"+parentid, 
			success: function(result){
        		parentid=result;
    		}
    	});
    	console.log('parentid='+parentid);
	});

	/*$('#toggle-two').bootstrapToggle({
      on: 'Enabled',
      off: 'Disabled'
    });*/

    /*$('#toggle-two').change(function(){    	
    	if($(this).prop('checked'))
    	{
    		$('.shtenadis').val(1);
    	}
	    else
	    {
	    	$('.shtenadis').val(0);
	    }

    });*/
    $('.proshtstatus').change(function(){    	
    	var proshtstatus=($('.proshtstatus:checked').val());
    	$('.shtenadis').val(proshtstatus);
    });

    $('.processcarnavli .active_a').closest('.gw-submenu').show();
    $('.processcarnavli .active_a').closest('.processcarnavli').addClass('active');

    processMenuAction($);

    /*$('body').delegate('.processcarnavul a','click',function(){
    	alert('hi');
    	//window.location.href=$(this).attr('href');
    	return false;
    });*/

    var adjustment;
    $('.processcarnavul').each(function(){

    	var class1="#"+$(this).attr('id');
    	var dataid=$(this).attr('data-id');

	    $( class1 ).sortable({
	    	update: function (event, ui) {
		        //var data = $(this).sortable('serialize',{ key: "datas" });
		        var data = $(this).sortable('serialize');
		        //console.log('this='+data);
		        $.ajax({
					url: base_url+"projects/updateProcessLstSrt", 
					type:'POST',
					data:data,
					success: function(result){
						//processMenuAction($);
			        	//$("#div1").html(result);
			    	}
				});
		    }
	    });
		$( class1 ).disableSelection();

    	/*var group =$(class1).sortable({
	    	group: 'serialization_'+dataid,
	    	delay: 500,
	    	nested: false,	    	
			onDrop: function ($item, container, _super) {
				var data = group.sortable("serialize").get();
				var jsonString = JSON.stringify(data, null, ' ');
				//alert(jsonString);
				$.ajax({
					url: base_url+"projects/updateProcessLstSrt", 
					type:'POST',
					data:{'datas':data},
					success: function(result){
						processMenuAction($);
			        	//$("#div1").html(result);
			    	}
				});
				_super($item, container);
			}
    	});*/

    	/*$(class1).sortable({
    		group: 'serialization_'+dataid,
    	});*/

    });



    var systemdetlicnt=$('.system_details_li').length;
    var incsysdetails=systemdetlicnt;
    if(systemdetlicnt>0)
    {
    	$('.system_details_li:first .systemdetailsremove').remove();
    	var systemdet_clone=$('.system_details_A').html();
    	$('body').delegate('.systemdetailsadd','click',function(){
			var customerName = localStorage.getItem("t1");
    		$('.system_details_li:last').after('<div class="panel panel-default system_details_'+(++incsysdetails)+' system_details_li">'+systemdet_clone+'</div>');
		    var $newPanel=$('.system_details_li:last');
		    $newPanel.find(".collapse").removeClass("in");
		    $newPanel.find(".accordion-toggle").attr("href",  "#syspanel_" + (incsysdetails));
			$newPanel.find(".accordion-toggle").attr("id",  "syspaneltitle_" + (incsysdetails));
		    $newPanel.find(".panel-collapse").attr("id", 'syspanel_'+incsysdetails).addClass("collapse").removeClass("in");
		    $("#accordion").append($newPanel.fadeIn());

		    //$('.system_details_li').each(function(key,value){
		    	//$(this).find(".accordion-toggle").text("System #" + (key+1));
		    //});
			//$("#syspaneltitle_" + incsysdetails).text("System #" + incsysdetails);
		    $('.system_details_li:last').find('.datepicker').datetimepicker({
				format: 'DD MMM, YYYY'
			});
		    $('.system_details_li:last').find('.accordion-toggle').click();
			$(".customernames_cron").val(customerName);
			$newPanel.find(".systemname").attr("id",  incsysdetails);
    	});

    	$('body').delegate('.systemdetailsremove','click',function(){

    		var closeli=$(this).closest('.system_details_li');
    		var systemid=$(closeli).find('.systemid').val();
    		var cuthis=$(this);

			$.ajax({
				type:'POST',
				url: base_url+"projects/checkSysAssign/"+systemid, 				
				data:{'sysid':systemid},		
				dataType:'html',
				contentType: "application/x-www-form-urlencoded",
				async:false,
				success: function(result){			
					if(result==0)
					{
			    		if(systemid!=0)
			    		{
			    			$('.systemdetailsadd').after('<input type="hidden" name="systemdelid[]" class="systemid" value="'+systemid+'" />');
			    		}
			    		closeli.remove();

			    		$('.system_details_li').each(function(key,value){
					    	//$(this).find(".accordion-toggle").text("System #"  + (key+1));
					    });
					}
					else
					{
						toastr.info('So can not able to delete this System.','This System has been assigned to Project.',toast_top_center)
						cuthis.remove();
					}
		    	}
			});
			return false;
    	});

    	$('.system_details_sec').each(function(){
    		var innpaneerror=$(this).find('.form-error').length;
    		if(innpaneerror>0)    		
    		{
    			$(this).addClass('panel-danger');
    		}
    		else
    		{
    			$(this).removeClass('panel-danger');
    		}
    	});



    }

    if(document.getElementById('projsystem'))
    {
    	var projsystemlen=$('#projsystem option').length;
    	if(projsystemlen==2)
    	{
    		$('#projsystem option:eq(1)').prop('selected',true);
    		projsystem_change($);
    	}

    	

    	$('#projsystem').change(function(){
			projsystem_change($);
    	});
    	
    }

    if(document.getElementById('grillegrid'))
    {
    	$('.grillegridtr:first .icon_list').remove();
    	var grilleclonetr=$('.grilleclonetr').html();
    	var grillegridtrcnt=$('.grillegridtr').length;
    	var grillegridtrinc=grillegridtrcnt;

    	$('.grilleaddnew').click(function(){
    		$('.grillegridtr:last').after('<tr class="grillegridtr grillegridtr_'+grillegridtrinc+'">'+grilleclonetr+'</tr>');    		
    		grillegridtrinc++;

    		$('.grillegridtr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
    		$('.grillegridtr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
    		$('.grillegridtr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});

    	});

    	$('body').delegate('.delete_grille_balrow','click',function(){
    		//grilleaddnew
    		var closetr=$(this).closest('tr');
    		var gilleid=$(closetr).find('.gilleid').val();
    		$(this).closest('tr').remove();
    		if(gilleid!=0)
    		{
    			$('.grilleaddnew').after('<input type="hidden" name="grilledel[]" value="'+gilleid+'" />');
    		}
    		grillegridCal($);
    	});

    	/*$('body').delegate('#grillegrid .grillefield','blur',function(){
    		var closegrdtr=$(this).closest('tr');
    		grillegridCal($,closegrdtr);
    	});*/
    	$('body').delegate('#grillegrid .grillefield,#grillegridmain .grilleductotal','blur',function(){
    		//grillegridtr
    		grillegridCal($);
    	});


    }
    if(document.getElementById('dirgrillegrid'))
    {
    	$('.dirgrillegridtr:first .icon_list').remove();
    	var dirgrilleclonetr=$('.dirgrilleclonetr').html();
    	var dirgrillegridtrcnt=$('.dirgrillegridtr').length;
    	var dirgrillegridtrinc=dirgrillegridtrcnt;

    	$('.dirgrilleaddnew').click(function(){
    		$('.dirgrillegridtr:last').after('<tr class="dirgrillegridtr dirgrillegridtr_'+dirgrillegridtrinc+'">'+dirgrilleclonetr+'</tr>');    		
    		dirgrillegridtrinc++;

    		$('.dirgrillegridtr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
    		$('.dirgrillegridtr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
    		$('.dirgrillegridtr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});

    	});

    	$('body').delegate('.delete_dirgrille_balrow','click',function(){
    		//grilleaddnew
    		var closetr=$(this).closest('tr');
    		var dirgilleid=$(closetr).find('.dirgilleid').val();
    		$(this).closest('tr').remove();
    		if(dirgilleid!=0)
    		{
    			$('.dirgrilleaddnew').after('<input type="hidden" name="dirgrilledel[]" value="'+dirgilleid+'" />');
    		}
    		dirgrillegridCal($);
    	});

    	$('body').delegate('#dirgrillegrid .dirgrillefield,#dirgrillemain .grilleductotal','blur',function(){
    		//grillegridtr
    		dirgrillegridCal($);
    	});
    }
    if(document.getElementById('vlmctrlgrid'))
    {
    	$('.vlmctrlgridtr:first .icon_list').remove();
    	var vlmctrlclonetr=$('.vlmctrlclonetr').html();
    	var vlmctrlgridtrcnt=$('.vlmctrlgridtr').length;
    	var vlmctrlgridtrinc=vlmctrlgridtrcnt;

    	$('.vlmctrladdnew').click(function(){
    		$('.vlmctrlgridtr:last').after('<tr class="vlmctrlgridtr vlmctrlgridtr_'+vlmctrlgridtrinc+'">'+vlmctrlclonetr+'</tr>');    		
    		vlmctrlgridtrinc++;

    		$('.vlmctrlgridtr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
    		$('.vlmctrlgridtr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
    		$('.vlmctrlgridtr:last').find('.num_1decimal').inputmask({'mask':"9{0,20}.9{0,1}", greedy: false});
    		$('.vlmctrlgridtr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});

    	});

    	$('body').delegate('.delete_vlmctrl_balrow','click',function(){
    		//grilleaddnew
    		var closetr=$(this).closest('tr');
    		var vlmctrlid=$(closetr).find('.vlmctrlid').val();
    		$(this).closest('tr').remove();
    		if(vlmctrlid!=0)
    		{
    			$('.vlmctrladdnew').after('<input type="hidden" name="vlmctrldel[]" value="'+vlmctrlid+'" />');
    		}
    	});

    	$('body').delegate('#vlmctrlgrid .vav_field','blur',function(){
    		//grillegridtr
    		vlmCtrlCal($);
    	});
    }
    if(document.getElementById('vlmctrlboxgrid'))
    {
    	$('.vlmctrlboxgridtr:first .icon_list').remove();
    	var vlmctrlboxclonetr=$('.vlmctrlboxclonetr').html();
    	var vlmctrlboxgridtrcnt=$('.vlmctrlboxgridtr').length;
    	var vlmctrlboxgridtrinc=vlmctrlboxgridtrcnt;

    	$('.vlmctrlboxaddnew').click(function(){
    		$('.vlmctrlboxgridtr:last').after('<tr class="vlmctrlboxgridtr vlmctrlboxgridtr_'+vlmctrlboxgridtrinc+'">'+vlmctrlboxclonetr+'</tr>');    		
    		vlmctrlboxgridtrinc++;

    		$('.vlmctrlboxgridtr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
    		$('.vlmctrlboxgridtr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
    		$('.vlmctrlboxgridtr:last').find('.num_1decimal').inputmask({'mask':"9{0,20}.9{0,1}", greedy: false});
    		$('.vlmctrlboxgridtr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});
    	});

    	$('body').delegate('.delete_vlmctrlbox_balrow','click',function(){
    		//grilleaddnew
    		var closetr=$(this).closest('tr');
    		var vlmctrlboxid=$(closetr).find('.vlmctrlboxid').val();
    		$(this).closest('tr').remove();
    		if(vlmctrlboxid!=0)
    		{
    			$('.vlmctrlboxaddnew').after('<input type="hidden" name="vlmctrlboxdel[]" value="'+vlmctrlboxid+'" />');
    		}
    	});
    }
    if(document.getElementById('plotrcdtable1'))
    {
    	$('.plotrcdgridtr:first .icon_list').remove();
    	var plotrcdclone=$('.plotrcdclone').html();
    	var plotrcdgridtrcnt=$('.plotrcdgridtr').length;
    	var plotrcdgridtrinc=plotrcdgridtrcnt;

    	$('.plotrcdaddnew').click(function(){
    		$('.plotrcdgridtr:last').after('<tr class="plotrcdgridtr plotrcdgridtr_'+plotrcdgridtrinc+'">'+plotrcdclone+'</tr>');    		
    		plotrcdgridtrinc++;

    		$('.plotrcdgridtr:last').find('.num_3decimal').inputmask({'mask':"9{0,10}.9{0,3}", greedy: false});
    		$('.plotrcdgridtr:last').find('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
    		$('.plotrcdgridtr:last').find('.num_1decimal').inputmask({'mask':"9{0,20}.9{0,1}", greedy: false});
    		$('.plotrcdgridtr:last').find('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});
    		
    	});

    	$('body').delegate('.delete_plotrcdrow','click',function(){
    		//grilleaddnew
    		var closetr=$(this).closest('tr');
    		var plotrcdid=$(closetr).find('.plotrcdid').val();
    		$(this).closest('tr').remove();
    		if(plotrcdid!=0)
    		{
    			$('.plotrcdaddnew').after('<input type="hidden" name="plotrcddel[]" value="'+plotrcdid+'" />');
    		}
    		plotrcdtable1RightCal($);
    	});

    	/* == Formula apply == */

    	$('.duct_size_mm,.duct_size_mm1').blur(function(){
    		var duct_size_mm=$('.duct_size_mm').val();
    		var duct_size_mm1=$('.duct_size_mm1').val();
    		var duct_val=((duct_size_mm*duct_size_mm1)*0.000001);
    		if(duct_size_mm!="" && duct_size_mm1!="")
    		{
    			$('.duct_area_m2').val(duct_val.toFixed(3));
    		}
    		else
    		{
    			$('.duct_area_m2').val('');    			
    		}
    	});

    	$('body').delegate('#plotrcdtable1 .volume,.flow_rate_m3_s','blur',function(){
    		plotrcdtable1RightCal($);    		
    	});

    }







    //num_3decimal
    //num_2decimal
    $('.num_3decimal').inputmask({
    	'mask':["9{0,10}.9{0,3}","X"],
		definitions: {
		    "X": {
		      validator: "[xX]",
		      cardinality: 1,
		      casing: "upper"
		    }
		  }
  });
    $('.num_2decimal').inputmask({'mask':"9{0,10}.9{0,2}", greedy: false});
    $('.num_1decimal').inputmask({'mask':"9{0,10}.9{0,1}", greedy: false});
    $('.num_0decimal').inputmask({'mask':"9{0,20}", greedy: false});

    /*$("#imgInp").change(function(){
	    readURL(this,$);
	}); */


    //grilleclonetr
    

  /*$('.alphanumeric-format').inputmask("Regex", {
  regex: "[a-zA-Z0-9]*"});*/

  $('form:first input:first').focus();

  $('#userpassword').focus(function(){  	
  	$('.userpassword').show();
  });
  $('#userpassword').blur(function(){
  	$('.userpassword').hide();
  });

  $("#content header.panel-heading *").each(function () {
	    if ($(this).children().length == 0) {
	        $(this).text($(this).text().replace('Volumn','Volume'));
	        $(this).text($(this).text().replace('Valumn','Volume'));
	    }
	});
  $("#content .alert-success").each(function () {
	    if ($(this).children().length == 0) {
	        $(this).text($(this).text().replace('Volumn','Volume'));
	        $(this).text($(this).text().replace('Valumn','Volume'));
	    }
	});

  /* ====================== Reports ========================= */

  if(document.getElementById('projectlist_reports'))
  {
  	$.fn.dataTable.ext.errMode = 'none';
  		var userroles_tables=$('#projectlist_reports').DataTable( {
  		"processing": true,
  		"serverSide": true,
  		"responsive": true,
  		"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
  		"sPaginationType": "full_numbers",
  		//"sPaginationType": "first_last_numbers",
  		/*"ajax": { 
  			url: base_url+"reports/getallProjects",
  			dataSrc: function(d){
  				
  				return d.data;    
  		 }
  		},*/
  		oLanguage: {
  	        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''  	        
  	    },
  		"aoColumnDefs": [
  			 { "bSortable": false, "aTargets": [ -1 ] },
  			{ "bSearchable": false, "aTargets": [ -1 ] }
  		 ],
  		"fnDrawCallback": function (oSettings) {
  			$('[data-toggle="tooltip"]').tooltip(); 
  		}
  		  
  	} );
  }
  
  if(document.getElementById('projectlist_exports'))
  {
  	$.fn.dataTable.ext.errMode = 'none';
  		var userroles_tables=$('#projectlist_exports').DataTable( {
  		"processing": true,
  		"serverSide": true,
  		"responsive": true,
  		"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
  		"sPaginationType": "full_numbers",
  		//"sPaginationType": "first_last_numbers",
  		"ajax": { 
  			url: base_url+"exports/getallProjects",
  			dataSrc: function(d){
  				
  				return d.data;    
  		 }
  		},
  		oLanguage: {
  	        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''  	        
  	    },
  		"aoColumnDefs": [
  			 { "bSortable": false, "aTargets": [ -1 ] },
  			{ "bSearchable": false, "aTargets": [ -1 ] }
  		 ],
  		"fnDrawCallback": function (oSettings) {
  			$('[data-toggle="tooltip"]').tooltip(); 
  		}
  		  
  	} );
  }
  
  if(document.getElementById('reportlist_project'))
  {
  	var projectid=$('#projectid').val();
  	$.fn.dataTable.ext.errMode = 'none';
  		var userroles_tables=$('#reportlist_project').DataTable( {
  		"processing": true,
  		"serverSide": true,
  		"responsive": true,
  		"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
  		"sPaginationType": "full_numbers",
  		//"sPaginationType": "first_last_numbers",
  		"ajax": { 
  			url: base_url+"exports/getallPrjReports/"+projectid,
  			dataSrc: function(d){
  				
  				return d.data;    
  		 }
  		},
  		"order": [[ 0, "desc" ]],
  		oLanguage: {
  	        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
  	    },
  		"aoColumnDefs": [
  			 { "bSortable": false, "aTargets": [ -1 ] },
  			{ "bSearchable": false, "aTargets": [ -1 ] }
  		 ],
  		"fnDrawCallback": function (oSettings) {
  			$('[data-toggle="tooltip"]').tooltip(); 
  		}
  		  
  	} );
  }

  if(document.getElementById('fan-performancelist'))
  {
  	$('.fanperformancelisttr input[type="text"]').blur(function(){
  		var clostr=$(this).closest('tr');
  		var commAirPreCommtestdata=parseFloat($(clostr).find('.commAirPreCommtestdata').val());
  		var commAirPreCommtestdata1=parseFloat($(clostr).find('.commAirPreCommtestdata1').val());
  		var commAirPreCommopt=parseFloat($(clostr).find('.commAirPreCommopt').val());
  		
  		var testdata_ans=($(clostr).find('.testdata_ans'));
  		var testdata1_ans=($(clostr).find('.testdata1_ans'));

  		var testdataans_val=0;
  		var testdataans1_val=0;

  		if($.isNumeric(commAirPreCommopt))
  		{
  			testdataans_val=((parseFloat(commAirPreCommtestdata)/commAirPreCommopt)*100).toFixed(0);  			
  			testdataans1_val=((parseFloat(commAirPreCommtestdata1)/commAirPreCommopt)*100).toFixed(0);
  		}
  		if(!$.isNumeric(testdataans_val))
  		{
  			testdataans_val=0;
  		}
  		if(!$.isNumeric(testdataans1_val))
  		{
  			testdataans1_val=0;
  		}
  		$(testdata_ans).val(testdataans_val+'%');
  		$(testdata1_ans).val(testdataans1_val+'%');




  	});
  }

  if(document.getElementById('pump-performancelist'))
  {
  	$('.pumpperformancelisttr input[type="text"]').blur(function(){
  		var clostr=$(this).closest('tr');
  		var commAirPreCommtestdata=parseFloat($(clostr).find('.commAirPreCommtestdata').val());
  		var commAirPreCommtestdata1=parseFloat($(clostr).find('.commAirPreCommtestdata1').val());
  		var commAirPreCommopt=parseFloat($(clostr).find('.commAirPreCommopt').val());
  		
  		var testdata_ans=($(clostr).find('.testdata_ans'));
  		var testdata1_ans=($(clostr).find('.testdata1_ans'));

  		var testdataans_val=0;
  		var testdataans1_val=0;

  		if($.isNumeric(commAirPreCommopt))
  		{
  			testdataans_val=((parseFloat(commAirPreCommtestdata)/commAirPreCommopt)*100).toFixed(0);  			
  			testdataans1_val=((parseFloat(commAirPreCommtestdata1)/commAirPreCommtestdata)*100).toFixed(0);
  		}
  		if(!$.isNumeric(testdataans_val))
  		{
  			testdataans_val=0;
  		}
  		if(!$.isNumeric(testdataans1_val))
  		{
  			testdataans1_val=0;
  		}
  		$(testdata_ans).val(testdataans_val+'%');
  		$(testdata1_ans).val(testdataans1_val+'%');
  	});
  }

  $('body').delegate('.failsafeopt','change',function(){
  	var failsafeopt=0;
  	if($(this).prop('checked'))
  	{
  		failsafeopt=1;
  	}
  	$(this).next('.failsafeopt1').val(failsafeopt);
  });
  if(document.getElementById('adduserform'))
  {
  	/*var signature=$('.signature').val();
  	
	  $('#adduserform').submit(function(){
		  	if (signaturePad.isEmpty()) {
		  		$('.signature').val('');
		    } else {
		    	$('.signature').val(signaturePad.toDataURL());
		    }
		
	  });
	  if(signature!="")
	  {
	  	signaturePad.fromDataURL(signature);
	  }*/
	}
	if(document.getElementById('addeditcustomer'))
  	{

  		var signature=$('.csignature').val();
  	
		  $('#addeditcustomer').submit(function(){
			  	if (signaturePad.isEmpty()) {
			  		$('.csignature').val('');
			    } else {
			    	$('.csignature').val(signaturePad.toDataURL());
			    }
			
		  });
		  if(signature!="")
		  {
		  	signaturePad.fromDataURL(signature);
		  }
	}

	$('body').delegate('.watersupp,.testername','change',function(){
		var dataalt=$(this).attr('data-alt');
		var dataid=$(this).attr('data-id');
		var userid=$(this).val();
		$.ajax({
			type:'POST',
			url: base_url+"projects/getStaffSign/"+userid, 				
			data:{'userid':userid},		
			dataType:'text',
			contentType: "application/x-www-form-urlencoded",
			async:false,
			success: function(result){			
				$('#'+dataalt).val(result);
				$('#'+dataid).attr('src',result);
	    	}
		});

	});

	//file-error-message

	$('body').delegate('.commAirSysScheform','submit',function(){		
		if($('.file-preview-error:visible').length!=0)
		{
			return false;
		}
	});

	$("#imgInp").fileinput({
        //'theme': 'explorer',
        'allowedFileExtensions': ['jpg', 'png', 'gif','pdf'],
        //'uploadUrl': '#',
        'showUpload':false,
        'showUploadedThumbs':false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: initPreviewfile,
        initialPreviewConfig: initPreviewfileconfig,

    });

    $("#cmplogo").fileinput({
        //'theme': 'explorer',
        'allowedFileExtensions': ['jpg', 'png', 'gif'],
        //'uploadUrl': '#',
        'showUpload':false,
        'showUploadedThumbs':false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: initPreviewfile,
        initialPreviewConfig: initPreviewfileconfig,

    });


    $('#imgInp,#cmplogo').on('change', function(event) {
        //$('#imgInp').fileinput('reset');
        //$('#input-id').fileinput('refresh');
    });

    $('#imgInp,#cmplogo').on('fileerror', function(event, data, msg) {
       $('#'+data.id).addClass('file-preview-error');
    });

    $('#imgInp,#cmplogo').on('filepreremove', function(event, id, index) {
        var abort = false;
	    if (confirm("Are you sure you want to delete?")) {
	        abort = true;
	    }
	    return abort;
    });


    $('#imgInp,#cmplogo').on('filepredelete', function(event, key, jqXHR, data) {
        var abort = true;
	    if (confirm("Are you sure you want to delete?")) {
	    	$('.shtenadis').after('<input type="hidden" name="delfiles[]" value="'+key+'" />');
	        abort = false;
	    }
	    return abort;
    });

    $(window).resize(function(){
    	updatepad($);
    });
    updatepad($);

    $('body').delegate('.userincharge','change',function(){    	
		var custid=$(this).val();
		$.ajax({
		  url: base_url + 'projects/getSites/' + custid,
		  method: "POST",
		  async:false,
		  data: {'custid':custid},
		  dataType: "json",
		  success:function(res){
		  	$('.sitename').html('');
		  	$('.sitecontactname').html('<option value="">Select Contact Name</option>');
		  	var sitename='<option value="">Select Project Name</option>';
		  	$(res).each(function(key,value){
		  		sitename+='<option value="'+value.id+'">'+value.sitename+'</option>';		  		
		  	});
		  	$('.sitename').html(sitename);
		  }
		});
	});

	$('body').delegate('.sitename','change',function(){    	
		var siteid=$(this).val();
		var custid=$('.userincharge').val();
		$.ajax({
		  url: base_url + 'projects/getContactSites/' + custid,
		  method: "POST",
		  async:false,
		  data: {'custid':custid,'siteid':siteid},
		  dataType: "json",
		  success:function(res){
		  	$('.sitecontactname').html('');
		  	var sitecontactname='<option value="">Select Contact Name</option>';
		  	$(res).each(function(key,value){		  		
		  		sitecontactname+='<option value="'+value.id+'">'+value.contactfirstname+' '+value.contactlastname+'</option>';		  		
		  	});
		  	$('.sitecontactname').html(sitecontactname);
		  }
		});
	});

	/* ==================================== Dashboard ====================== */

	if(document.getElementById('projectlist_home'))
	{
		$.fn.dataTable.ext.errMode = 'none';
			var userroles_tables=$('#projectlist_home').DataTable( {
				"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ]
			/*"processing": true,
			"serverSide": true,
			"responsive": true,
			"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
			"sPaginationType": "full_numbers",
			//"sPaginationType": "first_last_numbers",
			"ajax": { 
				url: base_url+"home/getallProjects",
				dataSrc: function(d){
					
					return d.data;    
			 }
			},
			oLanguage: {
		        sProcessing: "<img src='"+base_url+"/assets/images/loader.gif'>",
  	        sInfoFiltered:''
		    },
			"aoColumnDefs": [
				 { "bSortable": false, "aTargets": [ -1 ] },
				{ "bSearchable": false, "aTargets": [ -1 ] }
			 ],
			"fnDrawCallback": function (oSettings) {
				$('[data-toggle="tooltip"]').tooltip(); 
			}*/
			  
		} );
	}

});


$(document).ready(function(){
		$('#addsitedatafrm').on('show.bs.modal', function (e) {
			toastr.clear();	
		  if($('select[name="userincharge"]').val()=="")
		  {
		  	toastr.error('',"Please select Customer name",toast_top_center);
		  	return false;
		  }
		});
		$('#addsitedatafrm').on('shown.bs.modal', function (e) {
			toastr.clear();	
		});
		$('.frmaddsitemdl').submit(function(){
			var frmaddsitemdl=$(this);
			var sitename=$(this).find('[name="sitename"]');
			var siteaddress=$(this).find('[name="siteaddress"]');
			toastr.clear();	
			if(sitename.val()=="")
			{
				toastr.error('',"Please enter Site name",toast_top_center);		  	
				sitename.focus();
			}
			else if(siteaddress.val()=="")
			{
				toastr.error('',"Please enter Site address",toast_top_center);		  	
				siteaddress.focus();
			}
			else
			{
				$.ajax({
					type:'POST',
					url: base_url+"prjbg/addSitedata", 				
					data:{"sitename":sitename.val(),"siteaddress":siteaddress.val(),"cntid":$('.userincharge').val()},		
					dataType:'json',
					contentType: "application/x-www-form-urlencoded",
					async:false,
					success: function(result){			
						$('input[name="sitename"]').val('');
						$('textarea[name="siteaddress"]').val('');
						toastr.clear();
						toastr.success('',"Site Name has been added successfully",toast_top_center);
					    $('#addsitedatafrm').modal('hide');
						var custid=$('.userincharge').val();
						$.ajax({
						  url: base_url + 'projects/getSites/' + custid,
						  method: "POST",
						  async:false,
						  data: {'custid':custid},
						  dataType: "json",
						  success:function(res){
						  	$('.sitename').html('');
						  	$('.sitecontactname').html('<option value="">Select Contact Name</option>');
						  	var sitename='<option value="">Select Site Name</option>';
						  	$(res).each(function(key,value){
						  		sitename+='<option value="'+value.id+'">'+value.sitename+'</option>';		  		
						  	});
						  	$('.sitename').html(sitename);
						  	$('.sitename option[value="'+result.sid+'"]').prop('selected',true);
						  }
						});

			    	}
				});
			}
			return false;
		});
		$('#addsitedatafrm').on('hidden.bs.modal', function (e) {
		  $('input[name="sitename"]').val('');
		  $('textarea[name="siteaddress"]').val('');
		  toastr.clear();	
		});
		$('#addcontactdatafrm').on('show.bs.modal', function (e) {
			toastr.clear();	
		  if($('select[name="userincharge"]').val()=="")
		  {
		  	toastr.error('',"Please select Customer name",toast_top_center);
		  	return false;
		  }
		  else if($('select[name="sitename"]').val()=="")
		  {
		  	toastr.error('',"Please select Site name",toast_top_center);
		  	return false;
		  }
		  else
		  {

		  }
		});
		$('#addcontactdatafrm').on('shown.bs.modal', function (e) {
			toastr.clear();	
		});

		$('.frmaddcontactmdl').submit(function(){
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var frmaddsitemdl=$(this);
			var contactfirstname=$(this).find('[name="contactfirstname"]');
			var contactlastname=$(this).find('[name="contactlastname"]');
			var contactdesignation=$(this).find('[name="contactdesignation"]');
			var contactphone=$(this).find('[name="contactphone"]');
			var contactmobile=$(this).find('[name="contactmobile"]');
			var contactemailid=$(this).find('[name="contactemailid"]');
			var custid=$('.userincharge').val();
			var siteid=$('select[name="sitename"]').val();

			toastr.clear();	
			if(contactfirstname.val()=="")
			{
				toastr.error('',"Please enter First name",toast_top_center);		  	
				contactfirstname.focus();
				return false;
			}
			else if(contactlastname.val()=="")
			{
				toastr.error('',"Please enter Last name",toast_top_center);		  	
				contactlastname.focus();
				return false;
			}
			else if(contactdesignation.val()=="")
			{
				toastr.error('',"Please enter Job role",toast_top_center);		  	
				contactdesignation.focus();
				return false;
			}
			else if(contactphone.val()=="")
			{
				toastr.error('',"Please enter Phone",toast_top_center);		  	
				contactphone.focus();
				return false;
			}
			else if(contactemailid.val()=="")
			{
				toastr.error('',"Please enter Email address",toast_top_center);		  	
				contactemailid.focus();
				return false;
			}
			else if(re.test(contactlastname.val()))
			{
				toastr.error('',"Please enter valid Email address",toast_top_center);		  	
				contactlastname.focus();
				return false;
			}
			else
			{
				$.ajax({
					type:'POST',
					url: base_url+"prjbg/addContactdata", 				
					data:{
						'contactfirstname':contactfirstname.val(),
			            'contactlastname':contactlastname.val(),
			            'contactdesignation':contactdesignation.val(),
			            'contactphone':contactphone.val(),
			            'contactmobile':contactmobile.val(),
			            'contactemailid':contactemailid.val(),
						"siteid":siteid,
						"custid":custid
					},		
					dataType:'json',
					contentType: "application/x-www-form-urlencoded",
					async:false,
					success: function(result){			
						$('input[name="sitename"]').val('');
						$('textarea[name="siteaddress"]').val('');
						toastr.clear();
						toastr.success('',"Contact has been added successfully",toast_top_center);

						$.ajax({
						  url: base_url + 'projects/getContactSites/' + custid,
						  method: "POST",
						  async:false,
						  data: {'custid':custid,'siteid':siteid},
						  dataType: "json",
						  success:function(res){
						  	$('.sitecontactname').html('');
						  	var sitecontactname='<option value="">Select Contact Name</option>';
						  	$(res).each(function(key,value){		  		
						  		sitecontactname+='<option value="'+value.id+'">'+value.contactfirstname+' '+value.contactlastname+'</option>';		  		
						  	});
						  	$('.sitecontactname').html(sitecontactname);
						  	$('.sitecontactname option[value="'+result.contid+'"]').prop('selected',true);
						  }
						});

						$('#addcontactdatafrm').modal('hide');

						$(frmaddsitemdl).find('[name="contactfirstname"]').val('');
						$(frmaddsitemdl).find('[name="contactlastname"]').val('');
						$(frmaddsitemdl).find('[name="contactdesignation"]').val('');
						$(frmaddsitemdl).find('[name="contactphone"]').val('');
						$(frmaddsitemdl).find('[name="contactmobile"]').val('');
						$(frmaddsitemdl).find('[name="contactemailid"]').val('');

			    	}
				});
			}
			return false;
		});

		$('#frmaddcontactmdl').on('hidden.bs.modal', function (e) {
		  	$(frmaddsitemdl).find('[name="contactfirstname"]').val('');
			$(frmaddsitemdl).find('[name="contactlastname"]').val('');
			$(frmaddsitemdl).find('[name="contactdesignation"]').val('');
			$(frmaddsitemdl).find('[name="contactphone"]').val('');
			$(frmaddsitemdl).find('[name="contactmobile"]').val('');
			$(frmaddsitemdl).find('[name="contactemailid"]').val('');
		  	toastr.clear();	
		});

	});
	
 $('.allcb').on('click', function(){
    var childClass = $(this).attr('data-child');
	var parentClassID = $(this).attr('alt');
    $('.'+childClass+'').prop('checked', this.checked);
	if($(this).prop('checked'))
		{
		  $('.prvOptPageid_'+parentClassID).val(1);
		}
		else
		{    
      	 $('.prvOptPageid_'+parentClassID).val(0);
		}
});

$.each( $('.allcb'), function( key, value ) {
	var chthis=$(this);
  	var childClass = $(this).attr('data-child');
	var parentClassID = $(this).attr('alt');
	var cnttochk=$('.'+childClass+'').length;
	var cntchk=$('.'+childClass+':checked').length;
	if(cntchk!=0)
	{
		if(cnttochk==cntchk)
		{
			$(chthis).prop('checked', true);
		}
		else
		{
			$(chthis).prop('checked', false);	
		}
	}
});

$('.prvOptPageid[type="checkbox"]').click(function(){
	var panels=$(this).closest('.panel');
	var chthis=$(panels).find('.allcb');
  	var childClass = $(chthis).attr('data-child');  	
	var parentClassID = $(chthis).attr('alt');
	var cnttochk=$('.'+childClass+'').length;
	var cntchk=$('.'+childClass+':checked').length;
	if(cntchk!=0)
	{
		if(cnttochk==cntchk)
		{
			$(chthis).prop('checked', true);
		}
		else
		{
			$(chthis).prop('checked', false);	
		}
	}	
});



/*$("#selectbox1").click(function () 
 {
	if ($(this).is(":checked")) {
	   $("ul li#role").show();
	} else {
		//$("ul li#role").hide();
	}
 });
 
 $("#selectbox2").click(function () 
 {
	if ($(this).is(":checked")) {
	   $("ul li#users").show();
	} else {
		$("ul li#users").hide();
	}
 });
 
 $("#selectbox3").click(function () 
 {
	if ($(this).is(":checked")) {
	   $("ul li#customer").show();
	} else {
		$("ul li#customer").hide();
	}
 });
 
 $("#selectbox4").click(function () 
 {
	if ($(this).is(":checked")) {
	   $("ul li#projects").show();
	} else {
		$("ul li#projects").hide();
	}
 });
 
 $("#selectbox5").click(function () 
 {
	if ($(this).is(":checked")) {
	   $("ul li#reports").show();
	} else {
		$("ul li#reports").hide();
	}
 });
 
  $("#selectbox6").click(function () 
 {
	if ($(this).is(":checked")) {
	   $("ul li#export").show();
	} else {
		$("ul li#export").hide();
	}
 });

  $("#selectbox7").click(function () 
 {
	if ($(this).is(":checked")) {
	   $("ul li#company").show();
	} else {
		$("ul li#company").hide();
	}
 });*/
 
 $(function () {
        $('select[multiple].dayenggactive.3col').multiselect({
            placeholder: 'Select Engineer',
            search: true,
            searchOptions: {
                'default': 'Search Engineer'
            },
            selectAll: true
        });

    });
	
	$(".lter").click(function () 
	 {
		var selectedEngineers = [];
		$('select[multiple].dayenggactive.3col option:selected').each(function () {
					selectedEngineers.push([$(this).val()]);
				});
		//$("#dayengg1").val(selectedEngineers);
		//$("#dayengg2").val(selectedEngineers);
		
	 });
	
$('.number').keypress(function(event) {
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
    ((event.which < 48 || event.which > 57) &&
      (event.which != 0 && event.which != 8))) {
    event.preventDefault();
  }

  var text = $(this).val();

  if ((text.indexOf('.') != -1) &&
    (text.substring(text.indexOf('.')).length > 1) &&
    (event.which != 0 && event.which != 8) &&
    ($(this)[0].selectionStart >= text.length - 1)) {
    event.preventDefault();
  }
});
	
 $(document).ready(function() {
	var result = "";
    $(".button").click(function() {
	$("#slidingDiv").show();
	var projectid =  $(this).parent().parent().find('input').val();
    var customername =  $(this).parent().parent().find('td').eq(4).html();
	$("#projectids").val(projectid);
    localStorage.setItem("t1",customername);//changing c1Title to any String content like "test" will work
    result = localStorage.getItem("t1");
    $("#customernames").val(result);
    });
$(document).on('keyup', '.systemname', function (e) {	
  var dInput = this.value;
  var dInputId = $(this).attr("id");
  sessionStorage.setItem("MyId1", dInput);
  var value = sessionStorage.getItem("MyId1");
  $("#syspaneltitle_" + dInputId).text(value);
});

/**code to mimic the behaviour of tab key with enter key */
$('.processForm').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});

/** end of code to mimic the behaviour of tab key with enter key */


/** code to to prevent the navigation if form has unsaved data*/
var dataEntered = false;
		window.onbeforeunload = function(e) {  
		if (dataEntered) { 
			return "You have some unsaved changes";  
			}  
		}
		
		$(".processForm").submit(function() {
		window.onbeforeunload = null;
		});

		$(".processForm").find('input, textarea, select, button, option').each( function(){
   		$(this).on('change input', function(){
			   
			dataEntered = true;
		   })

		});

		$(".file-input").bind("DOMSubtreeModified",function(){
			dataEntered = true;
});
});

/** end of code to to prevent the navigation if form has unsaved data*/



/******Jquery Code To change the readonly option when click on enable or disable radio button*********/
/******When Clicked on Enable*********/
$("input:radio[value=1]").click( function(){
	$("form[name='adduser']").find('input:not(.alwaysreadonly), textarea, select, button, option').each(function(){
	   $(this).attr({
		   'readonly':false,
		   'disabled':false
		   });
	});
	$("a:contains('Add New'), button:contains('Add Row'), button:contains('Add New')").each(function(){
		$(this).css("pointer-events", "");
	})
	$("div.form-control.file-caption.file-caption-disabled.kv-fileinput-caption").removeClass('file-caption-disabled');

	$("div.btn.btn-primary.btn-file").attr('disabled', false);
})

/******When Clicked on Disable*********/
$("input:radio[value=0]").click( function() {
	$("form[name='adduser']").find('input:not(.alwaysreadonly), textarea, select, button, option').each( function(){
	   $(this).attr({
		   'readonly':true,
		   'disabled':true
		   });
	});
	$("a:contains('Add New'), button:contains('Add Row'), button:contains('Add New')").each(function(){
		$(this).css("pointer-events", "none");
	});
	$("div.form-control.file-caption.kv-fileinput-caption").addClass('file-caption-disabled');
	$("div.btn.btn-primary.btn-file").attr('disabled', true);
})

window.setTimeout(() => {
	//$("#flashmsgdiv").fadeOut("slow");
	$('.alert2.alert-success.text-center').animate({
		opacity: 0, // animate slideUp
		marginLeft: '-400px'
	}, 'slow', 'linear', function() {
		$(this).remove();
	});
	
}, 5000);




