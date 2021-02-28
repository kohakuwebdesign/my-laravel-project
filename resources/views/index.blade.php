@extends('layouts.app')

@section('description', '「Find My Pet」迷子のペットを探すサイト。TwitterとInstagramに投稿された迷子ペットの情報を横断的に閲覧することができます。')

@section('content')
    <div class="bg-info pt-5">
        <div class="pb-5 background d-flex align-content-center">
            <div class="container d-flex align-content-center">
                <div class="row justify-content-center d-flex align-content-center">
                    <div class="px-4 col-md-8 pb-4 pt-4 bg-white-transparent rounded ml-3 mr-3">
                        <h1 class="text-center mb-3">Find My Pet</h1>
                        このサイトではTwitterとInstagramに投稿された迷子のペット、保護されているペット、飼い主不明のペット等の情報を1時間に1度収集し、都道府県ごとに分類しています。<br>
                        お住まいの地域やペットが迷子になった都道府県をクリックしてご活用ください。<br>
                        それぞれの投稿は投稿者のSNSにリンクしていますので、飼い主の方や情報に心当たりのある方は投稿をクリックまたはタップすることで投稿者に連絡をとることができます。
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container section-01 mb-5">
        <div class="row justify-content-center">

            <div class="col-md-6 justify-content-between d-flex">
                <a href="{{ route('dog') }}" class="mybtn-01 d-flex justify-content-center bg-white shadow-sm justify-content-between align-items-center rounded text-decoration-none">
                    <div class="d-block w-100">
                        <i class="d-block text-center fas fa-dog font-size-30"></i>
                        <p class="text-center">迷い犬を探す</p>
                    </div>
                </a>

                <a href="{{ route('cat') }}" class="mybtn-01 d-flex justify-content-center bg-white shadow-sm justify-content-between align-items-center rounded text-decoration-none">
                    <div class="d-block w-100">
                        <i class="d-block text-center fas fa-cat font-size-30"></i>
                        <p class="text-center">迷い猫を探す</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <div class="container">
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
