<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Document</title>
</head>
<body>
   
   <div class="container" style="text-align-center">
    <form action="{{route('store')}}" method="post">
        @csrf
            <label for="fname">First name:</label><br>
            <input type="text" id="fname" name="fname" value=""><br>
            <label for="lname">Last name:</label><br>
            <input type="text" id="lname" name="lname" value=""><br><br>
            <label for="emial">Emial:</label><br>
            <input type="email" id="email" name="email" value=""><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value=""><br><br>
            <input type="submit" value="Submit">
        </form> 
   </div>
</body>
</html>