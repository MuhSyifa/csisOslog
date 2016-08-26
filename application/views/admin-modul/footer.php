
    <!-- start: Javascript -->
    <script src="<?php echo base_url('assets/js/jquery-2.1.4.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.ui.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/datatables/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatables/js/dataTables.bootstrap.js'); ?>"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>

    <!-- plugins -->
    <script src="<?php echo base_url('assets/js/plugins/moment.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/icheck.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/fullcalendar.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.nicescroll.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/summernote.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.vmap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/maps/jquery.vmap.world.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.vmap.sampledata.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/chart.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/raphael.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.knob.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/ion.rangeSlider.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.mask.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/select2.full.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/nouislider.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/tinymce/tinymce.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

    <script src="<?php echo base_url('assets/jquery-bootstrap-modal-steps.js'); ?>"></script>
    
    <!-- Custom -->
    <script>
      $('#stepModal').modalSteps();
    </script>

    <script>
      $(function () {
        $('#chartgps').highcharts({
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
          },
          title: {
            text: '<span class="fa fa-pie-chart"></span> Data GPS'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                style: {
                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
              }
            }
          },
          series: [{
            type: 'pie',
            name: 'Persentase Gps',
            data: [
                <?php 
                // data yang diambil dari database
                if(count($gps)>0)
                {
                   foreach ($gps as $v) {
                   echo "['" .$v->gps_type_name . "'," . $v->gps_type_qty ."],\n";
                   }
                }
                ?>
            ]
          }]
        });
      });
    </script>

    <!-- GPS Pie -->
    <script>
      $(function () {
        $('#chartgpspie').highcharts({
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
          },
          title: {
            text: '<span class="fa fa-pie-chart"></span> '
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                style: {
                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
              }
            }
          },
          series: [{
            type: 'pie',
            name: 'Persentase Gps',
            data: [
                <?php 
                // data yang diambil dari database
                if(count($gpsStock)>0)
                {
                   foreach ($gpsStock as $v) {
                   echo "['" .$v->gps_type_name ."<br>". $v->gps_cond_name ."<br>". $v->gps_stat_name . "<br>Quantity" ."', " . $v->gps_qty ."],\n";
                   }
                }
                ?>
            ]
          }]
        });
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#chartgpspieinstalled').highcharts({
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
          },
          title: {
            text: '<span class="fa fa-pie-chart"></span> '
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                style: {
                  color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
              }
            }
          },
          series: [{
            type: 'pie',
            name: 'Persentase Gps',
            data: [
                <?php 
                // data yang diambil dari database
                if(count($gpsInstalled)>0)
                {
                   foreach ($gpsInstalled as $v) {
                   echo "['" .$v->gps_type_name ."<br>". $v->gps_cond_name ."<br>". $v->gps_stat_name . "<br>Quantity" ."', " . $v->gps_qty ."],\n";
                   }
                }
                ?>
            ]
          }]
        });
      });
    </script>
    
    <!-- End -->
    
    <script>
      $(function() {
        $( ".datepicker" ).datepicker({
          dateFormat: "yy-mm-dd"
        });
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function(){

        $('.next').attr('disabled',true);
        $('.form-group input').keyup(function(){
            if($(this).val().length !=0)
                $('.next').attr('disabled', false);            
            else
                $('.next').attr('disabled',true);
        });

        $('#activateBtn').attr("disabled", true);
        $('#sendBtn').attr("disabled", true);
        $('.checkthis').click(function(){
          var countCheck = $('input.checkthis:checkbox:checked').length;  
          if(countCheck>0){
            $('#activateBtn').attr("disabled", false);
            $('#sendBtn').attr("disabled", false);
          }else{
            $('#activateBtn').attr("disabled", true);
            $('#sendBtn').attr("disabled", true);
          }
        });

        $('#checkAll').click(function(){
          var countCheck1 = $('input.checkthis:checkbox:checked').length;  
          if(countCheck1>0){
            $('#activateBtn').attr("disabled", true);
            $('#sendBtn').attr("disabled", true);
          }else{
            $('#activateBtn').attr("disabled", false);
            $('#sendBtn').attr("disabled", false);
          }
        });

        /*$("#edit").click(function(){
            id = $(this).attr('dep_id');
            $.ajax({
                url:'department/update/'+id,
                data:{send:true},
                success:function(data){
                    $("#editnama").val(data['nama']);
                    $("#editemail").val(data['email']);
                    $("#editkategori").val(data['kategori']);   
                }
            });
        });*/

        /*$(".dtype").change(function () {
            var val = $('.dtype:checked').val();
            alert(val);
        });*/
        
        $('#datatables-example').DataTable(/*{
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        className: 'green',
                        title: 'Data export Excel'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'red',
                        title: 'Data export PDF'
                    }
                ]
        }*/);
        $('.datatables').DataTable();

        $(function() {
          $('#checkAll').click(function() {
            $('.checkthis').prop('checked', this.checked);
          });
        });

        $(function() {
          $('.dtype').change(function() {
            $('.toHide').hide();
              if($(this).val() == '1') {$('#div1').show('500');}
              if($(this).val() == '2') {$('#div2').show('500');}
          });

          /*var rates = document.getElementById('.dtype').value;

          if (document.getElementById('#div1').checked) {
            rate_value = document.getElementById('#div1').value;
          }else if(document.getElementById('#div2').checked){
            rate_value = document.getElementById('#div2').value;
          }*/
        });

        tinymce.init({
              selector: 'textarea#emailText',
              height: 350,
              plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
              ],
              toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
              content_css: [
                '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                '//www.tinymce.com/css/codepen.min.css'
              ]
            });

      });
    </script>

    <script type="text/javascript">
      (function(jQuery){
        $('.summernote').summernote({
          height: 300
        });
      })(jQuery);
    </script>

    <script type="text/javascript">

      <?php if(isset($_POST['save_next'])) { ?> /* Your (php) way of checking that the form has been submitted */

        $(function() {                       // On DOM ready
          $('#stepModal').modal('show');     // Show the modal
        });

      <?php } ?>                                    /* /form has been submitted */

      
    </script>
    
  </body>
</html>