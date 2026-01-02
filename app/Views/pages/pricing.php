<?php /** Pricing page */ ?>
<main class="container pricing-page" style="padding:56px 28px;">
    <div class="pricing-container">
        <div class="pricing-header">
            <h1>Choose Your Plan</h1>
            <p>Select the perfect plan for your needs. Upgrade or downgrade at any time.</p>
        </div>

        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Free</h3>
                <div class="price">$0<span>/month</span></div>
                <ul>
                    <li>Basic idea submission</li>
                    <li>Limited investments view</li>
                    <li>Access to public events</li>
                    <li>Community support</li>
                </ul>
                <a href="<?= BASE_URL ?>/register" class="btn btn-outline">Get Started</a>
            </div>

            <div class="pricing-card popular">
                <h3>Monthly</h3>
                <div class="price">$20<span>/month</span></div>
                <ul>
                    <li>Unlimited idea submissions</li>
                    <li>Full investment access</li>
                    <li>Premium event features</li>
                    <li>Priority support</li>
                    <li>Advanced analytics</li>
                </ul>
                <button type="button" class="btn subscribe-btn" data-plan="monthly" data-price="20">Subscribe Now</button>
            </div>

            <div class="pricing-card">
                <h3>Yearly</h3>
                <div class="price">$100<span>/year</span></div>
                <ul>
                    <li>All Monthly features</li>
                    <li>2 months free</li>
                    <li>Exclusive webinars</li>
                    <li>Dedicated account manager</li>
                    <li>Custom integrations</li>
                </ul>
                <button type="button" class="btn subscribe-btn" data-plan="yearly" data-price="100">Subscribe Now</button>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Payment Method</h2>
                <span class="close">&times;</span>
            </div>

            <div class="modal-body">
                <div class="plan-summary">
                    <h3>Selected Plan</h3>
                    <div class="plan-details">
                        <span class="plan-name" id="selected-plan">Monthly Plan</span>
                        <span class="plan-price" id="selected-price">$20/month</span>
                    </div>
                </div>

                <form class="payment-form" id="paymentForm">
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
                        <button type="button" class="btn btn-outline" id="cancelBtn">Cancel</button>
                        <button type="submit" class="btn">Complete Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<style>
    .pricing-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
    .pricing-header { text-align: center; margin-bottom: 60px; }
    .pricing-header h1 { font-size: 2.5rem; margin-bottom: 20px; }
    .pricing-header p { font-size: 1.2rem; color: #666; }
    .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
    .pricing-card { border: 1px solid #ddd; border-radius: 10px; padding: 30px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .pricing-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .pricing-card.popular { border-color: #00a8ff; position: relative; }
    .pricing-card.popular::before { content: 'Most Popular'; position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #00a8ff; color: white; padding: 5px 15px; border-radius: 15px; font-size: 0.9rem; font-weight: 600; }
    .pricing-card h3 { font-size: 1.8rem; margin-bottom: 10px; }
    .pricing-card .price { font-size: 3rem; font-weight: 700; margin: 20px 0; }
    .pricing-card .price span { font-size: 1rem; font-weight: 400; }
    .pricing-card ul { list-style: none; padding: 0; margin: 20px 0; }
    .pricing-card li { padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
    .pricing-card li:last-child { border-bottom: none; }
    .btn { display: inline-block; padding: 12px 30px; background: #00a8ff; color: white; text-decoration: none; border-radius: 5px; font-weight: 600; transition: background 0.3s ease; }
    .btn:hover { background: #0088dd; }
    .btn-outline { background: transparent; color: #00a8ff; border: 2px solid #00a8ff; }
    .btn-outline:hover { background: #00a8ff; color: white; }
</style>

<!-- Modal Styles -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 0;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        border-bottom: 1px solid #eee;
    }

    .modal-header h2 {
        margin: 0;
        color: #333;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #000;
    }

    .modal-body {
        padding: 30px;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 40px;
    }

    .plan-summary {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }

    .plan-summary h3 {
        margin-bottom: 15px;
        color: #333;
    }

    .plan-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .plan-name {
        font-weight: 600;
    }

    .plan-price {
        font-weight: 700;
        color: #00a8ff;
    }

    .payment-form {
        background: white;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h3 {
        margin-bottom: 20px;
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #00a8ff;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    @media (max-width: 768px) {
        .modal-body {
            grid-template-columns: 1fr;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column;
        }
    }
</style>

<script>
    // Modal functionality
    const modal = document.getElementById('paymentModal');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelBtn');
    const subscribeBtns = document.querySelectorAll('.subscribe-btn');
    const selectedPlan = document.getElementById('selected-plan');
    const selectedPrice = document.getElementById('selected-price');
    const paymentForm = document.getElementById('paymentForm');

    // Open modal when subscribe button is clicked
    subscribeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const plan = this.getAttribute('data-plan');
            const price = this.getAttribute('data-price');

            selectedPlan.textContent = plan.charAt(0).toUpperCase() + plan.slice(1) + ' Plan';
            selectedPrice.textContent = '$' + price + '/' + (plan === 'yearly' ? 'year' : 'month');

            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal functions
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        paymentForm.reset();
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Handle form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Here you would typically send the data to your payment processor
        alert('Payment processing would happen here. This is just a demo.');
        closeModal();
    });
</script>