<?php
require_once 'config/conn.php';




?>



<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="rating">Rating:</label>
          <div class="rating">
            <span class="star" data-rating="1">&#9733;</span>
            <span class="star" data-rating="2">&#9733;</span>
            <span class="star" data-rating="3">&#9733;</span>
            <span class="star" data-rating="4">&#9733;</span>
            <span class="star" data-rating="5">&#9733;</span>
            <input type="hidden" name="rating" id="rating">
          </div>
        </div>
        <div class="form-group">
          <label for="comments">Comments:</label>
          <textarea class="form-control" id="comments" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitFeedback">Submit</button>
      </div>
    </div>
  </div>
</div>
<!-- JavaScript to automatically show the modal -->
<script>
    // $(document).ready(function () {
    //     $('#RedirectModal').modal('show');
    // });
</script>

<?php ?>