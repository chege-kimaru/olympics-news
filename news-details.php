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

<!-- Blog Details Hero Section Begin -->
<section id="image" class="blog-hero-section set-bg" data-setbg="img/blog/details/details-hero.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bh-text">
                    <h2 id="title"></h2>
                    <ul>
                        <li><i class="fa fa-calendar"></i> <span id="eventDate"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Hero Section End -->

<!-- Blog Details Section Begin -->
<section class="blog-details-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 left-blog-pad">
                <div class="bd-text">
                    <div class="bd-title" id="about1">

                    </div>
                    <div class="bd-pic">
                        <div class="row">
                            <div class="col-md-4">
                                <img style="display: none" id="image1" src="img/blog/details/details-1.jpg" alt="">
                            </div>
                            <div class="col-md-8">
                                <img style="display: none" id="image2" src="img/blog/details/details-2.jpg" alt="">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <img style="display: none" id="image3" src="img/blog/details/details-3.jpg"
                                             alt="">
                                    </div>
                                    <div class="col-sm-6">
                                        <img style="display: none" id="image4" src="img/blog/details/details-4.jpg"
                                             alt="">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row" id="images">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bd-more-title" id="about2">

                    </div>
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
<!-- Blog Details Section End -->


<?php include_once '_footer.php' ?>

<?php include_once '_scripts.php' ?>

<script>
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

    const game = (g) => {
        return `<li><a href="#">${g.name}</a></li>`;
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

    const getSingleNews = () => {
        axios.get('news.php?news-id=<?php echo $_GET['news-id']; ?>')
            .then(res => {
                $('#image').data('setbg', BASE_DOMAIN + res.data.image);
                $('#title').text(res.data.title);
                $('#eventDate').text(res.data.event_date);
                const about = String(res.data.about);
                $('#about1').text(about.substr(0, 400));
                $('#about2').text(about.substr(400));

                if (res.data.images && res.data.images.length > 0) {
                    if (res.data.images[0]) {
                        $('#image1').show().attr('src', BASE_DOMAIN + res.data.images[0].image);
                    }
                    if (res.data.images[1]) {
                        $('#image2').show().attr('src', BASE_DOMAIN + res.data.images[1].image);
                    }
                    if (res.data.images[2]) {
                        $('#image3').show().attr('src', BASE_DOMAIN + res.data.images[2].image);
                    }
                    if (res.data.images[3]) {
                        $('#image4').show().attr('src', BASE_DOMAIN + res.data.images[3].image);
                    }
                    if (res.data.images.length > 4) {
                        $('#images').empty();
                        for (let i = 4; i < res.data.images.length; i++) {
                            $('#images').append(`
                                <div class="col-md-4">
                                    <img src="${BASE_DOMAIN + res.data.images[3].image}">
                                </div>
                            `);
                        }
                    }
                }

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

    $(document).ready(() => {
        getSingleNews();
        getScheduled();
        getGames();
        getResults();
    });
</script>

</body>

</html>