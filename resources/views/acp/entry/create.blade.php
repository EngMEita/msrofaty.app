<x-app-layout>
    <x-slot name="header"><div><span class="badge-ms">المعاملات</span><h2 class="mt-2">إضافة عملية جديدة</h2></div></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto px-4"><div class="bg-white rounded-lg p-6 shadow-sm"><p class="text-gray-500 mb-6">سجل العملية الآن، وبعد الحفظ يمكنك إضافة تفاصيل الحساب والتصنيف.</p><x-auth-validation-errors class="alert" :errors="$errors" /><form method="POST" action="{{ route('acp.entry.store') }}" class="grid gap-5">@csrf
        <div><label for="date">تاريخ العملية</label><input id="date" type="date" name="date" value="{{ old('date', $today) }}" required></div>
        <div><label for="note">وصف العملية</label><textarea id="note" name="note" rows="4" placeholder="مثال: مصروفات البيت لهذا الأسبوع">{{ old('note') }}</textarea></div>
        <div class="flex justify-end gap-3"><a class="btn-light px-5 py-2" href="{{ route('acp.entry.index') }}">إلغاء</a><button class="btn-ms" type="submit">حفظ العملية</button></div>
    </form></div></div></div>
</x-app-layout>
