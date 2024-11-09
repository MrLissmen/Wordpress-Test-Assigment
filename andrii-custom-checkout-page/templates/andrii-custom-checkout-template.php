<?php
defined('ABSPATH') || exit;

get_header();
?>

<div class="custom-checkout-page" style="padding: 20px; max-width: 800px; margin: 0 auto;">
    <h1 style="margin-bottom: 30px;">Placing an order</h1>
    
    <!-- Показ товарів з карзини -->
    <?php if ( WC()->cart->is_empty() ) : ?>
        <p>Your cart is empty.</p>
    <?php else : ?>
        <ul style="list-style: none;" class="checkout-cart">
            <?php foreach ( WC()->cart->get_cart() as $cart_item ) : 
                $product = $cart_item['data'];
            ?>
                <li class="checkout-image" style="margin-bottom: 30px;"><?php echo $product->get_image(); ?> - <?php echo $product->get_name(); ?> - <?php echo $cart_item['quantity']; ?> шт.</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Форма оформлення замовлення -->
    <form id="custom-checkout-form" method="POST">
        <div><label for="name">First Name:</label>
        <input type="text" id="name" name="name" required></div>
        
        <div><label for="address">Address:</label>
        <input type="text" id="address" name="address" required></div>
        
        <div><label for="email">Email:</label>
        <input type="email" id="email" name="email" required></div>
        
        <div><label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="bacs">Bank transfer</option>
            <option value="cod">Cash on delivery</option>
            <option value="paypal">PayPal</option>
        </select></div>
        

        <button type="submit">Confirm order</button>
    </form>

    <div id="checkout-message"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#custom-checkout-form').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: "POST",
                data: formData + '&action=process_custom_checkout',
                success: function(response) {
                    if(response.success) {
                        window.location.href = response.redirect_url; 
                    } else {
                        $('#checkout-message').html(response.message);
                    }
                }
            });
        });
    });
</script>

<?php

get_footer();
?>