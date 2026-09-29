<div class="modal fade" id="globalConfirmModal" tabindex="-1" aria-labelledby="globalConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="globalConfirmModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i><span id="modalTitle">Confirm</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary py-3" id="modalMessage">
                Are you sure you want to perform this action?
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="modalConfirmBtn" class="btn btn-danger btn-sm px-3">Yes</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/messages/confirm_modal.js') }}"></script>
