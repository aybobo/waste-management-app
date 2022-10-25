

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Add Asset</h2>
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
                            <div class="card-header">Add Asset</div>
                            <div class="card-body">
                            	<?php echo form_open('assets/addassets', 
                        			['class' => 'form_horizontal']); ?>
                                
                                    <div class="form-group">
                                        <label for="catname" class="cols-sm-2 control-label">Asset Category Name<sup class="text-red">*</sup></label><small><?php echo form_error('catname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                	<span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="catname" id="catname" onchange="category()">
                                                    <option value="" selected>Select Asset Category</option>
                                                    <?php 
                                                    foreach($cats as $cat)
                                                        { 
                                                          echo '<option value="'.$cat->catid.'">'.$cat->categoryname.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- asset name -->

                                    <div class="form-group">
                                        <label for="asset" class="cols-sm-2 control-label">Asset Name<sup class="text-red">*</sup></label><small><?php echo form_error('asset', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-file fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="asset" id="asset" readonly="true" placeholder="Enter asset name" value="<?php echo (isset($_POST['asset']) ? $_POST['asset'] : ''); ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- quantity -->

                                    <div class="form-group">
                                        <label for="qty" class="cols-sm-2 control-label">Quantity</label>
                                        <small><?php echo form_error('qty', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-anchor fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="number" placeholder="Available quantity" class="form-control" name="qty" id="qty" value="<?php echo (isset($_POST['qty']) ? $_POST['qty'] : ''); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->

                                    <div class="form-group">
                                        <label for="desc" class="cols-sm-2 control-label">Description<sup class="text-red">*</sup></label><small><?php echo form_error('desc', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <!--<div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>-->
                                                <textarea class="form-control resize" name="desc" rows="3" placeholder="Asset description"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- value -->

                                    <div class="form-group">
                                        <label for="assetval" class="cols-sm-2 control-label">Value<sup class="text-red">*</sup><small>Numbers only</small></label><small><?php echo form_error('assetval', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="assetval" id="assetval" placeholder="Current asset value" value="<?php echo (isset($_POST['assetval']) ? $_POST['assetval'] : ''); ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- date of purchase -->

                                    <div class="form-group">
                                        <label for="purchasedate" class="cols-sm-2 control-label">Date of Purchase<sup class="text-red">*</sup></label><small><?php echo form_error('purchasedate', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar fa" aria-hidden="true"></i></span>
                                                </div>
                                                
                                                    <input type="text" placeholder="yyyy-mm-dd" name="purchasedate" autocomplete="off" class="form-control" id="picker"/>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <!--<button type="button" class="btn btn-success btn-lg btn-block">Add User</button>-->

                                     <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Add Asset',
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

