
<nav class="user-controls">
                    <ul class="user-controls__ul">
                    <li class="user-controls__ul__li user-controls__ul__li--cart">
                    <mini-cart
        view-cart="{{ route('shop.checkout.cart.index') }}"
        cart-text="{{ __('shop::app.minicart.view-cart') }}"
        checkout-text="{{ __('shop::app.minicart.checkout') }}"
        checkout-url="{{ route('shop.checkout.onepage.index') }}"
        subtotal-text="{{ __('shop::app.checkout.cart.cart-subtotal') }}">
    </mini-cart>
        </li>
    </ul>
</nav>