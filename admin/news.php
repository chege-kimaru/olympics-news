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
                <h1 class="page-header">News</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>News</h4>
                        <a href="news-form.php"><button class="btn btn-success"><i
                                    class="fa fa-plus"></i></button></a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="newsTable">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Game</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="newsTableBody">

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

    const newsTemplate = (news) => {
        return `
            <tr data-stadium="${encodeURIComponent(JSON.stringify((news)))}" onclick="setStadium(this)">
                <td><img style="width: 70px;" src="${BASE_DOMAIN + news.image}" alt="News"></td>
                <td><img style="width: 70px;" src="${BASE_DOMAIN + news.game_image}" alt="News"> ${news.game_name}</td>
                <td>${news.title}</td>
                <td>${news.event_date}</td>
                <td>${news.type}</td>
                <td>
                    <a href="news-form.php?news-id=${news.id}"><button class="btn btn-info"><i class="fa fa-pencil-square"></i></button></a>
                    <button onclick="deleteNews('${news.id}')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        `
    };

    const setNews = () => {
        $('#requestOverlay').show();
        axios.get('/news.php')
            .then(res => {
                $('#newsTableBody').empty();
                res.data.forEach(news => {
                    $('#newsTableBody').append(newsTemplate(news));
                });
                $('#requestOverlay').hide();
            })
            .catch(e => {
                $('#requestOverlay').hide();
                console.error(e);
                alert('Could not get news');
            });
    };

    const deleteNews = (newsId) => {
        $('#requestOverlay').show();
        if (confirm('Are you sure you want to delete this news?')) {
            axios.delete(`/news.php?id=${newsId}`)
                .then(res => {
                    $('#requestOverlay').hide();
                    setNews();
                })
                .catch(e => {
                    $('#requestOverlay').hide();
                    console.error(e);
                    alert('could not delete news');
                })
        }
    };

    $(document).ready(function () {

        setNews();
    });
</script>

</body>

</html>
