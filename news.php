<?php $active = 'news'; ?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Results</title>
    <?php include_once '_head.php' ?>
    <style>

    </style>
</head>

<body>
<?php include_once '_header.php' ?>

<!-- Blog Section Begin -->
<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 left-blog-pad">
                <div id="general1">

                </div>
                <div class="blog-items" id="generals">

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="blog-sidebar">
                    <div class="bs-categories">
                        <div class="section-title sidebar-title">
                            <h5>Games</h5>
                        </div>
                        <ul id="games">

                        </ul>
                    </div>
                    <div class="bs-recent">
                        <div class="section-title sidebar-title">
                            <h5>Upcoming games</h5>
                        </div>
                        <div id="schedules">

                        </div>
                    </div>
                    <div class="bs-recent">
                        <div class="section-title sidebar-title">
                            <h5>Recent results</h5>
                        </div>
                        <div id="results">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->


<?php include_once '_footer.php' ?>

<?php include_once '_scripts.php' ?>

<script>

    const general1 = (news) => {
        return `
            <div class="large-blog set-bg" data-setbg="${BASE_DOMAIN + news.image}">
                <div class="bi-tag">${news.game_name}</div>
                <div class="bi-text">
                    <h3><a href="news-details.php?news-id=${news.id}">${news.title}</a></h3>
                    <ul>
                        <li><i class="fa fa-calendar"></i> ${news.event_date}</li>
                    </ul>
                </div>
            </div>
        `;
    };

    const schedule = (news) => {
        return `
            <div class="news-item">
                <div class="ni-pic">
                    <img src="${BASE_DOMAIN + news.image}" alt="">
                </div>
                <div class="ni-text">
                    <h5><a href="news-details.php?news-id=${news.id}">${news.title}</a></h5>
                    <ul>
                        <li><i class="fa fa-calendar"></i> ${news.event_date}</li>
                    </ul>
                </div>
            </div>
        `;
    };

    const general = (news) => {
        return `
            <div class="single-item">
                <div class="bi-pic">
                    <img style="width: 340px; height: 240px;" src="${BASE_DOMAIN + news.image}" alt="">
                </div>
                <div class="bi-text">
                    <h4><a href="news-details.php?news-id=${news.id}">${news.title}</a></h4>
                    <ul>
                        <li><i class="fa fa-calendar"></i> ${news.event_date}</li>
                    </ul>
                    <p>${String(news.about).substr(0, 200) + '......'}</p>
                </div>
            </div>
        `;
    };

    const game = (g) => {
        return `<li><a href="#">${g.name}</a></li>`;
    };

    const getGeneral = () => {
        axios.get('news.php?type=general')
            .then(res => {
                if (res.data.length > 0) {
                    $('#general1').empty().append(general1(res.data[0]));
                }

                $('#generals').empty();
                res.data.forEach(news => {
                    $('#generals').append(general(news));
                });

                $('.set-bg').each(function () {
                    var bg = $(this).data('setbg');
                    $(this).css('background-image', 'url(' + bg + ')');
                });

                $(".loader").fadeOut();
                $("#preloder").delay(200).fadeOut("slow");
            })
            .catch(e => {
                $(".loader").fadeOut();
                $("#preloder").delay(200).fadeOut("slow");
                console.error(e);
                alert('Could not get results');
            });
    };

    const getGames = () => {
        axios.get('game.php')
            .then(res => {
                $('#games').empty();
                res.data.forEach(g => {
                    $('#games').append(game(g));
                });
            })
            .catch(e => {
                console.error(e);
                alert('Could not get games');
            });
    };

    const getScheduled = () => {
        axios.get('news.php?type=schedule')
            .then(res => {
                $('#schedules').empty();
                res.data.forEach(news => {
                    $('#schedules').append(schedule(news));
                });
            })
            .catch(e => {
                console.error(e);
                alert('Could not get scheduled games');
            });
    };

    const getResults = () => {
        axios.get('news.php?type=result')
            .then(res => {
                $('#results').empty();
                res.data.forEach(news => {
                    $('#results').append(schedule(news));
                });
            })
            .catch(e => {
                console.error(e);
                alert('Could not get results');
            });
    };

    $(document).ready(() => {
        getGeneral();
        getScheduled();
        getGames();
        getResults();
    });
</script>

</body>

</html>