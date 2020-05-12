<?php include_once '_session.php';
$title = 'Users'; ?>

<!DOCTYPE html>
<html lang="en">

<?php include_once '_head.php'; ?>

<body>
<script src="js/auth.js"></script>
<script>
    if (!isSuperAdmin()) location.href = 'login.php';
</script>

<div id="wrapper">

    <?php include_once '_nav.php'; ?>

    <div id="requestOverlay" class="request-overlay" style="display: none;"></div>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Users</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Users</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="usersTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th>Role</th>
                                <th>Actions</th>
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

    let selectedUser = undefined;

    const userTemplate = (user) => {
        let buttonTemplate = 'SUPER ADMIN';
        let role = 'USER';
        switch (+user.role) {
            case 3:
                role = 'SUPER ADMIN';
                break;
            case 2:
                role = 'ADMIN';
                buttonTemplate = `<button onclick="changeRole('${user.id}', 1)" class="btn btn-danger"><i class="fa fa-pencil"></i> Demote</button>`;
                break;
            case 1:
                role = 'USER';
                buttonTemplate = `<button onclick="changeRole('${user.id}', 2)" class="btn btn-success"><i class="fa fa-pencil"></i> Promote</button>`;
                break;
            default:

        }
        return `
            <tr data-user="${encodeURIComponent(JSON.stringify((user)))}">
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.location}</td>
                <td>${role}</td>
                <td>
                    ${buttonTemplate}
                </td>
            </tr>
        `
    };

    const setUsers = () => {
        $('#requestOverlay').show();
        axios.get('/user.php')
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
                alert('Could not get users');
            });
    };

    const changeRole = (userId, role) => {
        $('#requestOverlay').show();
        if (confirm('Are you sure you want to change this user\'s role?')) {
            const formData = new FormData();
            formData.append('id', userId);
            formData.append('role', role);
            axios.post(`user.php?type=change-role`, formData)
                .then(res => {
                    $('#requestOverlay').hide();
                    setUsers();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('could not change role');
                })
        }
    };

    $(document).ready(function () {
        setUsers();
    });
</script>

</body>

</html>
