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
            <div class="popover-header light">
                <div style="display:flex;align-items:center;gap:12px">
                    <img src="/public/images/logo.png" alt="logo" style="height:22px;opacity:.9"> 
                    <h3>Payment Method</h3>
                </div>
                <button class="close" aria-label="Close">&times;</button>
            </div>

            <div class="popover-body two-column">
                <div class="left-column">
                    <div class="payment-panel">
                        <h4 class="panel-title">Payment Details</h4>
                        <form class="payment-form" id="paymentForm">
                            <div class="form-row">
                                <div class="form-group small">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" required>
                                </div>
                                <div class="form-group small">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" placeholder="Street, building, apt">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group small">
                                    <label for="number">Number</label>
                                    <input type="text" id="number" name="number">
                                </div>
                                <div class="form-group small">
                                    <label for="zip">ZIP</label>
                                    <input type="text" id="zip" name="zip" placeholder="00-001">
                                </div>
                                <div class="form-group small">
                                    <label for="city">City</label>
                                    <input type="text" id="city" name="city">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select id="country" name="country">
                                        <option value="pl">Polska</option>
                                        <option value="us">United States</option>
                                        <option value="uk">United Kingdom</option>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-top:14px">
                                <div style="font-size:0.95rem;margin-bottom:8px;color:#333">Available Payment Methods</div>
                                <div class="payment-method-cards">
                                    <button type="button" class="pm-card active" data-method="card">Credit Card</button>
                                    <button type="button" class="pm-card" data-method="paypal">PayPal</button>
                                </div>
                            </div>

                            <div style="margin-top:18px;display:flex;align-items:center;gap:8px">
                                <input type="checkbox" id="agreeTerms" name="agreeTerms">
                                <label for="agreeTerms" style="font-size:0.9rem;color:#666">I agree to the <a href="#">Terms of service</a></label>
                            </div>

                            <div style="margin-top:18px;display:flex;gap:8px;justify-content:flex-end">
                                <button type="button" class="btn btn-outline" id="cancelBtn">Back</button>
                                <button type="submit" class="btn" id="placeOrderBtn" disabled>Place Your Order</button>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="right-column order-summary">
                    <div class="order-card">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                            <div style="font-size:0.95rem;color:#666">Your Order:</div>
                            <div style="font-size:0.85rem;color:#666">Country</div>
                        </div>

                        <div class="order-item">
                            <div class="item-title" id="order-plan-name">Subscription PREMIUM</div>
                            <div class="item-price" id="order-plan-price">$0.00</div>
                        </div>

                        <div class="order-addons">
                            <div class="addon">Add-on services</div>
                            <div class="addon-list">
                                <div class="addon-row"><span>ACCESS TO PREMIUM ARENA</span><span>FREE</span></div>
                                <div class="addon-row"><span>30 GENCOINS</span><span>FREE</span></div>
                                <div class="addon-row"><span>PREMIUM BADGE</span><span>FREE</span></div>
                            </div>
                        </div>

                        <div class="order-total">
                            <div>Total:</div>
                            <div class="total-amount" id="order-total">$0.00</div>
                        </div>
                    </div>
                </aside>
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

