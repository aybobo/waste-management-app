

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">All Commercial Types</h2>
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

                <?php
                    if ($num > 0) { ?>
                        <div class="row">
                            <div class="col-sm">
                                <?php echo form_open('customersetup/editcommercialtype', 
                                                            ['class' => 'form_horizontal']); ?>

                                <table class="table table-hover table-bordered mb-0" id="datatable">
                                    <thead class="thead-success">
                                        <tr>
                                            <th>S/No</th>
                                            <th>#</th>
                                            <th>Commercial Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 0;
                                        foreach ($types as $type) {
                                            $i++; ?>
                                            <tr>
                                                <?php $val = $type->typeId; ?>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <input type="checkbox" name="typeId[<?php echo  $val ; ?>]" value="<?php echo $val; ?>">
                                                </td>
                                                <td>
                                                    <input type="text" name="typeName[<?php echo $val; ?>]" value="<?php echo $type->typeName; ?>" class="form-control col-sm-6">
                                                </td>
                                                <td>
                                                    <?php
                                                        $status = $type->status;
                                                        $var = '';
                                                        if ($status == 'Active') {
                                                            $var = 'Inactive';
                                                        }
                                                        else {
                                                            $var = 'Active';
                                                        }
                                                    ?>
                                                    <select name="status[<?php echo  $val ; ?>]">
                                                        <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                                        <option value="<?php echo $var; ?>"><?php echo $var; ?></option>
                                                    </select>
                                                </td>
                                            </tr>
                                       <?php } ?>
                                    </tbody>
                                </table>

                                <?php echo form_submit(['name' => 'submit', 
                                                            'value' => 'Update Commercial Type',
                                                            'class' => 'btn btn-success mt-20']); ?>

                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    <?php }
                    else { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center">No record found</h2>
                            </div>
                        </div>
                  <?php  }
                ?>
               
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