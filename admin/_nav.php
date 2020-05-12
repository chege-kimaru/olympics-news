<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
    <div id="php"></div>

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">Olympics</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="change-password.php"><i class="fa fa-user fa-fw"></i> Change Password</a>
                </li>
                <li class="divider"></li>
                <li><a onclick="logout()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="news.php">News</a>
                </li>
                <li>
                    <a href="news-form.php">Add news</a>
                </li>
                <li>
                    <a href="games.php">Games</a>
                </li>
                <li>
                    <a href="classes.php">Classes</a>
                </li>
                <li>
                    <a href="stadiums.php">Stadia</a>
                </li>
                <li class="users-nav" style="display: none">
                    <a href="users.php">Users</a>
                </li>
                <li>
                    <a href="change-password.php">Change Password</a>
                </li>
                <li>
                    <a onclick="logout()">Log out</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
</nav>

<script>
    const logout = () => {
        location.href = 'login.php';
    };
    if(isSuperAdmin()) {
        $('.users-nav').show();
    } else {
        $('.users-nav').hide();
    }
</script>
