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
                <h1 class="page-header">News Form</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 id="formTitle">Add News</h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="images">

                        </div>
                        <form role="form" id="newsForm">
                            <input id="idInput" name="id" class="form-control" type="hidden">
                            <div class="form-group">
                                <label>Title</label>
                                <input id="titleInput" name="title" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>Game</label>
                                <select id="gameInput" name="game_id" class="form-control" type="text">

                                </select>
                            </div>

                            <p><strong>News Details</strong></p>
                            <div style="margin-bottom: 1rem;" id="editor"></div>

                            <div class="form-group">
                                <label>Caption Image</label>
                                <input required id="imageInput" name="image" class="form-control" type="file">
                            </div>
                            <div class="form-group">
                                <label>Other Images</label>
                                <input required id="imagesInput" name="images[]" class="form-control" type="file" multiple>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select id="typeInput" name="type" class="form-control" type="text">
                                    <option value="general" selected>General</option>
                                    <option value="result">Result</option>
                                    <option value="schedule">Schedule</option>
                                </select>
                            </div>
                            <p style="padding: 10px"><strong>If this is a schedule or results news, please fill the following
                                    fields</strong></p>
                            <div class="form-group">
                                <label>Stadium</label>
                                <select id="stadiumInput" name="stadium_id" class="form-control" type="text">

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Event Date</label>
                                <input id="eventDateInput" name="event_date" class="form-control" type="datetime-local">
                            </div>

                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
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
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script type="text/javascript">

    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    const submitNews = (data) => {
        data.append('about', quill.root.innerHTML);
        $('#requestOverlay').show();
        axios.post(`/news.php`, data)
            .then(res => {
                $('#requestOverlay').hide();
                location.href='news.php';
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('could not submit news details');
            })
    };

    const setNews = () => {
        const id = "<?php echo $_GET['news-id'] ?>";
        if(id) {
            $('#requestOverlay').show();
            axios.get('news.php?news-id=' + id)
                .then(res => {
                    $('#formTitle').text('Edit News');

                    $('#idInput').val(res.data.id);
                    $('#titleInput').val(res.data.title);
                    $('#gameInput').val(res.data.game_id);
                    $('#typeInput').val(res.data.type);
                    $('#stadiumInput').val(res.data.stadium_id);
                    $('#eventDateInput').val(res.data.custom_event_date);
                    quill.root.innerHTML = res.data.about;

                    $('#images').empty();
                    for(let image of res.data.images) {
                        $('#images').append(`
                            <div style="padding: 5px; display: inline-block">
                                <img style="width: 100px; height: 100px;" src="${BASE_DOMAIN + image.image}">
                                 <br>
                                <span style="cursor: pointer" onclick="deleteImage('${image.id}')">delete</span>
                            </div>
                        `);
                    }
                    $('#requestOverlay').hide();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('Could not get news');
                });
        }
    };

    const deleteImage = (imageId) => {
        $('#requestOverlay').show();
        if (confirm('Are you sure you want to delete this image?')) {
            axios.post(`/news.php?type=deleteImage&imageId=${imageId}`)
                .then(res => {
                    $('#requestOverlay').hide();
                    setNews();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('could not delete image');
                })
        }
    };

    const setStadiums = () => {
        axios.get('stadium.php')
            .then(res => {
                $('#stadiumInput').empty().append(`
                        <option value="">General</option>
                    `);
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
                $('#gameInput').empty().append(`
                        <option value="">General</option>
                    `);
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

    $(document).ready(function () {

        setStadiums();
        setGames();
        setNews();

        $('#newsForm').submit(e => {
            e.preventDefault();
            submitNews(new FormData($('#newsForm')[0]));
        });
    });
</script>

</body>

</html>
