<div id="site-footer" class="page-footer">
    <div class="footer-inner">
        <div style="flex:1;min-width:220px;" class="footer-col">
            <h3><?= htmlspecialchars(FOOTER_TITLE) ?></h3>
            <p><?= htmlspecialchars(FOOTER_DESCRIPTION) ?></p>
            <p style="margin-top:12px;color:#9fb6c9;font-size:13px">© <?= date('Y') ?> <?= htmlspecialchars(FOOTER_TITLE) ?>. All rights reserved.</p>
        </div>

        <div class="footer-col">
            <h4 style="margin:0 0 8px 0;color:#f8fafc;font-size:15px">Explore</h4>
            <ul class="footer-links">
                <li><a href="<?= BASE_URL ?>#about">About</a></li>
                <?php
                $links = json_decode(FOOTER_LINKS_JSON, true);
                if (is_array($links)) {
                    foreach ($links as $link) {
                        $label = htmlspecialchars($link['label'] ?? 'Link');
                        $href = $link['href'] ?? '/';
                        if (strpos($href, '/') === 0) $href = BASE_URL . $href;
                        $href = htmlspecialchars($href);
                        echo "<li><a href=\"{$href}\">{$label}</a></li>";
                    }
                }
                ?>
            </ul>
        </div>

        <div class="footer-col">
            <h4 style="margin:0 0 8px 0;color:#f8fafc;font-size:15px">Contact</h4>
            <p class="footer-contact">Email: <a href="mailto:<?= htmlspecialchars(FOOTER_EMAIL) ?>"><?= htmlspecialchars(FOOTER_EMAIL) ?></a></p>
            <p class="footer-contact" style="margin-top:6px">Phone: <?= htmlspecialchars(FOOTER_PHONE) ?></p>
            <div class="footer-social" style="margin-top:12px;">
                <a href="#">🐦</a>
                <a href="#">💼</a>
                <a href="#">🔗</a>
            </div>
        </div>
    </div>
</div>
