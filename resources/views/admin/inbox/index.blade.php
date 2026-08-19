<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages — Admin</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap">
    <style>
        :root {
            --white: #FBFBFE;
            --white-soft: #F1F3FA;
            --ink: #0A0E17;
            --ink-soft: #121A2B;
            --blue: #2F5DFF;
            --blue-deep: #1836B2;
            --cyan: #38E1FF;
            --text-dark: #10131C;
            --text-mid: #4B5468;
            --text-soft: #7A8299;
            --line: rgba(16, 19, 28, 0.09);
            --display: 'Space Grotesk', sans-serif;
            --body: 'Inter', sans-serif;
            --mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: var(--body);
            background: var(--white-soft);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .topbar {
            background: var(--ink);
            color: #fff;
            padding: 20px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            font-family: var(--mono);
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .brand span {
            color: var(--cyan);
        }

        .topbar__sub {
            font-family: var(--mono);
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .wrap {
            max-width: 720px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        h1 {
            font-family: var(--display);
            font-size: 1.7rem;
            margin: 0 0 6px;
        }

        .lede {
            color: var(--text-mid);
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        .conv {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 20px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            margin-bottom: 12px;
            text-decoration: none;
            color: var(--text-dark);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .conv:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 34px rgba(16, 19, 28, 0.08);
            border-color: rgba(47, 93, 255, 0.25);
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: var(--display);
            font-weight: 600;
            font-size: 1rem;
        }

        .conv__body {
            flex: 1;
            min-width: 0;
        }

        .conv__name {
            font-weight: 600;
            font-size: 0.98rem;
        }

        .conv__preview {
            color: var(--text-soft);
            font-size: 0.88rem;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .conv__meta {
            text-align: right;
            flex-shrink: 0;
        }

        .badge {
            background: var(--blue);
            color: #fff;
            border-radius: 100px;
            padding: 2px 10px;
            font-size: 0.72rem;
            font-family: var(--mono);
            font-weight: 600;
            display: inline-block;
            margin-bottom: 6px;
        }

        .time {
            font-family: var(--mono);
            font-size: 0.72rem;
            color: var(--text-soft);
        }

        .empty {
            background: #fff;
            border: 1px dashed var(--line);
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            color: var(--text-mid);
            font-size: 0.95rem;
        }

        @media (max-width: 600px) {
            .topbar{ padding:16px 20px; }
            .wrap{ padding:28px 16px 60px; }
            h1{ font-size:1.4rem; }
            .conv{ padding:14px 16px; gap:12px; }
            .avatar{ width:38px; height:38px; font-size:0.9rem; }
            .conv__preview{ font-size:0.82rem; }
        }

    </style>
</head>

<body>

    <div class="topbar">
        <div class="brand"><span>{</span>HTJ<span>}</span></div>
        <div class="topbar__sub">Espace admin — Portfolio Messagerie</div>
    </div>

    <div class="wrap">
        <h1>Messages reçus</h1>
        <p class="lede">Toutes les conversations démarrées depuis ton portfolio.</p>

        @forelse($conversations as $conv)
            <a class="conv" href="{{ route('admin.inbox.show', $conv->visitor_id) }}">
                <div class="avatar">{{ strtoupper(substr($conv->visitor_name, 0, 1)) }}</div>
                <div class="conv__body">
                    <div class="conv__name">{{ $conv->visitor_name }}</div>
                    <div class="conv__preview">{{ \Illuminate\Support\Str::limit($conv->last_message, 70) }}</div>
                </div>
                <div class="conv__meta">
                    @if($conv->unread > 0)
                        <div class="badge">{{ $conv->unread }} nouveau{{ $conv->unread > 1 ? 'x' : '' }}</div>
                    @endif
                    <div class="time">{{ \Carbon\Carbon::parse($conv->last_message_at)->diffForHumans() }}</div>
                </div>
            </a>
        @empty
            <div class="empty">Aucun message pour l'instant. Dès qu'un visiteur t'écrit depuis le portfolio, ça apparaîtra
                ici.</div>
        @endforelse
    </div>

</body>

</html>
