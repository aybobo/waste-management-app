    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url()?>vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Slimscroll JavaScript -->
    <script src="<?=base_url()?>dist/js/jquery.slimscroll.js"></script>

    <!-- Fancy Dropdown JS -->
    <script src="<?=base_url()?>dist/js/dropdown-bootstrap-extended.js"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="<?=base_url()?>dist/js/feather.min.js"></script>

    <!-- Toggles JavaScript -->
    <script src="<?=base_url()?>vendors/jquery-toggles/toggles.min.js"></script>
    <script src="<?=base_url()?>dist/js/toggle-data.js"></script>
	
	<!-- Counter Animation JavaScript -->
	<script src="<?=base_url()?>vendors/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="<?=base_url()?>vendors/jquery.counterup/jquery.counterup.min.js"></script>
	
	<!-- EChartJS JavaScript -->
    <script src="<?=base_url()?>vendors/echarts/dist/echarts-en.min.js"></script>
    
	<!-- Sparkline JavaScript -->
    <script src="<?=base_url()?>vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
	
	<!-- Vector Maps JavaScript -->
    <script src="<?=base_url()?>vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="<?=base_url()?>vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?=base_url()?>dist/js/vectormap-data.js"></script>

	<!-- Owl JavaScript -->
    <script src="<?=base_url()?>vendors/owl.carousel/dist/owl.carousel.min.js"></script>

    <!-- datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
	
	<!-- Toastr JS -->
    <!--<script src="<?=base_url()?>vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>-->
    
    <!-- Init JavaScript -->
  <script src="<?=base_url()?>dist/js/init.js"></script>
	<script src="<?=base_url()?>dist/js/dashboard-data.js"></script>
	<script>
  $(document).ready(function() {
    $('#sector').change(function() {
      var sectorid = $('#sector').val();
      console.log('sectorid:', sectorid);
      if (sectorid !='') 
      {
        $.ajax({
          url:"<?php echo base_url(); ?>customersetup/fetchactivestreet",
          method:"POST",
          data:{sectorid:sectorid},
          success:function(data)
          {
            $('#street').html(data);
            //$('#houseno').html('<option value="">Select House Number</option>');
          }
        });
      }
      else 
      {
        $('#street').html('<option value="">Select Street</option>');
        $('#houseno').html('<option value="">Select House Number</option>');
      }
    });
    $('#street').change(function() {
      var streetid = $('#street').val();

      if (streetid !='') {        
        $.ajax({
          url:"<?php echo base_url(); ?>customersetup/fetchactivehouses",
          method:"POST",
          data:{streetid:streetid},
          success:function(data)
          {
            
            $('#houseno').html(data);
          }
        });
      }
      else {
        $('#houseno').html('<option value="">Select House Number</option>');
      }
    });
    $('#houseno').change(function() {
      var houseid = $('#houseno').val();

      if (houseid !='') {        
        $.ajax({
          url:"<?php echo base_url(); ?>customersetup/fetchcustomercode",
          method:"POST",
          data:{houseid:houseid},
          success:function(data)
          {
            $('#code').html(data);
          }
        });
      }
      else {
        $('#code').html('<option value="">Select customer code</option>');
      }
    });
  });
</script>
<script>
  function mysector() {
    var e = document.getElementById("sector");
    var sectorid = e.options[e.selectedIndex].value;
    if (sectorid =='')
    {
      document.getElementById('street').disabled = true;
      document.getElementById('houseno').disabled = true;
      document.getElementById('code').disabled = true;
      document.getElementById('months').disabled = true;
      document.getElementById('amount').readOnly = true;

      document.getElementById("street").value = '';
      document.getElementById("houseno").value = '';
      document.getElementById("code").value = '';
      document.getElementById("months").value = '';
      document.getElementById("amount").value = '';
    }
    else {
      document.getElementById('street').disabled = false;
    }
  }
</script>
<script>
  function mystreet() {
    var e = document.getElementById("street");
    var streetid = e.options[e.selectedIndex].value;
    if (streetid =='')
    {
      document.getElementById('houseno').disabled = true;
      document.getElementById('code').disabled = true;
      document.getElementById('months').disabled = true;
      document.getElementById('amount').readOnly = true;
      
      document.getElementById("houseno").value = '';
      document.getElementById("code").value = '';
      document.getElementById("months").value = '';
      document.getElementById("amount").value = '';
    }
    else {
      document.getElementById('houseno').disabled = false;
    }
  }
</script>
<script>
  function myhouse() {
    var e = document.getElementById("houseno");
    var houseid = e.options[e.selectedIndex].value;
    if (houseid =='')
    {
      document.getElementById('code').disabled = true;
      document.getElementById('months').disabled = true;
      document.getElementById('amount').readOnly = true;
      
      document.getElementById("code").value = '';
      document.getElementById("months").value = '';
      document.getElementById("amount").value = '';
    }
    else {
      document.getElementById('code').disabled = false;
    }
  }
</script>
<script>
  function mycode() {
    var e = document.getElementById("code");
    var codeid = e.options[e.selectedIndex].value;
    if (codeid =='')
    {
      document.getElementById('months').disabled = true;
      document.getElementById('amount').readOnly = true;
      
      document.getElementById("months").value = '';
      document.getElementById("amount").value = '';
    }
    else {
      document.getElementById("months").disabled = false;
      
      $.ajax({
          url:"<?php echo base_url(); ?>customersetup/fetchcustomername",
          method:"POST",
          data:{codeid:codeid},
          success:function(data)
          {
           // $('#customer').html(data);
           document.getElementById("customer").value = data;
          }
        });
    }
  }
</script>

<script>
  function mymonth() {
    var e = document.getElementById("months");
    var monthsid = e.options[e.selectedIndex].value;
    if (monthsid =='')
    {
      document.getElementById('amount').readOnly = true;
      
      document.getElementById("amount").value = '';
    }
    else if (monthsid == 'Others') {
      document.getElementById('amount').readOnly = false;
    }
    else {
        var i = document.getElementById("code");
        var id = i.options[i.selectedIndex].value;
        var mntcharge = id.substring(id.lastIndexOf("@") +1);
        //document.getElementById("amount").value = mntcharge;

        /*var customerid = id.substring(id.lastIndexOf("@") +0);
        if (customerid !='') {        
          $.ajax({
            url:"<?php echo base_url(); ?>customersetup/fetchactivecustomer",
            method:"POST",
            data:{customerid:customerid},
            success:function(data)
            { 
              $('#amount').html(data);
            }
          });
        }*/
        //

        document.getElementById("amount").value = monthsid * mntcharge;
        document.getElementById('amount').readOnly = true;
    }
  }
</script>

<script>
      $(function() {
        $('#picker').datepicker({
          'format': 'yyyy-mm-dd',
          'autoclose': true
        });
      });
</script>

<script>
  function paymonth() {
    var mntchg = document.getElementById("charge").value;
    var e = document.getElementById("months");
    var monthsid = e.options[e.selectedIndex].value;
    if (monthsid =='')
    {
      document.getElementById('amount').readOnly = true;
      
      document.getElementById("amount").value = '';
    }
    else if (monthsid == 'Others') {
      document.getElementById('amount').readOnly = false;
    }
    else {

        document.getElementById("amount").value = monthsid * mntchg;
        document.getElementById('amount').readOnly = true;
    }
  }
</script>
</body>

</html>