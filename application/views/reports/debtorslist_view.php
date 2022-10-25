

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h4 class="hk-pg-title font-weight-600 mb-10">Debtors</h4>
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
                                                        <th>Address</th>
                                                        <th>Type of Prems</th>
                                                        <th>Monthly Charge</th>
                                                        <th>Debt</th>
                                                        <th>Last Payment</th>
                                                        <th>Last Payment Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($results as $result) { $i++; ?>
                                                        
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $result->name; ?></td>
                                                            <td>
                                                                <?php 
                                                                    $add = $result->houseno . ', ' . $result->streetname . ', ' . $result->areaname . ', Lagos State';
                                                                    echo $add;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $result->housecat; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $result->monthlycharge; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $result->debt; ?>
                                                            </td>
                                                            <td>
                                                              <?php 
                                                                $ans = '';
                                                                if ($result->lastpayment > 0) {
                                                                    $ans = $result->lastpayment;
                                                                }
                                                                echo $ans;
                                                               ?>
                                                            </td>
                                                           <td>
                                                              <?php 
                                                                $ans = '';
                                                                if ($result->lastpaymentdate != '0000-00-00') {
                                                                    $ans = $result->lastpaymentdate;
                                                                }
                                                                echo $ans;
                                                               ?>
                                                            </td>
                                                        </tr>    
                                                       
                                                   <?php } ?>
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

