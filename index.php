<?php
$launch_date = '2027-06-01 00:00:00';
$subscription_message = '';
$subscription_error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if ($email) {
        $log_file = __DIR__ . '/subscribers.txt';
        $entry    = date('Y-m-d H:i:s') . ' | ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . PHP_EOL;
        file_put_contents($log_file, $entry, FILE_APPEND | LOCK_EX);
        $subscription_message = "You're on the list! We'll notify you at launch.";
    } else {
        $subscription_error = 'Please enter a valid email address.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Hebeka Group — A diversified group of companies. Coming soon." />
    <meta name="robots" content="index, follow" />
    <title>Hebeka Group — Coming Soon</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #6c63ff;
            --secondary:    #ff6584;
            --accent:       #43e97b;
            --glass-bg:     rgba(255, 255, 255, 0.07);
            --glass-border: rgba(255, 255, 255, 0.15);
            --text-main:    #ffffff;
            --text-muted:   rgba(255, 255, 255, 0.65);
        }

        /* ── Base ── */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            overflow-x: hidden;
            /* Animated gradient */
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            /* Layout — min-height lets content scroll freely when taller than viewport */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        @keyframes gradientShift {
            0%   { background-position: 0%   50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0%   50%; }
        }

        /* ── Bubble canvas ── */
        #bubble-canvas {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        /* ── Card ── */
        .card {
            position: relative;
            z-index: 1;
            width: min(720px, 92vw);
            margin: auto;
            padding: 3.5rem 3rem;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.45),
                0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            text-align: center;
        }

        /* ── Logo ── */
        .logo-wrap {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 52px; height: 52px;
            flex-shrink: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            animation: iconPulse 3s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% { box-shadow: 0 4px 20px rgba(108, 99, 255, 0.5); }
            50%       { box-shadow: 0 4px 42px rgba(108, 99, 255, 0.9); }
        }

        .logo-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            background: linear-gradient(90deg, #fff 0%, #c3bfff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Tag ── */
        .tag {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 999px;
            background: rgba(108, 99, 255, 0.25);
            border: 1px solid rgba(108, 99, 255, 0.5);
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #c3bfff;
            margin-bottom: 1.5rem;
        }

        /* ── Headline ── */
        h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2.2rem, 6vw, 3.8rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.1rem;
            background: linear-gradient(135deg, #ffffff 0%, #a8a0ff 60%, #ff6584 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sub {
            font-size: clamp(0.9rem, 2.2vw, 1.05rem);
            color: var(--text-muted);
            max-width: 520px;
            margin: 0 auto 2.5rem;
            line-height: 1.75;
        }

        /* ── Countdown — CSS Grid keeps all 4 blocks in one row ── */
        .countdown {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto 1fr auto 1fr;
            align-items: start;
            gap: 0.5rem;
            margin-bottom: 2.8rem;
        }

        .cd-block {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cd-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.6rem, 4.5vw, 2.8rem);
            font-weight: 700;
            line-height: 1;
            width: 100%;
            padding: 0.65rem 0.4rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            position: relative;
            overflow: hidden;
            /* gradient text */
            color: transparent;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(135deg, #fff, #a8a0ff);
            /* we need the box bg separately */
            box-shadow: inset 0 0 0 1px var(--glass-border),
                        inset 0 0 30px rgba(108, 99, 255, 0.12);
        }

        /* override: can't apply background-color and background-image together easily */
        .cd-value {
            background: linear-gradient(135deg, #fff, #a8a0ff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cd-box {
            width: 100%;
            padding: 0.65rem 0.4rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--glass-border);
            border-radius: 14px;
            box-shadow: inset 0 0 28px rgba(108, 99, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cd-num {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.6rem, 4.5vw, 2.7rem);
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #fff 0%, #a8a0ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cd-label {
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 0.5rem;
            font-weight: 600;
        }

        .cd-sep {
            align-self: flex-start;
            padding-top: 0.55rem;
            font-size: clamp(1.4rem, 3.5vw, 2.2rem);
            font-weight: 700;
            color: var(--primary);
            opacity: 0.7;
            animation: blink 1s step-end infinite;
            line-height: 1;
        }

        @keyframes blink { 50% { opacity: 0; } }

        /* ── Progress ── */
        .progress-wrap { margin-bottom: 2rem; }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .progress-bar {
            width: 100%; height: 6px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 35%;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            background-size: 200% 100%;
            border-radius: 999px;
            animation: progressShimmer 2.5s linear infinite;
        }

        @keyframes progressShimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ── Email form ── */
        .notify-form {
            display: flex;
            gap: 0.6rem;
            max-width: 460px;
            margin: 0 auto 1rem;
        }

        .notify-form input[type="email"] {
            flex: 1 1 0;
            min-width: 0;
            padding: 0.85rem 1.2rem;
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            background: rgba(255, 255, 255, 0.09);
            color: #fff;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .notify-form input[type="email"]::placeholder { color: rgba(255, 255, 255, 0.38); }

        .notify-form input[type="email"]:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.25);
        }

        .notify-form button {
            flex: 0 0 auto;
            padding: 0.85rem 1.5rem;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, var(--primary), #9b59b6);
            color: #fff;
            font-size: 0.92rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            white-space: nowrap;
        }

        .notify-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(108, 99, 255, 0.45);
        }

        .notify-form button:active { transform: translateY(0); }

        /* ── Alert messages ── */
        .msg-success, .msg-error {
            font-size: 0.88rem;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.8rem;
            display: inline-block;
        }

        .msg-success {
            background: rgba(67, 233, 123, 0.15);
            border: 1px solid rgba(67, 233, 123, 0.4);
            color: #43e97b;
        }

        .msg-error {
            background: rgba(255, 101, 132, 0.15);
            border: 1px solid rgba(255, 101, 132, 0.4);
            color: #ff6584;
        }

        /* ── Divider ── */
        .divider {
            width: 60px; height: 2px;
            margin: 2rem auto;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 4px;
            opacity: 0.5;
        }

        /* ── Feature pills ── */
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            justify-content: center;
            margin-bottom: 2.2rem;
        }

        .feature-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .feature-pill i { font-size: 0.73rem; color: var(--primary); }

        /* ── Socials ── */
        .socials {
            display: flex;
            justify-content: center;
            gap: 0.85rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .socials a {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid var(--glass-border);
            color: var(--text-muted);
            font-size: 1rem;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, transform 0.2s, box-shadow 0.2s;
        }

        .socials a:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 99, 255, 0.4);
        }

        /* ── Footer ── */
        footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 1.5rem 1rem 2rem;
            color: rgba(255, 255, 255, 0.28);
            font-size: 0.78rem;
        }

        footer a { color: rgba(255, 255, 255, 0.4); text-decoration: none; }
        footer a:hover { color: rgba(255, 255, 255, 0.7); }

        /* ════════════════════════════════════════
           MOBILE  ≤ 600px
        ════════════════════════════════════════ */
        @media (max-width: 600px) {
            body { padding: 1.5rem 0; }

            .card { padding: 2rem 1.25rem; }

            .logo-icon { width: 44px; height: 44px; font-size: 1.25rem; }
            .logo-text { font-size: 1.15rem; }

            /* Countdown: hide separators, keep 4-column grid */
            .cd-sep { display: none; }

            .countdown {
                grid-template-columns: repeat(4, 1fr);
                gap: 0.4rem;
            }

            .cd-box { padding: 0.55rem 0.2rem; border-radius: 10px; }
            .cd-label { font-size: 0.58rem; margin-top: 0.4rem; }

            /* Form: stack input above button */
            .notify-form {
                flex-direction: column;
                max-width: 100%;
            }

            .notify-form input[type="email"],
            .notify-form button {
                width: 100%;
                flex: none;
            }

            /* Pills: allow 2-per-row */
            .feature-pill {
                font-size: 0.73rem;
                padding: 0.4rem 0.75rem;
            }

            .sub { font-size: 0.92rem; }
        }

        /* ── Very small phones ≤ 360px ── */
        @media (max-width: 360px) {
            .card { padding: 1.75rem 1rem; }
            h1 { font-size: 1.9rem; }
        }
    </style>
