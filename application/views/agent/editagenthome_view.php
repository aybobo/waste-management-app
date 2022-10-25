

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Update Agent</h2>
						<!--<p>Questions about onboarding lead data? <a href="#">Learn more.</a></p>-->
					</div>
					<!--<div class="d-flex w-500p">
						<select class="form-control custom-select custom-select-sm mr-15">
							<option selected="">Latest Products</option>
							<option value="1">CRM</option>
							<option value="2">Projects</option>
							<option value="3">Statistics</option>
						</select>
						<select class="form-control custom-select custom-select-sm mr-15">
							<option selected="">USA</option>
							<option value="1">USA</option>
							<option value="2">India</option>
							<option value="3">Australia</option>
						</select>
						<select class="form-control custom-select custom-select-sm">
							<option selected="">December</option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="1">April</option>
							<option value="2">May</option>
							<option value="3">June</option>
							<option value="1">July</option>
							<option value="2">August</option>
							<option value="3">September</option>
							<option value="1">October</option>
							<option value="2">November</option>
							<option value="3">December</option>
						</select>
					</div>-->
                </div>
                <!-- /Title -->
<!-- here ----->
				<div class="row justify-content-center">
					<div class="col-md-4 col-md-offset-4">
						<div class="text-center">
				        <?php if($msg = $this->session->flashdata('msg')) {
				                echo '<div class="text-danger">' . $msg . '</div>';  } ?>
				            <?php if($msg = $this->session->flashdata('success')) {
				                echo '<div class="text-success">' . $msg . '</div>';  } ?>
				      	</div>
					</div>
				</div>

                <!-- Row -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Edit Agent</div>
                            <div class="card-body">
                            	<?php echo form_open('customersetup/updateagent', 
                        			['class' => 'form_horizontal']); ?>
                                <!--<form class="form-horizontal" method="post" action="#">-->

                                    <div class="form-group">
                                        <label for="fname" class="cols-sm-2 control-label">First Name<sup class="text-red">*</sup></label><small><?php echo form_error('fname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter your first name" value="<?php echo (isset($_POST['fname']) ? $_POST['fname'] : $agent->fname); ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- middle name -->

                                    <div class="form-group">
                                        <label for="oname" class="cols-sm-2 control-label">Middle Name</label>
                                        <small><?php echo form_error('oname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="oname" id="oname" placeholder="Enter your middle name" value="<?php echo (isset($_POST['oname']) ? $_POST['oname'] : $agent->oname); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- last name -->

                                    <div class="form-group">
                                        <label for="lname" class="cols-sm-2 control-label">Last Name<sup class="text-red">*</sup></label>
                                        <small><?php echo form_error('lname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter your last name" value="<?php echo (isset($_POST['lname']) ? $_POST['lname'] : $agent->lname); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- phone -->

                                    <div class="form-group">
                                        <label for="telno" class="cols-sm-2 control-label">Phone Number<sup class="text-red">*</sup></label>
                                        <small><?php echo form_error('telno', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-phone fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="telno" id="telno" placeholder="Enter phone number" value="<?php echo (isset($_POST['telno']) ? $_POST['telno'] : $agent->telno); ?>" />

                                            </div>
                                        </div>
                                    </div>

                                    <!-- sector -->

                                    <!--<div class="form-group">
                                        <label for="sector" class="cols-sm-2 control-label">Sector Name<sup class="text-red">*</sup><small><?php echo form_error('sector', '<div class="text-danger">', '</div>'); ?></small></label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="sector" id="sector">
                                                    <option value="" selected>Select Sector</option>
                                                    <?php 
                                                    foreach($sectors as $sector)
                                                        { 
                                                          echo '<option value="'.$sector->sectorid.'">'.$sector->sectorname.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- status -->

                                    <?php

                                        $status = $agent->status;

                                        $val = '';

                                        if ($status == 'Active') {
                                            $val = 'Inactive';
                                        }
                                        else {
                                            $val = 'Active';
                                        }

                                    ?>

                                    <div class="form-group">
                                        <label for="password" class="cols-sm-2 control-label">Status</label>
                                        <div class="cols-sm-10">
                                            <div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="<?php echo $status; ?>" checked="checked">
											  <label class="form-check-label" for="inlineRadio1"><?php echo $status; ?></label>
											</div>
											<div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="<?php echo $val; ?>">
											  <label class="form-check-label" for="inlineRadio2"><?php echo $val; ?></label>
											</div>
                                        </div>
                                    </div>

                     
                                    <!--<div class="form-group">
                                        <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                                <input type="password" class="form-control" name="confirm" id="confirm" placeholder="Confirm your Password" />
                                            </div>
                                        </div>
                                    </div>-->
                                    
             
          <input type="hidden" id="old" name="old" value="<?php echo $agent->telno; ?>">
          <input type="hidden" id="id" name="id" value="<?php echo $agent->agentid; ?>">

                                    <div class="form-group ">
                                        <!--<button type="button" class="btn btn-success btn-lg btn-block">Add User</button>-->

                                     <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Save Change',
                                                            'class' => 'btn btn-success btn-block']); ?>
                                    </div>
                                    <!--<div class="login-register">
                                        <a href="index.php">Login</a>
                                    </div>-->
                                <?php echo form_close(); ?>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Row -->


            </div>

            <!-- /Container -->
			
            <!-- Footer -->
            <div class="hk-footer-wrap container">
                <footer class="footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p>&copy; <?=date ('Y')?> <a href="https://opendoorlimited.com/" class="text-dark" target="_blank">Open Door System International Limited</a></p>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p>Developed By<a href="mailto:insightconceptltd@gmail.com" class="text-dark" target="_blank">Insight Concept Nig. Ltd.</a></p>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="<?=base_url()?>vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/parsley.min.js"></script>

