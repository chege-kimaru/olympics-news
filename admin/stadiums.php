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
                <h1 class="page-header">Stadia</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Stadia</h4>
                        <button class="btn btn-success" onclick="openFormModal('add')"><i
                                    class="fa fa-plus"></i></button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="stadiumsTable">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="stadiumsTableBody">

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


<!-- Stadium Form Modal -->
<div class="modal fade" id="stadiumFormModal" tabindex="-1" role="dialog" aria-labelledby="stadiumFormModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="stadiumFormModalTitle">Add Stadium</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="stadiumForm">
                    <input id="idInput" name="id" class="form-control" type="hidden">
                    <div class="form-group">
                        <label>Name</label>
                        <input id="nameInput" name="name" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input id="locationInput" name="location" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input id="imageInput" name="image" class="form-control" type="file">
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php include_once '_scripts.php'; ?>

<script type="text/javascript">

    let selectedStadium = undefined;

    const stadiumTemplate = (stadium) => {
        return `
            <tr data-stadium="${encodeURIComponent(JSON.stringify((stadium)))}" onclick="setStadium(this)">
                <td><img style="width: 70px;" src="${BASE_DOMAIN + stadium.image}" alt="Stadium"></td>
                <td>${stadium.name}</td>
                <td>${stadium.location}</td>
                <td>
                    <button onclick="openFormModal('update')" class="btn btn-info"><i class="fa fa-pencil-square"></i></button>
                    <button onclick="deleteStadium('${stadium.id}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        `
    };

    const setStadiums = () => {
        $('#requestOverlay').show();
        axios.get('/stadium.php')
            .then(res => {
                $('#stadiumsTableBody').empty();
                res.data.forEach(stadium => {
                    $('#stadiumsTableBody').append(stadiumTemplate(stadium));
                });
                $('#requestOverlay').hide();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('Could not get stadia');
            });
    };

    const deleteStadium = (stadiumId) => {
        $('#requestOverlay').show();
        if (confirm('Are you sure you want to delete this stadium?')) {
            axios.delete(`/stadium.php?id=${stadiumId}`)
                .then(res => {
                    $('#requestOverlay').hide();
                    setStadiums();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('could not delete stadium');
                })
        }
    };

    const submitStadium = (data) => {
        $('#requestOverlay').show();
        axios.post(`/stadium.php`, data)
            .then(res => {
                $('#stadiumFormModal').modal('hide');
                $('#requestOverlay').hide();
                setStadiums();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('could not submit stadium details');
            })
    };

    const openFormModal = (type) => {
        if (type === 'add') {
            $('#idInput').val('');
            $('#nameInput').val('');
            $('#locationInput').val('');
            $('#stadiumFormModalTitle').text('Add Stadium');
        }
        $('#stadiumFormModal').modal('show');
    };

    const setStadium = (obj) => {
        selectedStadium = JSON.parse(decodeURIComponent($(obj).data('stadium')));
        $('#idInput').val(selectedStadium.id);
        $('#nameInput').val(selectedStadium.name);
        $('#locationInput').val(selectedStadium.location);
        $('#stadiumFormModalTitle').text('Edit Stadium details');
    };

    $(document).ready(function () {
        // requireAdmin();

        setStadiums();

        $('#stadiumForm').submit(e => {
            e.preventDefault();
            submitStadium(new FormData($('#stadiumForm')[0]));
        });
    });
</script>

</body>

</html>
