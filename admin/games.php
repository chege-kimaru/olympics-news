<?php include_once '_session.php'; $title = 'Games'; ?>

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
                <h1 class="page-header">Games</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Games</h4>
                        <button class="btn btn-success" onclick="openFormModal('add')"><i
                                    class="fa fa-plus"></i></button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="gamesTable">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="gamesTableBody">

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


<!-- Game Form Modal -->
<div class="modal fade" id="gameFormModal" tabindex="-1" role="dialog" aria-labelledby="gameFormModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="gameFormModalTitle">Add Game</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="gameForm">
                    <input id="idInput" name="id" class="form-control" type="hidden">
                    <div class="form-group">
                        <label>Name</label>
                        <input id="nameInput" name="name" class="form-control" type="text">
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

    let selectedGame = undefined;

    const gameTemplate = (game) => `
        <tr data-game="${encodeURIComponent(JSON.stringify((game)))}" onclick="setGame(this)">
            <td><img style="width: 70px;" src="${BASE_DOMAIN + game.image}" alt="Game"></td>
            <td>${game.name}</td>
            <td>
                <button onclick="openFormModal('update')" class="btn btn-info"><i class="fa fa-pencil-square"></i></button>
                <button onclick="deleteGame('${game.id}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
    `;

    const setGames = () => {
        $('#requestOverlay').show();
        axios.get('/game.php')
            .then(res => {
                $('#gamesTableBody').empty();
                res.data.forEach(game => {
                    $('#gamesTableBody').append(gameTemplate(game));
                });
                $('#requestOverlay').hide();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('Could not get games');
            });
    };

    const submitGame = (data) => {
        $('#requestOverlay').show();
        axios.post('/game.php', data)
            .then(res => {
                $('#gameFormModal').modal('hide');
                $('#requestOverlay').hide();
                setGames();
            })
            .catch(e => {
                $('#gameFormModal').modal('hide');
                $('#requestOverlay').hide();
                console.error(e);
                alert('could not submit game details');
            })
    };

    const deleteGame = (gameId) => {
        $('#requestOverlay').show();
        if (confirm('Are you sure you want to delete this game?')) {
            axios.delete(`game.php?id=${gameId}`)
                .then(res => {
                    $('#requestOverlay').hide();
                    setGames();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('could not delete game');
                })
        }
    };

    const openFormModal = (type) => {
        if (type === 'add') {
            $('#idInput').val('');
            $('#nameInput').val('');
            $('#gameFormModalTitle').text('Add Game');
        }
        $('#gameFormModal').modal('show');
    };

    const setGame = (obj) => {
        selectedGame = JSON.parse(decodeURIComponent($(obj).data('game')));
        $('#idInput').val(selectedGame.id);
        $('#nameInput').val(selectedGame.name);
        $('#gameFormModalTitle').text('Edit Game Details');
    };

    $(document).ready(function () {
        // requireAdmin();

        setGames();

        $('#gameForm').submit(e => {
            e.preventDefault();
            submitGame(new FormData($('#gameForm')[0]));
        });
    });
</script>

</body>

</html>
