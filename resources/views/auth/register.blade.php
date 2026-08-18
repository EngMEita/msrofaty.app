<x-guest-layout>
    <x-auth-card>
        <p class="auth-intro">أنشئ مساحة مالية مشتركة لأسرتك وابدأوا شهرًا أوضح</p>
        <x-auth-validation-errors class="alert" :errors="$errors" />
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div><x-label for="name" value="الاسم" /><x-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="اكتب اسمك" /></div>
            <div><x-label for="email" value="البريد الإلكتروني" /><x-input id="email" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="name@example.com" /></div>
            <div><x-label for="password" value="كلمة المرور" /><x-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="٨ أحرف على الأقل" /></div>
            <div><x-label for="password_confirmation" value="تأكيد كلمة المرور" /><x-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="أعد كتابة كلمة المرور" /></div>
            <button type="submit">إنشاء حساب الأسرة</button>
            <div class="auth-footer"><span>لديك حساب بالفعل؟</span><a href="{{ route('login') }}">تسجيل الدخول</a></div>
        </form>
    </x-auth-card>
</x-guest-layout>
