<x-app-layout>
    <x-slot name="header"><h2>تعديل العملية</h2></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto px-4"><div class="bg-white rounded-lg p-6 shadow-sm"><form method="POST" action="{{ route('acp.entry.update', $entry) }}" class="grid gap-5">@csrf @method('PUT')<div><label for="date">تاريخ العملية</label><input id="date" type="date" name="date" value="{{ old('date', $entry->date?->format('Y-m-d')) }}" required></div><div><label for="note">وصف العملية</label><textarea id="note" name="note" rows="4">{{ old('note', $entry->note) }}</textarea></div><div class="flex justify-end gap-3"><a class="btn-light px-5 py-2" href="{{ route('acp.entry.index') }}">إلغاء</a><button class="btn-ms" type="submit">حفظ التعديلات</button></div></form></div></div></div>
</x-app-layout>
