

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">View Liabilities</h2>
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
                                        <div class="">
                                            <table class="table table-hover table-bordered mb-0" id="data">
                                                <thead class="thead-success">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        <th>Entered By</th>
                                                        <th>Date Entered</th>
                                                        <th>Status</th>
                                                        <th>Modify</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($rows as $row) {
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td>
                                                                <a href="<?=base_url()?>assets/singleliability/?id=<?php echo $row->liabilityid; ?>"><?php
                                                                  echo $row->name;
                                                                ?></a>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                  echo $row->amount;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    echo $row->date;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                            echo $row->enteredby;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                            echo $row->entrydate;
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row->status; ?></td>
                                                            <td>
                                                            <?php $var = $row->liabilityid; ?>
                                                            <a href="<?=base_url()?>assets/editliability/?id=<?php echo $var; ?>" class="label label-primary"><span class="glyphicon glyphicon-pencil"></span></a>
                                                            </td>
                                                            <td>
                                                            <?php $var = $row->liabilityid; ?>
                                                            <a href="#confirm" class="label label-primary" data-toggle="modal" data-id="<?php echo $var; ?>"><span class="glyphicon glyphicon-trash"></span></a>
                                                            </td>
                                                        </tr>
                                                   <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
               
               <!-- Modal -->
                <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure want to delete this credit facility?
                        
                        
                      </div>
                      <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <?php echo form_open('assets/deleteliability', 
                                    ['class' => 'form_horizontal']); ?>

                        <input type="hidden" id="id" name="id" value="">
                            
                        <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Delete Liability',
                                                            'class' => 'btn btn-danger']); ?>
                        <!--<button type="button" class="btn btn-danger">Delete</button>-->
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

