

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Update Customer</h2>
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
                            <div class="card-header">Edit Customer</div>
                            <div class="card-body">
                            	<?php echo form_open('customersetup/updatecustomer', 
                        			['class' => 'form_horizontal']); ?>
                                <!--<form class="form-horizontal" method="post" action="#">-->

                                    <!--<div class="form-group">
                                        <label for="title" class="cols-sm-2 control-label">Title<sup class="text-red">*</sup></label><small><?php echo form_error('title', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-card fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="title" id="title" value="<?php echo (isset($_POST['title']) ? $_POST['title'] : $customer->title); ?>"/>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- first name -->

                                    <!--<div class="form-group">
                                        <label for="fname" class="cols-sm-2 control-label">First Name<sup class="text-red">*</sup></label><small><?php echo form_error('fname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="fname" id="fname" value="<?php echo (isset($_POST['fname']) ? $_POST['fname'] : $customer->fname); ?>"/>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- middle name -->

                                    <!--<div class="form-group">
                                        <label for="oname" class="cols-sm-2 control-label">Middle Name</label>
                                        <small><?php echo form_error('oname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="oname" id="oname" value="<?php echo (isset($_POST['oname']) ? $_POST['oname'] : $customer->oname); ?>" />
                                            </div>
                                        </div>
                                    </div>-->

                                    <!-- last name -->

                                    <div class="form-group">
                                        <label for="lname" class="cols-sm-2 control-label">Name<sup class="text-red">*</sup></label>
                                        <small><?php echo form_error('lname', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="lname" id="lname" value="<?php echo (isset($_POST['lname']) ? $_POST['lname'] : $customer->name); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- tel no -->

                                    <div class="form-group">
                                        <label for="telno" class="cols-sm-2 control-label">Phone Number<sup class="text-red">*</sup></label>
                                        <small><?php echo form_error('telno', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-phone fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="telno" id="telno" placeholder="Enter phone number" value="<?php echo (isset($_POST['telno']) ? $_POST['telno'] : $customer->telno); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- debt -->

                                    <div class="form-group">
                                        <label for="debt" class="cols-sm-2 control-label">Debt <small>(Numbers only)</small></label>
                                        <small><?php echo form_error('debt', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="debt" id="debt" value="<?php echo (isset($_POST['debt']) ? $_POST['debt'] : $customer->debt); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- wallet -->

                                    <div class="form-group">
                                        <label for="wallet" class="cols-sm-2 control-label">Wallet <small>(Numbers only)</small></label>
                                        <small><?php echo form_error('wallet', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="wallet" id="wallet" value="<?php echo (isset($_POST['wallet']) ? $_POST['wallet'] : $customer->wallet); ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- area -->

                                    <div class="form-group">
                                        <label for="area" class="cols-sm-2 control-label">Area Name<sup class="text-red">*</sup></label><small><?php echo form_error('area', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="area" id="area" onchange="myarea()">
                                                    <option value="<?php echo $customer->areaid; ?>" selected><?php echo $customer->areaname; ?></option>
                                                    <?php 
                                                    foreach($areas as $area)
                                                        { 
                                                          echo '<option value="'.$area->areaid.'">'.$area->areaname.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- sector -->

                                    <div class="form-group">
                                        <label for="sector" class="cols-sm-2 control-label">Sector Name<sup class="text-red">*</sup></label><small><?php echo form_error('sector', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="sector" id="sector" onchange="mysector()">
                                                    <option value="<?php echo $customer->sectorid; ?>" selected><?php echo $customer->sectorname; ?></option>
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
                                            <select class="form-control custom-select" name="street" id="street" onchange="mystreet()">
                                                <option value="<?php echo $customer->streetid; ?>" selected><?php echo $customer->streetname; ?></option>
                                                <?php 
                                                    foreach($streets as $street)
                                                        { 
                                                          echo '<option value="'.$street->streetid.'">'.$street->streetname.'</option>';
                                                        }
                                                ?>
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
                                            <select class="form-control custom-select" name="houseno" id="houseno" onchange="myhouse()">
                                                <option value="<?php echo $customer->houseid; ?>" selected><?php echo $customer->houseno; ?></option>
                                                <?php 
                                                    foreach($houses as $house)
                                                        { 
                                                          echo '<option value="'.$house->houseid.'">'.$house->houseno.'</option>';
                                                        }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- house type -->

                                    <div class="form-group">
                                        <label for="housetype" class="cols-sm-2 control-label">House Type<sup class="text-red">*</sup></label><small><?php echo form_error('housetype', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="housetype" id="housetype">
                                                    <option value="<?php echo $customer->housecatid; ?>" selected><?php echo $customer->housecat; ?></option>
                                                    <?php 
                                                    foreach($cats as $cat)
                                                        { 
                                                          echo '<option value="'.$cat->catid.'">'.$cat->housetype.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- customer type ---->

                                    <?php

                                        $status = $customer->customertype;

                                        $val = '';

                                        if ($status == 'Commercial') {
                                            $val = 'Residential';
                                        }
                                        else {
                                            $val = 'Commercial';
                                        }

                                    ?>

                                    <div class="form-group">
                                        <label for="customertype" class="cols-sm-2 control-label">Customer Type<sup class="text-red">*</sup></label><small><?php echo form_error('customertype', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-key fa" aria-hidden="true"></i></span>
                                                </div>
                                                    <select class="form-control custom-select" name="customertype" id="customertype" onchange="mycustomertype()">
                                                    <option value="<?php echo $status; ?>" selected><?php echo $status; ?></option>
                                                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if ($customer->customertype == 'Residential') { ?>
                                        <div class="form-group">
                                            <label for="commtype" class="cols-sm-2 control-label">Commercial Type<sup class="text-red">*</sup></label>
                                            <div class="cols-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                    </div>
                                                <select class="form-control custom-select" name="commtype" disabled="FALSE" id="commtype">
                                                    <option value="" selected>Select commercial type</option>
                                                    <?php 
                                                        foreach($types1 as $type)
                                                            { 
                                                              echo '<option value="'.$type->typeId.'">'.$type->typeName.'</option>';
                                                            }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                   <?php }
                                        else { ?>
                                            <div class="form-group">
                                                <label for="commtype" class="cols-sm-2 control-label">Commercial Type<sup class="text-red">*</sup></label>
                                                <div class="cols-sm-10">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-home fa" aria-hidden="true"></i></span>
                                                        </div>
                                                    <select class="form-control custom-select" name="commtype" id="commtype">
                                                        <option value="<?php echo $customer->commercialtype; ?>" selected><?php echo $customer->commercialTypeName; ?></option>
                                                        <?php 
                                                            foreach($types as $type)
                                                                { 
                                                                  echo '<option value="'.$type->typeId.'">'.$type->typeName.'</option>';
                                                                }
                                                        ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php    }
                                    ?>

                                    <!-- entry date -->

                                    <div class="form-group">
                                        <label for="entrydate" class="cols-sm-2 control-label">Customer Entrance Date<sup class="text-red">*</sup></label><small><?php echo form_error('entrydate', '<div class="text-danger">', '</div>'); ?></small>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar fa" aria-hidden="true"></i></span>
                                                </div>
                                                
                                                    <input type="text" placeholder="yyyy-mm-dd" name="entrydate" autocomplete="off" class="form-control" id="picker" value="<?php echo $customer->customerentrydate;  ?>" />
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!-- status -->

                                    <?php

                                        $res = $customer->status;

                                        $out = '';

                                        if ($res == 'Active') {
                                            $out = 'Inactive';
                                        }
                                        else {
                                            $out = 'Active';
                                        }

                                    ?>

                                    <div class="form-group">
                                        <label for="password" class="cols-sm-2 control-label">Status</label>
                                        <div class="cols-sm-10">
                                            <div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="<?php echo $res; ?>" checked="checked">
											  <label class="form-check-label" for="inlineRadio1"><?php echo $res; ?></label>
											</div>
											<div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="<?php echo $out; ?>">
											  <label class="form-check-label" for="inlineRadio2"><?php echo $out; ?></label>
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
                                    
             
          <input type="hidden" id="oldno" name="oldno" value="<?php echo $customer->telno; ?>">
          <input type="hidden" id="id" name="id" value="<?php echo $customer->customerid; ?>">
          <input type="hidden" name="olddebt" value="<?php echo $customer->debt; ?>">
          <input type="hidden" name="oldwallet" value="<?php echo $customer->wallet; ?>">
          <input type="hidden" name="oldentrydate" value="<?php echo $customer->customerentrydate; ?>">
          <input type="hidden" id="oldsec" name="oldsec" value="<?php echo $customer->sectorid; ?>">
          <input type="hidden" id="oldstr" name="oldstr" value="<?php echo $customer->streetid; ?>">
          <input type="hidden" id="oldhouse" name="oldhouse" value="<?php echo $customer->houseid; ?>">
          <input type="hidden" id="oldcat" name="oldcat" value="<?php echo $customer->housecatid; ?>">
          <input type="hidden" name="oldcustomercode" value="<?php echo $customer->customercode; ?>">
          <input type="hidden" name="oldcustomertype" value="<?php echo $customer->customertype; ?>">
          <input type="hidden" name="oldcounter" value="<?php echo $customer->counter; ?>">
          <input type="hidden" name="oldcommtype" value="<?php echo $customer->commercialtype; ?>">

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

