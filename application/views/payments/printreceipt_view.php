
    <div class="container-fluid bg-white">
      <div style="font-size: 18px">
        <div class="row"><!-- outer row -->

            <div class="col-sm-12">
                <h4 class="text-center morebold">LAGOS WASTE MANAGEMENT AUTHORITY</h4>
                <h4 class="text-center morebold">OPEN DOOR SYSTEMS INTERNATIONAL LIMITED(PSP)</h4>
            </div>

            <div class="col-sm">
                    
                    <div class="">
                        
                        <table class="table table-bordered">
                            
                            <thead>
                                <tr>
                                    <th colspan="3">
                                        <div class="morebold text-center">
                                            <h3 class="text-uppercase">Payment Receipt</h3>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <div align="center"><img src="<?=base_url()?>assets/images/lawmalogo.jpg" width="350" height="150"/></div>
                                    </td>
                                    <td>
                                        <div align="center"><img src="<?=base_url()?>assets/images/laglogo.jpg" width="200" height="150" alt=""/></div>
                                    </td>
                                    <td>
                                        <div align="center"><img src="<?=base_url()?>assets/images/newopendoorlogo.jpg" width="350" height="150" alt=""/></div>
                                    </td>
                                </tr>
                            </thead>

                            <tbody>
                                
                                
                                <tr>
                                    <td>
                                        <span class="morebold">
                                            Receipt No: <?php 
                                              $data['receiptno'] = sprintf('%06d', $data['receiptno']);
                                              echo $data['receiptno'];
                                            ?>
                                        </span>
                                    </td>
                                    <td><?php echo ''; ?> </td>
                                    <td>
                                        <span class="morebold">Date: <?php echo $data['date']; ?>
                                            </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span class="morebold">
                                            Received From: <?php echo $data['name']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo ''; ?> </td>
                                    <td>
                                        <span class="morebold">Tel:<?php echo $data['tel']; ?>
                                            </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <span class="morebold">Address: <?php echo $data['address']; ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <span class="morebold">
                                            the sum of: <?php echo $data['amountinwords']; ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <span class="morebold">
                                            Being payment for: <?php echo $data['purpose']; ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <div class="morebold" align="left">Amount in figure: N<?php echo $data['amount']; ?></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?php echo ''; ?></td>
                                    <td colspan="2">
                                        <div align="center">
                                            <img src="<?php echo base_url().'/signatures/'. $signature; ?>" width="50" height="50" />
                                            <hr style="margin: 0;">
                                            <span style="font-size: 12px;"><strong>For: Open Door Systems International Ltd</strong></span>
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

    <div style="height: 50px;"><hr></div>
   

   <!-- duplicate -->


   