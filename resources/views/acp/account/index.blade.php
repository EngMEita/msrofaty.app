<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-bread-cramp :href="route('acp.dashboard')">الرئيسية</x-bread-cramp>
            الحسابات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul class="list-group">
                        <li class="list-group-item active" aria-current="true">
                            الحساب
                            <span class="float-end">
                                <span class="badge rounded-pill text-bg-info">الرصيد</span>
                            </span>
                        </li>
                        @if (!isset($current))
                            <li class="list-group-item">
                                {!! Form::open(['route' => 'acp.account.store']) !!}
                                <div class="form-floating">
                                    {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'accName', 'placeholder' => 'اسم الحساب']) !!}
                                    {!! Form::label('accName', 'اسم الحساب') !!}
                                </div>
                                <button type="submit" class="btn btn-sm btn-info float-end mt-1"><i
                                        class="fa-solid fa-save fa-fw"></i></button>
                                {!! Form::close() !!}
                            </li>
                        @endif

                        @foreach ($accounts as $account)
                            <li class="list-group-item">
                                @if (isset($current) && $current->id == $account->id)
                                    {!! Form::open(['route' => ['acp.account.update', $account->id], 'method' => 'PUT']) !!}
                                    <div class="form-floating">
                                        {!! Form::text('name', $current->name, ['class' => 'form-control', 'id' => 'accName', 'placeholder' => 'اسم الحساب']) !!}
                                        {!! Form::label('accName', 'اسم الحساب') !!}
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-info float-end mt-1"><i
                                            class="fa-solid fa-save fa-fw"></i></button>
                                    {!! Form::close() !!}
                                @else
                                    {!! Form::open(['route' => ['acp.account.destroy', $account->id], 'method' => 'DELETE']) !!}
                                    <a href="{{ route('acp.account.edit', ['account' => $account->id]) }}"
                                        class="btn btn-outline-success btn-sm"><i
                                            class="fa-solid fa-edit fa-fw"></i></a>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash fa-fw"></i></button>
                                    {{ $account->name }}
                                    <span class="float-end">
                                        <span
                                            class="badge rounded-pill text-bg-success">{{ $account->balance }}</span>
                                    </span>
                                    {!! Form::close() !!}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
