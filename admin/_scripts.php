<script src="vendor/jquery/jquery.cookie.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>

<!-- DataTables JavaScript -->
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script src="js/axios.min.js"></script>

<script src="js/auth.js"></script>

<script>
    const BASE_DOMAIN = 'http://localhost/dawson-olympics/';
    const BASE_URL = BASE_DOMAIN + 'api';
    axios.defaults.baseURL = BASE_URL;
    axios.defaults.headers.common['Authorization'] = getJwt();
</script>