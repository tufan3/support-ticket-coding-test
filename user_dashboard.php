<?php
session_start();
$user_name = $_SESSION['username'];
$user_type = $_SESSION['role'];

if ($user_type !== 'customer') {
    header('Location: login.php');
    exit;
}

include 'db.php';

$query = $db->query("SELECT * FROM tickets");

if ($query === false) {
    die("Query failed: " . $conn->error);
}

$tickets = [];
while ($row = $query->fetch_assoc()) {
    $tickets[] = $row;
}
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container mt-5">

    <?php include('navbar.php'); ?>

    <!-- Open ticket modal -->
    <div style="margin: 10px; float: right;">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Open Ticket </button>
    </div>
    <!-- Open ticket modal -->

    <!-- list of open ticket -->
    <table class="table table-bordered table-striped text-center" id="mytable">
        <thead class="table-dark opacity-75">
            <tr>
                <th>S/N</th>
                <th>Issues Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $sl = 0;
            if (!empty($tickets)): ?>
                <?php foreach ($tickets as $ticket):
                    $sl++;
                    if ($ticket['status'] == 'open') {
                        $status = '<span style="background-color: green; color: 
                        white; padding: 5px;">Open</span>';
                    } else {
                        $status = '<span style="background-color: red; color: white; padding: 5px;">Closed</span>';
                    }
                ?>
                    <tr>
                        <td><?php echo $sl ?></td>
                        <td><?= $ticket['subject'] ?></td>
                        <td><?= $ticket['description'] ?></td>
                        <td><?= $status ?></td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm open-modal" data-bs-toggle="modal" data-bs-target="#replayModal" data-ticket-id="<?= $ticket['id'] ?>">Replay</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No tickets available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- list of open ticket -->

<?php include 'add_ticket_form.php'; ?>

<?php include 'ticket_replay_modal.php'; ?>

<!-- pagination table -->
<script src="https://code.jquery.com/jquery-3.7.0.js"
    integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#mytable').DataTable();
    });
</script>
<!-- pagination table -->

<!-- replay message part -->
<script>
    $('#replayModal').on('show.bs.modal', function(event) {
        var user_type_role = "<?php echo $user_type ?>";
        var button = $(event.relatedTarget);
        var ticketId = button.data('ticket-id');

        $('#ticket-id').val(ticketId);

        $.ajax({
            url: 'get_ticket_replay_details.php',
            type: 'GET',
            data: {
                id: ticketId
            },
            success: function(response) {
                console.log(response);

                $('#ticket_subject').text(response.ticket.subject);
                $('#ticket_description').text(response.ticket.description);
                $('#ticket_status').text(response.ticket.status);

                var repliesList = '';

                function timeAgo(dateString) {
                    const now = new Date();
                    const createdAt = new Date(dateString);
                    const diffInSeconds = Math.floor((now - createdAt) / 1000);

                    const intervals = {
                        year: 31536000,
                        month: 2592000,
                        day: 86400,
                        hour: 3600,
                        minute: 60,
                        second: 1
                    };

                    for (const unit in intervals) {
                        const intervalValue = intervals[unit];
                        const count = Math.floor(diffInSeconds / intervalValue);
                        if (count >= 1) {
                            return count === 1 ? `${count} ${unit} ago` : `${count} ${unit}s ago`;
                        }
                    }
                    return 'just now';
                }

                response.replies.forEach(function(reply) {
                    const timeAgoString = timeAgo(reply.created_at);

                    repliesList += `
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" style="margin-top:5px; ">
                            <div class="toast-body">
                                    ${reply.message}
                                </div>
                                <div class="toast-header" style="background-color: #7b7d7d; color:white;">
                                    <strong class="me-auto">${reply.user_role === 'admin' ? 'Admin' : reply.user_name}</strong>
                                    <small class="text-body-light" >${timeAgoString}</small>
                                </div>
                            </div>`;
                });

                if (response.ticket.status == 'open') {
                    repliesList += `
                        <textarea style="margin-top:10px;" id="message" name="message" class="form-control" required></textarea>
                        <button style="margin-top:10px; type="submit" class="btn btn-primary" onclick="submit_reply()" id="submitReply">
                            <b>Reply to </b> ${user_type_role === 'admin' ? 'Customer' : 'Admin'}
                        </button>`;
                } else {
                    repliesList += "";
                }

                $('#ticket_replies').html(repliesList);

                $('#replayModal').on('shown.bs.modal', function() {
                    $('.toast').toast('show');
                });
            }
        });

    });
</script>
<!-- replay message part -->