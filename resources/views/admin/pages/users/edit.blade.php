@extends('admin.layouts.app')

@section('title', 'Пользователь - '.$user->name)

@section('content')
    @include('admin.components.breadcrumb', [
        'list' => [
            [
                'url' => route('admin.users.index'),
                'title' => 'Пользователи'
            ]
        ],
        'lastTitle' => $user->name
    ])
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{ $user->name }} <small>Редактировать</small></h3>
        </div>
        <div class="block-content">
            <form action="{{ route('admin.users.update'), $user->id }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group @error('name') is-invalid @enderror">
                            <div class="form-material floating">
                                <label for="name">Имя пользователя</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
                            </div>
                            @error('name') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group @error('email') is-invalid @enderror">
                            <div class="form-material floating">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                            </div>
                            @error('email') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="form-material floating">
                                <label for="roleId">Роль</label>
                                <select name="roleId" id="roleId">
                                    <option value="0">Нет</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if($user->hasRole()) @if($user->getRole()->id == $role->id) selected @endif @endif>{{ $role->descripton }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="image">Аватар</label>
                            @if ($user->image)
                                <div class="user-image">
                                    <img src="{{ $user->getImage() }}" alt="{{ $user->name }}" class="img-avatar img-avatar48">
                                </div>
                            @endif
                            <input type="file" name="image" id="image">
                        </div>
                    </div>
                </div>
                <div class="block-content mb-10">
                    <div class="block-content text-right pb-10">
                        <button class="btn btn-alt-success" type="submit">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Изменить пароль</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('admin.users.change.password', $user->id) }}" method="post">
                <div class="row">
                    <div class="co-sm-12">
                        <div class="form-group @error('newPassword') is-invalid @enderror">
                            <div class="form-material floating">
                                <label for="newPassword">Новый пароль</label>
                                <input type="password" name="newPassword" id="newPassword" class="form-control">
                            </div>
                            @error('newPassword') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="co-sm-12">
                        <div class="form-group">
                            <div class="form-material floating @error('confirmPassword') is-invalid @enderror">
                                <label for="confirmPassword">Подтвердите пароль</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                            </div>
                            @error('confirmPassword') <div class="invalid-feedback animated fadeInDown">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="block-content mb-10">
                    <div class="block-content text-right pb-10">
                        <button class="btn btn-alt-success" type="submit">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection