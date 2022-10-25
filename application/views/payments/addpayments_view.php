

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Add Payments</h2>
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
                            <div class="card-header">Add Payment</div>
                            <div class="card-body">
                            	<?php echo form_open('customersetup/confirmpayment', 
                        			['class' => 'form_horizontal']); ?>
                                <!--<form class="form-horizontal" method="post" action="#">-->

                                    <!-- sector -->

                                    <div class="form-group">
                                        <label for="sector" class="cols-sm-2 control-label">Sector Name<sup class="text-red">*</sup></label><small><?php echo form_error('sector', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="sector" id="sector" onchange="mysector()">
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
                                    </div>

                                    <!-- street -->

                                    <div class="form-group">
                                        <label for="street" class="cols-sm-2 control-label">Street Name<sup class="text-red">*</sup></label><small><?php echo form_error('street', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                            <select class="form-control custom-select" name="street" id="street" onchange="mystreet()" disabled="FALSE">
                                                <option value="" selected>Select Street</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- house -->

                                    <div class="form-group">
                                        <label for="houseno" class="cols-sm-2 control-label">House Number<sup class="text-red">*</sup></label><small><?php echo form_error('houseno', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                            <select class="form-control custom-select" name="houseno" id="houseno" onchange="myhouse()" disabled="FALSE">
                                                <option value="" selected>Select House Number</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- customer code -->

                                    <div class="form-group">
                                        <label for="code" class="cols-sm-2 control-label">Customer Code<sup class="text-red">*</sup></label><small><?php echo form_error('code', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-anchor fa" aria-hidden="true"></i></span>
                                                </div>
                                            <select class="form-control custom-select" name="code" id="code" onchange="mycode()" disabled="FALSE">
                                                <option value="" selected>Select customer code</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- customer -->

                                    <!--<div class="form-group">
                                        <label for="customer" class="cols-sm-2 control-label">Customer Name<sup class="text-red">*</sup></label><small><?php echo form_error('customer', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="customer" id="customer" readonly="true"/>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- number of months -->

                                    <div class="form-group">
                                        <label for="months" class="cols-sm-2 control-label">Number of Months<sup class="text-red">*</sup></label><small><?php echo form_error('months', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" onchange="mymonth()" name="months" id="months" disabled="FALSE">
                                                    <option value="" selected>Select number of months</option>
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Months</option>
                                                    <option value="3">3 Months</option>
                                                    <option value="4">4 Months</option>
                                                    <option value="5">5 Months</option>
                                                    <option value="6">6 Months</option>
                                                    <option value="7">7 Months</option>
                                                    <option value="8">8 Months</option>
                                                    <option value="9">9 Months</option>
                                                    <option value="10">10 Months</option>
                                                    <option value="11">11 Months</option>
                                                    <option value="12">12 Months</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- amount -->

                                    <div class="form-group">
                                        <label for="amount" class="cols-sm-2 control-label">Amount <small>(Numbers only)</small></label>
                                        <small><?php echo form_error('amount', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" readonly="true" class="form-control" name="amount" id="amount" value="<?php echo (isset($_POST['amount']) ? $_POST['amount'] : ''); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- payment date -->

                                    <div class="form-group">
                                        <label for="paymentdate" class="cols-sm-2 control-label">Payment Date<sup class="text-red">*</sup></label><small><?php echo form_error('paymentdate', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar fa" aria-hidden="true"></i></span>
                                                </div>
                                                
                                                    <input type="text" placeholder="yyyy-mm-dd" name="paymentdate" autocomplete="off" class="form-control" id="picker"/>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Narration -->

                                    <div class="form-group">
                                        <label for="desc" class="cols-sm-2 control-label">Narration<sup class="text-red">*</sup></label><small><?php echo form_error('desc', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-file fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="desc" id="desc" placeholder="Payment narration" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- payment mode -->

                                    <!--<div class="form-group">
                                        <label for="paymode" class="cols-sm-2 control-label">Payment Mode<sup class="text-red">*</sup></label><small><?php echo form_error('paymode', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-key fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="paymode" id="paymode">
                                                    <option value="" selected>Select payment mode</option>
                                                    <option value="Agent">Agent</option>
                                                    <option value="Direct">Direct</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>-->
                                    

                                    <div class="form-group ">
                                        <!--<button type="button" class="btn btn-success btn-lg btn-block">Add User</button>-->

                                     <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Next',
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
    

