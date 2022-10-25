
<style>
.l{
	float:left;
}

.r{
	float:right;
}
</style>
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
           
               
             

               
                	 
                         <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                        <?php foreach ($rows as $row) { ?>
                                            <table class="table table-hover table-bordered mb-0">
                                          <thead class="thead">
                                               
                                              <h4 class="text-center">LAGOS STATE WASTE MANAGEMENT AUTHORITY</h4>
                                              <h4 class="text-center">OPEN DOOR SYSTEM INTERNATIONAL LIMITED(PSP)</h4>    
                                              <tr>
                                                <th><div align="center"><img src="<?=base_url()?>assets/images/lawmalogo.jpg" width="116" height="99"/></div></th>
                                                <th colspan="2"><div align="center"><img src="<?=base_url()?>assets/images/laglogo.jpg" width="108" height="92" alt=""/></div>
                                            <div align="center">    <strong>3, Otto Road, Ijora Olopa, Lagos<br />
                                                    Tel: 01-740075, 81686. Fax: 01-5844784<br />
Email: newlawma@gmail.com<br />
Website: www.lawma.org</strong></div></th>
                                                <th><div align="center"><img src="<?=base_url()?>assets/images/opendoorlogo.jpg" width="104" height="102" alt=""/></div></th>
                                                <th> <strong>Head Office</strong>: 
                                                 <span style="font-size: 10px;"> <br />  Suite 16, Block B (2nd floor) 
                                                  <br />L.S.P.C Complex, 
                                                  <br />131, Obafemi Awolowo Way  
                                                  <br />P.O. Box 13913, Ikeja-Lagos. 
                                                <br />Tel: 08174707015, 08080181911,
                                                <br />08033350632, 08035068656 </span></th>
                                              </tr>
                                              <tr>
                                                <th colspan="3">
                                                  NAME: <?php $code = '(' . $row->customercode . ')';
                                                  echo $row->name . $code;
                                                 ?>
                                                </th>
                                                <th colspan="2">DATE: <?php echo $date; ?></th>
                                              </tr>
                                              <tr>
                                                <th colspan="3">ADDRESS: 
                                                  <?php $add = $row->houseno . ', ' . $row->streetname. ', ' . $row->areaname . ', Lagos State.';
                                                    echo $add;
                                                    ?>
                                                </th>
                                                <th colspan="2" rowspan="4" valign="top"> 
                                                  <table width="80%" border="1" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                      <td colspan="3"><div align="center"><strong>PAYMENT CONFIRMATION</strong></div></td>
                                                    </tr>
                                                    <tr>
                                                      <td>Month</td>
                                                      <td>Receipt No.</td>
                                                      <td>Date</td>
                                                    </tr>
                                                    <tr>
                                                      <td>&nbsp;</td>
                                                      <td>&nbsp;</td>
                                                      <td>&nbsp;</td>
                                                    </tr>
                                                  </table><br />
                                                  <div>
                                                    <p>DESIGNATED BANKS:<br />
                                                     <!--<img src="<?=base_url()?>assets/images/gtb.jpg" width="24" height="24"/> GT Bank A/C No: 0007344500<br />-->
                                                     1. <strong>Open Door Systems Int'l Ltd</strong><br>
                                                        Wema Bank - A/C No: 0123074951<br>
                                                     2. <strong>Muhfat Desire Global Ventures</strong><br>
                                                        Access Bank A/C No: 1228832480
                                                    <!--<img src="<?=base_url()?>assets/images/asb.jpg" width="39" height="19"/>Access Bank A/C No: 0026785709--></p>
                                                    <br /><table  border="1" align="left" cellpadding="0" cellspacing="0">
                                                      <tr>
                                                        <td><div align="center" class="l"><small>Customer Receipt</small><br /><small>Payment Confirmation</small></div></td>
                                                      </tr>
                                                      <tr>
                                                        <td><p>&nbsp;</p>
                                                        <p>&nbsp;</p></td>
                                                      </tr>
                                                      <tr>
                                                        <td><div align="left"><small>DATE </small><BR /><small>SIGNATURE</small> <BR /><small>BANK STAMP</small></div></td>
                                                      </tr>
                                                      </table>
                                                  <div align="left">  <p style="font-size:9px">&nbsp;&nbsp;NOTE:<br />
                                                      &nbsp; All receipts after payment <br />
                                                      &nbsp; should be issued by the <br />
                                                      &nbsp; office of Open Door Systems  <br />
                                                     &nbsp;International Limited,  <br />
                                                     &nbsp; upon presentation of payment <br />
                                                    &nbsp; Tellers/ Cash or Cheque. <br />  <br /> 
                                                      &nbsp;To avoid any fraudulent <br />
                                                      &nbsp; activities, please contact  <br />
                                                      &nbsp; the office through any of <br />
                                                     &nbsp;the following numbers: <br />
                                                     &nbsp; 08098068656,08033240119,<br />
                                                   &nbsp;   08037202793  </p>
                                                </div></th>
                                              </tr>
                                              <tr>
                                                <th colspan="3"><div align="center"><strong>PLACING OUR CUSTOMER<br />
                                                AND THE ENVIRONMENT FIRST</strong>
                                                    <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                                          
                                                      <tr>
                                                        <td width="47%"><strong>INVOICE/MONTH</strong> <?php echo $month; ?></td>
                                                        <td colspan="3">&nbsp;</td>
                                                        <td width="14%"><strong>Year</strong><br><?php echo $year; ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td><strong>Previous Wallet Balance</strong> - N<?php echo $row->formerwallet; ?>
                                                          
                                                        </td>
                                                        <td width="18%"><strong>Previous Debt:</strong> N<?php echo $row->formerdebt; ?></td>
                                                        <td colspan="2"><strong>Monthly Charge</strong><br>N<?php echo $row->monthlycharge; ?>

                                                        </td>
                                                        <td><p><strong>&nbsp;</strong></p></td>
                                                      </tr>
                                                      <tr>
                                                        <td height="22">Type of Customer: <?php echo $row->customertype; ?></td>
                                                        <td colspan="3">
                                                          <strong>Last Payment Date: </strong><?php echo $row->lastpaymentdate; ?>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="2"><strong>Last Payment: </strong>N<?php echo $row->lastpayment; ?></td>
                                                        <!--<td>&nbsp;</td>
                                                        <td>&nbsp;</td>-->
                                                        <td colspan="3"><strong>Current Amount in Wallet: </strong>N<?php echo $row->wallet; ?></td>
                                                        </tr>
                                                    </table>
                                                  </div>
                                                  <BR />
                                                    
                                                  <div align="center">
                                                      <table width="100%" border="1" cellpadding="0" cellspacing="0">
                                                          
                                                        <tr>
                                                          <td width="47%"><strong>MONTH(S)</strong></td>
                                                          <td width="11%"><?php echo $month; ?></td>
                                                          <td width="7%">&nbsp;</td>
                                                          <td width="10%">&nbsp;</td>
                                                          <td width="11%">&nbsp;</td>
                                                          <td width="14%"><strong>OUTSTANDING<br>BILL</strong></td>
                                                        </tr>
                                                        <tr>
                                                          <td><strong>Last Invoice Generate Date</strong> - <?php echo $row->lastinvoicegeneratedate; ?></td>
                                                          <td>&nbsp;</td>
                                                          <td>&nbsp;</td>
                                                          <td>&nbsp;</td>
                                                          <td>&nbsp;</td>
                                                          <td>N<?php echo intval(ceil($row->debt)); ?></td>
                                                        </tr>
                                                      </table>
                                                  </div>
                                                    
                                                </th>
                                              </tr>
                                              <tr>
                                                <th colspan="3"><p>This invoice issued by LAWMA on behalf of the Lagos State Government by virtue of section 16 of the Lagos <br />
                                                      Waste Management Authority Law No 27 Vol 40 Laws of Lagos State 2007, any person who fails or <br />
                                                      neglects to pay the tariff, less or charges prescribed by the Lagos Waste Management Authority commits <br />
                                                    an offense and is liable on conviction to a fine or imprisonment.</p>
                                                  <br />
                                                <div  class="l">PLEASE PAY YOUR WASTE BILL ON OR BEFORE</div> </th>
                                              </tr>
                                              <tr>
                                                <th colspan="3"> <br />
                                                  <div  class="l">Reference Code: <br />
                                                      
                                                  Property Code:</div><div class="r">Dear Customer<br />
                                                    Please call Open Door Systems Int'l Ltd.<br />
                                                    On the following numbers for your enquiry<br />
                                                    and information 08174707015, 08080181911,<br />
                                                08033350632, 08035068656</div></th>
                                              </tr>
                                              </thead>
                                          <tbody>
                                                    
                                          </tbody>
                                      </table>
                                      <br />
                                      <br />
                                      
                                      <table class="table table-hover table-bordered mb-0">
                                          <thead class="thead">
                                                    
                                              <tr>
                                                <th><div align="LEFT"><strong style="font-size:20px">LAWMA COPY</strong></div>
                                                NAME:<BR />ADDRESS:</th>
                                                <th><div align="center"><img src="<?=base_url()?>assets/images/opendoorlogo.jpg" width="104" height="102" alt=""/></div></th>
                                                <th>Customer Account Code </th>
                                                <th>Property Class</th>
                                                <th>Amount Due</th>
                                                <th>Invoice Months</th>
                                              </tr>
                                              <tr>
                                                <th><p><strong>Amount Paid:</strong></p>
                                                <p><strong></strong></p></th>
                                                <th colspan="2">&nbsp; </th>
                                                <th colspan="3"><table  border="1" align="left" cellpadding="0" cellspacing="0">
                                                      <tr>
                                                        <td><div align="left" class="l">
                                                          <p><small><strong>Are you satisfied with our services?</strong></small></p>
                                                          <p>
                                                            <input type="checkbox" name="checkbox" id="checkbox" />
                                                          <strong>YES</strong></p>
                                                          <p>
                                                            <input type="checkbox" name="checkbox2" id="checkbox2" />
                                                          <strong>NO</strong></p>
                                                          <p>
                                                            <input type="checkbox" name="checkbox3" id="checkbox3" />
                                                          <strong>NOT SURE</strong></p>
                                                        </div></td>
                                                      </tr>
                                                      </table><BR /> <BR /><BR />
                                                     &nbsp;&nbsp; __________________________<BR />
                                                      <strong style="font-size:9px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE SIGNATURE AND BANK STAMP</strong>
                                                  </th>
                                              </tr>
                                              <tr>
                                                <th colspan="6">Amount paid in words:_______________________________________________________________________________________________________________________________________ </th>
                                              </tr>
                                              <tr>
                                                <th colspan="6">&nbsp;</th>
                                              </tr>
                                              <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th colspan="3"><div align="center" class="l">___________________________________________________________________________<br />
                                                Authorised Signature</div></th>
                                              </tr>
                                              </thead>
                                          <tbody>
                                                    
                                          </tbody>
                                      </table>
                                      <br /><br /><br /><table class="table table-hover table-bordered mb-0">
                                          <thead class="thead">
                                                    
                                              <tr>
                                                <th><div align="LEFT"><strong style="font-size:20px">BANK COPY</strong></div>
                                                NAME:<BR />ADDRESS:</th>
                                                <th><div align="center"><img src="<?=base_url()?>assets/images/opendoorlogo.jpg" width="104" height="102" alt=""/></div></th>
                                                <th>Customer Account Code </th>
                                                <th>Property Class</th>
                                                <th>Amount Due</th>
                                                <th>Invoice Months</th>
                                              </tr>
                                              <tr>
                                                <th colspan="3"><p><strong>Amount Paid: </strong><strong></strong></p></th>
                                                <th colspan="3"><BR /> 
                                                  <BR /><BR />
                                                     &nbsp;&nbsp; __________________________<BR />
                                                      <strong style="font-size:9px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE SIGNATURE AND BANK STAMP</strong>
                                                </th>
                                              </tr>
                                              <tr>
                                                <th colspan="6">Amount paid in words:_______________________________________________________________________________________________________________________________________ </th>
                                              </tr>
                                              <hr>
                                            
                                              </thead>
                                          <tbody>
                                                    
                                          </tbody>
                                      </table>  <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
    

            <!-- /Container -->
			
            <!-- Footer -->
            <div class="hk-footer-wrap container">
                <footer class="footer">
                    <div class="row">
                        <div align="center">
                             </div>
                        
                    </div>
                </footer>
            </div>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->

 
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="<?=base_url()?>vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/parsley.min.js"></script>

