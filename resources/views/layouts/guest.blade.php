<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>مصروفاتي</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            :root{--ink:#12221f;--muted:#71817b;--green:#174b43;--mint:#d9f1e4;--line:#e3ebe5;--cream:#f6f8f3}
            html,body{margin:0;min-height:100%;background:var(--cream);font-family:'IBM Plex Sans Arabic','Cairo',sans-serif;color:var(--ink)}
            .auth-shell{min-height:100vh;display:grid;place-items:center;padding:28px 16px;background:radial-gradient(circle at 12% 8%,#d9f1e4 0,transparent 28%),radial-gradient(circle at 90% 90%,#ffe7ce 0,transparent 25%),var(--cream)}
            .auth-card{width:min(100%,450px);background:#fff;border:1px solid var(--line);border-radius:26px;padding:34px;box-shadow:0 22px 65px rgba(18,34,31,.12)}
            .auth-brand{display:flex;align-items:center;justify-content:center;gap:10px;margin:0 0 28px;color:var(--green);font:800 25px Cairo,sans-serif}.auth-brand-mark{width:43px;height:43px;border-radius:14px;display:grid;place-items:center;background:var(--green);color:#fff;font:700 22px Arial}
            .auth-card form{display:grid;gap:16px}.auth-card form>div{margin:0!important}.auth-card label{display:block;margin:0 0 7px;color:#38504a;font-size:13px;font-weight:700}.auth-card input{display:block;width:100%;height:47px;padding:0 14px;border:1px solid var(--line);border-radius:12px;background:#fbfdfb;color:var(--ink);font:14px inherit;outline:0;transition:.2s}.auth-card input:focus{border-color:#70ad91;box-shadow:0 0 0 4px var(--mint);background:#fff}.auth-card button{display:flex;width:100%;height:47px;align-items:center;justify-content:center;border:0;border-radius:12px;background:var(--green);color:#fff;font:700 14px 'IBM Plex Sans Arabic',sans-serif;cursor:pointer;transition:.2s}.auth-card button:hover{background:#0e3932;transform:translateY(-1px)}.auth-card .auth-footer{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:4px;color:var(--muted);font-size:13px}.auth-card .auth-footer a{color:var(--green);font-weight:700;text-decoration:none}.auth-card .auth-intro{text-align:center;color:var(--muted);font-size:13px;margin:-15px 0 22px}.auth-card .alert{padding:11px 13px;border-radius:11px;background:#fff0e4;color:#9a5529;font-size:13px}
            @media(max-width:480px){.auth-card{padding:25px 19px;border-radius:20px}}
        </style>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased auth-shell">
            {{ $slot }}
        </div>
    </body>
</html>
