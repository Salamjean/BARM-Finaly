<div class="modal fade" id="messageModal{{ $leave->id }}" tabindex="-1" aria-labelledby="messageModallabel{{ $leave->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <small class="modal-title" id="messageModallabel{{ $leave->id }}">Message</small>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($leave->comment != null)
                    <div class="modal-body">
                        <div class="fw-bold text-center">
                            <span>
                                {{ $leave->reason }}
                            </span><br>
                            <small class="text-muted">
                                ({{ $leave->nb_day }} Jours)
                            </small> 
                        </div>
                        <br><br>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="comment{{ $leave->id }}" class="form-label">Message du responsable</label>
                                <div class="input-group">
                                    <textarea class="form-control" id="comment{{ $leave->id }}" name="comment" rows="5" readonly>{{ $leave->comment }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div> 
        </div>
    </div>
</div>