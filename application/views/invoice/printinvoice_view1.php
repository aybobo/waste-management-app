<?php 
$i = 0;
foreach ($rows as $row) { ?>

<div class="container-fluid bg-white">
  <div style="font-size: 18px">
	<div class="row"><!-- outer row -->

		<div class="col-sm-12">
			<h5 class="text-center morebold">LAGOS WASTE MANAGEMENT AUTHORITY</h5>
			<h5 class="text-center morebold">OPEN DOOR SYSTEMS INTERNATIONAL LIMITED(PSP)</h5>
		</div>

		<div class="col-sm">
				
				<div class="">
					
					<table class="table table-bordered">
						
						<thead>
							<tr>
								<th>
									<div align="center"><img src="<?=base_url()?>assets/images/lawmalogo.jpg" width="150" height="100"/></div>
								</th>
								<th>
									<div align="center"><img src="<?=base_url()?>assets/images/laglogo.jpg" width="150" height="100" alt=""/></div>
								</th>
								<th>
									<div align="center"><img src="<?=base_url()?>assets/images/newopendoorlogo.jpg" width="150" height="100" alt=""/></div>
								</th>
							</tr>
						</thead>

						<tbody>
							
							<tr>
								<td>
									<span class="morebold"><h5>REF: <?php echo $row->customercode; ?></h5></span><br>
									<span style="font-size: 12px;"><strong>(Please quote reference number on all payment)</strong></span>
								</td>
								<td rowspan="2">
									<div class="text-center">
										<span class="morebold">INVOICE<br><span style="font-size: 12px; padding: 0;">(CASH PAYMENT NOT ALLOWED)</span></span>
									</div>
								</td>
								<td><span class="morebold">Date: <?php echo $row->invoicegeneratedate; ?></span></td>
							</tr>

							<tr>
								<td><span class="morebold">Name: <?php echo $row->customername; ?></span></td>
								<td>
									<span class="morebold"><?php echo $row->invoicemonth; ?>/<?php echo $row->invoiceyear; ?></span>
								</td>
							</tr>

							<tr>
								<td colspan="2">
									<span class="morebold">Address: <?php echo $row->address; ?></span>
								</td>
								<td>
									<span class="morebold">INVOICE NO: <?php 
			                              $inv = sprintf('%07d', $row->invoiceid);
			                              echo $inv;
			                            ?></span>
								</td>
							</tr>

							<tr>
								<td width="400"><span class="morebold">Type of Customer</span></td>
								<td><span class="morebold"><?php echo $row->customertype; ?></span></td>
								<td rowspan="2">
									<strong>Designated Banks</strong><br>
						1. <strong>Open Door Systems Int'l Ltd</strong><br>
		                                                        GTB - A/C No: 0007344500<br>
		                                                     2. <strong>Open Door Systems Int'l Ltd</strong><br>
		                                                        Access Bank A/C No: 0026785709<br>
		                                                        3. <strong>Open Door Systems Int'l Ltd</strong><br>
		                                                        Wema Bank A/C No: 0123074951
								</td>
							</tr>

							<tr>
								<td><span class="morebold">Last Payment/Date
									<?php
										$count = 0;

										foreach ($payments as $payment) {
											if ($payment->customerid == $row->customerid) {
												$count += 1;
											}
										}

										if ($count > 1) {
											echo '<br>Other Payments/Date';
										}
									?>
								</span></td>
								<td>
									<span class="morebold">
										<?php
											foreach ($payments as $payment) {
												if ($payment->customerid == $row->customerid) {
													echo $payment->paymentdate . '/' . $payment->amount . '<br>';
												}
											}
										?>
									</span>
								</td>
							</tr>

							<tr>
								<td>
									<span class="morebold">Previous Balance</span>
								</td>
								<td>
									<span class="morebold">
										<span class="morebold">
										<?php 
                                                            $output = '';
                                                            if ($row->formerwallet > 0) {
                                                              $output = 'N' . $row->formerwallet . '(CR)';
                                                            }
                                                            else {
                                                              if ($row->formerdebt > 0) {
                                                                $output = 'N' . $row->formerdebt . '(DR)';
                                                              }
                                                              else {
                                                                $output = 'Nil';
                                                              }
                                                            }
                                                            echo $output;
                                                           ?>
									</span>
									</span>
								</td>
								<td rowspan="3">
								Kindly text/screenshot proof of payment by <strong>whatsapp to 08174707015</strong><br>
									<strong>For Enquiries,</strong><br>
												<strong>call - </strong> 08080181911, 08033350632, 08035068656
								</td>
								<!--<td><?php echo ''; ?></td>-->
							</tr>

							<tr>
								<td><span class="morebold">Current Monthly Charge</span></td>
								<td><span class="morebold">N<?php echo $row->monthlycharge; ?></span></td>
								
							</tr>

							<tr>
								<td><span class="morebold">VAT 7.5% of current monthly charge</span></td>
								<td><span class="morebold">
									<?php
										$vat = 0.075 * $row->monthlycharge;
										echo $vat;
									?>
								</span></td>
								
							</tr>

							<tr>
								<td><span class="morebold">Total Outstanding</span></td>
								<td>
									<span class="morebold">
										<?php 
                                                            $output = '';
                                                            if ($row->wallet > 0) {
                                                              $output = 'N' . $row->wallet . '(CR)';
                                                            }
                                                            else {
                                                              if ($row->debt > 0) {
                                                                $x = intval(ceil($row->debt));
                                                                $output = 'N' . $x . '(DR)';
                                                                // code...
                                                              }
                                                              else {
                                                                $output = 'Nil';
                                                              }
                                                            }
                                                            //$total = $output + $vat;
                                                            echo $output;
                                                           ?>
									</span>
								</td>
								<td rowspan="2">
									<div class="info-font">
										This invoice is issued by <strong>Opendoor</strong> on behalf of <strong>LAWMA</strong> by virtue of section 16 of the Lagos
		                                                      Waste Management Authority Law No 27 Vol 40 Laws of Lagos State 2007, any person who fails or
		                                                      neglects to pay the tariff, less or charges prescribed by the Lagos Waste Management Authority commits
		                                                    an offense and is liable on conviction to a fine or imprisonment.
									</div>
								</td>
							</tr>

							<tr>
								<td colspan="2">
									<div class="text-center">
										PLEASE PAY YOUR WASTE BILL ON OR BEFORE <span style="text-decoration: underline;" class="morebold"><?php echo $row->deadlinedate; ?></span>
									</div>
								</td>
							</tr>

						</tbody>

					</table><!-- class table -->

				</div><!-- table-responsive -->



		</div>
		

	</div><!-- outer row -->

	</div>
</div><!-- end container -->

<?php
	$i++;

	if ($i%2 > 0) { ?>
		<div style="height: 50px;"><hr></div>
		<?php continue;
	}
	else { ?>
		<div class="pagebreak"> </div>
<?php	}

 } ?><!-- end foreach -->