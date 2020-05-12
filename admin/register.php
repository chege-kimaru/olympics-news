<?php $title = 'Register'; ?>

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
                    <h3 class="panel-title">Sign Up</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success" id="loginAlertSuccess" style="display: none">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a>
                        <p>Successfully Signed up. Please login to continue.</p>
                    </div>
                    <div class="alert alert-danger" id="loginAlertDanger" style="display: none">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a>
                        <p>Could not sign you up, please try again.</p>
                    </div>
                    <form role="form" id="loginForm">
                        <fieldset>
                            <div class="form-group">
                                <input id="name" class="form-control" placeholder="name" name="name" type="text"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input id="email" class="form-control" placeholder="Email" name="email" type="email"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input id="location" class="form-control" placeholder="location" name="location" type="text"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input id="phone" class="form-control" placeholder="phone" name="phone" type="text"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input id="password" class="form-control" placeholder="Password" name="password"
                                       type="password" value="">
                            </div>
                            <div class="form-group">
                                <input id="r-password" class="form-control" placeholder="Password" name="r-password"
                                       type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-success btn-block">Sign Up</button>

                            <p style="padding: 1rem">Have an account? <a href="login.php">Login</a></p>
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
            if($('#password').val() !== $('#r-password').val()) {
                alert('Passwords do not match');
                return;
            }
            $('#requestOverlay').show();
            axios.post(`/user.php?type=register`, new FormData($('#loginForm')[0]))
                .then(res => {
                    $('#requestOverlay').hide();
                    $('#loginAlertSuccess').show();
                    setTimeout(() => location.href = 'login.php', 2000)
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