<!-- Popover Styles & Behavior -->
<style>
    /* anchored popover (appended to body) */
    .payment-popover { display: none; position: fixed; z-index: 10000; }
    .popover-content { background: #fff; border-radius: 10px; box-shadow: 0 14px 40px rgba(16,24,40,0.12); width: 920px; max-width: 94vw; overflow: hidden; transform-origin: top right; opacity: 0; transform: translateY(-6px) scale(0.98); transition: opacity .18s ease, transform .18s ease; }
    .payment-popover.show .popover-content { opacity: 1; transform: translateY(0) scale(1); }

    .popover-header { display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #f0f2f5; background:#f7fafc; }
    .popover-header.light h3 { margin:0; font-size:1.05rem; color:#111827; font-weight:600; }
    .popover-header .close { background:none; border:0; font-size:20px; cursor:pointer; color:#374151; }

    .popover-body.two-column { padding:18px; display:grid; grid-template-columns: 1fr 360px; gap:20px; max-height:75vh; overflow:auto; }

    .payment-panel { background:transparent; }
    .panel-title { font-size:1.05rem; margin:0 0 14px 0; }

    .form-row { display:flex; gap:12px; margin-bottom:12px; }
    .form-group { flex:1; display:flex; flex-direction:column; }
    .form-group.small { flex:0.9; }
    .form-group label { font-size:0.85rem; color:#374151; margin-bottom:6px; }
    .form-group input, .form-group select { padding:10px 12px; border:1px solid #e6eef6; border-radius:8px; background:#fff; font-size:0.95rem; }

    .payment-method-cards { display:flex; gap:10px; }
    .pm-card { padding:10px 16px; border:1px solid #e6eef6; border-radius:8px; background:#fff; cursor:pointer; }
    .pm-card.active { border-color:#0ea5e9; box-shadow:0 6px 18px rgba(14,165,233,0.12); }

    .order-summary .order-card { background:#fff; border-radius:8px; padding:18px; box-shadow:0 8px 20px rgba(2,6,23,0.06); display:flex; flex-direction:column; gap:10px; }
    .order-item { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #f3f4f6; }
    .order-item .item-title { font-weight:600; color:#111827; }
    .order-item .item-price { color:#111827; font-weight:700; }
    .addon-list { margin-top:6px; }
    .addon-row { display:flex; justify-content:space-between; font-size:0.9rem; color:#6b7280; padding:4px 0; }
    .order-total { display:flex; justify-content:space-between; align-items:center; margin-top:12px; font-weight:700; font-size:1.05rem; }
    .total-amount { color:#0ea5e9; }

    .payment-popover::before { content: ''; position: absolute; width: 12px; height: 12px; background: #fff; transform: rotate(45deg); box-shadow: -3px -3px 6px rgba(0,0,0,0.04); }

    @media (max-width: 920px) { .popover-content { width: 92vw; } .popover-body.two-column { grid-template-columns: 1fr; } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popover = document.getElementById('paymentPopover');
        const closeBtn = popover.querySelector('.close');
        const cancelBtn = document.getElementById('cancelBtn');
        const subscribeBtns = document.querySelectorAll('.subscribe-btn');
        const paymentForm = document.getElementById('paymentForm');
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        const agreeTerms = document.getElementById('agreeTerms');
        const orderPlanName = document.getElementById('order-plan-name');
        const orderPlanPrice = document.getElementById('order-plan-price');
        const orderTotal = document.getElementById('order-total');
        const pmButtons = document.querySelectorAll('.pm-card');

        // Move popover to document.body so it's not clipped by containers
        if (popover && popover.parentNode !== document.body) {
            document.body.appendChild(popover);
        }

        function computePosition(button) {
            const rect = button.getBoundingClientRect();
            const pop = popover.querySelector('.popover-content');
            const popWidth = Math.min(pop.offsetWidth || 920, window.innerWidth - 20);
            let left = rect.left + (rect.width / 2) - (popWidth / 2);
            const margin = 10;
            if (left < margin) left = margin;
            if (left + popWidth > window.innerWidth - margin) left = window.innerWidth - popWidth - margin;

            // preferred top: below button, otherwise above
            let top = rect.bottom + 10; // 10px gap
            if ((window.innerHeight - rect.bottom) < pop.offsetHeight + 20) {
                top = rect.top - pop.offsetHeight - 10; // place above
            }

            return { left: left + window.scrollX, top: top + window.scrollY, arrowLeft: rect.left + rect.width/2 - left - 6 };
        }

        function showPopoverAt(button) {
            const pos = computePosition(button);
            popover.style.left = pos.left + 'px';
            popover.style.top = pos.top + 'px';
            popover.style.setProperty('--arrow-left', pos.arrowLeft + 'px');
            popover.classList.add('show');
            popover.style.display = 'block';
            popover.setAttribute('aria-hidden', 'false');
            requestAnimationFrame(() => popover.querySelector('.popover-content').classList.add('visible'));
        }

        function hidePopover() {
            popover.classList.remove('show');
            popover.style.display = 'none';
            popover.setAttribute('aria-hidden', 'true');
            paymentForm.reset();
            placeOrderBtn.disabled = true;
            // reset active method
            pmButtons.forEach(b => b.classList.remove('active'));
            if (pmButtons[0]) pmButtons[0].classList.add('active');
        }

        function setOrder(plan, price, periodLabel) {
            orderPlanName.textContent = plan.charAt(0).toUpperCase() + plan.slice(1) + ' Plan';
            const formatted = '$' + parseFloat(price).toFixed(2) + (periodLabel ? ('/' + periodLabel) : '');
            orderPlanPrice.textContent = formatted;
            orderTotal.textContent = formatted;
        }

        subscribeBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const plan = this.getAttribute('data-plan');
                const price = this.getAttribute('data-price');
                const period = (plan === 'yearly') ? 'year' : 'month';
                setOrder(plan, price, period);
                showPopoverAt(this);
                currentAnchor = this;
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

        // Payment method buttons
        pmButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                pmButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Terms checkbox enables Place Order
        agreeTerms.addEventListener('change', function() {
            placeOrderBtn.disabled = !this.checked;
        });

        // Form submission (placeholder)
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const method = document.querySelector('.pm-card.active')?.getAttribute('data-method') || 'card';
            if (!agreeTerms.checked) {
                alert('Please agree to the terms of service.');
                return;
            }
            if (method === 'paypal') {
                window.location.href = 'https://www.paypal.com/checkoutnow?token=TEST';
                return;
            }
            alert('Order placed — (placeholder).');
            hidePopover();
        });

        // Close on Escape and reposition on resize/scroll
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') hidePopover();
        });
        let currentAnchor = null;
        window.addEventListener('resize', function(){ if (popover.style.display === 'block' && currentAnchor) showPopoverAt(currentAnchor); });
        window.addEventListener('scroll', function(){ if (popover.style.display === 'block' && currentAnchor) showPopoverAt(currentAnchor); }, true);
    });
</script>