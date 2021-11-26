<html lang="en">
<head>
    <title>Laravel Linkedin Login</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Laravel Linkedin Login</h2><br/>


        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <a href="{{ url('/redirect/linkedin') }}" class="btn btn-primary">Login With Linkedin</a>
                <button type="submit" class="btn btn-success">Login</button>
            </div>
        </div>


</div>
</body>
</html>