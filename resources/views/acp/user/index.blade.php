<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-bread-cramp :href="route('acp.dashboard')">الرئيسية</x-bread-cramp>
            المستخدمين
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="table-responsive">
                        <table class="table table-striped table-info caption-top">
                            <caption>المستخدمين</caption>
                            <thead>
                                <tr>
                                    <th class="col-6">الاسم</th>
                                    <th class="col-6">الايميل</th>
                                    <th colspan="2"><a href="{{ route('acp.user.create') }}"
                                        class="btn btn-outline-info btn-block"><i
                                            class="fa-solid fa-add fa-fw"></i></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    {!! Form::open(['route' => ['acp.user.destroy', $user->id], 'method' => 'DELETE']) !!}
                                    <tr>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td><a href="{{ route('acp.user.edit', ['user' => $user->id]) }}"
                                                class="btn btn-outline-success btn-block"><i
                                                    class="fa-solid fa-edit fa-fw"></i></a></td>
                                        <td><button type="submit" class="btn btn-block btn-outline-danger"><i
                                                    class="fa-solid fa-trash fa-fw"></i></button></td>
                                    </tr>
                                    {!! Form::close() !!}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
