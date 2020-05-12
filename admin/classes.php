<?php $title = 'Classes'; ?>

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
                <h1 class="page-header">Classes</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Classes</h4>
                        <button class="btn btn-success" onclick="openFormModal('add')"><i
                                    class="fa fa-plus"></i></button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="classesTable">
                            <thead>
                            <tr>
                                <th>Game</th>
                                <th>Stadium</th>
                                <th>Location</th>
                                <th>Title</th>
                                <th>About</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Members</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="classesTableBody">

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


<!-- Class Form Modal -->
<div class="modal fade" id="classFormModal" tabindex="-1" role="dialog" aria-labelledby="classFormModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="classFormModalTitle">Add Class</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="classForm">
                    <input id="idInput" name="id" class="form-control" type="hidden">
                    <div class="form-group">
                        <label>Game</label>
                        <select id="gameInput" name="game_id" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stadium</label>
                        <select id="stadiumInput" name="stadium_id" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input id="locationInput" name="location" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input id="titleInput" name="title" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label>About</label>
                        <textarea id="aboutInput" name="about" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <input id="fromInput" name="from" class="form-control" type="date">
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input id="toInput" name="to" class="form-control" type="date">
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

    let selectedClass = undefined;

    const classTemplate = (mclass) => `
        <tr data-mclass="${encodeURIComponent(JSON.stringify((mclass)))}" onclick="setClass(this)">
            <td><img style="width: 70px;" src="${BASE_DOMAIN + mclass.game_image}" alt="Game"> ${mclass.game_name}</td>
            <td><img style="width: 70px;" src="${BASE_DOMAIN + mclass.stadium_image}" alt="Stadium"> ${mclass.stadium_name}</td>
            <td>${mclass.location}</td>
            <td>${mclass.title}</td>
            <td>${mclass.about}</td>
            <td>${mclass.mfrom}</td>
            <td>${mclass.mto}</td>
            <td><a href="class-members.php?class-id=${mclass.id}">view</a></td>
            <td>
                <button onclick="openFormModal('update')" class="btn btn-info"><i class="fa fa-pencil-square"></i></button>
                <button onclick="deleteClass('${mclass.id}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
    `;

    const setClasses = () => {
        $('#requestOverlay').show();
        axios.get('/mclass.php')
            .then(res => {
                $('#classesTableBody').empty();
                res.data.forEach(mclass => {
                    $('#classesTableBody').append(classTemplate(mclass));
                });
                $('#requestOverlay').hide();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('Could not get classes');
            });
    };

    const setStadiums = () => {
        axios.get('stadium.php')
            .then(res => {
                $('#stadiumInput').empty();
                res.data.forEach(stadium => {
                    $('#stadiumInput').append(`
                        <option value="${stadium.id}">${stadium.name}</option>
                    `);
                });
            })
            .catch(e => {
                console.error(e);
                alert('Could not get stadia');
            });
    };

    const setGames = () => {
        axios.get('game.php')
            .then(res => {
                $('#gameInput').empty();
                res.data.forEach(game => {
                    $('#gameInput').append(`
                        <option value="${game.id}">${game.name}</option>
                    `);
                });
            })
            .catch(e => {
                console.error(e);
                alert('Could not get games');
            });
    };

    const submitClass = (data) => {
        $('#requestOverlay').show();
        axios.post('/mclass.php', data)
            .then(res => {
                $('#classFormModal').modal('hide');
                $('#requestOverlay').hide();
                setClasses();
            })
            .catch(e => {
                $('#classFormModal').modal('hide');
                $('#requestOverlay').hide();
                console.error(e);
                alert('could not submit class details');
            })
    };

    const deleteClass = (classId) => {
        $('#requestOverlay').show();
        if (confirm('Are you sure you want to delete this class?')) {
            axios.delete(`/mclass.php?id=${classId}`)
                .then(res => {
                    $('#requestOverlay').hide();
                    setClasses();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('could not delete class');
                })
        }
    };

    const openFormModal = (type) => {
        if (type === 'add') {
            $('#idInput').val('');
            $('#gameInput').val('');
            $('#stadiumInput').val('');
            $('#locationInput').val('');
            $('#titleInput').val('');
            $('#aboutInput').text('');
            $('#fromInput').val('');
            $('#toInput').val('');
            $('#classFormModalTitle').text('Add Class');
        }
        $('#classFormModal').modal('show');
    };

    const setClass = (obj) => {
        selectedClass = JSON.parse(decodeURIComponent($(obj).data('mclass')));
        $('#idInput').val(selectedClass.id);
        $('#gameInput').val(selectedClass.game_id);
        $('#stadiumInput').val(selectedClass.stadium_id);
        $('#locationInput').val(selectedClass.location);
        $('#titleInput').val(selectedClass.title);
        $('#aboutInput').text(selectedClass.about);
        $('#fromInput').val(selectedClass.custom_from);
        $('#toInput').val(selectedClass.custom_to);
        $('#classFormModalTitle').text('Edit Class Details');
    };

    $(document).ready(function () {
        setClasses();
        setStadiums();
        setGames();

        $('#classForm').submit(e => {
            e.preventDefault();
            submitClass(new FormData($('#classForm')[0]));
        });
    });
</script>

</body>

</html>