</head>
<body>

<canvas id="bubble-canvas"></canvas>

<main class="card" role="main">

    <!-- Logo -->
    <div class="logo-wrap">
        <div class="logo-icon" aria-hidden="true">
            <i class="fa-solid fa-hexagon-nodes" style="color:#fff;"></i>
        </div>
        <span class="logo-text">HEBEKA GROUP</span>
    </div>

    <!-- Status pill -->
    <div class="tag">
        <i class="fa-solid fa-circle-dot" style="font-size:0.6em;margin-right:5px;color:#43e97b;"></i>
        Something big is coming
    </div>

    <!-- Headline -->
    <h1>We're Building<br>the Future</h1>

    <p class="sub">
        Hebeka Group is a forward-thinking consortium of companies spanning multiple industries.
        Our full platform launches soon — and we can't wait to show you what we've built.
    </p>

    <!-- Countdown -->
    <div class="countdown" id="countdown" aria-label="Countdown to launch">
        <div class="cd-block">
            <div class="cd-box"><span class="cd-num" id="cd-days">--</span></div>
            <div class="cd-label">Days</div>
        </div>
        <div class="cd-sep" aria-hidden="true">:</div>
        <div class="cd-block">
            <div class="cd-box"><span class="cd-num" id="cd-hours">--</span></div>
            <div class="cd-label">Hours</div>
        </div>
        <div class="cd-sep" aria-hidden="true">:</div>
        <div class="cd-block">
            <div class="cd-box"><span class="cd-num" id="cd-mins">--</span></div>
            <div class="cd-label">Mins</div>
        </div>
        <div class="cd-sep" aria-hidden="true">:</div>
        <div class="cd-block">
            <div class="cd-box"><span class="cd-num" id="cd-secs">--</span></div>
            <div class="cd-label">Secs</div>
        </div>
    </div>

    <!-- Progress bar -->
    <div class="progress-wrap">
        <div class="progress-label">
            <span><i class="fa-solid fa-code-branch" style="margin-right:4px;"></i>Development Progress</span>
            <span>35%</span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
    </div>

    <!-- Subscription form -->
    <?php if ($subscription_message): ?>
        <div class="msg-success" role="alert">
            <i class="fa-solid fa-circle-check" style="margin-right:6px;"></i>
            <?= htmlspecialchars($subscription_message, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php elseif ($subscription_error): ?>
        <div class="msg-error" role="alert">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:6px;"></i>
            <?= htmlspecialchars($subscription_error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (!$subscription_message): ?>
    <form class="notify-form" method="POST" action="" novalidate>
        <input
            type="email"
            name="email"
            placeholder="Enter your email address"
            aria-label="Email address"
            required
            autocomplete="email"
        />
        <button type="submit">
            <i class="fa-solid fa-bell"></i> Notify Me
        </button>
    </form>
    <?php endif; ?>

    <div class="divider" aria-hidden="true"></div>

    <!-- Feature pills -->
    <div class="features" aria-label="What we're building">
        <div class="feature-pill"><i class="fa-solid fa-building-columns"></i> Multi-Industry Holdings</div>
        <div class="feature-pill"><i class="fa-solid fa-globe"></i> 10+ Group Companies</div>
        <div class="feature-pill"><i class="fa-solid fa-chart-line"></i> Strategic Investments</div>
        <div class="feature-pill"><i class="fa-solid fa-shield-halved"></i> Trusted &amp; Compliant</div>
        <div class="feature-pill"><i class="fa-solid fa-handshake"></i> Partnership-Driven</div>
    </div>

    <!-- Social links -->
    <div class="socials" aria-label="Social media links">
        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="#" aria-label="X / Twitter"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
    </div>

</main>

<footer>
    <p>
        &copy; <?= date('Y') ?> Hebeka Group &mdash; All rights reserved
        &nbsp;|&nbsp;
        <a href="mailto:info@hebekagroup.com">info@hebekagroup.com</a>
    </p>
</footer>

<script>
// ── Countdown ──
(function () {
    const launch = new Date('<?= $launch_date ?>').getTime();

    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        const diff = launch - Date.now();

        if (diff <= 0) {
            ['days','hours','mins','secs'].forEach(id => {
                document.getElementById('cd-' + id).textContent = '00';
            });
            return;
        }

        document.getElementById('cd-days').textContent  = pad(Math.floor(diff / 86400000));
        document.getElementById('cd-hours').textContent = pad(Math.floor((diff % 86400000) / 3600000));
        document.getElementById('cd-mins').textContent  = pad(Math.floor((diff % 3600000) / 60000));
        document.getElementById('cd-secs').textContent  = pad(Math.floor((diff % 60000) / 1000));
    }

    tick();
    setInterval(tick, 1000);
})();

// ── Floating bubbles ──
(function () {
    const canvas = document.getElementById('bubble-canvas');
    const ctx    = canvas.getContext('2d');
    const COLORS = ['#6c63ff','#ff6584','#43e97b','#f7971e','#38f9d7','#a78bfa'];

    function resize() {
        canvas.width  = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const bubbles = Array.from({ length: 22 }, makeBubble);

    function makeBubble() {
        return {
            x:     Math.random() * window.innerWidth,
            y:     Math.random() * window.innerHeight + window.innerHeight,
            r:     20 + Math.random() * 60,
            dx:    (Math.random() - 0.5) * 0.5,
            dy:    -(0.4 + Math.random() * 0.7),
            alpha: 0.06 + Math.random() * 0.12,
            color: COLORS[Math.floor(Math.random() * COLORS.length)],
        };
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        for (const b of bubbles) {
            const g = ctx.createRadialGradient(b.x - b.r * 0.3, b.y - b.r * 0.3, b.r * 0.1, b.x, b.y, b.r);
            g.addColorStop(0, b.color + 'cc');
            g.addColorStop(1, b.color + '00');

            ctx.beginPath();
            ctx.arc(b.x, b.y, b.r, 0, Math.PI * 2);
            ctx.fillStyle   = g;
            ctx.globalAlpha = b.alpha;
            ctx.fill();
            ctx.globalAlpha = 1;

            b.x += b.dx;
            b.y += b.dy;

            if (b.y + b.r < 0) {
                b.x = Math.random() * canvas.width;
                b.y = canvas.height + b.r;
            }
        }
        requestAnimationFrame(draw);
    }

    draw();
})();
</script>

</body>
</html>
