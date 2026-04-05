document.addEventListener('DOMContentLoaded', function() {
    const itemsBody = document.getElementById('itemsBody');
    const addItemBtn = document.getElementById('addItemBtn');
    const grandTotalSpan = document.getElementById('grandTotal');
    const totalAmountInput = document.getElementById('totalAmountInput');

    let itemIndex = 1;

    function calculateTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('.item-row');
        
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const total = qty * price;
            
            row.querySelector('.total-input').value = total.toLocaleString('id-ID');
            grandTotal += total;
        });
        
        grandTotalSpan.textContent = grandTotal.toLocaleString('id-ID');
        totalAmountInput.value = grandTotal.toFixed(0);
    }

    if (addItemBtn) {
        addItemBtn.addEventListener('click', () => {
            const tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td><input type="text" name="items[${itemIndex}][description]" class="form-control" required></td>
                <td><input type="number" name="items[${itemIndex}][qty]" class="form-control qty-input" value="1" min="1" required></td>
                <td><input type="number" name="items[${itemIndex}][price]" class="form-control price-input" value="0" step="1" required></td>
                <td><input type="text" class="form-control total-input" value="0" readonly></td>
                <td><button type="button" class="remove-row"><i class="fa-solid fa-xmark"></i></button></td>
            `;
            itemsBody.appendChild(tr);
            itemIndex++;
            attachEventListeners();
        });
    }

    function attachEventListeners() {
        const qtyInputs = document.querySelectorAll('.qty-input');
        const priceInputs = document.querySelectorAll('.price-input');
        const removeBtns = document.querySelectorAll('.remove-row');

        qtyInputs.forEach(input => {
            input.removeEventListener('input', calculateTotal);
            input.addEventListener('input', calculateTotal);
        });

        priceInputs.forEach(input => {
            input.removeEventListener('input', calculateTotal);
            input.addEventListener('input', calculateTotal);
        });

        removeBtns.forEach(btn => {
            btn.removeEventListener('click', removeRow);
            btn.addEventListener('click', removeRow);
        });
    }

    function removeRow(e) {
        const btn = e.currentTarget;
        const row = btn.closest('tr');
        // Prevent removing the last row
        if (document.querySelectorAll('.item-row').length > 1) {
            row.remove();
            calculateTotal();
        }
    }

    attachEventListeners();
});
