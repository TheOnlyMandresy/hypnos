<nav id="navbar">
    <a href="/" onclick="route()"><img src="/img/hypnos.png" alt="company name" /></a>

    <div class="nav">
        <ul>
            <li>
                <p class="btn-nav">
                    <span><a href="/" onclick="route()">Nos hôtels</a></span>
                </p>
            </li>
            <li>
                <p class="btn-nav">
                    <span><a href="<?= System::getSystemInfos('url_room'); ?>s" onclick="route()">Nos chambres</a></span>
                </p>
            </li>
            <li>
                <p class="btn-nav">
                    <span><a href="/booking" onclick="route()">Faire une réservation</a></span>
                </p>
            </li>
        </ul>

        <ul>
            <?php if (!isset($_SESSION['user'])): ?>
            <li>
                <p class="btn-nav">
                    <span><a href="/login" onclick="route()">Se connecter</a></span>
                </p>
            </li>
            <li>
                <p class="btn-nav">
                    <span><a href="/register" onclick="route()">S'inscrire</a></span>
                </p>
            </li>
            <li>
                <p class="btn-nav">
                    <span><a href="/contact" onclick="route()">Nous contacter</a></span>
                </p>
            </li>
            <?php else: ?>
            <li>
                <p class="btn-nav">
                    <span><a href="/reservations" onclick="route()">Mes réservations</a></span>
                </p>
            </li>
            <li>
                <p class="btn-nav">
                    <span><a href="/support" onclick="route()">assistant</a></span>
                </p>
            </li>
            <li>
                <p class="btn-danger xl">
                    <span><a href="/logout" onclick="route()">déconnexion</a></span>
                </p>
            </li>
            <?php endif; ?>
        </ul>
        
        <?php if (isset($_SESSION['user']) && $myDatas->rank > 0): ?>
        <ul>
            <li>
                <p class="btn-nav <?php if ($myDatas->rank == 1) echo 'disabled'; ?>">
                    <span><a href="/admin/team" onclick="route()">équipe</a></span>
                </p>
            </li>
            <li>
                <p class="btn-nav">
                    <span><a href="/admin/views" onclick="route()">Hôtels/Suites</a></span>
                </p>
            </li>
            <li>
                <p class="btn-nav <?php if ($myDatas->rank == 1) echo 'disabled'; ?>">
                    <span><a href="/admin/support" onclick="route()">Support</a></span>
                </p>
            </li>
        </ul>
        <?php endif; ?>
    </div>
</nav>

<div class="logo">
    <div class="img">
        <img src="/img/logo.png" alt="logo" />
    </div>
</div>