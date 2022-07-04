<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-bread-cramp :href="route('acp.dashboard')">الرئيسية</x-bread-cramp>
            <x-bread-cramp :href="route('acp.user.index')">المستخدمين</x-bread-cramp>
            إضافة مستخدم جديد
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-form :action="route('acp.user.store')">
                            <x-form.input title="اسم المستخدم" name="name" required="yes" />
                            <x-form.input title="الإيميل" name="email" type="email" required="yes" />
                            <x-form.input title="كلمة المرور" name="password" required="yes" />
                            <x-button>حفظ <i class="fa-solid fa-save fa-fw"></i></x-button>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
