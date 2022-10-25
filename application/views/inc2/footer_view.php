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
    $('#area').change(function() {
      var areaid = $('#area').val();
      if (areaid !='') 
      {
        $.ajax({
          url:"<?php echo base_url(); ?>customersetup/fetchactivesector",
          method:"POST",
          data:{areaid:areaid},
          success:function(data)
          {
            $('#sector').html(data);
            //$('#houseno').html('<option value="">Select House Number</option>');
          }
        });
      }
      else 
      {
        $('#sector').html('<option value="">Select Sector</option>');
        $('#street').html('<option value="">Select Street</option>');
        $('#houseno').html('<option value="">Select House Number</option>');
      }
    });
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
  });
</script>
<script>
  function myarea()
  {
    var f = document.getElementById("area");
    var areaid = f.options[f.selectedIndex].value;
    if (areaid =='')
    {
      document.getElementById('sector').disabled = true;
      document.getElementById("sector").value = '';
    }
    else {
      document.getElementById('sector').disabled = false;
    }
  }

  //----------------------------

  function mysector() {
    var e = document.getElementById("sector");
    var sectorid = e.options[e.selectedIndex].value;
    if (sectorid =='')
    {
      document.getElementById('street').disabled = true;
      document.getElementById('houseno').disabled = true;
      document.getElementById('housetype').disabled = true;
      
      document.getElementById("street").value = '';
      document.getElementById("houseno").value = '';
      document.getElementById("housetype").value = '';
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
      document.getElementById('housetype').disabled = true;
      
      document.getElementById("houseno").value = '';
      document.getElementById("housetype").value = '';
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
      document.getElementById('housetype').disabled = true;
      document.getElementById("housetype").value = '';
    }
    else {
      document.getElementById('housetype').disabled = false;
    }
  }

  //-----------------------------------

  function mycustomertype()
  {
    var e = document.getElementById("customertype");
    var commtype = e.options[e.selectedIndex].value;
    if (commtype == 'Residential')
    {
      document.getElementById('commtype').disabled = true;
      document.getElementById("commtype").value = '';
    }
    else {
      document.getElementById('commtype').disabled = false;
    }
  }
</script>
<!-- date picker -->
<script>
  $(function() {
    $('#picker').datepicker({
      'format': 'yyyy-mm-dd',
      'autoclose': true
    });
  });
</script>
</body>

</html>