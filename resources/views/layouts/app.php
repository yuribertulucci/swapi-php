<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Application</title>

    <!-- Bootstrap CSS and JS -->
    <link rel="stylesheet" type="text/css" href="/assets/bootstrap/css/bootstrap.min.css">
    <script type="application/javascript" src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script type="application/javascript" src="/assets/jquery/jquery.min.js"></script>
</head>
<body>
    <header class="bg-danger">
        <h1>My Application Header</h1>
    </header>
    <main>
        {{ $slot }}
    </main>
</body>
</html>


<script>
</script>