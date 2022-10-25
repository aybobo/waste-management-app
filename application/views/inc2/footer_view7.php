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

  <!-- Data Table JavaScript -->
  <script src="<?=base_url()?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="<?=base_url()?>vendors/jszip/dist/jszip.min.js"></script>
  <script src="<?=base_url()?>vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="<?=base_url()?>vendors/pdfmake/build/vfs_fonts.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="<?=base_url()?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?=base_url()?>dist/js/dataTables-data.js"></script>
    
    <!-- Init JavaScript -->
  <script src="<?=base_url()?>dist/js/init.js"></script>
	<script src="<?=base_url()?>dist/js/dashboard-data.js"></script>
  <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>
  <script type = "text/javascript">
         google.charts.load('current', {packages: ['corechart']});     
  </script>
<script>
  $(document).ready(function() {
      $('#datatable').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'excel', 'pdf', 'print'
          ]
      } );
  } );
</script>

<script type="text/javascript">
    function drawChart() {
      // Define the chart to be drawn.
      var data = google.visualization.arrayToDataTable([
         ['Street', 'Debt'],
         <?php
          foreach ($streetdebt as $key => $value) {
            echo "['". $key . "'," .  $value . "],";
          }

         ?>
      ]);

      var sector = '<?php echo $sector; ?>';
      var main = 'Debt breakdown of ' + sector;
      var options = {title: main}; 

      // Instantiate and draw the chart.
      var chart = new google.visualization.ColumnChart(document.getElementById('graph'));
      chart.draw(data, options);
   }
   google.charts.setOnLoadCallback(drawChart);
</script>

</body>
</html>