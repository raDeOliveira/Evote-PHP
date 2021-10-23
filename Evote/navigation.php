<div >
    <div id="app" class="container">
        <nav id="custom-color-navbar" class="navbar navbar-expand-md navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="custom-color-navbar2">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo $home_url; ?>index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>

                <?php
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && ($_SESSION['access_level']=="Voter")){ ?>
                <div class="nav-link">
                    <a style="color: black" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span  class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        <?php echo $_SESSION['name_user']; ?>
                        <span class="caret"></span></a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a style="color: black" href="<?php echo $home_url; ?>logout.php">Logout</a>
                        </li>

                        <?php

                        } else{

                            ?>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="nav-link">
                                    <a class="nav-link" href="<?php echo $home_url; ?>login.php">
                                        <span class="link-text">Log In</span>
                                    </a>
                                </li>
<!--                            </ul>-->
                            <?php
                        }
                        ?>
                    </ul>
            </div>
        </nav>
    </div>
</div>
