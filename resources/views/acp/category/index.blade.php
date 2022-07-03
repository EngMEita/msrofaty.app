<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-bread-cramp :href="route('acp.dashboard')">الرئيسية</x-bread-cramp>
            التصنيفات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="table-responsive">
                        <table class="table table-striped table-info caption-top">
                            <caption>التصنيفات</caption>
                            <thead>
                                <tr>
                                    <th class="col-10">التصنيف</th>
                                    <th colspan="2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $category)
                                    @if (isset($current) && $current->id == $category->id)
                                        {!! Form::open(['route' => ['acp.category.update', $category->id], 'method' => 'PUT']) !!}
                                        <tr>
                                            <td class="row">
                                                <div class="col-8">{!! Form::text('name', $current->name, ['class' => 'form-control', 'id' => 'catName', 'placeholder' => 'الاسم']) !!}</div>
                                                <div class="col-4">
                                                    <select name="category_id" size="1" id="catId"
                                                        class="form-control">
                                                        <option> </option>
                                                        @foreach ($list as $item)
                                                            <option value="{{ $item->id }}" @if ($item->id == $current->category_id)
                                                                 selected
                                                            @endif>
                                                                @for ($i = $item->level; $i > 0; $i--)
                                                                    ----- +
                                                                @endfor
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td><button type="submit" class="btn btn-block btn-info"><i
                                                        class="fa-solid fa-save fa-fw"></i></button></td>
                                            <td><button type="reset" class="btn btn-block btn-danger"><i
                                                        class="fa-solid fa-times fa-fw"></i></button></td>
                                        </tr>
                                        {!! Form::close() !!}
                                    @else
                                        {!! Form::open(['route' => ['acp.category.destroy', $category->id], 'method' => 'DELETE']) !!}
                                        <tr>
                                            <td class="col-10">
                                                @for ($i = $category->level; $i > 1; $i--)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+&nbsp;
                                                @endfor
                                                {{ $category->name }}
                                            </td>
                                            <td class="col-1"><a
                                                    href="{{ route('acp.category.edit', ['category' => $category->id]) }}"
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
                                    {!! Form::open(['route' => 'acp.category.store']) !!}
                                    <tr>
                                        <td class="row">
                                            <div class="col-8">{!! Form::text('name', '', ['class' => 'form-control', 'id' => 'catName', 'placeholder' => 'الاسم']) !!}</div>
                                            <div class="col-4">
                                                <select name="category_id" size="1" id="catId"
                                                    class="form-control">
                                                    <option> </option>
                                                    @foreach ($list as $item)
                                                        <option value="{{ $item->id }}">
                                                            @for ($i = $item->level; $i > 0; $i--)
                                                                ----- +
                                                            @endfor
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
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
