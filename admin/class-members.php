<?php $title = 'Class Members'; ?>

<!DOCTYPE html>
<html lang="en">

<?php include_once '_head.php'; ?>

<body>
<script src="js/auth.js"></script>
<script>
    if (!isAdmin()) location.href = 'login.php';
</script>

<div id="wrapper">

    <?php include_once '_nav.php'; ?>

    <div id="requestOverlay" class="request-overlay" style="display: none;"></div>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Class Members</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Class Members</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="usersTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Location</th>
                            </tr>
                            </thead>
                            <tbody id="usersTableBody">

                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<?php include_once '_scripts.php'; ?>

<script type="text/javascript">


    const userTemplate = (user) => {
        return `
            <tr data-user="${encodeURIComponent(JSON.stringify((user)))}">
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.location}</td>
            </tr>
        `
    };

    const setUsers = () => {
        $('#requestOverlay').show();
        axios.get("mclass.php?type=members&&class-id=<?php echo $_GET['class-id'] ?>")
            .then(res => {
                $('#usersTableBody').empty();
                res.data.forEach(user => {
                    $('#usersTableBody').append(userTemplate(user));
                });
                $('#requestOverlay').hide();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('Could not get members');
            });
    };

    $(document).ready(function () {
        setUsers();
    });
</script>

</body>

</html>
