<x-app-layout>
    <x-slot name="header"><h2>إنشاء ميزانية جديدة</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto px-4"><div class="bg-white rounded-lg p-6 shadow-sm"><p class="text-gray-500 mb-6">حدد الحد المالي والتصنيفات التي تريد متابعتها.</p><x-auth-validation-errors class="alert" :errors="$errors" /><form method="POST" action="{{ route('acp.budget.store') }}" class="grid gap-5">@csrf
        <div><label for="name">اسم الميزانية</label><input id="name" name="name" value="{{ old('name') }}" required placeholder="مثال: مصروفات شهر يونيو"></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label for="start_date">تبدأ من</label><input id="start_date" type="date" name="start_date" value="{{ old('start_date', now()->startOfMonth()->format('Y-m-d')) }}" required></div><div><label for="end_date">تنتهي في</label><input id="end_date" type="date" name="end_date" value="{{ old('end_date', now()->endOfMonth()->format('Y-m-d')) }}" required></div></div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label for="limit">الحد المسموح</label><input id="limit" type="number" step="0.01" min="0" name="limit" value="{{ old('limit') }}" required></div><div><label for="notice">التنبيه عند</label><input id="notice" type="number" step="0.01" min="0" name="notice" value="{{ old('notice') }}" required></div></div>
        @if($categories->count())<div><label>التصنيفات</label><div class="grid grid-cols-2 gap-3 mt-2">@foreach($categories as $category)<label class="flex items-center gap-2"><input type="checkbox" name="categories[]" value="{{ $category->id }}"> <span>{{ $category->name }}</span></label>@endforeach</div></div>@endif
        <div class="flex justify-end gap-3 pt-3"><a class="btn-light px-5 py-2" href="{{ route('acp.budget.index') }}">إلغاء</a><button class="btn-ms" type="submit">حفظ الميزانية</button></div>
    </form></div></div></div>
</x-app-layout>
