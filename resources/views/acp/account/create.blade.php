<x-app-layout>
    <x-slot name="header"><h2>إضافة حساب</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto px-4"><div class="bg-white rounded-lg p-6 shadow-sm">
        <x-auth-validation-errors class="alert" :errors="$errors" />
        <form method="POST" action="{{ route('acp.account.store') }}" class="grid gap-5">@csrf
            <div><label for="name">اسم الحساب</label><input id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="مثال: المحفظة أو الحساب البنكي"></div>
            <div class="flex justify-end gap-3"><a class="btn-light px-5 py-2" href="{{ route('acp.account.index') }}">إلغاء</a><button class="btn-ms" type="submit">حفظ الحساب</button></div>
        </form>
    </div></div></div>
</x-app-layout>
