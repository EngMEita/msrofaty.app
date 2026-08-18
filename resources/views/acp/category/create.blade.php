<x-app-layout>
    <x-slot name="header"><h2>إضافة تصنيف</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto px-4"><div class="bg-white rounded-lg p-6 shadow-sm">
        <x-auth-validation-errors class="alert" :errors="$errors" />
        <form method="POST" action="{{ route('acp.category.store') }}" class="grid gap-5">@csrf
            <div><label for="name">اسم التصنيف</label><input id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="مثال: بقالة أو فواتير"></div>
            <div><label for="category_id">التصنيف الأب (اختياري)</label><select id="category_id" name="category_id"><option value="">بدون تصنيف أب</option>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
            <div class="flex justify-end gap-3"><a class="btn-light px-5 py-2" href="{{ route('acp.category.index') }}">إلغاء</a><button class="btn-ms" type="submit">حفظ التصنيف</button></div>
        </form>
    </div></div></div>
</x-app-layout>
