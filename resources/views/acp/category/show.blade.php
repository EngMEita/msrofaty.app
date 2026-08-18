<x-app-layout>
    <x-slot name="header"><div class="flex items-center justify-between"><h2>{{ $category->name }}</h2><a class="btn-ms" href="{{ route('acp.category.edit', $category) }}">تعديل</a></div></x-slot>
    <div class="py-8"><div class="max-w-4xl mx-auto px-4"><div class="bg-white rounded-lg p-6 shadow-sm"><p class="text-gray-600">التصنيف الأب: {{ $category->parentCategory?->name ?: 'لا يوجد' }}</p><p class="mt-3 text-gray-600">عدد السجلات: {{ $category->records()->count() }}</p><div class="mt-6"><a class="btn-light px-5 py-2" href="{{ route('acp.category.index') }}">العودة للتصنيفات</a></div></div></div></div>
</x-app-layout>
