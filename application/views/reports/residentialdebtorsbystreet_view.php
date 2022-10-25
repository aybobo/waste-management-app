

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h4 class="hk-pg-title font-weight-600 mb-10">Debt Analysis of Residential<br>
                            Debtors in <?php echo $sector; ?></h4>
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
                

                <!--  --->

                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="overflow">
                                <table class="table table-hover table-bordered mb-0" id="data" width="100%">
                                    <thead class="thead-success">
                                        <tr>
                                            <th>#</th>
                                            <th>Street</th>
                                            <th>Amount(N)</th>
                                            <th>Analysis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($streetdebt as $key => $value) {
                                            $i++; ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                   <?php echo $key; ?> 
                                                </td>
                                                <td>
                                                    <?php echo $value; ?>
                                                </td>
                                                <td>
                                                    <a href="<?=base_url()?>reports/residentialdebtperhouse/?street=<?php echo $key; ?>&sector=<?php echo $sector; ?>" class="label label-primary" target="_blank"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                              </td>
                                            </tr>
                                       <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- --->
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="graph" style = "width: 800px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
                <!-- -->
 
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
    

