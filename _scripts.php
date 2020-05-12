<!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<script src="js/axios.min.js"></script>
<script>
    const BASE_DOMAIN = 'http://localhost/dawson-olympics/';
    const BASE_URL = BASE_DOMAIN + 'api';
    axios.defaults.baseURL = BASE_URL;
    axios.defaults.headers.common['Authorization'] = getJwt();
</script>