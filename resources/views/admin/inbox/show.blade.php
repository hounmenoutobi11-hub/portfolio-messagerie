<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation — Admin</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap">
    <style>
        :root {
            --white: #FBFBFE;
            --white-soft: #F1F3FA;
            --ink: #0A0E17;
            --blue: #2F5DFF;
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
        }

        .brand span {
            color: var(--cyan);
        }

        .back {
            font-family: var(--mono);
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
        }

        .back:hover {
            color: var(--cyan);
        }

        .wrap {
            max-width: 640px;
            margin: 0 auto;
            padding: 36px 24px 40px;
        }

        h1 {
            font-family: var(--display);
            font-size: 1.4rem;
            margin: 0 0 20px;
        }

        #thread {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 24px;
            min-height: 160px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 22px;
        }

        .msg {
            padding: 10px 15px;
            border-radius: 14px;
            max-width: 78%;
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .visitor {
            background: var(--white-soft);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .admin {
            background: var(--blue);
            color: #fff;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        textarea {
            flex: 1;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid var(--line);
            font-family: inherit;
            font-size: 0.92rem;
            resize: vertical;
            min-height: 48px;
            background: #fff;
        }

        textarea:focus {
            outline: none;
            border-color: var(--blue);
        }

        button {
            padding: 0 22px;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: var(--ink);
            color: #fff;
            cursor: pointer;
            font-weight: 600;
            font-family: var(--mono);
            font-size: 0.85rem;
        }

        button:hover {
            background: #000;
        }

        @media (max-width: 600px) {
            .topbar{ padding:16px 20px; }
            .wrap{ padding:28px 16px 40px; }
            h1{ font-size:1.25rem; }
            #thread{ padding:16px; }
            .msg{ max-width:88%; font-size:0.88rem; }
            form{ flex-direction:column; align-items:stretch; }
            button{ width:100%; }
        }

    </style>
</head>

<body>

    <div class="topbar">
        <div class="brand"><span>{</span>HTJ<span>}</span></div>
        <a class="back" href="{{ route('admin.inbox.index') }}">← Retour aux messages</a>
    </div>

    <div class="wrap">
        <h1>Conversation</h1>

        <div id="thread">
            @foreach($messages as $m)
                <div class="msg {{ $m->sender }}">{{ $m->body }}</div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('admin.inbox.reply', $visitorId) }}">
            @csrf
            <textarea name="body" placeholder="Répondre…" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <script>
        const visitorId = @json($visitorId);
        const thread = document.getElementById('thread');

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        async function poll() {
            try {
                const res = await fetch(`/admin/inbox/${visitorId}/poll`);
                const messages = await res.json();
                thread.innerHTML = messages.map(m =>
                    `<div class="msg ${m.sender}">${escapeHtml(m.body)}</div>`
                ).join('');
                thread.scrollTop = thread.scrollHeight;
            } catch (e) { console.error('poll error', e); }
        }
        setInterval(poll, 4000);
    </script>
</body>

</html>
