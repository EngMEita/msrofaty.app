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

                    <div class="table-responsive">
                        <table class="table table-striped table-info caption-top">
                            <caption>الحسابات</caption>
                            <thead>
                                <tr>
                                    <th class="col-8">الحساب</th>
                                    <th class="col-2">الرصيد</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    @if (isset($current) && $current->id == $account->id)
                                        {!! Form::open(['route' => ['acp.account.update', $account->id], 'method' => 'PUT']) !!}
                                        <tr>
                                            <td colspan="2">{!! Form::text('name', $current->name, ['class' => 'form-control', 'id' => 'accName', 'placeholder' => 'اسم الحساب']) !!}</td>
                                            <td><button type="submit" class="btn btn-block btn-info"><i
                                                        class="fa-solid fa-save fa-fw"></i></button></td>
                                            <td><button type="reset" class="btn btn-block btn-danger"><i
                                                        class="fa-solid fa-times fa-fw"></i></button></td>
                                        </tr>
                                        {!! Form::close() !!}
                                    @else
                                        {!! Form::open(['route' => ['acp.account.destroy', $account->id], 'method' => 'DELETE']) !!}
                                        <tr>
                                            <td class="col-8">{{ $account->name }}</td>
                                            <td class="col-2">{{ $account->balance }}</td>
                                            <td class="col-1"><a
                                                    href="{{ route('acp.account.edit', ['account' => $account->id]) }}"
                                                    class="btn btn-outline-success btn-block"><i
                                                        class="fa-solid fa-edit fa-fw"></i></a></td>
                                            <td class="col-1"><button type="submit"
                                                    class="btn btn-block btn-outline-danger"><i
                                                        class="fa-solid fa-trash fa-fw"></i></button></td>
                                        </tr>
                                        {!! Form::close() !!}
                                    @endif
                                @endforeach
                            </tbody>
                            @if (!isset($current))
                                <tfoot>
                                    {!! Form::open(['route' => 'acp.account.store']) !!}
                                    <tr>
                                        <td colspan="2">{!! Form::text('name', '', ['class' => 'form-control', 'id' => 'accName', 'placeholder' => 'اسم الحساب']) !!}</td>
                                        <td><button type="submit" class="btn btn-block btn-info"><i
                                                    class="fa-solid fa-save fa-fw"></i></button></td>
                                        <td><button type="reset" class="btn btn-block btn-danger"><i
                                                    class="fa-solid fa-times fa-fw"></i></button></td>
                                    </tr>
                                    {!! Form::close() !!}
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
