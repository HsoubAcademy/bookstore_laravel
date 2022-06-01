<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body dir="rtl">
    <p>مرحبًا {{$user->name}}</p>
    <p>لقد استلمنا طلبك بنجاح</p>
    <br/>

    <table style="width: 600px; text-align:right">
        <thead>
            <tr>
                <th>عنوان الكتاب</th>
                <th>السعر</th>
                <th>عدد النسخ</th>
                <th>السعر الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subTotal = 0
            @endphp
            @foreach($order as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->price }}$</td>
                    <td>{{ $product->pivot->number_of_copies }}</td>
                    <td>{{ $product->price * $product->pivot->number_of_copies}}$</td>
                    @php
                        $subTotal += $product->price * $product->pivot->number_of_copies
                    @endphp
                </tr>
            @endforeach
            <hr>
            <tr>
                <td colspan="3" style="border-top:1px solid #ccc;"></td>
                <td style="font-size:15px;font-weight:bold;border-top:1px solid #ccc;">المجموع الكلي : ${{$subTotal}}</td>
            </tr>
        </tbody>
    </table>  
    
</body>
</html>