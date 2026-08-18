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
        :root{--ms-ink:#12221f;--ms-muted:#6d7d78;--ms-bg:#f6f8f3;--ms-card:#fff;--ms-green:#174b43;--ms-mint:#d9f1e4;--ms-orange:#f9a45b;--ms-line:#e3ebe5;--ms-shadow:0 14px 40px rgba(18,34,31,.08)}
        html,body{background:var(--ms-bg)!important;color:var(--ms-ink)!important;font-family:'IBM Plex Sans Arabic','Cairo','Nunito',sans-serif!important}body{direction:rtl}.min-h-screen{background:var(--ms-bg)!important}
        nav.bg-white{background:rgba(255,255,255,.96)!important;border-bottom:1px solid var(--ms-line)!important;box-shadow:0 4px 18px rgba(18,34,31,.05)}nav .text-gray-600,nav .text-gray-500{color:#52635e!important}nav a:hover{color:var(--ms-green)!important}nav .fill-current{color:var(--ms-green)!important}
        header.bg-white{background:transparent!important;box-shadow:none!important;border:0!important}header .max-w-7xl{padding-top:28px;padding-bottom:22px}header h2{font-family:'Cairo',sans-serif;font-weight:800;color:var(--ms-ink);font-size:24px}
        main{color:var(--ms-ink)}main .bg-white{background:var(--ms-card)!important;border:1px solid var(--ms-line);border-radius:18px;box-shadow:var(--ms-shadow)!important}main table{border-collapse:separate;border-spacing:0;width:100%;overflow:hidden}main th{background:#f2f7f3;color:#52635e;font-size:12px;font-weight:800;padding:13px;text-align:right}main td{border-bottom:1px solid #eef3ef;padding:13px;font-size:13px;color:#40534e}main tr:last-child td{border-bottom:0}
        input,select,textarea{border:1px solid var(--ms-line)!important;border-radius:11px!important;background:#fff!important;color:var(--ms-ink)!important;min-height:42px;padding:8px 12px!important}input:focus,select:focus,textarea:focus{border-color:#70ad91!important;box-shadow:0 0 0 3px var(--ms-mint)!important;outline:0!important}.bg-gray-800,.bg-indigo-600{background:var(--ms-green)!important}.bg-gray-800:hover,.bg-indigo-600:hover{background:#0d3932!important}.text-gray-700{color:#40534e!important}.text-gray-600{color:var(--ms-muted)!important}.border-gray-200,.border-gray-300{border-color:var(--ms-line)!important}
        label{display:block;color:#40534e;font-size:13px;font-weight:700;margin-bottom:7px}.btn-ms{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:11px;padding:10px 18px;background:var(--ms-green);color:#fff;font-weight:700}.btn-ms:hover{background:#0d3932;color:#fff;transform:translateY(-1px)}.btn-light{display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--ms-line);border-radius:11px;background:#fff;color:var(--ms-green);font-weight:700}.btn-light:hover{background:var(--ms-mint);color:var(--ms-green)}.btn,.btn-primary{border-radius:11px}.alert-success{background:var(--ms-mint)!important;color:var(--ms-green)!important;border-color:#b9dfc9!important}.pagination{gap:4px}.pagination .page-link{border:1px solid var(--ms-line);color:var(--ms-green);border-radius:8px!important}.pagination .active .page-link{background:var(--ms-green);border-color:var(--ms-green);color:#fff}
        @media(max-width:640px){header .max-w-7xl{padding-top:18px;padding-bottom:14px}header h2{font-size:20px}main .p-6{padding:16px!important}main table{display:block;overflow-x:auto;white-space:nowrap}}
    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.rtl.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dc2NSrAXbAkjrdm9IYrX10fQq9SDG6Vjz7nQVKdKcJl3pC+k37e7qJR5MVSCS+wR" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
