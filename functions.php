// Euro Price Display Functions

// Function to convert BGN to EUR with proper rounding
function convert_bgn_to_eur($price_bgn, $exchange_rate = 1.95583) {
    $price_eur = $price_bgn / $exchange_rate;
    return round($price_eur, 2);
}

// Format EUR price using WooCommerce's markup
function format_euro_price($eur) {
    return '<span class="woocommerce-Price-amount amount"><bdi>' . number_format($eur, 2) . '&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi></span>';
}

// Display Euro price on single product page
add_action('woocommerce_single_product_summary', 'display_euro_price_single', 15);
function display_euro_price_single() {
    global $product;
    $price_bgn = $product->get_price();
    if ($price_bgn) {
        $price_eur = convert_bgn_to_eur($price_bgn);
        echo '<div class="euro-price">Цена в EUR: ' . format_euro_price($price_eur) . '</div>';
    }
}

// Display Euro price in shop loop (product grid)
add_action('woocommerce_after_shop_loop_item_title', 'display_euro_price_loop', 15);
function display_euro_price_loop() {
    global $product;
    $price_bgn = $product->get_price();
    if ($price_bgn) {
        $price_eur = convert_bgn_to_eur($price_bgn);
        echo '<div class="euro-price">' . format_euro_price($price_eur) . '</div>';
    }
}

// Display Euro price in cart
add_filter('woocommerce_cart_item_price', 'add_euro_price_to_cart', 10, 3);
function add_euro_price_to_cart($price_html, $cart_item, $cart_item_key) {
    $product = $cart_item['data'];
    $price_bgn = $product->get_price();
    if ($price_bgn) {
        $price_eur = convert_bgn_to_eur($price_bgn);
        $price_html .= '<br><span class="euro-price">' . format_euro_price($price_eur) . '</span>';
    }
    return $price_html;
}

// Display Euro price in cart totals
add_action('woocommerce_cart_totals_after_order_total', 'display_cart_total_in_euro');
function display_cart_total_in_euro() {
    $cart_total_bgn = WC()->cart->total;
    if ($cart_total_bgn) {
        $cart_total_eur = convert_bgn_to_eur($cart_total_bgn);
        echo '<tr class="euro-price">
                <th>Total in EUR:</th>
                <td>' . format_euro_price($cart_total_eur) . '</td>
              </tr>';
    }
}

// Display Euro price in cart subtotal
add_action('woocommerce_cart_totals_after_subtotal', 'display_cart_subtotal_in_euro');
function display_cart_subtotal_in_euro() {
    $cart_subtotal_bgn = WC()->cart->subtotal;
    if ($cart_subtotal_bgn) {
        $cart_subtotal_eur = convert_bgn_to_eur($cart_subtotal_bgn);
        echo '<tr class="euro-price">
                <th>Subtotal in EUR:</th>
                <td>' . format_euro_price($cart_subtotal_eur) . '</td>
              </tr>';
    }
}

// Display Euro price in checkout totals
add_action('woocommerce_review_order_after_order_total', 'display_checkout_total_in_euro');
function display_checkout_total_in_euro() {
    $order_total_bgn = WC()->cart->total;
    if ($order_total_bgn) {
        $order_total_eur = convert_bgn_to_eur($order_total_bgn);
        echo '<tr class="euro-price">
                <th>Total in EUR:</th>
                <td>' . format_euro_price($order_total_eur) . '</td>
              </tr>';
    }
}

// Display Euro price in mini cart widget
add_filter('woocommerce_widget_cart_total', 'add_euro_to_mini_cart_total');
function add_euro_to_mini_cart_total($total_html) {
    $cart_total_bgn = WC()->cart->total;
    if ($cart_total_bgn) {
        $cart_total_eur = convert_bgn_to_eur($cart_total_bgn);
        $total_html .= '<br><span class="euro-price">' . format_euro_price($cart_total_eur) . '</span>';
    }
    return $total_html;
}
