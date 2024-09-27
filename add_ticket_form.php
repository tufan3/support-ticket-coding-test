<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Open Ticket</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- <form id="ticketForm" method="POST"> -->
        <div class="form-group">
          <label for="subject">Issues Title</label>
          <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="form-group">
          <label for="description">Describe Your Issues</label>
          <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <!-- </form> -->
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary" id="" onclick="add_ticket()">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  function add_ticket() {
    var subject = $('#subject').val();
    var description = $('#description').val();
    var datastr = "subject=" + subject + "&description=" + description;
    // alert()

    $.ajax({
      url: 'submit_ticket.php',
      type: 'POST',
      data: datastr,
      success: function(response) {
        // alert(response);
        if (response == 'admin') {
          alert('Ticket submitted successfully');
          $('#exampleModal').modal('hide');
          window.location.href = 'admin_dashboard.php';
        } else if (response == 'customer') {
          alert('Ticket submitted successfully');
          $('#exampleModal').modal('hide');
          window.location.href = 'user_dashboard.php';
        }
      }
    });
  }
</script>