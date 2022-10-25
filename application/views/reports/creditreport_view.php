

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
                        <h2 class="hk-pg-title font-weight-600 mb-10">Cash Book</h2>
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
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 

                                                    $creditSum = 0;
                                                    $debitSum = 0;

                                                    foreach ($credit as $row) {
                                                        $i++; 

                                                        if ($row->credit > 0) {
                                                            $creditSum += $row->credit;
                                                        }
                                                        else {
                                                            $debitSum += $row->debit;
                                                        }

                                                        ?>
                                                               
                                                           <tr>
                                                              <td><?php echo $i; ?></td>
                                                              <td><?php echo $row->date; ?></td>
                                                              <td><?php echo $row->narration; ?></td>
                                                              <td><?php echo $row->debit; ?></td>
                                                              <td><?php echo $row->credit; ?></td>
                                                              
                                                           </tr>
                                                            
                                                       
                                                   <?php 

                                                    if ($i == $count) { ?>
                                                        <tr>
                                                            <td><?php echo ''; ?></td>
                                                            <td><?php echo ''; ?></td>
                                                            <td><?php echo ''; ?></td>
                                                            <td>
                                                                <strong>
                                                                    <?php echo $debitSum; ?>
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    <?php echo $creditSum; ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                   <?php }

                                                    } ?>
                                                </tbody>
                                            </table>
                                        <!--</div>-->
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

