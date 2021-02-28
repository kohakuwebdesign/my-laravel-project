@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <h3>設定</h3>
                <form class="form-group" action="{{route('admin.state')}}" method="post">
                    @csrf
                    <div class="row mt-4">
                        <div class="col-md-4"><span>Twitter dog search keyword: </span><input class="form-control" name="twitter_dog_keyword" type="text" value="{{ old('twitter_dog_keyword', isset($adminstate->twitter_dog_keyword) ? $adminstate->twitter_dog_keyword : '') }}"></div>
                        <div class="col-md-4"><span>Twitter cat search keyword: </span><input class="form-control" name="twitter_cat_keyword" type="text" value="{{ old('twitter_cat_keyword', isset($adminstate->twitter_cat_keyword) ? $adminstate->twitter_cat_keyword : '') }}"></div>
                        <div class="col-md-4"><span>Twitter search limit: </span><input class="form-control" name="instagram_search_limit" type="text" value="{{ old('instagram_search_limit', isset($adminstate->instagram_search_limit) ? $adminstate->instagram_search_limit : '') }}"></div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4"><span>Instagram dog search keyword: </span><input class="form-control" name="instagram_dog_keyword" type="text" value="{{ old('instagram_dog_keyword', isset($adminstate->instagram_dog_keyword) ? $adminstate->instagram_dog_keyword : '') }}"></div>
                        <div class="col-md-4"><span>Instagram cat search keyword: </span><input class="form-control" name="instagram_cat_keyword" type="text" value="{{ old('instagram_cat_keyword', isset($adminstate->instagram_cat_keyword) ? $adminstate->instagram_cat_keyword : '') }}"></div>
                        <div class="col-md-4"><span>Instagram search limit: </span><input class="form-control" name="twitter_search_limit" type="text" value="{{ old('twitter_search_limit', isset($adminstate->twitter_search_limit) ? $adminstate->twitter_search_limit : '') }}"></div>
                    </div>

                    <input type="submit" class="btn btn-warning mt-4" value="設定を保存">
                </form>
            </div>
        </div>

        <hr>
        <div class="row mt-5">
            <div class="col-12"><h3>情報の取得</h3></div>
        </div>
        <div class="row mt-4">
            <div class="col-md-3">
                <form action="{{route('admin.collect.dog')}}" method="post">
                    @csrf
                    <input class="btn btn-warning" type="submit" value="犬の情報を取得">
                </form>
            </div>
            <div class="col-md-3">
                <form action="{{route('admin.collect.cat')}}" method="post">
                    @csrf
                    <input class="btn btn-warning" type="submit" value="猫の情報を取得">
                </form>
            </div>
        </div>

        <hr>

        <div class="row mt-5">
            <div class="col-12"><h3>一覧</h3></div>
        </div>


        <div class="row">
            <div class="col-md-2 d-none d-md-block">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;地域から探す</li>
                    @foreach($sidebar_contents as $item)
                        <li class="list-group-item"><a href="{{ route('admin.prefecture', ['prefecture_slug' => $item->slug])}}">{{$item->label}}&nbsp({{$item->posts_count}}件)</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-10">
                <div class="row">
                    @foreach($items as $item)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    @if($item->is_published == 0)
                                        <form action="{{route('admin.publish')}}" method="post" class="form-group">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <input name="is_published" type="hidden" value="1">
                                            <input type="submit" class="btn btn-success" value="公開する">
                                        </form>
                                    @endif

                                    @if($item->is_published == 1)
                                        <form action="{{route('admin.publish')}}" method="post" class="form-group">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <input name="is_published" type="hidden" value="0">
                                            <input type="submit" class="btn btn-warning" value="非公開にする">
                                        </form>
                                    @endif

                                    <form action="{{route('admin.delete')}}" method="post" class="form-group">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="prefecture_id" value="{{$item->prefecture_id}}">
                                        <input type="hidden" name="is_deleted" value="1">
                                        <input type="submit" class="btn btn-danger" value="削除">
                                    </form>

                                    <form method="post" action="{{route('admin.update')}}" class="form-group">
                                        @csrf
                                        関連性のある都道府県: <span class="badge badge-info">{{optional($item->prefecture)->label}}</span><br>
                                        種類: <span class="badge badge-info">{{optional($item->animal)->label}}</span>
                                        <select name="prefecture_id" class="form-control">
                                            @if(!isset($item->prefecture->label))
                                                <option selected="selected">---</option>
                                            @endif
                                            @foreach($item->all_prefectures as $option_category)
                                                @if($item->prefecture_id == $option_category->id)
                                                    <option selected="selected" value="{{ $option_category->id }}">{{ $option_category->label }}</option>
                                                @else
                                                    <option value="{{ $option_category->id }}">{{ $option_category->label }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="is_published" value="{{$item->is_published}}">
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="submit" class="btn btn-info mt-2" value="都道府県を保存">
                                    </form>
                                </div><!-- /.card-header -->
                                <div class="card-body px-3 px-md-2 px-lg-4">
                                    {!! $item->embed_tag !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>


        <div class="row mt-4">
            <div class="col-12">
                {{ $items->links('vendor.pagination.mypagination') }}
            </div>
        </div>
@endsection
