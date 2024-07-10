<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Document</title>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td scope="row"><img src="{{ $product -> product_image}}" alt=""></td>
                <td>{{$product -> product_name}}</td>
                <td>{{$product -> product_price}}</td>
                <td><button class="cart" data-id = "{{ $product ->id }}">Add to cart</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Cart Items</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
            <tr>
                <td scope="row"><img src="{{$item->product->product_image}}" alt=""></td>
                <td>{{$item->product->product_name}}</td>
                <td>{{$item->product->product_price}}</td>
                <td>{{$item->quantity}}</td>
                <td><button class="id" data-id = "{{$item->id}}"> remove </button></td>
            </tr>
           @endforeach
        </tbody>
    </table>
</body>

<script>
    $(document).ready(function(){

        $('.cart').click(function(){
            var id = $(this).data('id');

            $.ajax({
                url : ' {{route("addToCart")}}',
                method : 'POST',
                data : {
                    _token : $('meta[name = "csrf-token"]').attr('content'),
                    id : id
                },
                success : function(response){
                    if(response.success){
                        location.reload();
                    } else{
                        alert(response.message);
                    }
                }
            });
        });

        $('.id').click(function(){
            var id = $(this).data('id');

            $.ajax({
                url : ' {{route('delete')}} ',
                method : 'POST',
                data : {
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    id : id
                },
                success : function(response){
                    if(response.success){
                        location.reload();
                    } else{
                        alert(response.message);
                    }
                }

            });

        });
    });
</script>
</html>