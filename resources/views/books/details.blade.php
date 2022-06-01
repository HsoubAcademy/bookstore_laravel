@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">عرض تفاصيل الكتاب</div>

                <div class="card-body">
                    <table class="table table-stribed">
                        @auth
                            <div class="form text-center mb-2">
                                <input id="bookId" type="hidden" value="{{ $book->id }}">
                                <span class="text-muted mb-3"><input class="form-control d-inline mx-auto" id="quantity" name="quantity" type="number" value="1" min="1" max="{{ $book->number_of_copies }}" style="width:10%;" required></span> 
                                <button type="submit" class="btn bg-cart addCart me-2"><i class="fa fa-cart-plus"></i> أضف للسلة</button>
                            </div>
                        @endauth
                        <hr>
                        <tr>
                            <th>العنوان</th>
                            <td class="lead"><b>{{ $book->title }}</b></td>
                        </tr>

                        <tr>
                            <th>تقييم المستخدمين</th>
                            <td>
                                <span class="score">
                                    <div class="score-wrap">
                                        <span class="stars-active" style="width:{{ $book->rate()*20 }}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                        
                                        <span class="stars-inactive">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </span>

                                <span>عدد المقيّمين {{ $book->ratings()->count() }} مستخدم</span>
                            </td>
                        </tr>

                        @if ($book->isbn)
                            <tr>
                                <th>الرقم التسلسلي</th>
                                <td>{{ $book->isbn }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>صورة الغلاف</th>
                            <td><img class="img-fluid img-thumbnail" src="{{ asset('storage/' . $book->cover_image) }}"></td>
                        </tr>
                        @if ($book->category)
                            <tr>
                                <th>التصنيف</th>
                                <td>{{ $book->category->name }}</td>
                            </tr>
                        @endif
                        @if ($book->authors()->count() > 0)
                            <tr>
                                <th>المؤلفون</th>
                                <td>
                                    @foreach ($book->authors as $author)
                                        {{ $loop->first ? '' : 'و' }}
                                        {{ $author->name }}
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        @if ($book->publisher)
                            <tr>
                                <th>الناشر</th>
                                <td>{{ $book->publisher->name }}</td>
                            </tr>
                        @endif
                        @if ($book->description)
                            <tr>
                                <th>الوصف</th>
                                <td>{{ $book->description }}</td>
                            </tr>
                        @endif
                        @if ($book->publish_year)
                            <tr>
                                <th>سنة النشر</th>
                                <td>{{ $book->publish_year }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>عدد الصفحات</th>
                            <td>{{ $book->number_of_pages }}</td>
                        </tr>
                        <tr>
                            <th>عدد النسخ</th>
                            <td>{{ $book->number_of_copies }}</td>
                        </tr>
                        <tr>
                            <th>السعر</th>
                            <td>{{ $book->price }} $</td>
                        </tr>
                    </table>
                    @auth
                        <h4 class="mb-3">قيّم هذا الكتاب<h4>
                        @if ($bookfind)
                            @if(auth()->user()->rated($book))
                                <div class="rating">
                                    <span class="rating-star {{ auth()->user()->bookRating($book)->value == 5 ? 'checked' : '' }}" data-value="5"></span>
                                    <span class="rating-star {{ auth()->user()->bookRating($book)->value == 4 ? 'checked' : '' }}" data-value="4"></span>
                                    <span class="rating-star {{ auth()->user()->bookRating($book)->value == 3 ? 'checked' : '' }}" data-value="3"></span>
                                    <span class="rating-star {{ auth()->user()->bookRating($book)->value == 2 ? 'checked' : '' }}" data-value="2"></span>
                                    <span class="rating-star {{ auth()->user()->bookRating($book)->value == 1 ? 'checked' : '' }}" data-value="1"></span>
                                </div>
                            @else
                                <div class="rating">
                                    <span class="rating-star" data-value="5"></span>
                                    <span class="rating-star" data-value="4"></span>
                                    <span class="rating-star" data-value="3"></span>
                                    <span class="rating-star" data-value="2"></span>
                                    <span class="rating-star" data-value="1"></span>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-danger mt-4" role="alert">
                                    يجب شراء الكتاب لتستطيع تقيمه
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('.rating-star').click(function() {
            
            var submitStars = $(this).attr('data-value');

            $.ajax({
                type: 'post',
                url: {{ $book->id }} + '/rate',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'value' : submitStars
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    toastr.error('حدث خطأ ما')
                },
            });
        });
    </script>

    <script>
        $('.addCart').on('click', function(event) {
            var token = '{{ Session::token() }}';
            var url = "{{ route('cart.add') }}";

            event.preventDefault();

            var bookId = $(this).parents(".form").find("#bookId").val()
            var quantity = $(this).parents(".form").find("#quantity").val()


            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    quantity: quantity, 
                    id: bookId,
                    _token: token
                },
                success : function(data) {            
                    $('span.badge').text(data.num_of_product);
                    toastr.success('تم إضافة الكتاب بنجاح')
                },
                error: function() {
                    alert('حدث خطأ ما');
                }
            })  
        });
    </script>
@endsection