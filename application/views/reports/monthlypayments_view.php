

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Monthly Payment Breakdown</h2>
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

                <?php $i = 0; ?>
                	<div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <!--<div class="table-responsive">-->
                                            <table id="data" class="table table-hover table-bordered mb-0">
                                                <thead class="thead-success">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>House No.</th>
                                                        <th>Type of Prems</th>
                                                        <th>Monthly Charge</th>
                                                        <th>Jan</th>
                                                        <th>Feb</th>
                                                        <th>Mar</th>
                                                        <th>Apr</th>
                                                        <th>May</th>
                                                        <th>June</th>
                                                        <th>July</th>
                                                        <th>Aug</th>
                                                        <th>Sept</th>
                                                        <th>Oct</th>
                                                        <th>Nov</th>
                                                        <th>Dec</th>
                                                    </tr>
                                                </thead>
                                                <!--<tfoot class="thead-success">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Customer Name</th>
                                                        <th>Address</th>
                                                        <th>Phone No.</th>
                                                        <th>House Type</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </tfoot>-->
                                                <tbody>
                                                    <?php foreach ($payments as $payment) {
                                                        $i++;
                                                        foreach ($results as $result) { 
                                                            if ($payment->customerid == $result->customerid) { ?>
                                                               
                                                           <tr>
                                                              <td><?php echo $i; ?></td>
                                                              <td><?php echo $payment->customername; ?></td>
                                                              <td><?php echo $result->houseno; ?></td>
                                                              <td><?php echo $result->housecat; ?></td>
                                                              <td><?php echo $result->monthlycharge; ?></td>
                                                              <td>
                                                                  <?php 
                                                                    $ans = '';
                                                                    if ($payment->jan > 0) {
                                                                        $ans = $payment->jan;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->feb > 0) {
                                                                        $ans = $payment->feb;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->mar > 0) {
                                                                        $ans = $payment->mar;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->april > 0) {
                                                                        $ans = $payment->april;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->may > 0) {
                                                                        $ans = $payment->may;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->june > 0) {
                                                                        $ans = $payment->june;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->july > 0) {
                                                                        $ans = $payment->july;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->aug > 0) {
                                                                        $ans = $payment->aug;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->sept > 0) {
                                                                        $ans = $payment->sept;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->oct > 0) {
                                                                        $ans = $payment->oct;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                <?php 
                                                                    $ans = '';
                                                                    if ($payment->nov > 0) {
                                                                        $ans = $payment->nov;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                              <td>
                                                                  <?php 
                                                                    $ans = '';
                                                                    if ($payment->december > 0) {
                                                                        $ans = $payment->december;
                                                                    }
                                                                    echo $ans;
                                                                   ?>
                                                              </td>
                                                           </tr>
                                                            
                                                       
                                                   <?php } } } ?>
                                                </tbody>
                                            </table>
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
               <?php //} ?>
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

