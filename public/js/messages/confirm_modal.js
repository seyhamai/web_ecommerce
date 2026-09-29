document.addEventListener("DOMContentLoaded", function () {
    const confirmModalEl = document.getElementById("globalConfirmModal");

    if (!confirmModalEl) {
        console.error("Global Confirm Modal element not found in DOM.");
        return;
    }

    const bsModal = bootstrap.Modal.getOrCreateInstance(confirmModalEl);
    const modalTitle = document.getElementById("modalTitle");
    const modalMessage = document.getElementById("modalMessage");
    const modalConfirmBtn = document.getElementById("modalConfirmBtn");

    let targetForm = null;

    // Listen for clicks on the entire document
    document.addEventListener("click", function (e) {
        const trigger = e.target.closest(".requires-confirmation");

        if (trigger) {
            e.preventDefault();
            targetForm = trigger.closest("form");

            if (!targetForm) {
                console.error("Trigger button must be inside a <form>");
                return;
            }

            // Set custom modal texts if provided via data attributes
            modalTitle.textContent =
                trigger.getAttribute("data-title") || "Are you sure?";
            modalMessage.textContent =
                trigger.getAttribute("data-message") ||
                "This action cannot be undone.";
            modalConfirmBtn.textContent =
                trigger.getAttribute("data-btn-text") || "Confirm";

            // ---> THE TWO NEW LINES FOR THE BUTTON COLOR <---
            const btnColor =
                trigger.getAttribute("data-btn-class") || "btn-danger";
            modalConfirmBtn.className = `btn btn-sm px-3 ${btnColor}`;
            // ------------------------------------------------

            bsModal.show();
        }
    });

    // When the confirm button inside the modal is clicked
    modalConfirmBtn.addEventListener("click", function () {
        if (targetForm) {
            targetForm.submit();
        }
    });
});
