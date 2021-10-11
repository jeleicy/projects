    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="{{ URL::route('logOut') }}">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('js/functions.js') }}"></script>
	
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ URL::asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Page level plugin JavaScript-->
    <script src="{{ URL::asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ URL::asset('js/sb-admin.min.js') }}"></script>
    <!-- Custom scripts for this page-->
    <script src="{{ URL::asset('js/sb-admin-datatables.min.js') }}"></script>
    <!--<script src="{{ URL::asset('js/sb-admin-charts.min.js') }}"></script>-->
	
	<script type="text/javascript" src="{{ URL::asset('js/moment.min.js') }}"></script>
		
	    
  	<!--******************END DASHBOARD*****************************-->

  </div>
	@if (strpos(URL::current(),"editUsers") !== false)
		<script>viewRoleEmp(idCondominium,'../', idRole, idEmployee);</script>
	@elseif (strpos(URL::current(),"formUsers") !== false)
		<script>viewRoleEmp(idCondominium,'', idRole, idEmployee);</script>
	@endif
	
	<!----------------------->
	
	@if (strpos(URL::current(),"editActivitieEmployee") !== false)
		<script>viewBuilding(idCondominium, idBuilding,'../');</script>
	@elseif (strpos(URL::current(),"formActivitieEmployee") !== false)
		<script>viewBuilding(idCondominium, idBuilding,'');</script>
	@endif
  
</body>
</html>