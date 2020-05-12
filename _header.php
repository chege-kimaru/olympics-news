<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Offcanvas Menu Section Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="canvas-close">
        <i class="fa fa-close"></i>
    </div>
    <ul class="main-menu mobile-menu">
        <li class="<?php $active === 'home' ? print 'active' : print ''; ?>"><a href="index.php">Home</a></li>
        <li class="<?php $active === 'schedule' ? print 'active' : print ''; ?>"><a href="schedule.php">Schedule</a>
        </li>
        <li class="<?php $active === 'results' ? print 'active' : print ''; ?>"><a href="results.php">Results</a></li>
        <li class="<?php $active === 'news' ? print 'active' : print  ''; ?>"><a href="news.php">News</a></li>
        <li class="<?php $active === 'classes' ? print 'active' : print  ''; ?>"><a href="classes.php">Classes</a></li>
    </ul>
    <div id="mobile-menu-wrap"></div>
</div>
<!-- Offcanvas Menu Section End -->

<!-- Header Section Begin -->
<header class="header-section">
    <div class="header__nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="index.php" style="display:flex; align-items:center;flex-direction: row;">
                            <img src="img/olympic.png" style="height: 40px;" alt="">
                            <span style="color: white; font-size: 21px; margin-left: 0.5rem">Olympics</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="nav-menu">
                        <ul class="main-menu">
                            <li class="<?php $active === 'home' ? print 'active' : print ''; ?>"><a href="index.php">Home</a>
                            </li>
                            <li class="<?php $active === 'schedule' ? print 'active' : print ''; ?>"><a
                                        href="schedule.php">Schedule</a>
                            </li>
                            <li class="<?php $active === 'result' ? print 'active' : print ''; ?>"><a href="results.php">Results</a>
                            </li>
                            <li class="<?php $active === 'news' ? print 'active' : print  ''; ?>"><a href="news.php">News</a>
                            </li>
                            <li class="<?php $active === 'classes' ? print 'active' : print ''; ?>"><a
                                        href="classes.php">Classes</a>
                            </li>
                            <li><a href="admin/login.php"><i class="fa fa-user"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->