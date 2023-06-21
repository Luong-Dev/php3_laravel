// var quantityCart = sizeOf($cart);
// if (cartQuantity) {
//     alert("có cart");
// }
if (cartQuantity && cartQuantity > 0) {
    for (let i = 0; i < cartQuantity; i++) {
        window['minusButton' + i] = document.getElementById(`minus-btn-${i}`);
        window['plusButton' + i] = document.getElementById(`plus-btn-${i}`);
        window['quantity' + i] = document.getElementById(`quantity-${i}`);
        window['oneCart' + i] = document.querySelector(`#js-update-one-cart-${i}`);
        window['productDetailId-' + i] = document.querySelector(`#js-product-detail-id-${i}`);

        // Xử lý sự kiện khi người dùng nhấp vào nút tăng giảm số lượng
        window['minusButton' + i].addEventListener("click", function() {
            if (window['quantity' + i].value > 1) {
                window['quantity' + i].value = parseInt(window['quantity' + i].value) - 1;
            }
        });

        window['plusButton' + i].addEventListener("click", function() {
            window['quantity' + i].value = parseInt(window['quantity' + i].value) + 1;
        });

        window['oneCart' + i].addEventListener("click", function() {
            // alert(window['quantity' + i].value);
            // alert(window['productDetailId-' + i].value);
            window['oneCart' + i].href = `/carts/update/${window['productDetailId-' + i].value}/${window['quantity' + i].value}`;
        });
    }
}