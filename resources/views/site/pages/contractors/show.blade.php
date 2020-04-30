@extends('site.layouts.app')

@section('title')
    @if (empty($contractor->meta_title)) {{ $contractor->getCommonTitle() }} @else {{ $contractor->meta_title }} @endif в Ташкенте / Узбекистане
@endsection

@section('meta')
    <meta name="title"
          content="@if (empty($contractor->meta_title)) {{ $contractor->getCommonTitle() }} @else {{ $contractor->meta_title }} @endif в Ташкенте / Узбекистане">
    <meta name="description"
          content="{{ strip_tags($contractor->about_myself) }}">
@endsection

@section('css')
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">
  <style>
  .rating {
      float:left;
    }

    /* :not(:checked) is a filter, so that browsers that don’t support :checked don’t
      follow these rules. Every browser that supports :checked also supports :not(), so
      it doesn’t make the test unnecessarily selective */
    .rating:not(:checked) > input {
        position:absolute;
        top:-9999px;
        clip:rect(0,0,0,0);
    }

    .rating:not(:checked) > label {
        float:right;
        width:1em;
        /* padding:0 .1em; */
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:300%;
        /* line-height:1.2; */
        color:#ddd;
    }

    .rating:not(:checked) > label:before {
        content: '★ ';
    }

    .rating > input:checked ~ label {
        color: dodgerblue;

    }

    .rating:not(:checked) > label:hover,
    .rating:not(:checked) > label:hover ~ label {
        color: dodgerblue;

    }

    .rating > input:checked + label:hover,
    .rating > input:checked + label:hover ~ label,
    .rating > input:checked ~ label:hover,
    .rating > input:checked ~ label:hover ~ label,
    .rating > label:hover ~ input:checked ~ label {
        color: dodgerblue;

    }

    .rating > label:active {
        position:relative;
        top:2px;
        left:2px;
    }
    .ck-editor__editable_inline {
        min-height: 200px;
    }

  </style>

