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

  <!-- Data Table JavaScript -->
    <!--<script src="<?=base_url()?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
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
    <script src="<?=base_url()?>dist/js/dataTables-data.js"></script>-->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>


	<script>
     $(document).ready(function() {

        $('#sector').change(function() {
            var sectorid = $('#sector').val();

            if (sectorid != '') {
                $.ajax({
                  url:"<?php echo base_url(); ?>customersetup/fetchactivestreet",
                  method:"POST",
                  data:{sectorid:sectorid},
                  success:function(data)
                  {
                    $('#street').html(data);
                  }
                });
            }
        });

     });
    </script>
    <script>
      function mySector() {
        var e = document.getElementById("sector");
        var sectorid = e.options[e.selectedIndex].value;
        if (sectorid =='')
        {
          document.getElementById('street').readOnly = true;
          document.getElementById("street").value = '';
        }
        else {
          document.getElementById('street').readOnly = false;
        }
      }
    </script>
    <script>
      function myAgent() {
        var e = document.getElementById("agent");
        var agentid = e.options[e.selectedIndex].value;
        if (agentid =='')
        {
          document.getElementById('sector').readOnly = true;
          document.getElementById("sector").value = '';
        }
        else {
          document.getElementById('sector').readOnly = false;
        }
      }
    </script>
    <script>
      function housesector() {
        var e = document.getElementById("sector");
        var sectorid = e.options[e.selectedIndex].value;
        if (sectorid =='')
        {
          document.getElementById('street').disabled = true;
          document.getElementById('houseno').readOnly = true;
          document.getElementById("street").value = '';
          document.getElementById("houseno").value = '';
        }
        else {
          document.getElementById('street').disabled = false;
        }
      }
    </script>
    <script>
      function housestreet() {
        var e = document.getElementById("street");
        var streetid = e.options[e.selectedIndex].value;
        if (streetid =='')
        {
          document.getElementById('houseno').readOnly = true;
          document.getElementById("houseno").value = '';
        }
        else {
          document.getElementById('houseno').readOnly = false;
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
      function category() {
        var e = document.getElementById("catname");
        var catid = e.options[e.selectedIndex].value;
        if (catid =='')
        {
          document.getElementById('asset').readOnly = true;
          document.getElementById("asset").value = '';
        }
        else {
          document.getElementById('asset').readOnly = false;
        }
      }
    </script>
    <script>
      function myasset() {
        var e = document.getElementById("asset");
        var assetid = e.options[e.selectedIndex].value;
        if (assetid =='' || assetid =='Others')
        {
          document.getElementById('misc').readOnly = false;
        }
        else {
          document.getElementById('misc').readOnly = true;
          document.getElementById("misc").value = '';
        }
      }
    </script>
    <!-- datatable script -->
    <script>
     $(document).ready(function() {
          $('#data').DataTable( {
              dom: 'Bfrtip',
             
                "buttons": [ 'pdf',
            {
                extend: 'print',
               
                exportOptions: {
                    columns: ':visible',
                    stripHtml: false,
                },
               
                
            },
        ],
          } );
      } );
  </script>
    <!--<script type="text/javascript">
  
    $(document).ready(function(){
        $(document).ready(function() {
            $('#data-table').DataTable({
                dom: 'Bfrtip',
               "buttons": [ 'copy', 'excel', 'pdf',
        {
            extend: 'print',
            title: 'Exam Result',
            exportOptions: {
                columns: ':visible',
                stripHtml: false,
            },
            text: '<i class="fa fa-print"></i> Print Report',
            customize: function (win) {
                $(win.document.body)
                    .css('font-size', '10pt')
                    .prepend(
                        '<img src="<?php //echo base_url().'images/logo1.png' ?>" style="position:absolute; top:0; left:0;" />'
                    );

                $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
            }
        },
    ],
                "order": [[ 3, 'asc' ], [ 4, 'asc' ],[0, 'asc']]
            } );
        } );
    
    })
  </script>-->
    <!--<script>
      $(document).ready(function() {
          $('#datable_1').DataTable();
          $("[data-toggle=tooltip]").tooltip();
      } );
    </script>-->

    <!-- modal confirmation -->
    <script>
      $('#confirm').on('show.bs.modal', function(e) {
          var id = $(e.relatedTarget).data('id');
          $(e.currentTarget).find('input[name="id"]').val(id);
      });
    </script>
</body>

</html>