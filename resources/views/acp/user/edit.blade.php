<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-bread-cramp :href="route('acp.dashboard')">الرئيسية</x-bread-cramp>
            <x-bread-cramp :href="route('acp.user.index')">المستخدمين</x-bread-cramp>
            تحرير مستخدم #{{$user->id}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-form :action="route('acp.user.update', ['user' => $user->id])" data-method="PUT">
                            <x-form.input title="اسم المستخدم" name="name" required="yes" :value="$user->name" />
                            <x-form.input title="الإيميل" name="email" type="email" required="yes" :value="$user->email" />
                            <x-form.input title="كلمة المرور" name="password" required="no" />
                            <x-button>حفظ <i class="fa-solid fa-save fa-fw"></i></x-button>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
