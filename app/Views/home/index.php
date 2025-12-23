<!-- 3D Carousel Section -->
<div class="carousel-container">
    <div class="carousel-3d" id="carousel">
        
        <!-- Card 1: Ideas -->
        <div class="carousel-item" onclick="rotateTo(0)">
            <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=2072&auto=format&fit=crop');"></div>
            <div class="card-details">
                <div>
                    <h3 class="card-title">Innovation Hub</h3>
                    <p class="card-description">Share your groundbreaking ideas, get community feedback, and find potential investors to turn your vision into reality.</p>
                    <div class="card-tags">
                        <span class="card-tag purple">Startup</span>
                        <span class="card-tag purple">Innovation</span>
                        <span class="card-tag purple">Crowdfunding</span>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/ideas" class="btn-explore">Explore Ideas</a>
            </div>
        </div>

        <!-- Card 2: Investments -->
        <div class="carousel-item" onclick="rotateTo(1)">
            <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1642543492481-44e81e3914a7?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="card-details">
                <div>
                    <h3 class="card-title highlight">Smart Investments</h3>
                    <p class="card-description">Discover high-potential startups and projects. Build your portfolio by backing the next big thing in tech.</p>
                    <div class="card-tags">
                        <span class="card-tag blue">Finance</span>
                        <span class="card-tag blue">Growth</span>
                        <span class="card-tag blue">ROI</span>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/investments" class="btn-explore">View Investments</a>
            </div>
        </div>

        <!-- Card 3: Jobs -->
        <div class="carousel-item" onclick="rotateTo(2)">
            <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=2071&auto=format&fit=crop');"></div>
            <div class="card-details">
                <div>
                    <h3 class="card-title">Career Portal</h3>
                    <p class="card-description">Find your dream job or post opportunities. Connect with top talent and innovative companies worldwide.</p>
                    <div class="card-tags">
                        <span class="card-tag green">Tech</span>
                        <span class="card-tag green">Remote</span>
                        <span class="card-tag green">Full-time</span>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/jobs" class="btn-explore">Find Offers</a>
            </div>
        </div>
        
        <!-- Card 4: Events -->
        <div class="carousel-item" onclick="rotateTo(3)">
            <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="card-details">
                <div>
                    <h3 class="card-title">Tech Events</h3>
                    <p class="card-description">Participate in workshops, hackathons, and conferences. Network with industry leaders and enhance your skills.</p>
                    <div class="card-tags">
                        <span class="card-tag purple">Meetups</span>
                        <span class="card-tag purple">Networking</span>
                        <span class="card-tag purple">Workshops</span>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/events" class="btn-explore">Join Events</a>
            </div>
        </div>

        <!-- Card 5: Blog -->
        <div class="carousel-item" onclick="rotateTo(4)">
            <div class="card-image" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop');"></div>
            <div class="card-details">
                <div>
                    <h3 class="card-title">Community Feed</h3>
                    <p class="card-description">Stay updated with the latest trends. Share your thoughts, achievements, and connect with the global community.</p>
                    <div class="card-tags">
                        <span class="card-tag blue">Social</span>
                        <span class="card-tag blue">News</span>
                        <span class="card-tag blue">Discussion</span>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/feed" class="btn-explore">Social Feed</a>
            </div>
        </div>

    </div>
</div>

<!-- Controls -->
<div class="nav-arrow nav-prev" onclick="prevSlide()">‹</div>
<div class="nav-arrow nav-next" onclick="nextSlide()">›</div>

<!-- Pagination -->
<div class="carousel-dots" id="dots">
    <div class="dot active" onclick="rotateTo(0)"></div>
    <div class="dot" onclick="rotateTo(1)"></div>
    <div class="dot" onclick="rotateTo(2)"></div>
    <div class="dot" onclick="rotateTo(3)"></div>
    <div class="dot" onclick="rotateTo(4)"></div>
</div>

<script>
let activeIndex = 1; // Start with "Quantum Cloud" (Index 1) active
const totalItems = 5;

function updateCarousel() {
    const items = document.querySelectorAll('.carousel-item');
    const dots = document.querySelectorAll('.dot');
    
    items.forEach((item, index) => {
        // Reset classes
        item.className = 'carousel-item';
        
        // Calculate difference
        let diff = index - activeIndex;
        
        // Handle wrap-around for simpler logic if needed, but for now simple linear logic
        // Circular logic for 5 items:
        // If diff is -4, it means it's the item after the last one (conceptually), but let's stick to standard indices for simplicity first.
        // Actually, let's just assign specific classes based on active index.
        
        if (index === activeIndex) {
            item.classList.add('active');
        } else if (index === (activeIndex - 1 + totalItems) % totalItems) {
            item.classList.add('prev');
        } else if (index === (activeIndex + 1) % totalItems) {
            item.classList.add('next');
        } else {
            // Determine if it should go left or right hidden
            // Simple heuristic to hide
            if (index < activeIndex) {
                item.classList.add('hide-left');
            } else {
                item.classList.add('hide-right');
            }
            // Fix circular hiding
            if (activeIndex === 0 && index === totalItems - 1) item.className = 'carousel-item prev';
            if (activeIndex === totalItems - 1 && index === 0) item.className = 'carousel-item next';
        }
    });
    
    // Update dots
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === activeIndex);
    });
}

function nextSlide() {
    activeIndex = (activeIndex + 1) % totalItems;
    updateCarousel();
}

function prevSlide() {
    activeIndex = (activeIndex - 1 + totalItems) % totalItems;
    updateCarousel();
}

function rotateTo(index) {
    activeIndex = index;
    updateCarousel();
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    updateCarousel();
});
</script>

<!-- About excerpt on home page -->
<section class="about-section">
    <div class="about-card">
        <h2><?= htmlspecialchars(FOOTER_TITLE) ?></h2>
        <p><?= htmlspecialchars(FOOTER_DESCRIPTION) ?></p>
        <p style="margin-top:12px;"><a href="#site-footer" class="btn">Learn more</a></p>
    </div>
</section>
