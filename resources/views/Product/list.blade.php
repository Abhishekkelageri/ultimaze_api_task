<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=h, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>
<body>
    <h1>Product list</h1>
    <table class="table">
        <thead>
            <tr>
                <th>image</th>
                <th>name</th>
                <th>price</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
    <tr>
        <td><img src="{{ $product->product_image }}" alt=""></td> 
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->product_price }}</td>
        <td class="id" data-id="{{ $product->id }}"><button>Add to cart</button></td>
    </tr>
@endforeach

        </tbody>
    </table>

    <h2>Cart</h2>
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>image</th>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
            @if($cartItems->isEmpty())
                <tr>
                    <td>no data in cart</td>
                </tr>
            @else
            @foreach($cartItems as $item)
                <tr>
                    <td><img src="{{ $item->product->product_image }}" alt=""></td> 
                    <td>{{ $item->product->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->product_price }}</td>
                    <td class="delete" data-id="{{ $item->id }}"><button>Remove</button></td>
                </tr>
            @endforeach
            @endif
            </tbody>
    </table>
<div class="row">
    <span>Grand Total: {{$total}} </span>
</div>
    <script>
        $(document).ready(function(){
           
            $('.id').click(function(){
               var id = $(this).data('id') ;

                $.ajax({
                    url : '{{ route('add.to.cart') }}',
                    method : 'POST',
                    data : {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        product_id : id
                    },
                    success: function(response){
                        if(response.success){
                            location.reload();
                        }else{
                            alert(response.message);
                        }

                    }
                });
            });

            $('.delete').click(function(){
                var id = $(this).data('id');
                console.log(id);

                $.ajax({
                    url : '{{ route('remove')}}',
                    method : 'POST',
                    data : {
                        _token : $('meta[name="csrf-token"]').attr('content'),
                        product_id : id
                    },
                    success : function(response){
                        if(response.success){
                            location.reload();
                        }else{
                            alert(response.message);
                        }
                    }
                });

            });
        });

       
    </script>

</body>
</html>
































