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
                <a href="<?= BASE_URL ?>/payment?plan=monthly&price=20" class="btn">Subscribe Now</a>
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
                <a href="<?= BASE_URL ?>/payment?plan=yearly&price=100" class="btn">Subscribe Now</a>
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