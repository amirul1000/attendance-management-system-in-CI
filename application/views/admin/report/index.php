<h5 class="font-20 mt-15 mb-1">Report</h5>
<!--Form of products Paramaters-->
<?php echo form_open_multipart('admin/report/report/',array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<code>To get full report keep date range empty</code>
			<div class="col-md-8">
				<label for="Date From" class="col-md-4 control-label">Date From</label>
				<div class="col-md-4">
					<input type="text" name="date_from" id="date_from"
						value="<?php echo ($this->input->post('date_from') ? $this->input->post('date_from') : ''); ?>"
						class="form-control-static datepicker" />
				</div>

				<label for="Date To" class="col-md-4 control-label">Date To</label>
				<div class="col-md-4">
					<input type="text" name="date_to" id="date_to"
						value="<?php echo ($this->input->post('date_to') ? $this->input->post('date_to') : ''); ?>"
						class="form-control-static datepicker" />
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-8">
				 <label for="Users" class="col-md-4 control-label">Users</label> 
                 <div class="col-md-8"> 
                  <?php 
                     $this->CI =& get_instance(); 
                     $this->CI->load->database();  
                     $this->CI->load->model('Users_model'); 
                     $dataArr = $this->CI->Users_model->get_all_users(); 
                  ?> 
                  <select name="users_id"  id="users_id"  class="form-control"/> 
                    <option value="">--Select--</option> 
                    <?php 
                     for($i=0;$i<count($dataArr);$i++) 
                     {  
                    ?> 
                    <option value="<?=$dataArr[$i]['id']?>"><?=$dataArr[$i]['first_name']?> <?=$dataArr[$i]['last_name']?></option> 
                    <?php 
                     } 
                    ?> 
                  </select> 
                 </div> 
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success">Report</button>
	</div>
</div>
<?php echo form_close(); ?>

<!--End of Form to save data//-->
<script language="javascript">
  $( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>
<!--End of Form//-->
