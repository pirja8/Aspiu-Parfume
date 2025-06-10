document.addEventListener('DOMContentLoaded', () => {
    function updateCartTotal() {
        const rows = document.querySelectorAll('.cart-table tbody tr');
        let totalProducts = 0;

        rows.forEach(row => {
            const priceCell = row.querySelector('td.price');
            const quantityInput = row.querySelector('.quantity-control input');
            const totalCell = row.querySelector('td.total-price');

            const price = parseFloat(priceCell.textContent.replace(/[^\d]/g, ''));
            const quantity = parseInt(quantityInput.value);

            const rowTotal = price * quantity;
            totalProducts += rowTotal;

            totalCell.textContent = `IDR ${rowTotal.toLocaleString('id-ID')}`;
        });

        // Update total in cart summary
        const totalElements = document.querySelectorAll('.cart-total td:last-child');
        totalElements.forEach(el => {
            el.textContent = `IDR ${totalProducts.toLocaleString('id-ID')}`;
        });
    }

    // Update quantity via AJAX
    function updateQuantity(inputElement) {
        const row = inputElement.closest('tr');
        const productId = row.getAttribute('data-product-id');
        const quantity = inputElement.value;

        fetch('keranjang.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `product_id=${productId}&quantity=${quantity}&action=update`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateCartTotal();
                showPopup('Kuantitas produk berhasil diperbarui', true);
            } else {
                showPopup(data.message, false);
            }
        })
        .catch(() => showPopup('Terjadi kesalahan. Silakan coba lagi.', false));
    }

    // Quantity adjustment listeners
    document.querySelectorAll('.quantity-control').forEach(control => {
        const input = control.querySelector('input');
        control.querySelector('.increase-qty').addEventListener('click', () => {
            input.value = parseInt(input.value) + 1;
            updateQuantity(input);
        });
        control.querySelector('.decrease-qty').addEventListener('click', () => {
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateQuantity(input);
            }
        });
        input.addEventListener('change', () => {
            if (parseInt(input.value) < 1) input.value = 1;
            updateQuantity(input);
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', () => {
            const row = button.closest('tr');
            const productId = row.getAttribute('data-product-id');

            fetch('keranjang.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `product_id=${productId}&action=remove`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                    updateCartTotal();
                    showPopup('Produk berhasil dihapus dari keranjang', true);
                } else {
                    showPopup(data.message, false);
                }
            })
            .catch(() => showPopup('Terjadi kesalahan. Silakan coba lagi.', false));
        });
    });

    // Add to cart
document.addEventListener('click', function (e) {
    if (e.target.matches('.add-to-cart-btn:not(.login-required)')) {
        const button = e.target;
        const productId = button.getAttribute('data-product-id');
        button.disabled = true;
        button.textContent = 'Adding...';

        fetch('add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = 'keranjang.php';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(() => alert('Terjadi kesalahan. Silakan coba lagi.'))
        .finally(() => {
            button.disabled = false;
            button.textContent = 'Add to Cart';
        });
    }
});


    // Login required buttons
    document.querySelectorAll('.login-required').forEach(button => {
        button.addEventListener('click', () => {
            alert('Silakan login terlebih dahulu untuk menambahkan ke keranjang.');
            window.location.href = 'login.php';
        });
    });

    // Popup functions
    function showPopup(message, isSuccess = true) {
        let popup = document.getElementById('popup');
        let overlay = document.getElementById('overlay');
        if (!popup) {
            popup = document.createElement('div');
            popup.id = 'popup';
            popup.className = 'popup';
            popup.innerHTML = `<div id="popup-message"></div><button id="popup-close">OK</button>`;
            document.body.appendChild(popup);
            popup.querySelector('#popup-close').onclick = closePopup;
        }
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'overlay';
            overlay.className = 'overlay';
            document.body.appendChild(overlay);
        }

        popup.querySelector('#popup-message').textContent = message;
        popup.className = 'popup ' + (isSuccess ? 'success' : 'error');
        popup.style.display = 'block';
        overlay.style.display = 'block';
    }

    function closePopup() {
        const popup = document.getElementById('popup');
        const overlay = document.getElementById('overlay');
        if (popup) popup.style.display = 'none';
        if (overlay) overlay.style.display = 'none';
    }

    updateCartTotal();
});
