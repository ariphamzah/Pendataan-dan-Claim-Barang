<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/sweetalert/dist/sweetalert.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/web_admin/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url() ?>assets/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>assets/web_admin/dist/js/demo.js"></script>

<!-- page script -->
<script>
  jQuery(document).ready(function($){
      $('.btn-delete').on('click',function(){
          var getLink = $(this).attr('href');
          swal({
                  title: 'Delete Data',
                  text: 'Yakin Ingin Menghapus Data ?',
                  html: true,
                  confirmButtonColor: '#d9534f',
                  showCancelButton: true,
                  },function(){
                  window.location.href = getLink
              });
          return false;
      });
  });

  $(function () {
    $('#example1').DataTable();
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  });
</script>

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Stock Op Name</b>
  </div>
  <strong>Copyright &copy; <?= date('Y') ?></strong>
</footer>

</body>

</html>