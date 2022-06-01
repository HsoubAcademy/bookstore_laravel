@extends('layouts.main')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تصنيفات الكتب</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <form action="{{ route('gallery.categories.search') }}" method="GET">
                            <div class="row d-flex justify-content-center">
                                <input type="text" class="col-4 mx-sm-3 mb-2" name="term" placeholder="ابحث عن صنف...">
                                <button type="submit" class="col-1 btn btn-secondary bg-secondary mb-2">ابحث</button>
                            </div>
                        </form>

                    </div>

                    <hr>
                    
                    <br>

                    <h3 class="mb-4">{{ $title }}</h3>

                    @if($categories->count())
                        <ul class="list-group">
                            @foreach($categories as $category)
                                <a style="color:grey" href="{{ route('gallery.categories.show', $category) }}">
                                    <li class="list-group-item">
                                        {{ $category->name }} ({{ $category->books->count() }})
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    @else
                        <div class="col-12 alert alert-info mt-4 mx-auto text-center">
                            لا نتائج                                
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection