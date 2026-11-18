let cart = [];
let subtotal = 0;

function addToCart(product) {
    // product = {id, code, name, price, qty}
    let existing = cart.find(item => item.id === product.id);
    if (existing) {
        existing.qty += product.qty;
        existing.subtotal = existing.qty * existing.price;
    } else {
        product.subtotal = product.qty * product.price;
        cart.push(product);
    }
    renderCart();
    calculateTotal();
}

function renderCart() {
    let cartBody = document.getElementById('cartBody');
    cartBody.innerHTML = '';
    if (cart.length === 0) {
        cartBody.innerHTML = `<tr><td colspan="6">Keranjang masih kosong</td></tr>`;
        return;
    }
    cart.forEach((item, index) => {
        cartBody.innerHTML += `
            <tr>
                <td>${index+1}</td>
                <td>${item.name}</td>
                <td>Rp ${item.price}</td>
                <td>${item.qty}</td>
                <td>Rp ${item.subtotal}</td>
                <td><button onclick="removeItem(${item.id})" class="btn btn-sm btn-danger">Hapus</button></td>
            </tr>
        `;
    });
}

function removeItem(id) {
    cart = cart.filter(item => item.id !== id);
    renderCart();
    calculateTotal();
}

function calculateTotal() {
    subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
    document.getElementById('subtotal').innerText = `Rp ${subtotal}`;

    let discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
    let discountAmount = parseFloat(document.getElementById('discountAmount').value) || 0;
    let tax = parseFloat(document.getElementById('tax').value) || 0;
    let otherFee = parseFloat(document.getElementById('otherFee').value) || 0;

    let discount = (subtotal * discountPercent / 100) + discountAmount;
    let grandTotal = subtotal - discount + tax + otherFee;

    document.getElementById('grandTotal').innerText = `Rp ${grandTotal}`;
}

function calculateChange() {
    let payment = parseFloat(document.getElementById('payment').value) || 0;
    let grandTotal = parseFloat(document.getElementById('grandTotal').innerText.replace('Rp ', '')) || 0;
    let change = payment - grandTotal;
    document.getElementById('change').innerText = `Rp ${change}`;
}

function holdTransaction() {
    alert("Transaksi ditahan sementara.");
}

function cancelTransaction() {
    cart = [];
    renderCart();
    calculateTotal();
    alert("Transaksi dibatalkan.");
}

function processPayment() {
    if (cart.length === 0) {
        alert("Keranjang kosong!");
        return;
    }
    alert("Transaksi berhasil disimpan!");
    // di Laravel, ini akan submit form ke route kasir.store
}
