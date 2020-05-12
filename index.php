<?php $active = 'home'; ?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Home</title>
    <?php include_once '_head.php' ?>
    <style>
        .hero-section {
            height: 400px;
        }

        .latest-section {
            margin-top: 4rem;
        }
    </style>
</head>

<body>
<?php include_once '_header.php' ?>

<!-- Hero Section Begin -->
<section class="hero-section set-bg" data-setbg="img/hero/hero-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hs-item">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hs-text" id="comingUp">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Soccer Section Begin -->
<section class="soccer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="section-title">
                    <h3>Latest <span>Results</span></h3>
                </div>
            </div>
        </div>
        <div class="row" id="results">

        </div>
    </div>
</section>
<!-- Soccer Section End -->

<!-- Latest Section Begin -->
<section class="latest-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title latest-title">
                    <h3>Upcoming <span>Games</span></h3>
                    <ul>
                        <li>More</li>
                    </ul>
                </div>
                <div class="row">
                    <div id="schedule1" class="col-md-6">

                    </div>
                    <div class="col-md-6" id="schedules">

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="section-title">
                    <h3>Info <span>Section</span></h3>
                </div>
                <div class="vote-option set-bg" data-setbg="img/news/vote-bg.jpg">
                    <div class="vo-text" style="padding-right: 10px;">
                        <h5>
                            Did you know you can register for classes on this platform? Click <a
                                    href="classes.php">here</a> to get started
                        </h5>
                        <h5>
                            Hit us up on this email, to suggest any possible improvements you want on the site. Cheers✨
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Section End -->

<!-- Popular News Section Begin -->
<section class="popular-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title">
                    <h3>General <span>News</span></h3>
                </div>
                <div class="row">
                    <div class="col-md-6" id="general1">

                    </div>
                    <div class="col-md-6" id="general2">

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="section-title">
                    <h3>Info <span>Section</span></h3>
                </div>
                <div class="vote-option set-bg" data-setbg="img/news/vote-bg.jpg">
                    <div class="vo-text" style="padding-right: 10px;">
                        <h5>
                            Did you know you can register for classes on this platform? Click <a
                                    href="classes.php">here</a> to get started
                        </h5>
                        <h5>
                            Hit us up on this email, to suggest any possible improvements you want on the site. Cheers✨
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Popular News Section End -->


<?php include_once '_footer.php' ?>

<?php include_once '_scripts.php' ?>

<script>

    const result = (news) => {
        return `
            <div class="col-lg-3 col-sm-6 p-0">
                <div class="soccer-item set-bg" data-setbg="${BASE_DOMAIN + news.image}">
                    <div class="si-tag">${news.game_name}</div>
                    <div class="si-text">
                        <h5><a href="news-details.php?news-id=${news.id}">${news.title}</a></h5>
                        <ul>
                            <li><i class="fa fa-calendar"></i> ${news.event_date}</li>
                        </ul>
                    </div>
                </div>
            </div>
        `
    };

    const schedule1 = (news) => {
        return `
            <div class="news-item left-news">
                <div class="ni-pic set-bg" data-setbg="${BASE_DOMAIN + news.image}">
                    <div class="ni-tag">${news.game_name}</div>
                </div>
                <div class="ni-text">
                    <h4><a href="news-details.php?news-id=${news.id}">${news.title}</a></h4>
                    <ul>
                        <li><i class="fa fa-calendar"></i> ${news.event_date}</li>
                    </ul>
                    <p>${String(news.about).substr(0, 200) + '......'}</p>
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

    const generalFirst = (news) => {
        return `
            <div class="news-item popular-item set-bg" data-setbg="${BASE_DOMAIN + news.image}">
                <div class="ni-tag tenis">${news.game_name}</div>
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

    const comingUp = (news) => {
        return `
            <h4>${news.event_date}</h4>
            <h2>${news.title}</h2>
            <a href="news-details.php?news-id=${news.id}" class="primary-btn">More Details</a>
        `;
    };

    const getGeneral = () => {
        axios.get('news.php?type=general')
            .then(res => {
                let news = res.data;
                const center = Math.trunc(news.length / 2);
                const news1 = news.slice(0, center);
                const news2 = news.slice(center, news.length);

                if(news1.length > 0) {
                    $('#general1').empty().append(generalFirst(news1[0]));
                    news1.forEach(news => {
                        $('#general1').append(general(news));
                    });
                }

                if(news2.length > 0) {
                    $('#general2').empty().append(generalFirst(news2[0]));
                    news2.forEach(news => {
                        $('#general2').append(general(news));
                    });
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

    const getScheduled = () => {
        axios.get('news.php?type=schedule')
            .then(res => {
                if (res.data.length > 0) {
                    $('#schedule1').empty().append(schedule1(res.data[0]));
                }
                $('#comingUp').empty().append(comingUp(res.data[0]));
                $('#schedules').empty();
                res.data.forEach(news => {
                    $('#schedules').append(schedule(news));
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

    const getResults = () => {
        axios.get('news.php?type=result')
            .then(res => {
                $('#results').empty();
                res.data.forEach(news => {
                    $('#results').append(result(news));
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


    $(document).ready(() => {
        getGeneral();
        getScheduled();
        getResults();
    });
</script>
</body>

</html>