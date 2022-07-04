<div class="table-responsive">
    <table class="table table-striped table-info caption-top">
        <caption>سجل العمليات</caption>
        <thead>
            <tr>
                <th>تاريخ</th>
                <th>ملاحظة</th>
                <th>المبلغ</th>
                <th>الحساب</th>
                <th>-</th>
                <th>+</th>
                <th>تصنيف</th>

                <th colspan="2"><a href="{{ route('acp.entry.create') }}"
                    class="btn btn-outline-info btn-block"><i
                        class="fa-solid fa-add fa-fw"></i></a></th>
            </tr>
        </thead>

            @foreach ($entries as $entry)
            <tbody>
                {!! Form::open(['route' => ['acp.entry.destroy', $entry->id], 'method' => 'DELETE']) !!}
                <tr>
                    <td>
                        @if ($entry->status)
                        <i class="fa-solid fa-circle-check fa-fw text-success"></i>
                        @else
                        <i class="fa-solid fa-circle-xmark fa-fw text-danger"></i>
                        @endif
                        {{ $entry->date->format('Y-m-d') }}
                    </td>
                    <td>
                        {{ $entry->note }}
                    </td>
                    <td><strong>{{number_format($entry->withdraw, 2)}}</strong></td>
                    <td colspan="4"></td>
                    <td><a href="{{ route('acp.entry.edit', ['entry' => $entry->id]) }}"
                            class="btn btn-outline-success btn-block"><i
                                class="fa-solid fa-edit fa-fw"></i></a></td>
                    <td><button type="submit" class="btn btn-block btn-outline-danger"><i
                                class="fa-solid fa-trash fa-fw"></i></button></td>
                </tr>
                @foreach ($entry->records as $record)
                <tr>
                    <td></td>
                    <td>{{$record->comment}}</td>
                    <td></td>
                    <td>{{$record->account->name}}</td>
                    <td>{{$record->type < 0 ? number_format($record->value, 2) : ''}}</td>
                    <td>{{$record->type > 0 ? number_format($record->value, 2) : ''}}</td>
                    <td>{{$record->category->name}}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
                {!! Form::close() !!}
            </tbody>
            <tr class="table-warning">
                <td colspan="9"><hr/></td>
            </tr>
            @endforeach

    </table>
</div>
