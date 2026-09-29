class UniversalModal {
    constructor() {
        document.addEventListener("show.bs.modal", (event) =>
            this.handleModalOpen(event),
        );
    }

    handleModalOpen(event) {
        const button = event.relatedTarget;

        // Modal was opened by JavaScript instead of a button
        if (!button) {
            return;
        }

        const modal = event.target;
        const form = modal.querySelector("form");

        // =====================================================
        // 1. UPDATE FORM ACTION
        // =====================================================

        const actionUrl = button.getAttribute("data-action-url");

        if (form && actionUrl) {
            form.action = actionUrl;
        }

        // =====================================================
        // 2. AUTO POPULATE INPUTS
        // =====================================================

        Array.from(button.attributes).forEach((attr) => {
            if (!attr.name.startsWith("data-input-")) {
                return;
            }

            const inputName = attr.name.replace("data-input-", "");

            // First search inside the modal
            let inputElement = modal.querySelector(`[name="${inputName}"]`);

            // If not found, search by ID
            if (!inputElement) {
                inputElement = document.getElementById(inputName);
            }

            if (!inputElement) {
                return;
            }

            // =================================================
            // CHECKBOX / RADIO
            // =================================================

            if (
                inputElement.type === "checkbox" ||
                inputElement.type === "radio"
            ) {
                inputElement.checked =
                    attr.value === "1" || attr.value === "true";
            }

            // =================================================
            // NORMAL INPUT
            // =================================================
            else {
                inputElement.value = attr.value;
            }
        });
    }
}

/**
 * ============================================================
 * UNIVERSAL AUTO SUBMITTER
 * ============================================================
 *
 * Automatically submits a form when the user stops typing
 * in an input with class:
 *
 * class="auto-submit"
 *
 * Example:
 *
 * <input
 *     type="text"
 *     name="search"
 *     class="auto-submit">
 */

class AutoSubmitter {
    constructor() {
        // Keep separate timers for separate inputs
        this.timeouts = new WeakMap();

        document.addEventListener("input", (event) => {
            const input = event.target;

            if (
                !input ||
                !input.classList ||
                !input.classList.contains("auto-submit")
            ) {
                return;
            }

            this.debounceSubmit(input);
        });
    }

    debounceSubmit(inputElement) {
        // Clear previous timer for this input
        const previousTimeout = this.timeouts.get(inputElement);

        if (previousTimeout) {
            clearTimeout(previousTimeout);
        }

        // Create new timer
        const timeout = setTimeout(() => {
            if (inputElement.form) {
                inputElement.form.submit();
            }

            this.timeouts.delete(inputElement);
        }, 500);

        this.timeouts.set(inputElement, timeout);
    }
}

/**
 * ============================================================
 * UNIVERSAL MULTI-IMAGE PREVIEWER
 * ============================================================
 *
 * Shows thumbnails when multiple images are selected.
 *
 * Required HTML structure:
 *
 * <div class="multi-image-uploader">
 *
 *     <input
 *         type="file"
 *         multiple
 *         class="multi-upload-input">
 *
 *     <div class="new-image-previews"></div>
 *
 * </div>
 */

class MultiImagePreviewer {
    constructor() {
        document.addEventListener("change", (event) => {
            const input = event.target;

            if (
                !input ||
                !input.classList ||
                !input.classList.contains("multi-upload-input")
            ) {
                return;
            }

            this.handlePreview(input);
        });
    }

    handlePreview(input) {
        // Find the uploader containing this input
        const wrapper = input.closest(".multi-image-uploader");

        if (!wrapper) {
            return;
        }

        // Find preview area
        const previewContainer = wrapper.querySelector(".new-image-previews");

        if (!previewContainer) {
            return;
        }

        // Remove old previews
        previewContainer.innerHTML = "";

        // No files selected
        if (!input.files || input.files.length === 0) {
            return;
        }

        // =====================================================
        // CREATE PREVIEW FOR EACH FILE
        // =====================================================

        Array.from(input.files).forEach((file) => {
            // Only allow images
            if (!file.type.startsWith("image/")) {
                return;
            }

            const reader = new FileReader();

            reader.onload = (event) => {
                const img = document.createElement("img");

                img.src = event.target.result;

                img.className = "img-thumbnail shadow-sm border-primary";

                img.style.width = "100px";
                img.style.height = "100px";
                img.style.objectFit = "cover";
                img.style.marginRight = "5px";
                img.style.marginBottom = "5px";

                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    }
}

/**
 * ============================================================
 * INITIALIZE GENERAL.JS
 * ============================================================
 *
 * Keep ONLY ONE DOMContentLoaded block here.
 */

document.addEventListener("DOMContentLoaded", () => {
    new UniversalModal();

    new AutoSubmitter();

    new MultiImagePreviewer();
});
