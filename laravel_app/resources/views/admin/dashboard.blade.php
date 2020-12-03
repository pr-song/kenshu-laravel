@extends('layouts.master')

@section('title', 'マイ記事')

@section('content')
@include('partials.message')
<div class="jumbotron">
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            ユーザー数
            <span class="badge badge-primary badge-pill">{{ $number_of_users }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            記事数
            <span class="badge badge-primary badge-pill">{{ $number_of_articles }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            タグ数
            <span class="badge badge-primary badge-pill">{{ $number_of_tags }}</span>
        </li>
    </ul>
</div>

<div class="jumbotron">
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-primary mb-3" style="max-width: 25rem;">
                <div class="card-header">ユーザー管理</div>
                <div class="card-body">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">ユーザーリスト</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-3" style="max-width: 25rem;">
                <div class="card-header">記事管理</div>
                <div class="card-body">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">記事リスト</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-info mb-3" style="max-width: 25rem;">
                <div class="card-header">タグ管理</div>
                <div class="card-body">
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-info">タグリスト</a>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-info">新しいタグ作成</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection