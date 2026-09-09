// 1. Make selectPreset global so the HTML onclick="" buttons can use it
window.selectPreset = function (hex, name) {
    document.getElementById("hexTextInput").value = hex;
    document.getElementById("visualPicker").value = hex;

    // Auto-fill the name if it's empty
    const nameInput = document.getElementById("colorNameInput");
    if (!nameInput.value) {
        nameInput.value = name;
    }
};

// 2. Wait for the page to load before handling tabs
document.addEventListener("DOMContentLoaded", function () {
    const tabsContainer = document.getElementById("attributeTabs");
    if (!tabsContainer) return; // Exit if not on the attributes page

    // --- A. TAB MEMORY LOGIC ---
    const triggerTabList = document.querySelectorAll("#attributeTabs button");
    triggerTabList.forEach((triggerEl) => {
        triggerEl.addEventListener("click", function () {
            localStorage.setItem("activeAttributeTab", this.id);
        });
    });

    const activeTabId = localStorage.getItem("activeAttributeTab");
    if (activeTabId) {
        const tabElement = document.getElementById(activeTabId);
        if (tabElement && typeof bootstrap !== "undefined") {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
        }
    }

    // --- B. TAB TEXT COLOR LOGIC ---
    const colorsTab = document.getElementById("colors-tab");
    const sizesTab = document.getElementById("sizes-tab");

    if (colorsTab && sizesTab) {
        // Function to handle switching text colors
        function updateTabStyles(activeId) {
            if (activeId === "colors-tab") {
                colorsTab.classList.replace("text-secondary", "text-primary");
                sizesTab.classList.replace("text-primary", "text-secondary");
            } else {
                sizesTab.classList.replace("text-secondary", "text-primary");
                colorsTab.classList.replace("text-primary", "text-secondary");
            }
        }

        // Apply colors immediately when page loads based on the remembered tab
        updateTabStyles(activeTabId || "colors-tab");

        // Listen for clicks to change colors live
        colorsTab.addEventListener("click", () =>
            updateTabStyles("colors-tab"),
        );
        sizesTab.addEventListener("click", () => updateTabStyles("sizes-tab"));
    }
});
