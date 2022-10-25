

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Update User Accounts</h2>
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
                            <div class="card-header">Edit User</div>
                            <div class="card-body">
                            	<?php echo form_open_multipart('users/updateuser', 
                        			['class' => 'form_horizontal']); ?>
                                <!--<form class="form-horizontal" method="post" action="#">-->

                                    <div class="form-group">
                                        <label for="fname" class="cols-sm-2 control-label">First Name<sup class="text-red">*</sup></label><small><?php echo form_error('fname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter your first name" value="<?php echo (isset($_POST['fname']) ? $_POST['fname'] : $user->fname); ?>"/>
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
                                                <input type="text" class="form-control" name="oname" id="oname" placeholder="Enter your middle name" value="<?php echo (isset($_POST['oname']) ? $_POST['oname'] : $user->oname); ?>" />
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
                                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter your last name" value="<?php echo (isset($_POST['lname']) ? $_POST['lname'] : $user->lname); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- role ---->

                                    <?php

                                        $role = $user->role;

                                        $val = '';

                                        if ($role == 'Admin') {
                                            $val = 'General';
                                        }
                                        else {
                                            $val = 'Admin';
                                        }

                                    ?>

                                    <div class="form-group">
                                        <label for="role" class="cols-sm-2 control-label">User Role<sup class="text-red">*</sup></label><small><?php echo form_error('role', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-key fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="role" id="role">
                                                        <option value="<?php echo $role; ?>" selected><?php echo $role; ?></option>
                                                        <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- email -->

                                    <div class="form-group">
                                        <label for="email" class="cols-sm-2 control-label">Your Email<sup class="text-red">*</sup></label>
                                        <small><?php echo form_error('email', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter your Email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : $user->email); ?>" />

                                            </div>
                                        </div>
                                    </div>

                                    <!-- signature -->

                                    <div class="form-group">
                                        <label class="cols-sm-2 control-label">Upload Signature
                                        </label>

                                        <div class="col-sm-8 formspace">                                
                                            <input type="file" name="signature" size="20" />
                                        </div>
                                    </div>

                                    <!-- status -->
                                    <?php

                                        $status = $user->status;

                                        $res = '';

                                        if ($status == 'Active') {
                                            $res = 'Inactive';
                                        }
                                        else {
                                            $res = 'Active';
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
											  <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="<?php echo $res; ?>">
											  <label class="form-check-label" for="inlineRadio2"><?php echo $res; ?></label>
											</div>
                                        </div>
                                    </div>
                                    
             
          <input type="hidden" id="oemail" name="oemail" value="<?php echo $user->email; ?>">
          <input type="hidden" id="id" name="id" value="<?php echo $user->userid; ?>">

                                    <div class="form-group ">

                                     <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Save Change',
                                                            'class' => 'btn btn-success btn-block']); ?>
                                    </div>
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