@endsection

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('content')
    <div class="primary-page">
        <div class="container">
            <div class="item-detail-special">
                <div class="img"><img src="{{ $contractor->getImage() }}" class="avatar" alt="{{ $contractor->getContractorTitle() }}"></div>
                <div class="text">
                    <div class="row align-items-lg-center">
                        <div class="col-lg-7 col-xl-8">
                            <h2 class="title-detail">{{ $contractor->getContractorTitle() }}</h2>
                            <div class="date-job">@if ($contractor->contractor_type == 'freelancer') Фрилансер @elseif ($contractor->contractor_type == 'agency') Digital-агество @endif
                            </div>
                            @for($i=0; $i<$mean; $i++)
                              <i class="fas fa-star" style="font-size:15px; color:green"></i>
                            @endfor
                            <div class="meta-job"><span class="phone"><i class="fa fa-mobile-alt"></i>@guest [Скрыто] @else @if (auth()->user()->hasRequestFromContractor($contractor)) {{ $contractor->phone_number }} @else [Скрыто] @endif @endguest </span><span
                                    class="mail"><i class="far fa-envelope"></i><a
                                        href="#" class="__cf_email__"
                                        data-cfemail="25565144574750464e56654c4b434a0b464a48">[email&nbsp;protected]</a></span>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="btn-feature">
                                @guest
                                        <button class="btn btn-light btn-lg tender-item" type="button" data-target="{{ route('site.tenders.contractors.add.guest', $contractor->id) }}">Добавить
                                                в конкурс</button>
                                @endguest
                                @auth
                                    @if (auth()->user()->hasRole('customer'))
                                            <button class="btn btn-light btn-lg" type="button" data-toggle="modal" data-target="#tendersModal{{ $contractor->id }}">Добавить
                                                    в конкурс</button>
                                        <div class="modal fade" id="tendersModal{{ $contractor->id }}" tabindex="-1" role="dialog" aria-labelledby="tendersModalLabel{{ $contractor->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="tendersModalLabel{{ $contractor->id }}">Выберите конкурс</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Выберите конкурс, в который вы хотите пригласить исполнителя</p>
                                                        <ul class="list-group list-group-flush">
                                                            @foreach(auth()->user()->ownedTenders as $tender)
                                                                @continue(!$tender->opened || $tender->status == 'done')
                                                                @if ($tender->hasRequestFrom($contractor->id))
                                                                    <li class="list-group-item">{{ $tender->title }} <small class="text-primary"><i class="far fa-check-circle"></i> Уже участвует в этом конкурсе</small></li>
                                                                    @continue
                                                                @endif
                                                                <a href="#" class="list-group-item list-group-item-action tender-item" data-target="{{ route('site.tenders.contractors.add', ['tenderId' => $tender->id, 'contractorId' => $contractor->id]) }}">{{ $tender->title }}</a>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-green" data-dismiss="modal">Закрыть</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-main-right single-detail">
                        <div class="box-description">
                            <h3>Об исполнителе</h3>
                            {!! $contractor->about_myself !!}

                        </div>
                        <hr>
                        <div class="intro-profile">
                            <h3 class="title-box">Предоставляемые услуги</h3>
                            <div class="candidate-box">
                                <div class="tags">
                                    @foreach($contractor->categories as $category)
                                        <a href="{{ route('site.catalog.main', $category->getAncestorsSlugs()) }}">{{ $category->getTitle() }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="intro-profile">
                            <h3 class="title-box">Комментарии</h3>
                            <div class="candidate-box">
                                <div class="tags">
                                  <div class="row">
                                  @foreach($comments as $comment)
                                      <div class="col-md-4 single-card-info">
                                          <div class="card-info">

                                              <div class="card-info-body">
                                                  <h3 class="card-info-title">{{ $comment->who_set }}</h3>
                                                  Оценка:
                                                  @for($i = 0; $i< $comment->assessment; $i++)
                                                    <i class="fas fa-star" style="font-size:15px; color:green"></i>
                                                  @endfor
                                                  <hr>
                                                  <div class="card-info-text">{!! $comment->comment !!}
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                                </div>

                            </div>
                          </div>
                        </div>

                        <div class="intro-profile pt-5">
                          <h3 class="title-box">Портфолио</h3>
                        <div class="candidate-box">
                          <div class="table-responsive m-1 p-1">
                            <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <td>Название проекта</td>
                                    <td>Изображение</td>
                                    <td>Ссылка</td>
                                </thead>

                                <tbody>
                                @foreach($portfolio as $row)
                                @if($row)
                                  <tr>
                                    <td>{{ $row->project_name}}</td>
                                    <td>
                                      <a data-fancybox="gallery" href="{{ asset('images/portfolio/portfolio_contractor/'.$row->filename) }}">
                                          <img class="img-fluid" src="{{ asset('images/portfolio/portfolio_contractor/'.$row->filename) }}" style="height:120px; width:200px"/>
                                      </a>
                                    </td>
                                    @if($row->link)
                                      <td>
                                        <a href="{{ $row->link }}">Перейти на проект</a>
                                      </td>
                                    @else
                                      <td>Ссылка не указана исполнителем</td>
                                    @endif
                                  </tr>
                                @endif
                                @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-right">
                        <div class="sidebar-right-group">
                            <div class="job-detail-summary">
                                <h3 class="title-block">Цены на услуги</h3>
                                <ul>
                                    @foreach($contractor->categories as $category)
                                      @if($category ->pivot->price_from!='' or $category->pivot->price_to !='')
                                        <li><span>{{ $category->getTitle() }}</span>: {{ $category->pivot->price_from }} - {{ $category->pivot->price_to }} сум</li>
                                      @else
                                        <li><span>{{ $category->getTitle() }}</span>: Договорная</li>
                                      @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="side-right-social">
                                <h3 class="title-block">Поделиться исполнителем</h3>
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                </ul>
                            </div>
                            <form action="{{ route('site.contractors.comment.contractor') }}" method="post">
                              @csrf
                              <input type="hidden" name="for_comment_id" value="{{ $contractor->slug}}">
                              <div class="job-detail-summary">
                                <h3 class="title-block">Поставить оценку</h3>
                                <div class="container">
                              	<div class="row">
                              	<div class="rating">
                                    <input type="radio" id="star10" name="rating" value="5" /><label for="star10" title="Rocks!">5 stars</label>
                                    <input type="radio" id="star9" name="rating" value="4" /><label for="star9" title="Rocks!">4 stars</label>
                                    <input type="radio" id="star8" name="rating" value="3" /><label for="star8" title="Pretty good">3 stars</label>
                                    <input type="radio" id="star7" name="rating" value="2" /><label for="star7" title="Pretty good">2 stars</label>
                                    <input type="radio" id="star6" name="rating" value="1" /><label for="star6" title="Meh">1 star</label>

                                  </div>
                                  <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Оставить комментарий <i class="fas fa-long-arrow-alt-right"></i>
                                  </a>
                                  <div class="collapse" id="collapseExample">

                                    <textarea name="comment" id="writeComment"></textarea>

                                  </div>
                                  <button class="btn btn-success" type="submit">Сохранить</button>
                              	</div>
                              </div>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="{{ asset('js/ckeditor.js') }}"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  jQuery(document).ready(function($){

  $(".btnrating").on('click',(function(e) {

  var previous_value = $("#selected_rating").val();

  var selected_value = $(this).attr("data-attr");
  $("#selected_rating").val(selected_value);

  $(".selected-rating").empty();
  $(".selected-rating").html(selected_value);

  for (i = 1; i <= selected_value; ++i) {
  $("#rating-star-"+i).toggleClass('btn-warning');
  $("#rating-star-"+i).toggleClass('btn-default');
  }

  for (ix = 1; ix <= previous_value; ++ix) {
  $("#rating-star-"+ix).toggleClass('btn-warning');
  $("#rating-star-"+ix).toggleClass('btn-default');
  }

  }));


  });
</script>
<script>
ClassicEditor
        .create(document.querySelector('#writeComment'), {

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
