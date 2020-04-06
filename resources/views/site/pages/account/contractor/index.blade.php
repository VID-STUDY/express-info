@extends('site.layouts.account')

@section('title', 'Личный кабинет')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
@endsection
@section('account.title', 'Личный кабинет')
@section('content.account')
    <form action="{{ route('site.account.contractor.personal.save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <section class="uk-section-xsmall">
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>Фото</h4>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-4">
                    <img src="{{ $user->getImage() }}" alt="{{ $user->name }}" class="uk-border-circle account-avatar">
                </div>
                <div class="uk-width-3-4">
                    <div class="uk-flex uk-flex-column uk-flex-center">
                        <div class="js-upload" uk-form-custom>
                            <input type="file" name="image" id="image">
                            <button class="uk-button uk-button-primary-outline" type="button" tabindex="-1"><span
                                    uk-icon="image" class="uk-margin-small-right"></span>Загрузить фото
                            </button>
                        </div>
                        <span class="uk-text-muted uk-text-small uk-margin-small-top"><span uk-icon="info"></span> Минимальные пропорции: 120х120 пикселей</span>
                    </div>
                </div>
            </div>
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>Ваше имя: <span class="uk-text-danger">*</span></h4>
                </div>
            </div>
            <div class="uk-grid uk-margin-remove-top">
                <div class="uk-width-1-2">
                    <input type="text" placeholder="Имя" name="firstName"
                           class="uk-input @error('firstName') uk-form-danger @enderror"
                           value="{{ $user->getFirstName() }}">
                </div>
                <div class="uk-width-1-2">
                    <input type="text" placeholder="Фамилия" name="secondName"
                           class="uk-input @error('secondName') uk-form-danger @enderror"
                           value="{{ $user->getSecondName() }}">
                </div>
            </div>
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>Пол: <span class="uk-text-danger">*</span></h4>
                </div>
            </div>
            <div class="uk-grid-small uk-child-width-1-1 uk-grid uk-margin-remove-top">
                <label><input type="radio" name="gender" id="gender" class="uk-radio" value="male"
                              @if($user->gender == 'male') checked @endif> Мужской</label>
                <label class="uk-margin-small-top"><input type="radio" name="gender" id="gender" class="uk-radio"
                                                          value="female" @if($user->gender == 'female') checked @endif>
                    Женский</label>
            </div>
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>Дата рождения: <span class="uk-text-danger">*</span></h4>
                </div>
            </div>
            <div class="uk-grid uk-margin-remove-top">
                <div class="uk-width-1-2">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: calendar"></span>
                        <input type="text" class="uk-input" id="birthdayDate" name="birthday_date"
                               value="{{ $user->birthday_date }}">
                    </div>
                </div>
            </div>
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>О себе: <span class="uk-text-danger">*</span></h4>
                </div>
            </div>
            <div class="uk-grid uk-margin-remove-top">
                <div class="uk-width-1-1">
                    <textarea name="about_myself" id="aboutMySelf">{!! $user->about_myself !!}</textarea>
                </div>
            </div>
            <div class="wrapper uk-padding-small uk-padding-remove-horizontal uk-flex-middle uk-margin-top" uk-grid>
                <div class="wrapper_title">
                    <h4>Ссылки на соц. сети:</h4>
                </div>
            </div>
            <div class="uk-grid uk-margin-remove-top">
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: facebook"></span>
                        <input type="text" class="uk-input" id="facebook" name="facebook" placeholder="Facebook"
                               value="{{ $user->facebook }}">
                    </div>
                </div>
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: question"></span>
                        <input type="text" class="uk-input" id="telegram" name="telegram" placeholder="Telegram"
                               value="{{ $user->telegram }}">
                    </div>
                </div>
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: question"></span>
                        <input type="text" class="uk-input" id="vk" name="vk" placeholder="ВКонтакте"
                               value="{{ $user->vk }}">
                    </div>
                </div>
                <div class="uk-width-1-2 uk-margin-small-bottom">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: whatsapp"></span>
                        <input type="text" class="uk-input" id="whatsapp" name="whatsapp" placeholder="WhatsApp"
                               value="{{ $user->vk }}">
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <div class="uk-inline" style="width: 100%">
                        <span class="uk-form-icon" uk-icon="icon: instagram"></span>
                        <input type="text" class="uk-input" id="instagram" name="instagram" placeholder="Instagram"
                               value="{{ $user->instagram }}">
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <button type="submit" class="uk-button uk-button-success uk-width-1-1 uk-margin-medium-left">Сохранить
                </button>
            </div>
        </section>
    </form>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="{{ asset('js/ckeditor.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr(document.getElementById('birthdayDate'), {
                dateFormat: 'd.m.Y',
            });
        });
    </script>
    <script>ClassicEditor
            .create(document.querySelector('#aboutMySelf'), {

                toolbar: {
                    items: [
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                language: 'ru',
                licenseKey: '',
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
