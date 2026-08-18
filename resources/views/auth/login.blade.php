<x-guest-layout>
    <x-auth-card>
        <p class="auth-intro">أهلًا بك من جديد — بيتك المالي في انتظارك</p>
        <x-auth-session-status class="alert" :status="session('status')" />
        <x-auth-validation-errors class="alert" :errors="$errors" />
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div><x-label for="email" value="البريد الإلكتروني" /><x-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" /></div>
            <div><x-label for="password" value="كلمة المرور" /><x-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="اكتب كلمة المرور" /></div>
            <label style="display:flex!important;align-items:center;gap:8px;color:#71817b!important;font-size:12px!important"><input type="checkbox" name="remember" style="width:17px!important;height:17px!important;min-height:17px!important;margin:0;padding:0!important"> تذكرني على هذا الجهاز</label>
            <button type="submit">تسجيل الدخول</button>
            <div class="auth-footer">@if(Route::has('password.request'))<a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a><span>·</span>@endif<a href="{{ route('register') }}">إنشاء حساب جديد</a></div>
        </form>
    </x-auth-card>
</x-guest-layout>
