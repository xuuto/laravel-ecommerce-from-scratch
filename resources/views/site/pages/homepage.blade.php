@extends('site.app')
@section('title', 'Homepage')

@section('content')
    <h2>homepage</h2>
    <section class="section-pagetop bg-dark">
        <div class="container clearfix">
            @foreach($products as $key => $product)
            <h2 class="title-page">{{ $product->name }}</h2>
            <p>{{$product->description}}</p>
            @endforeach
        </div>
    </section>
@stop