<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: index.php');
}
?>

<?php $title = 'Login'; ?>

<!DOCTYPE html>
<html lang="en">

<?php include_once '_head.php'; ?>

<body>

<div id="php"></div>

<div id="requestOverlay" class="request-overlay" style="display: none;"></div>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success" id="loginAlertSuccess" style="display: none">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a>
                        <p>Successfully Logged In</p>
                    </div>
                    <div class="alert alert-danger" id="loginAlertDanger" style="display: none">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a>
                        <p>Wrong Credentials. Please try again.</p>
                    </div>
                    <form role="form" id="loginForm">
                        <fieldset>
                            <div class="form-group">
                                <input id="email" class="form-control" placeholder="email" name="email" type="email"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input id="password" class="form-control" placeholder="Password" name="password"
                                       type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>

                            <p style="padding: 1rem">No Account? <a href="register.php">Register</a></p>
                        </fieldset>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '_scripts.php'; ?>

<script>
    $(document).ready(() => {
        $('#loginForm').submit(e => {
            e.preventDefault();
            $('#requestOverlay').show();
            axios.post(`/user.php?type=login`, new FormData($('#loginForm')[0]))
                .then(res => {
                    $('#requestOverlay').hide();
                    sessionStorage.setItem('user', JSON.stringify(res.data));
                    sessionStorage.setItem('jwt', res.data.jwt);
                    if(isAdmin()){
                        location.href = 'index.php';
                    } else {
                        location.href = '../index.php';
                    }
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    $('#loginAlertDanger').show();
                })
        });
    });
</script>

</body>

</html>
