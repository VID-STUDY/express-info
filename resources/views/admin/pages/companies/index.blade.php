@extends('admin.layouts.app')

@section('title')
    Компании
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.css') }}">

    <style>
        .js-dataTable-full .btn {
            height: 100%;
        }
    </style>
@endsection
@section('content')
    @include('admin.components.breadcrumb', ['lastTitle' => 'Компании'])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Компании</h3>
            <div class="block-options">
                <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">Создать</a>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-stripped table-bordered table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px"><i class="fa fa-image"></i></th>
                            <th class="text-center">Заголовок</th>
                            <th class="text-center">Кол-во кликов</th>
                            <th class="text-center">Категория</th>
                            <th class="text-center">Активность</th>
                            <th class="text-center" style="width: 50px">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td class="text-center font-w600">@if($company->image)<img src="{{ $company->getImage() }}" alt="{{ $company->ru_title }}" class="img-avatar img-avatar48"> @else - @endif</td>
                                <td class="text-center font-w600">{{ $company->getTitle() }}</td>
                                <td class="text-center font-w600"> - </td>
                                <td class="text-center font-w600">@if($company->category){{ $company->category->getTitle() }} @else - @endif</td>
                                <td class="text-center font-w600">
                                    @if($company->active)
                                        <i class="text-success fa fa-check"></i>
                                    @else
                                        <i class="text-danger fa fa-times"></i>
                                    @endif
                                </td>
                                <td class="text-center font-w600 d-flex align-items-center justify-content-around">
                                    <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-sm btn-alt-info"
                                       data-toggle="tooltip"
                                       title="Редактировать"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('admin.companies.destroy', $company->id) }}" method="post" data-toggle="tooltip" title="Удалить">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-alt-delete" onclick="return confirm('Вы уверены?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                    <select name="position" id="position" class="position">
                                        @for($i = 0; $i <= count($companies); $i++)
                                            <option value="{{ $i }}" @if($company->position == $i) selected @endif>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        jQuery('.js-dataTable-full').dataTable({
            "order": [],
            pageLength: 10,
            lengthMenu: [[10, 20, 30, 50], [10, 20, 30, 50]],
            autoWidth: true,
            language: ru_datatable
        });

        $('.position').change(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let formData = new FormData;
            formData.append('id', $(this).data('id'));
            formData.append('position', $(this).val());
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.companies.change.position') }}',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.position').attr('disabled', 'disabled');
                },
                success: function() {
                    $('.position').removeAttr('disabled', '');
                },
                error: function(data) {
                    console.log(data);
                    $('.position').removeAttr('disabled', '');
                }
            })
        });
    </script>
@endsection