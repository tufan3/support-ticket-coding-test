<?php
// session_start();
$user_name = $_SESSION['username'];
?>
<h2>Support Ticket System</h2>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <?php if ($_SESSION['role'] == 'admin') { ?>
            <a class="navbar-brand" href="admin_dashboard.php">NetCoden</a>
        <?php } else if ($_SESSION['role'] == 'customer') { ?>
            <a class="navbar-brand" href="user_dashboard.php">NetCoden</a>
        <?php } ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <a class="nav-link active" aria-current="page" href="admin_dashboard.php">Ticket</a>
                    <?php } else if ($_SESSION['role'] == 'customer') { ?>
                        <a class="nav-link active" aria-current="page" href="user_dashboard.php">Ticket</a>
                    <?php } ?>
                </li>
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user_list.php">UserList</a>
                    </li>
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="label label-pill label-danger count"></span>
                        <?= $user_name ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>

                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>