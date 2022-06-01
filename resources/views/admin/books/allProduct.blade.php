@extends('theme.default')

@section('head')
<link href="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('heading')
جميع المشتريات
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <table id="books-table" class="table table-striped table-bordered text-right" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>المشتري</th>
                    <th>الكتاب</th>
                    <th>السعر</th>
                    <th>عدد النسخ</th>
                    <th>السعر الإجمالي</th>
                    <th>تاريخ الشراء</th>
                </tr>
            </thead>

            <tbody>
                @foreach($allBooks as $product)
                    <tr>
                        <td>{{ $product->user::find($product->user_id)->name }}</td>
                        <td><a href="{{ route('book.details', $product->book_id) }}">{{ $product->book::find($product->book_id)->title }}</a></td>
                        <td>{{ $product->price }}$</td>
                        <td>{{ $product->number_of_copies }}</td>
                        <td>{{ $product->price * $product->number_of_copies}}$</td>
                        <td>{{  $product->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<!-- Page level plugins -->
<script src="{{ asset('theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#books-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            }
        });
    });
</script>
@endsection