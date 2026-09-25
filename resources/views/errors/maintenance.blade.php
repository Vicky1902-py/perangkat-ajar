<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Dalam Pengembangan - {{ app_setting('app_name', 'Perangkat Ajar Pintar') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap');
        
        :root {
            --primary: {{ app_setting('theme_primary_color', '#2563eb') }};
            --accent-cyan: {{ app_setting('theme_accent_cyan', '#38bdf8') }};
            --accent-indigo: {{ app_setting('theme_accent_indigo', '#6366f1') }};
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: #0f172a;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Particles */
        .bg-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            display: block;
            pointer-events: none;
            width: 5px;
            height: 5px;
            background-color: var(--accent-cyan);
            box-shadow: 0 0 20px var(--accent-cyan);
            border-radius: 50%;
            animation: float-up 10s infinite linear;
            opacity: 0.5;
        }

        @keyframes float-up {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            50% { opacity: 0.8; transform: translateY(50vh) scale(1.5); }
            100% { transform: translateY(-10vh) scale(0); opacity: 0; }
        }

        /* Glassmorphism Card */
        .maintenance-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 4rem 3rem;
            max-width: 700px;
            width: 90%;
            text-align: center;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            animation: slide-up 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slide-up {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Animated Gear Icon */
        .gear-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
        }

        .gear {
            font-size: 5rem;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-indigo));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: spin 10s linear infinite;
            display: inline-block;
            line-height: 1;
        }

        .gear-small {
            font-size: 2.5rem;
            position: absolute;
            bottom: 0;
            right: 0;
            background: linear-gradient(135deg, var(--accent-indigo), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: spin-reverse 7s linear infinite;
            line-height: 1;
        }

        @keyframes spin { 100% { transform: rotate(360deg); } }
        @keyframes spin-reverse { 100% { transform: rotate(-360deg); } }

        /* Typography */
        h1 {
            font-weight: 800;
            font-size: 2.5rem;
            letter-spacing: -0.05em;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .developer-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(var(--accent-cyan), 0.1);
            border: 1px solid rgba(var(--accent-cyan), 0.2);
            padding: 0.5rem 1.25rem;
            border-radius: 100px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: var(--accent-cyan);
            margin-bottom: 2rem;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.1);
        }

        .developer-badge i {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 1; text-shadow: 0 0 10px var(--accent-cyan); }
            50% { opacity: 0.5; text-shadow: none; }
        }

        p.desc {
            font-size: 1.1rem;
            color: #cbd5e1;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        /* Buttons */
        .btn-custom {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--accent-indigo));
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
            color: white;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }
    </style>
</head>
<body>

    <!-- Animated Particles -->
    <div class="bg-particles" id="particles"></div>

    <div class="maintenance-card">
        <div class="gear-container">
            <i class="bi bi-gear-fill gear"></i>
            <i class="bi bi-gear-wide-connected gear-small"></i>
        </div>

        <div class="developer-badge">
            <i class="bi bi-terminal"></i> Sistem Dalam Pengembangan By. Vicky Koroh
        </div>

        <h1>MAINTENANCE MODE</h1>
        
        <p class="desc">
            Mohon maaf, saat ini sedang dilakukan peningkatan besar-besaran (System Upgrade) pada pangkalan data kecerdasan buatan dan struktur kurikulum untuk memberikan pengalaman yang lebih sempurna. 
            <br><br>Hanya <strong>Superadmin</strong> yang diizinkan mengakses sistem saat ini.
        </p>

        <div class="d-flex justify-content-center gap-3">
            @auth
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-custom btn-logout">
                        <i class="bi bi-box-arrow-left me-2"></i>Logout
                    </button>
                </form>
            @endauth
            
            <a href="{{ route('login') }}" class="btn btn-custom btn-login">
                <i class="bi bi-shield-lock-fill me-2"></i>Superadmin Login
            </a>
        </div>
    </div>

    <script>
        // Generate random particles
        const particlesContainer = document.getElementById('particles');
        const particleCount = 20;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Random properties
            const size = Math.random() * 5 + 2;
            const left = Math.random() * 100;
            const duration = Math.random() * 10 + 5;
            const delay = Math.random() * 10;
            
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${left}%`;
            particle.style.animationDuration = `${duration}s`;
            particle.style.animationDelay = `${delay}s`;
            
            particlesContainer.appendChild(particle);
        }
    </script>
</body>
</html>
