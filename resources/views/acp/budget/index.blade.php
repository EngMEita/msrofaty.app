<x-app-layout>
    <x-slot name="header"><div class="flex items-center justify-between"><div><span class="badge-ms">إدارة الأسرة</span><h2 class="mt-2">الميزانيات</h2></div><a class="btn-ms" href="{{ route('acp.budget.create') }}">+ ميزانية جديدة</a></div></x-slot>
    <div class="py-8"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('message'))<div class="mb-5 rounded-lg p-4" style="background:#d9f1e4;color:#174b43">{{ session('message') }}</div>@endif
        @if($budgets->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($budgets as $budget)
                    <article class="p-6 bg-white rounded-lg shadow-sm" style="border-top:4px solid #174b43">
                        <div class="flex items-start justify-between gap-3"><div><h3 class="text-lg font-bold">{{ $budget->name }}</h3><p class="text-sm text-gray-500 mt-1">{{ $budget->start_date?->format('d/m/Y') }} — {{ $budget->end_date?->format('d/m/Y') }}</p></div><span class="badge-ms">{{ $budget->categories->count() }} تصنيفات</span></div>
                        <div class="mt-6 grid grid-cols-2 gap-3"><div class="rounded-lg p-3" style="background:#f2f7f3"><small class="text-gray-500">الحد المسموح</small><strong class="block mt-1 text-lg">{{ number_format((float)$budget->limit, 2) }}</strong></div><div class="rounded-lg p-3" style="background:#fff4e8"><small class="text-gray-500">تنبيه عند</small><strong class="block mt-1 text-lg">{{ number_format((float)$budget->notice, 2) }}</strong></div></div>
                        <div class="mt-5 flex gap-2"><a class="btn-ms flex-1" href="{{ route('acp.budget.show', $budget) }}">التفاصيل</a><a class="btn-light flex-1 text-center" href="{{ route('acp.budget.edit', $budget) }}">تعديل</a><form method="POST" action="{{ route('acp.budget.destroy', $budget) }}" onsubmit="return confirm('هل تريد حذف هذه الميزانية؟')">@csrf @method('DELETE')<button class="text-red-600 px-3 py-2" type="submit">حذف</button></form></div>
                    </article>
                @endforeach
            </div>
            <div class="mt-6">{{ $budgets->links() }}</div>
        @else
            <div class="bg-white rounded-lg p-12 text-center shadow-sm"><div class="mx-auto mb-4 grid place-items-center rounded-full" style="width:68px;height:68px;background:#d9f1e4;font-size:30px">◈</div><h3 class="text-xl font-bold">لسه مفيش ميزانيات</h3><p class="text-gray-500 mt-2 mb-6">حدد أول ميزانية للأسرة وابدأ تابع مصروفاتك بوضوح.</p><a class="btn-ms" href="{{ route('acp.budget.create') }}">إنشاء أول ميزانية</a></div>
        @endif
    </div></div>
</x-app-layout>
