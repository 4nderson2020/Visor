        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <div id="modalVideo" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" class="modal fade" >
        <div class="modal-dialog modal-lg" role ="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #00B5AC">
                    <span style="font-size: medium;color: white; font-weight: bold; ">VIDEO TUTORIALES</span>
                    <button type="button" data-dismiss="modal" data-backdrop="false" aria-label="Close" class="close cerrarModal"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="list-group" style="font-weight: bold;">
                                <a href="javascript:;" class="list-group-item" style="color: #00738D" onclick="reproducir('https://www.youtube.com/embed/cQGRvvlKYCM')">1. Capas de Información</a>
                                <a href="javascript:;" class="list-group-item" style="color: #00738D"onclick="reproducir('https://www.youtube.com/embed/oouq6v12CbU')">2. Fuentes de Información</a>
                                <a href="javascript:;" class="list-group-item" style="color: #00738D"onclick="reproducir('https://www.youtube.com/embed/C75ODCUZ5Ow')">3. Herramientas de Apoyo</a>
                                </div> 
                            </div>
                            <div class="col-md-8">
                                <div class="video-container">
                                    <iframe width="500" height="400" id="frame-video" src="https://www.youtube.com/embed/nFQRFgIGsLA" frameborder="0" allowfullscreen> </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- All Jquery -->    
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.js"></script>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- <script src="assets/js/popper.min.js"></script> -->
    <!-- <script src="assets/js/bootstrap.min.js"></script> -->    

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!--Custom JavaScript -->
    
    <script src="assets/js/custom.min.js"></script>
    <!-- Charts -->
    <script src="assets/js/bootbox.js"></script>    
    <script src="assets/js/leaflet-src.js"></script>
    <script src="assets/js/leaflet.draw-src.js"></script>
    <!-- <script src="assets/js/L.TileLayer.BetterWMS.js"></script> -->

    <script src="assets/js/leaflet-dvf.js"></script>
    <script src="assets/js/tile.stamen.js"></script>

    <!-- <script src="assets/js/leaflet.wms.js"></script> -->
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/perfect-scrollbar.jquery.min.js"></script>
    <!-- Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!-- Linea de Tiempo - Slide JS -->
    <script src="assets/plugins/jqueryui/jquery-ui.js"></script>
    <script src="assets/js/jquery-ui-slider-pips.js"></script>
    <script src="assets/js/jquery-ui-slider-pips.min.js"></script>
    <!-- Cargando -->
    <script src="assets/js/loadingoverlay.js"></script>
    <!-- Notificaciones -->
    <script src="assets/js/bootstrap-notify.min.js"></script>
    <!-- Full Screen -->
    <script src="assets/js/Leaflet.fullscreen.min.js"></script>
    <!-- Buscar -->
    <!-- <script src="assets/js/Leaflet.Search.js"></script> -->
    <!-- Centrar-->
    <script src="assets/js/bundle.js"></script>
    <script src="assets/js/easy-button.js"></script>
    <script src="assets/js/leaflet.markercluster.js"></script>
    <script src="assets/js/esri-leaflet.js" type="text/javascript"></script> 
    <script src="assets/js/leaflet.wms.js"></script>

    <script type="text/javascript">

    $( function() {
        $(document).on('show.bs.modal', '.modal', function(event) { 
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('in');
            }, 0);
        });
    });

    // $(".cerrarModal").click(function(){
    //   $("#modalVideo").modal('hide');
    // });



        // $(document).on('hidden.bs.modal', '.modal', function () {
        //     $('.modal:visible').length && $(document.body).addClass('in');
        // });

        // $('#modalVideo').modal('hide');
        // if ($('.modal-backdrop').is('.modal:visible')) {
        //   $$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).removeClass('show'); 
        //   $('.modal-backdrop').addClass('in'); 
        // };

        $( function() {
                $( "#slider" ).slider();
              } );

        $(function(){
          try{
            
            if(typeof preCarga != 'undefined'){
              preCarga();
            }
          }catch(err){
            console.log(err);
            }
        });

        function reproducir(url){
          var $iframe = $('#frame-video');
            if ( $iframe.length ) {
                $iframe.attr('src',url);   
                return false;
            }
          return true;
        }
        
    </script>

</body>

</html>