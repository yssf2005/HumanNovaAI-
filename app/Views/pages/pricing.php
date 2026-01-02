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

    <!-- Payment Popover (anchored) -->
    <div id="paymentPopover" class="payment-popover" aria-hidden="true" style="display:none;position:absolute;z-index:10000;">
        <div class="popover-content">
            <div class="popover-header">
                <h3>Payment Method</h3>
                <button class="close" aria-label="Close">&times;</button>
            </div>

            <div class="popover-body">
                <div class="plan-summary">
                    <h4>Selected Plan</h4>
                    <div class="plan-details">
                        <span class="plan-name" id="selected-plan">Monthly Plan</span>
                        <span class="plan-price" id="selected-price">$20/month</span>
                    </div>
                </div>

                <form class="payment-form" id="paymentForm">
                    <div class="form-section">
                        <h4>Billing</h4>
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
                    </div>

                    <div class="form-section">
                        <h4>Payment</h4>
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

<!-- Popover Styles -->
<style>
    .payment-popover { display: none; position: absolute; z-index: 10000; }
    .popover-content { background: #fff; border-radius: 8px; box-shadow: 0 12px 30px rgba(0,0,0,0.12); width: 360px; overflow: hidden; }
    .popover-header { display:flex; justify-content:space-between; align-items:center; padding:12px 14px; border-bottom:1px solid #eee; }
    .popover-header h3 { margin:0; font-size:1rem; }
    .popover-header .close { background:none; border:0; font-size:20px; cursor:pointer; color:#666; }
    .popover-body { padding:12px 14px; max-height:70vh; overflow:auto; }
    .popover-body .plan-summary { margin-bottom:10px; }
    .popover-body h4 { margin:0 0 8px 0; font-size:0.95rem; }
    .popover-body .form-actions { display:flex; gap:8px; justify-content:flex-end; margin-top:12px; }

    @media (max-width: 600px) { .popover-content { width: 92vw; } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popover = document.getElementById('paymentPopover');
        const closeBtn = popover.querySelector('.close');
        const cancelBtn = document.getElementById('cancelBtn');
        const subscribeBtns = document.querySelectorAll('.subscribe-btn');
        const selectedPlan = document.getElementById('selected-plan');
        const selectedPrice = document.getElementById('selected-price');
        const paymentForm = document.getElementById('paymentForm');

        function showPopoverAt(button) {
            const rect = button.getBoundingClientRect();
            const popWidth = Math.min(360, window.innerWidth - 20);
            let left = rect.left + window.scrollX;
            let top = rect.bottom + window.scrollY + 8;

            // Adjust if overflowing right
            if (left + popWidth > window.scrollX + window.innerWidth - 10) {
                left = window.scrollX + window.innerWidth - popWidth - 10;
            }
            // Ensure not off-screen left
            if (left < 10) left = 10 + window.scrollX;

            popover.style.left = left + 'px';
            popover.style.top = top + 'px';
            popover.style.display = 'block';
            popover.setAttribute('aria-hidden', 'false');
        }

        function hidePopover() {
            popover.style.display = 'none';
            popover.setAttribute('aria-hidden', 'true');
            paymentForm.reset();
        }

        subscribeBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const plan = this.getAttribute('data-plan');
                const price = this.getAttribute('data-price');

                selectedPlan.textContent = plan.charAt(0).toUpperCase() + plan.slice(1) + ' Plan';
                selectedPrice.textContent = '$' + price + '/' + (plan === 'yearly' ? 'year' : 'month');

                showPopoverAt(this);
            });
        });

        closeBtn.addEventListener('click', hidePopover);
        cancelBtn.addEventListener('click', hidePopover);

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!popover.contains(e.target) && !e.target.closest('.subscribe-btn')) {
                hidePopover();
            }
        });

        // Prevent clicks inside popover from closing
        popover.addEventListener('click', function(e){ e.stopPropagation(); });

        // Form submission (placeholder)
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Payment processing would happen here.');
            hidePopover();
        });
    });
</script>