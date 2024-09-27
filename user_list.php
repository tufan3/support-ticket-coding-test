<?php
session_start();
$user_name = $_SESSION['username'];

include 'db.php';

$query = $db->query("SELECT * FROM users");

if ($query === false) {
    die("Query failed: " . $conn->error);
}

$user_info = [];
while ($row = $query->fetch_assoc()) {
    $user_info[] = $row;
}
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container mt-5">


    <?php include('navbar.php'); ?>

    <!-- <div style="margin: 10px; float: right;">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_user">
            add user </button>
    </div> -->

    <table class="table table-bordered table-striped text-center" id="mytable">
        <thead class="table-dark opacity-75">
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <!-- <th>Actions</th> -->
            </tr>
        </thead>
        <tbody>
            <?php $sl = 0;
            if (!empty($user_info)): ?>
                <?php foreach ($user_info as $user):
                    $sl++;
                    // if ($user['status'] == 'open') {
                    //     $status = '<span style="background-color: green; color: white; padding: 5px;">Open</span>';
                    // } else {
                    //     $status = '<span style="background-color: red; color: white; padding: 5px;">Closed</span>';
                    // }
                ?>
                    <tr>
                        <td><?php echo $sl ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"
    integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#mytable').DataTable();
    });
</script>