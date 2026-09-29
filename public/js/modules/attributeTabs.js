window.selectPreset = function (hex, name) {
    const hexInput = document.getElementById("addHexInput");
    const visualPicker = document.getElementById("addVisualPicker");

    // REMOVED THE SPACE: Changed '#a ddColorModal' to '#addColorModal'
    const nameInput = document.querySelector(
        '#addColorModal input[name="color_name"]',
    );

    if (hexInput) {
        hexInput.value = hex;
    }
    if (visualPicker) {
        visualPicker.value = hex;
    }
    if (nameInput) {
        nameInput.value = name;
        nameInput.dispatchEvent(new Event("input", { bubbles: true }));
        nameInput.dispatchEvent(new Event("change", { bubbles: true }));
    }
};

// ==========================================
// PAGE LOAD
// ==========================================

document.addEventListener("DOMContentLoaded", function () {
    // ------------------------------------------
    // A. AUTO-REOPEN MODAL WHEN VALIDATION ERROR
    // ------------------------------------------

    const errorModalEl = document.querySelector(".has-validation-error");

    if (errorModalEl && typeof bootstrap !== "undefined") {
        const errorModal = new bootstrap.Modal(errorModalEl);
        errorModal.show();

        // Remember which Attribute tab should be active
        if (errorModalEl.id === "addSizeModal") {
            localStorage.setItem("activeAttributeTab", "sizes-tab");
        } else {
            localStorage.setItem("activeAttributeTab", "colors-tab");
        }
    }

    // ------------------------------------------
    // B. ATTRIBUTE TAB MEMORY
    // ------------------------------------------

    const tabsContainer = document.getElementById("attributeTabs");

    if (!tabsContainer) {
        return;
    }

    const triggerTabList = document.querySelectorAll("#attributeTabs button");

    triggerTabList.forEach(function (triggerEl) {
        triggerEl.addEventListener("click", function () {
            localStorage.setItem("activeAttributeTab", this.id);
        });
    });

    // Restore previous tab
    const activeTabId = localStorage.getItem("activeAttributeTab");

    if (activeTabId && typeof bootstrap !== "undefined") {
        const tabElement = document.getElementById(activeTabId);

        if (tabElement) {
            const tab = new bootstrap.Tab(tabElement);

            tab.show();
        }
    }

    // ------------------------------------------
    // C. TAB TEXT COLOR
    // ------------------------------------------

    const colorsTab = document.getElementById("colors-tab");

    const sizesTab = document.getElementById("sizes-tab");

    if (!colorsTab || !sizesTab) {
        return;
    }

    function updateTabStyles(activeId) {
        if (activeId === "colors-tab") {
            colorsTab.classList.replace("text-secondary", "text-primary");

            sizesTab.classList.replace("text-primary", "text-secondary");
        } else {
            sizesTab.classList.replace("text-secondary", "text-primary");

            colorsTab.classList.replace("text-primary", "text-secondary");
        }
    }

    // Set initial tab color
    updateTabStyles(activeTabId || "colors-tab");

    // Update when clicking tabs
    colorsTab.addEventListener("click", function () {
        updateTabStyles("colors-tab");
    });

    sizesTab.addEventListener("click", function () {
        updateTabStyles("sizes-tab");
    });
});
