class ProductManager {
    constructor() {
        // Core Elements
        this.generateBtn = document.getElementById("generateVariantsBtn");
        this.variantsBody = document.getElementById("variantsBody");
        this.noVariantsRow = document.getElementById("noVariantsRow");
        this.mainStockInput = document.querySelector(
            'input[name="stock_quantity"]',
        );
        this.productNameInput = document.querySelector('input[name="name"]');

        this.init();
    }

    init() {
        if (this.mainStockInput) {
            this.mainStockInput.style.transition = "all 0.3s ease";
        }

        // Bind generate logic
        if (this.generateBtn && this.variantsBody) {
            this.generateBtn.addEventListener("click", () =>
                this.generateVariants(),
            );
        }

        // Bind delegated events for the variants table (Create & Update)
        if (this.variantsBody) {
            this.variantsBody.addEventListener("click", (e) =>
                this.handleRowRemoval(e),
            );
            this.variantsBody.addEventListener("input", (e) =>
                this.handleStockInput(e),
            );

            // Calculate stock on initial page load
            this.calculateTotalStock();
        }
    }

    generateVariants() {
        // 1. Collect all checked colors
        const selectedColors = Array.from(
            document.querySelectorAll(".color-checkbox:checked"),
        ).map((cb) => ({
            id: cb.value,
            name: cb.getAttribute("data-name"),
        }));

        // 2. Collect all checked sizes
        const selectedSizes = Array.from(
            document.querySelectorAll(".size-checkbox:checked"),
        ).map((cb) => ({
            id: cb.value,
            name: cb.getAttribute("data-name"),
        }));

        if (selectedColors.length === 0 && selectedSizes.length === 0) {
            alert(
                "Please select at least one color or size to generate variants.",
            );
            return;
        }

        // Remove the "No variants" placeholder row if it exists
        if (this.noVariantsRow) {
            this.noVariantsRow.classList.add("d-none");
        }

        // 3. Save existing rows data into a map to preserve custom edits
        const existingRowsMap = new Map();
        const existingTableRows = this.variantsBody.querySelectorAll(
            "tr:not(#noVariantsRow)",
        );

        existingTableRows.forEach((row) => {
            const colorInput = row.querySelector('input[name*="[color_id]"]');
            const sizeInput = row.querySelector('input[name*="[size_id]"]');
            const skuInput = row.querySelector('input[name*="[sku]"]');
            const priceInput = row.querySelector(
                'input[name*="[price_offset]"]',
            );
            const stockInput = row.querySelector('input[name*="[stock]"]');
            const idInput = row.querySelector('input[name*="[id]"]');

            if (colorInput || sizeInput) {
                const key = `${colorInput ? colorInput.value : ""}_${sizeInput ? sizeInput.value : ""}`;
                existingRowsMap.set(key, {
                    id: idInput ? idInput.value : "",
                    sku: skuInput ? skuInput.value : "",
                    price_offset: priceInput ? priceInput.value : "0",
                    stock: stockInput ? stockInput.value : "0",
                });
            }
        });

        // 4. Generate combinations (Cartesian Product logic)
        let combinations = [];

        if (selectedColors.length > 0 && selectedSizes.length > 0) {
            selectedColors.forEach((color) => {
                selectedSizes.forEach((size) => {
                    combinations.push({
                        color_id: color.id,
                        color_name: color.name,
                        size_id: size.id,
                        size_name: size.name,
                        label: `${color.name} / ${size.name}`,
                    });
                });
            });
        } else if (selectedColors.length > 0) {
            selectedColors.forEach((color) => {
                combinations.push({
                    color_id: color.id,
                    color_name: color.name,
                    size_id: "",
                    size_name: "",
                    label: color.name,
                });
            });
        } else if (selectedSizes.length > 0) {
            selectedSizes.forEach((size) => {
                combinations.push({
                    color_id: "",
                    color_name: "",
                    size_id: size.id,
                    size_name: size.name,
                    label: size.name,
                });
            });
        }

        // 5. Rebuild the table cleanly
        this.variantsBody.innerHTML = "";
        const productName = this.productNameInput
            ? this.productNameInput.value
            : "PROD";

        combinations.forEach((combo, index) => {
            const key = `${combo.color_id}_${combo.size_id}`;
            const existingData = existingRowsMap.get(key);

            let cleanDefaultSku = `${productName.substring(0, 3).toUpperCase()}`;
            if (combo.color_name)
                cleanDefaultSku += `-${combo.color_name.substring(0, 3)}`;
            if (combo.size_name) cleanDefaultSku += `-${combo.size_name}`;
            cleanDefaultSku = cleanDefaultSku.replace(/\s+/g, "").toUpperCase();

            // Use existing custom data if it exists, otherwise use defaults
            const rowId = existingData ? existingData.id : "";
            const rowSku =
                existingData && existingData.sku
                    ? existingData.sku
                    : cleanDefaultSku;
            const rowPrice = existingData ? existingData.price_offset : "0";
            const rowStock = existingData ? existingData.stock : "0";
            const badgeText = rowId
                ? '<span class="badge bg-secondary me-2">Saved</span>'
                : '<span class="badge bg-primary me-2">New</span>';

            const tr = document.createElement("tr");
            tr.style.animation = "fadeIn 0.3s ease-in-out";
            tr.innerHTML = `
                <td class="align-middle fw-semibold text-dark">
                    ${badgeText} ${combo.label}
                    ${rowId ? `<input type="hidden" name="variants[${index}][id]" value="${rowId}">` : ""}
                    ${combo.color_id ? `<input type="hidden" name="variants[${index}][color_id]" value="${combo.color_id}">` : ""}
                    ${combo.size_id ? `<input type="hidden" name="variants[${index}][size_id]" value="${combo.size_id}">` : ""}
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="variants[${index}][sku]" value="${rowSku}" required>
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control form-control-sm" name="variants[${index}][price_offset]" value="${rowPrice}">
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm variant-stock-input" name="variants[${index}][stock]" value="${rowStock}" min="0" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-row-btn" title="Remove Variant">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            `;
            this.variantsBody.appendChild(tr);
        });

        this.calculateTotalStock();
    }

