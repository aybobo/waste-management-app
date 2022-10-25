

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Waste Management Application</h2>
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
                    <div class="col-xl-12">
                        <div class="hk-row">
							<div class="col-sm-12">
								<div class="card-group hk-dash-type-2">
									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Sectors</span>
												</div>
												<!--<div>
													<span class="text-success font-14 font-weight-500">+10%</span>
												</div>-->
											</div>
											<div>
												<span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $data['sectors']; ?></span></span>
												<!--<small class="d-block">172,458 Target Users</small>-->
											</div>
										</div>
									</div>
								
									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Streets</span>
												</div>
												<!--<div>
													<span class="text-success font-14 font-weight-500">+12.5%</span>
												</div>-->
											</div>
											<div>
												<span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $data['streets']; ?></span></span>
												<!--<small class="d-block">472,458 Targeted</small>-->
											</div>
										</div>
									</div>
								
									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Houses</span>
												</div>
												<!--<div>
													<span class="text-warning font-14 font-weight-500">-2.8%</span>
												</div>-->
											</div>
											<div>
												<span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $data['houses']; ?></span></span>
												<!--<small class="d-block">100 Targeted</small>-->
											</div>
										</div>
									</div>
								
									<div class="card card-sm">
										<div class="card-body">
											<div class="d-flex justify-content-between mb-5">
												<div>
													<span class="d-block font-15 text-dark font-weight-500">Customers</span>
												</div>
												<!--<div>
													<span class="text-danger font-14 font-weight-500">-75%</span>
												</div>-->
											</div>
											<div>
												<span class="d-block display-4 text-dark mb-5"><span class="counter-anim"><?php echo $data['customers']; ?></span></span>
												<!--<small class="d-block">42:32 Targeted</small>-->
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
						<div class="hk-row">
							<!--<div class="col-lg-6">
								<div class="card card-refresh">
									<div class="refresh-container">
										<div class="loader-pendulums"></div>
									</div>
									<div class="card-header card-header-action">
										<h6>Youtube Subscribers</h6>
										<div class="d-flex align-items-center card-action-wrap">
											<a href="#" class="inline-block refresh mr-15">
												<i class="ion ion-md-radio-button-off"></i>
											</a>
											<div class="inline-block dropdown">
												<a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="ion ion-md-more"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="hk-legend-wrap mb-20">
											<div class="hk-legend">
												<span class="d-10 bg-brown rounded-circle d-inline-block"></span><span>Desktop</span>
											</div>
											<div class="hk-legend">
												<span class="d-10 bg-brown-light-4 rounded-circle d-inline-block"></span><span>Mobile</span>
											</div>
										</div>
										<div id="e_chart_3" class="echart" style="height: 240px;"></div>
									</div>
								</div>
								<div class="card">
									<div class="card-header card-header-action">
										<h6>Country Stats</h6>
										<div class="d-flex align-items-center card-action-wrap">
											<a href="#" class="inline-block refresh mr-15">
												<i class="ion ion-md-arrow-down"></i>
											</a>
											<a href="#" class="inline-block full-screen">
												<i class="ion ion-md-expand"></i>
											</a>
										</div>
									</div>
									<div class="card-body pa-0">
										<div class="pa-20">
											<div id="world_map_marker_1" style="height: 300px"></div>
										</div>
										<div class="table-wrap">
											<div class="table-responsive">
												<table class="table table-sm table-hover mb-0">
													<thead>
														<tr>
															<th class="w-25">Country</th>
															<th>Sessions</th>
															<th>Goals</th>
															<th>Goals Rate</th>
															<th>Bounce Rate</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>Canada</td>
															<td>55,555</td>
															<td>210</td>
															<td>2.46%</td>
															<td>0.26%</td>
														</tr>
														<tr>
															<td>India</td>
															<td>24,152</td>
															<td>135</td>
															<td>0.58%</td>
															<td>0.43%</td>
														</tr>
														<tr>
															<td>UK</td>
															<td>15,640</td>
															<td>324</td>
															<td>5.15%</td>
															<td>2.47%</td>
														</tr>
														<tr>
															<td>Botswana</td>
															<td>12,148</td>
															<td>854</td>
															<td>4.19%</td>
															<td>0.1%</td>
														</tr>
														<tr>
															<td>UAE</td>
															<td>11,258</td>
															<td>453</td>
															<td>8.15%</td>
															<td>0.14%</td>
														</tr>
														<tr>
															<td>Australia</td>
															<td>10,786</td>
															<td>376</td>
															<td>5.48%</td>
															<td>0.45%</td>
														</tr>
														<tr>
															<td>Phillipines</td>
															<td>9,485</td>
															<td>63</td>
															<td>3.51%</td>
															<td>0.9%</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>-->
							<!--<a href="<?=site_url('customersetup/status')?>">Update Status</a>-->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header card-header-action">
										<!--<a href="<?=site_url('customersetup/updateCustomerStatus')?>">Update Status</a>-->
										<h6>Payment Analysis For The Month</h6>
										<!--<div class="d-flex align-items-center card-action-wrap">
											<a href="#" class="inline-block refresh mr-15">
												<i class="ion ion-md-arrow-down"></i>
											</a>
											<a href="#" class="inline-block full-screen mr-15">
												<i class="ion ion-md-expand"></i>
											</a>
											<a class="inline-block card-close" href="#" data-effect="fadeOut">
												<i class="ion ion-md-close"></i>
											</a>
										</div>-->
									</div>
									<?php
									$debt = 0; $ndebt = 0;
									foreach ($customerrecords as $row) {
										if ($row->customertype == 'Commercial') {
											$debt += $row->debt;
										}
										else {
											$ndebt += $row->debt;
										}
									}
									?>
									<div class="card-body pa-0">
										<div class="table-wrap">
											<div class="table-responsive">
												<table class="table table-sm table-hover mb-0">
													<!--<thead>
														<tr>
															<th>Metrics</th>
															<th class="w-40">Period</th>
															<th class="w-25">Past</th>
															<th>Trend</th>
														</tr>
													</thead>-->
													<tbody>
														<tr>
															<td>Total Collection</td>
															<td><?php echo $data['mntcollection']; ?></td>
														</tr>
														<tr>
															<td>Net Commission</td>
															<td><?php echo $data['netcomm']; ?></td>
														</tr>
														<tr>
															<td colspan="2">
																<h6>Customer Breakdown</h6>
															</td>
														</tr>
														<tr>
															<td>Commercial</td>
															<td><a href="<?=site_url('reports/commercialbytype')?>" class="btn btn-success btn-block" style="text-decoration: none;" target="_blank"><?php echo $data['commercial']; ?></a></td>
														</tr>
														<tr>
															<td>Residential</td>
															<td><?php echo ($data['customers'] - $data['commercial']); ?></td>
														</tr>
														<tr>
															<td colspan="2">
																<h6>Debt Analysis By Customer Type</h6>
															</td>
														</tr>
														<tr>
															<td>Commercial</td>
															<td><a href="<?=site_url('reports/commercialdebts')?>" class="btn btn-success btn-block" style="text-decoration: none;"><?php echo $debt; ?></a></td>
														</tr>
														<tr>
															<td>Residential</td>
															<td><a href="<?=site_url('reports/residentialdebts')?>" class="btn btn-success btn-block" style="text-decoration: none;"><?php echo $ndebt; ?></a></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!--<div class="card">
									<div class="card-header card-header-action">
										<h6>Users by Gendar & Age</h6>
										<div class="d-flex align-items-center card-action-wrap">
											<div class="inline-block dropdown">
												<a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="ion ion-ios-more"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div id="e_chart_5" class="echart" style="height:250px;"></div>
										<div class="hk-legend-wrap mt-20">
											<div class="hk-legend">
												<span class="d-10 bg-primary rounded-circle d-inline-block"></span><span>18-24</span>
											</div>
											<div class="hk-legend">
												<span class="d-10 bg-brown-light-2 rounded-circle d-inline-block"></span><span>25-34</span>
											</div>
											<div class="hk-legend">
												<span class="d-10 bg-brown-light-3 rounded-circle d-inline-block"></span><span>35-44</span>
											</div>
											<div class="hk-legend">
												<span class="d-10 bg-brown-light-4 rounded-circle d-inline-block"></span><span>45-54</span>
											</div>
											<div class="hk-legend">
												<span class="d-10 bg-brown-light-5 rounded-circle d-inline-block"></span><span>55-64</span>
											</div>
										</div>
									</div>
								</div>-->
								<!--<div class="card">
									<div class="card-header card-header-action">
										<h6>Analytics Audience Matrics</h6>
										<div class="d-flex align-items-center card-action-wrap">
											<div class="inline-block dropdown">
												<a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="ion ion-ios-more"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Action</a>
													<a class="dropdown-item" href="#">Another action</a>
													<a class="dropdown-item" href="#">Something else here</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#">Separated link</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="hk-legend-wrap mb-20">
											<div class="hk-legend">
												<span class="d-10 bg-brown rounded-circle d-inline-block"></span><span>Users</span>
											</div>
											<div class="hk-legend">
												<span class="d-10 bg-brown-light-1 rounded-circle d-inline-block"></span><span>Sessions</span>
											</div>
											<div class="hk-legend">
												<span class="d-10 bg-brown-light-4 rounded-circle d-inline-block"></span><span>Pageviews</span>
											</div>
										</div>
										<div id="e_chart_6" class="echart" style="height:250px;"></div>
									</div>
								</div>-->
							</div>
							<div class="col-lg-6">
								<div class="card">
									<div class="text-center">
										<a href="<?=site_url('customersetup/debtanalysis')?>" class="btn btn-success">Debt Analysis</a>
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

