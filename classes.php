<?php $active = 'classes'; ?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Classes</title>
    <?php include_once '_head.php' ?>
    <style>

    </style>
</head>

<body>
<?php include_once '_header.php' ?>

<!-- Soccer Section Begin -->
<section class="soccer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="section-title">
                    <h3>Olympic <span>classes</span></h3>
                </div>
            </div>
        </div>
        <div class="row" id="classes">

        </div>
    </div>
</section>
<!-- Soccer Section End -->


<?php include_once '_footer.php' ?>

<?php include_once '_scripts.php' ?>

<script>

    const mclass = (c) => {
        return `
        <div class="col-lg-3 col-sm-6 p-0">
            <div class="soccer-item set-bg" data-setbg="${BASE_DOMAIN + c.game_image}">
                <div class="si-tag">${c.game_name}</div>
                <div class="si-text">
                    <h5><a href="#">${c.title}</a></h5>
                    <ul>
                        <li><i class="fa fa-calendar"></i> From ${c.mfrom}</li>
                        <li><i class="fa fa-calendar"></i> To ${c.mto}</li>
                    </ul>
                    <button onclick="joinClass('${c.id}', ${c.joined && c.joined.id})" style="border-radius: 4px; margin-top: 1rem; border: transparent;" class="primary-btn text-center">
                        ${c.joined ? 'Joined': 'Join'}
                    </button>
                </div>
            </div>
        </div>
      `;
    };

    const getClasses = () => {
        axios.get('/mclass.php')
            .then(res => {
                $('#classes').empty();
                res.data.forEach(c => {
                    $('#classes').append(mclass(c));
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
                alert('Could not get classes');
            });
    };

    const joinClass = (classId, joined) => {
        if(joined) return;

        if (!isUser()) {
            alert('Please login to register for a class');
            location.href = 'admin/login.php';
        }
        $(".loader").fadeIn();
        $("#preloder").delay(200).fadeIn("slow");
        axios.post(`/mclass.php?type=join&class-id=${classId}`, {})
            .then(res => {
                alert('You are now a member of this class. Please wait for your instructor to contact you.');
                $(".loader").fadeOut();
                $("#preloder").delay(200).fadeOut("slow");
                getClasses();
            })
            .catch(e => {
                $(".loader").fadeOut();
                $("#preloder").delay(200).fadeOut("slow");
                console.error(e);
                alert('Could not register for class classes');
            });
    };

    $(document).ready(() => {
        getClasses();
    });
</script>

</body>

</html>