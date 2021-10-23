<div>
    <div id="app" class="container">
        <nav id="custom-color-navbar"  class="navbar navbar-expand-md navbar-light ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="custom-color-navbar2">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="../voter/index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>

                <ul class="navbar-nav">

                    <li class="nav-item">
                        <div class="nav-link btn-group">
                            <span class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['name_user']; ?>
                            </span>
                            <div class="dropdown-menu">
                                <a class="nav-link" href="../logout.php">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
