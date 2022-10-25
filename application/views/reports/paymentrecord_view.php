

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Payments Records</h2>
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
    <div class="row">
        <div class="col-md-12">
            <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#home">Monthly Breakdown</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#menu1">Date Range</a>
                </li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div id="home" class="container tab-pane active"><br>
                  <h5 class="mb-10">Monthly breakdown of payments</h5>
                  <div class="row">
                      <div class="col-sm-12">
                        <?php echo form_open('reports/monthlybreakdown', 
                                    ['class' => 'form-inline']); ?>
                          <!--<form class="form-inline">-->
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <select class="form-control custom-select" name="all" id="all" onchange="allsector()" >
                                                    <option value="" selected>Choose Option</option>
                                                    <option value="All">All Customers</option>
                                                    <option value="Selected">Selected Customers</option>
                                                </select>
                                </div>
                                <div class="col-auto">
                                    <select class="form-control custom-select" name="sector" id="sector" onchange="mysector()" disabled="FALSE">
                                                    <option value="" selected>Select Sector</option>
                                                    <?php 
                                                    foreach($sectors as $sector)
                                                        { 
                                                          echo '<option value="'.$sector->sectorid.'">'.$sector->sectorname.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                </div>
                                <div class="col-auto">
                                    <select class="form-control custom-select" name="street" id="street" onchange="mystreet()" disabled="FALSE">
                                                <option value="" selected>Select Street</option>
                                                </select>
                                </div>
                                <div class="col-auto">
                                    <select class="form-control custom-select" name="houseno" id="houseno" disabled="FALSE">
                                                <option value="" selected>Select House Number</option>
                                                </select>
                                </div>
                                <div class="col-auto">
                                    <!--<button type="submit" class="btn btn-success">Submit</button>-->
                                    <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Search',
                                                            'class' => 'btn btn-success btn-block']); ?>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                      </div>
                  </div>
                </div>
                <div id="menu1" class="container tab-pane fade"><br>
                  <h5 class="mb-10">Payments by date</h5>
                    <div class="row">
                      <div class="col-sm-12">
                          <?php echo form_open('reports/paymentsbydate', 
                                    ['class' => 'form-inline']); ?>
                            <div class="form-row align-items-center">
                                <div class="col-auto">Start Date
                                    <input type="text" placeholder="yyyy-mm-dd" name="startdate" autocomplete="off" class="form-control" id="picker"/>
                                </div>

                                <div class="col-auto">End Date
                                    <input type="text" placeholder="yyyy-mm-dd" name="enddate" autocomplete="off" class="form-control" id="picker1"/>
                                </div>
                                
                                <div class="col-auto">
                                    <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Search',
                                                            'class' => 'btn btn-success btn-block']); ?>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                      </div>
                  </div>
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
    

