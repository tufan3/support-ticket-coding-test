<?php
// session_start();

?>
<div class="modal fade" id="replayModal" tabindex="-1" aria-labelledby="replayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="replayModalLabel">Ticket Replay</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Subject:</b> <span id="ticket_subject"></span></p>
                <p><b>Description:</b> <span id="ticket_description"></span></p>
                <p><b>Status:</b> <span id="ticket_status"></span></p>

                <h4><b>Replies</b></h4>
                <div id="ticket_replies" style="margin-bottom: 20px;"></div>
                <input type="hidden" id="ticket-id" name="ticket_id">

            </div>
        </div>
    </div>
</div>


<script>
    function submit_reply() {
        var ticket_id = $('#ticket-id').val();
        var message = $('#message').val();
        if (message == '') {
            alert("Please say something");
            $("#message").focus();
            return false;
        }
        var datastr = "ticket_id=" + ticket_id + "&message=" + message;
        // alert(datastr);
        $.ajax({
            url: 'submit_reply.php',
            type: 'POST',
            data: datastr,
            success: function(response) {
                // console.log(response)
                // alert(response);
                alert('Reply submitted');

                location.reload();
            }
        });
    }
</script>