<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Project</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            font-family: 'Segoe UI', sans-serif;
            color: #f8f5f0;
            background: linear-gradient(rgba(45,27,20,.55), rgba(45,27,20,.55)),
                        linear-gradient(135deg, #3e2723 0%, #5d4037 45%, #8d6e63 100%);
        }

        /* ─── RAK BUKU ─── */
        .shelf-track {
            position: fixed;
            bottom: 10px;
            left: 0;
            display: flex;
            align-items: flex-end;
            flex-wrap: nowrap;
            animation: moveShelf 28s linear infinite;
            z-index: 0;
            pointer-events: none;
        }

        @keyframes moveShelf {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        .shelf-floor {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 10px;
            background: rgba(30, 15, 8, 0.6);
            z-index: 0;
            pointer-events: none;
        }

        .book {
            display: inline-block;
            flex-shrink: 0;
            border-radius: 2px 3px 3px 2px;
        }

        /* ─── LANDING CONTENT ─── */
        .landing-container {
            text-align: center;
            max-width: 700px;
            padding: 50px 40px;
            position: relative;
            z-index: 1;
        }

        .library-icon {
            width: 90px;
            height: 90px;
            margin: auto;
            border-radius: 20px;
            background: linear-gradient(135deg, #d4a017, #f6d365);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.7rem;
            color: #2d1b14;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(212,160,23,.3);
        }

        .welcome-text {
            color: #d4a017;
            font-size: .95rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.1;
        }

        .subtitle {
            color: #d6d3d1;
            font-size: 1.1rem;
            margin-bottom: 40px;
            line-height: 1.7;
        }

        .btn-group-custom {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-login {
            background: #d4a017;
            color: #2d1b14;
            border: none;
            padding: 14px 34px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: .25s;
        }

        .btn-login:hover {
            background: #f6d365;
            transform: translateY(-2px);
            color: #2d1b14;
        }

        .btn-register {
            border: 1.5px solid #d4a017;
            color: #f8f5f0;
            padding: 14px 34px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: .25s;
        }

        .btn-register:hover {
            background: #d4a017;
            color: #2d1b14;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            h1 { font-size: 2.7rem; }
            .subtitle { font-size: 1rem; }
            .landing-container { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <!-- RAK BUKU: diisi oleh JavaScript di bawah -->
    <div class="shelf-track" id="shelfTrack"></div>
    <div class="shelf-floor"></div>

    <div class="landing-container">
        <div class="library-icon">
            <i class="bi bi-book-half"></i>
        </div>

        <div class="welcome-text">Welcome To</div>

        <h1>Digital Library</h1>

        <p class="subtitle">
            Explore knowledge, discover books, and experience
            a modern digital library with elegant design and
            comfortable reading experience.
        </p>

        <div class="btn-group-custom">
            <a href="{{ route('login') }}" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </a>
            <a href="{{ route('register') }}" class="btn-register">
                <i class="bi bi-person-plus me-2"></i>Register
            </a>
        </div>
    </div>

    <!-- SCRIPT: tepat sebelum </body>, SETELAH semua div ditutup -->
    <script>
        // Warna kayu: coklat muda, coklat tua, krem, mahoni, oak, walnut
        const WOOD_COLORS = [
            '#8B5E3C', // coklat sedang
            '#6B3A2A', // mahoni gelap
            '#A0724A', // oak terang
            '#C49A6C', // krem kayu
            '#7A4F35', // walnut
            '#B07D4E', // pine
            '#5C3317', // coklat tua
            '#D4A574', // birch terang
            '#9B6B45', // teak
            '#4A2C1A', // ebony
            '#C8906A', // cedar
            '#7C5230', // rosewood
            '#B8844E', // maple
            '#634020', // wenge
            '#E0B080', // ash terang
        ];

        const HEIGHTS = [95, 140, 65, 160, 85, 120, 150, 70, 130, 100, 165, 75, 115, 90, 145, 80, 110, 155, 60, 135];

        function buildBooks() {
            const track = document.getElementById('shelfTrack');
            const screenW = window.innerWidth;

            // Hitung lebar 1 set buku
            let oneSetWidth = 0;
            HEIGHTS.forEach((_, i) => {
                oneSetWidth += (16 + (i % 5) * 5) + 3; // width + gap
            });

            // Butuh berapa set untuk nutup 2x lebar layar (karena translateX -50%)
            const setsNeeded = Math.ceil((screenW * 2) / oneSetWidth) + 1;

            for (let repeat = 0; repeat < setsNeeded; repeat++) {
                HEIGHTS.forEach((h, i) => {
                    const book = document.createElement('div');
                    book.className = 'book';
                    const width  = 16 + (i % 5) * 5;
                    const color  = WOOD_COLORS[i % WOOD_COLORS.length];
                    // Sedikit variasi kecerahan tiap buku agar terlihat natural
                    const brightness = 0.85 + (i % 3) * 0.08;
                    book.style.cssText = `
                        width: ${width}px;
                        height: ${h}px;
                        background: ${color};
                        opacity: 0.35;
                        margin-right: 3px;
                        filter: brightness(${brightness});
                    `;
                    track.appendChild(book);
                });
            }

            // Set lebar total track = setsNeeded set, animasi ke -50% = nyambung sempurna
            track.style.width = (oneSetWidth * setsNeeded) + 'px';
        }

        buildBooks();
    </script>

</body>
</html>