    handleRowRemoval(e) {
        const btn = e.target.closest(".remove-row-btn");
        if (btn) {
            const row = btn.closest("tr");
            row.style.opacity = "0";
            setTimeout(() => {
                row.remove();
                if (
                    this.variantsBody.querySelectorAll("tr:not(#noVariantsRow)")
                        .length === 0
                ) {
                    if (this.noVariantsRow)
                        this.noVariantsRow.classList.remove("d-none");
                }
                this.calculateTotalStock();
            }, 200);
        }
    }

    handleStockInput(e) {
        if (e.target.classList.contains("variant-stock-input")) {
            this.calculateTotalStock();
        }
    }

    calculateTotalStock() {
        if (!this.mainStockInput) return;

        let total = 0;
        const stockInputs = this.variantsBody.querySelectorAll(
            ".variant-stock-input",
        );

        if (stockInputs.length > 0) {
            stockInputs.forEach(
                (input) => (total += parseInt(input.value) || 0),
            );
            this.mainStockInput.value = total;
            this.mainStockInput.setAttribute("readonly", true);
            this.mainStockInput.classList.add("bg-light", "text-muted");
        } else {
            this.mainStockInput.removeAttribute("readonly");
            this.mainStockInput.classList.remove("bg-light", "text-muted");
        }
    }
}

// Global function for inline onclick attributes in Blade
window.toggleIcon = function (button) {
    let icon = button.querySelector(".toggle-icon");
    if (icon) {
        icon.classList.toggle("rotate-down");
    }
};

// Initialize the class when the DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    new ProductManager();
});
