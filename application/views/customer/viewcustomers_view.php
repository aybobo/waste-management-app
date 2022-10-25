

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">All Customers</h2>
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

                <?php $i = 0; ?>
                	<div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <div class="overflow">
                                            <table class="table table-hover table-bordered mb-0" id="datatable" width="100%">
                                                <thead class="thead-success">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Customer Name</th>
                                                        <th>Customer Code</th>
                                                        <th>Debt</th>
                                                        <th>Wallet</th>
                                                        <th>Payment Record</th>
                                                        <th>Generate Invoice</th>
                                                        <th>Status</th>
                                                        <th>Created By</th>
                                                        <th>Date Created</th>
                                                        <th>Last Modified By</th>
                                                        <th>Date Modified</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($customers as $row) {
                                                        $var = $row->customerid; 
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td>
                                                                <a href="<?=base_url()?>customersetup/singlecustomer/?id=<?php echo $var; ?>"><?php
                                                                    echo $row->name;
                                                                ?></a>
                                                            </td>
                                                            
                                                          <td><?php echo $row->customercode; ?></td>
                                                          <td><?php echo $row->debt; ?></td>
                                                          <td><?php echo $row->wallet; ?></td>
                                                            <td class="text-center">
                                                            <a href="<?=base_url()?>customersetup/payrecord/?id=<?php echo $var; ?>" class="label label-primary"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                                            </td>
                                                            <td class="text-center">
                                                            <a href="<?=base_url()?>customersetup/singlecustomerinvoice/?id=<?php echo $var; ?>" class="label label-primary"><span class="glyphicon glyphicon-print"></span></a>
                                                            </td>
                                                            <td>
                                                                <?php echo $row->status; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                            echo $row->createdby;
                                                                ?>       
                                                            </td>
                                                            <td>
                                                                <?php echo date('M j, Y h:ia', strtotime($row->datecreated)); ?>
                                                            </td>
                                                            <td>
                                                               <?php echo $row->modifiedby; ?> 
                                                            </td>
                                                            <td>
                                                                <?php echo date('M j, Y h:ia', strtotime($row->datemodified)); ?>
                                                            </td>
                                                            <td>
                                                            <a href="<?=base_url()?>customersetup/editcustomer/?id=<?php echo $var; ?>" class="label label-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                          </td>
                                                        </tr>
                                                   <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
               
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

