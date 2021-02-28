@extends('layouts.app')
@section('title', $data[0]->prefecture->label.'の迷子の動物一覧')
@section('description', $data[0]->prefecture->label.'の迷子の動物一覧「Find My Pet」迷子のペットを探すサイト')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p><a href="{{route('index')}}">トップページ</a> &rsaquo; {{$data[0]->prefecture->label}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 d-none d-md-block">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;地域から探す</li>
                    @foreach($sidebar_contents as $item)
                        <li class="list-group-item"><a href="{{ route('all.prefecture', ['prefecture_slug' => $item->slug])}}">{{$item->label}}&nbsp({{$item->posts_count}}件)</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-10">
                <div class="row">
                    @foreach($data as $item)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    @if(isset($item->prefecture->slug))
                                        関連性のある都道府県: <a href="{{ route('all.prefecture', ['prefecture_slug' => optional($item->prefecture)->slug])}}" class="badge badge-info">{{optional($item->prefecture)->label}}</a><br>
                                    @endif
                                    @if(isset($item->animal->slug))
                                        種類: <span class="badge badge-info">{{optional($item->animal)->label}}</span><br>
                                    @endif
                                    投稿日: {{date('Y年m月d日', strtotime($item->data_created_at))}}
                                </div>
                                <div class="card-body px-3 px-md-2 px-lg-4">
                                    {!! $item->embed_tag !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $data->links('vendor.pagination.mypagination') }}
            </div>

        </div>
    </div>
@endsection
