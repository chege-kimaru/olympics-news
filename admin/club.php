<?php include_once '_session.php';  $title = 'Players'; ?>

<!DOCTYPE html>
<html lang="en">

<?php include_once '_head.php'; ?>

<body>
<script src="js/auth.js"></script>

<div id="wrapper">

    <?php include_once '_nav.php'; ?>

    <div id="requestOverlay" class="request-overlay" style="display: none;"></div>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $_GET['club'] ?> Players</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Players</h4>
                        <button class="btn btn-success" onclick="openFormModal('add')"><i
                                    class="fa fa-plus"></i></button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Number</th>
                                <th>Position</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="playersTableBody">

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


<!-- Player Form Modal -->
<div class="modal fade" id="playerFormModal" tabindex="-1" role="dialog" aria-labelledby="playerFormModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="playerFormModalTitle">Add Player</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="playerForm">
                    <input id="idInput" name="id" class="form-control" type="hidden">
                    <input id="clubIdInput" name="club_id" class="form-control" type="hidden"
                           value="<?php echo $_GET['id'] ?>">
                    <div class="form-group">
                        <label>Name</label>
                        <input id="nameInput" name="name" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label>DOB</label>
                        <input id="dobInput" name="dob" class="form-control" type="date">
                    </div>
                    <div class="form-group">
                        <label>Number</label>
                        <input id="numberInput" name="player_number" class="form-control" type="number">
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <select name="position" id="positionInput" class="form-control">
                            <option value="Goalkeeper">Goalkeeper</option>
                            <option value="Left Center-Defender">Left Center-Defender</option>
                            <option value="Right Center-Defender">Right Center-Defender</option>
                            <option value="Right-Defender">Right-Defender</option>
                            <option value="Left-Defender">Left-Defender</option>
                            <option value="Left Center-Forward">Left Center-Forward</option>
                            <option value="Right Center-Forward">Right Center-Forward</option>
                            <option value="Left Forward">Left Forward</option>
                            <option value="Right Forward">Right Forward</option>
                            <option value="Center Forward">Center Forward</option>
                            <option value="Striker">Striker</option>
                        </select>
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

    let selectedPlayer = undefined;

    const playerTemplate = (player) => {
        return `
            <tr data-player="${encodeURIComponent(JSON.stringify((player)))}" onclick="setPlayer(this)">
                <td><img style="width: 70px;" src="${'http://localhost/DawsonsFC/' + player.image}" alt="player"></td>
                <td>${player.name}</td>
                <td>${player.dob}</td>
                <td>${player.player_number}</td>
                <td>${player.position}</td>
                <td>
                    <button onclick="openFormModal('update')" class="btn btn-info"><i class="fa fa-pencil-square"></i></button>
                    <button onclick="deletePlayer('${player.id}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        `
    };

    const setPlayers = () => {
        $('#requestOverlay').show();
        axios.get(`http://localhost/DawsonsFc/api/player.php?club_id=<?php echo $_GET['id'] ?>`)
            .then(res => {
                $('#playersTableBody').empty();
                res.data.forEach(player => {
                    $('#playersTableBody').append(playerTemplate(player));
                });
                $('#requestOverlay').hide();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('Could not get players');
            });
    };

    const deletePlayer = (playerId) => {
        $('#requestOverlay').show();
        if (confirm('Are you sure you want to delete this player?')) {
            axios.delete(`http://localhost/DawsonsFc/api/player.php?id=${playerId}`)
                .then(res => {
                    $('#requestOverlay').hide();
                    setPlayers();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('could not delete player');
                })
        }
    };

    const submitPlayer = (data) => {
        $('#requestOverlay').show();
        axios.post(`http://localhost/DawsonsFc/api/player.php`, data)
            .then(res => {
                $('#playerFormModal').modal('hide');
                $('#requestOverlay').hide();
                setPlayers();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('could not update player');
            })
    };

    const openFormModal = (type) => {
        if (type === 'add') {
            $('#idInput').val('');
            $('#nameInput').val('');
            $('#dobInput').val('');
            $('#numberInput').val('');
            $('#positionInput').val('');
            $('#playerFormModalTitle').text('Add Player');
        }
        $('#playerFormModal').modal('show');
    };

    const setPlayer = (obj) => {
        selectedPlayer = JSON.parse(decodeURIComponent($(obj).data('player')));
        $('#idInput').val(selectedPlayer.id);
        $('#nameInput').val(selectedPlayer.name);
        $('#dobInput').val(selectedPlayer.custom_dob);
        $('#numberInput').val(selectedPlayer.player_number);
        $('#positionInput').val(selectedPlayer.position);
        $('#playerFormModalTitle').text('Edit Player details');
    };

    $(document).ready(function () {
        // requireAdmin();

        setPlayers();

        $('#playerForm').submit(e => {
            e.preventDefault();
            submitPlayer(new FormData($('#playerForm')[0]));
        });
    });
</script>

</body>

</html>
