<?php /** Payment method page */ ?>
<main class="container payment-page" style="padding:56px 28px;">
    <div class="payment-container">
        <div class="payment-header">
            <h1>Payment Method</h1>
            <p>Enter your payment details to complete your subscription</p>
        </div>

        <div class="payment-content">
            <div class="plan-summary">
                <h3>Selected Plan</h3>
                <div class="plan-details">
                    <span class="plan-name" id="selected-plan">Monthly Plan</span>
                    <span class="plan-price" id="selected-price">$20/month</span>
                </div>
            </div>

            <form class="payment-form" action="<?= BASE_URL ?>/payment/process" method="POST">
                <div class="form-section">
                    <h3>Billing Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Billing Address</label>
                        <input type="text" id="address" name="address" placeholder="Street address" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="zip">ZIP Code</label>
                            <input type="text" id="zip" name="zip" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select id="country" name="country" required>
                            <option value="">Select Country</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="UK">United Kingdom</option>
                            <option value="AU">Australia</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Payment Information</h3>
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry">Expiry Date</label>
                            <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card_name">Name on Card</label>
                        <input type="text" id="card_name" name="card_name" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= BASE_URL ?>/pricing" class="btn btn-outline">Back to Pricing</a>
                    <button type="submit" class="btn">Complete Payment</button>
                </div>
            </form>
        </div>
    </div>
</main>

<style>
    .payment-container { max-width: 800px; margin: 0 auto; }
    .payment-header { text-align: center; margin-bottom: 40px; }
    .payment-header h1 { font-size: 2.5rem; margin-bottom: 10px; }
    .payment-header p { color: #666; }

    .payment-content { display: grid; grid-template-columns: 1fr 2fr; gap: 40px; }

    .plan-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; }
    .plan-summary h3 { margin-bottom: 15px; color: #333; }
    .plan-details { display: flex; justify-content: space-between; align-items: center; }
    .plan-name { font-weight: 600; }
    .plan-price { font-weight: 700; color: #00a8ff; }

    .payment-form { background: white; padding: 30px; border: 1px solid #ddd; border-radius: 8px; }

    .form-section { margin-bottom: 30px; }
    .form-section h3 { margin-bottom: 20px; color: #333; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 500; color: #555; }
    .form-group input, .form-group select {
        width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px;
        font-size: 14px; transition: border-color 0.3s ease;
    }
    .form-group input:focus, .form-group select:focus { outline: none; border-color: #00a8ff; }

    .form-actions { display: flex; gap: 15px; justify-content: space-between; margin-top: 30px; }
    .btn { padding: 12px 30px; border-radius: 5px; font-weight: 600; text-decoration: none; display: inline-block; text-align: center; transition: all 0.3s ease; }
    .btn { background: #00a8ff; color: white; border: 2px solid #00a8ff; }
    .btn:hover { background: #0088dd; border-color: #0088dd; }
    .btn-outline { background: transparent; color: #00a8ff; }
    .btn-outline:hover { background: #00a8ff; color: white; }

    @media (max-width: 768px) {
        .payment-content { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column; }
    }
</style>

<script>
    // Get plan from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const plan = urlParams.get('plan') || 'monthly';
    const price = urlParams.get('price') || '20';

    // Update plan display
    document.getElementById('selected-plan').textContent = plan.charAt(0).toUpperCase() + plan.slice(1) + ' Plan';
    document.getElementById('selected-price').textContent = '$' + price + '/' + (plan === 'yearly' ? 'year' : 'month');
</script>