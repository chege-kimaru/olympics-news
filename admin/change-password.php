<?php include_once '_session.php'; $title = 'Change Password'; ?>

<!DOCTYPE html>
<html lang="en">

<?php include_once '_head.php';?>

<body>
<script src="js/auth.js"></script>
<script>
    if (!isUser()) location.href = 'login.php';
</script>

<div id="wrapper">

    <?php include_once '_nav.php';?>

    <div id="requestOverlay" class="request-overlay" style="display: none;"></div>

    <div id="page-wrapper">
        <br><br>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Change Password
                        </h4>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="changePasswordForm">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input id="currentPasswordInputField" class="form-control" type="password"
                                       name="password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input id="newPasswordInputField" class="form-control" type="password"
                                       name="newPassword">
                            </div>

                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<?php include_once '_scripts.php';?>

<script>
    $(document).ready(() => {
        $('#changePasswordForm').submit(e => {
            e.preventDefault();
            $('#requestOverlay').show();
            axios.post(`/user.php?type=change-password`, new FormData($('#changePasswordForm')[0]))
                .then(res => {
                    $('#requestOverlay').hide();
                    alert('Password has been changed successfully');
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('Could not change password');
                })
        });
    });
</script>

</body>

</html>
