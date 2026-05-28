<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModallabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModallabel">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <center>
              <p> Voulez-vous vraiment supprimer cette demande ?</p>
          </center>
        </div>
        {{-- <div class="modal-footer">
          <a href="" type="button" class="btn btn-danger modal_URL"><i class="fas fa-check-circle">&nbsp;</i> Oui</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times-circle">&nbsp;</i> Non</button>
        </div>  --}}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
            <form id="delete-form-{{ $leave->id }}" action="{{ route('leave.delete', $leave->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Oui</button>
            </form>
        </div>
      </div>
    </div>
</div>
