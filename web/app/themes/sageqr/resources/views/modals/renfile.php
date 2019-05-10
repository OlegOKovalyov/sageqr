<!-- Rename File Modal -->
<div class="modal fade" id="renFileModal" tabindex="-1" role="dialog" aria-labelledby="renFileModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <form action="<?= $_SERVER['REQUEST_URI'];?>" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rename</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <p>Please enter a new name for the item:</p>
              <input type="text" name="renfile" value=""><br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </div>
    </form>

  </div>
</div>