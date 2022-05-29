<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav main-nav">
                @foreach($categories as $cat)
                    @foreach($cat->children as $category)
                        @if ($category->children->count() > 0)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ route('category.show', $category->slug) }}"
                                   {{--                                   id="{{ $category->slug }}"--}}
                                 aria-haspopup="true"
                                   aria-expanded="false">{{ $category->name }}</a>
                                <div class="dropdown-menu" aria-labelledby="{{ $category->slug }}">
                                    {{--                                    @foreach($category as $item)--}}
                                    @foreach($category->children as $childCat)
                                        {{--                                        @php dump($childCat->menu ) @endphp--}}
                                        @if($childCat->menu > 0)
                                            <a class="dropdown-item"
                                               href="{{ route('category.show', $childCat->slug) }}">{{
                                        $childCat->name }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
</nav>