<div >
    <div id="app" class="container">
        <nav id="custom-color-navbar" class="navbar navbar-expand-md navbar-light ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="custom-color-navbar2" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="../admin/read_events.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/createEvent.php">Create event <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../admin/createVoter.php">Create voter <span class="sr-only">(current)</span></a>
                    </li>

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
