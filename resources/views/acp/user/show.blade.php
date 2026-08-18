<x-app-layout>
    <x-slot name="header"><div class="flex items-center justify-between"><h2>{{ $user->name }}</h2><a class="btn-ms" href="{{ route('acp.user.edit', $user) }}">تعديل</a></div></x-slot>
    <div class="py-8"><div class="max-w-3xl mx-auto px-4"><div class="bg-white rounded-lg p-6 shadow-sm"><p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p><p class="mt-3"><strong>تاريخ الانضمام:</strong> {{ $user->created_at?->format('d/m/Y') }}</p><div class="mt-6"><a class="btn-light px-5 py-2" href="{{ route('acp.user.index') }}">العودة للأعضاء</a></div></div></div></div>
</x-app-layout>
