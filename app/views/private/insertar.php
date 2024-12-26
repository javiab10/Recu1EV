<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>El Tenedor 4V</title>
    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">El Tenedor 4V</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="../public/index.php" id="inicio">Inicio</a>
                </li>
            </ul>
            <div class="d-flex" id="form-login">
                <input class="form-control" type="text" placeholder="User" aria-label="User" id="input-login">
                <input class="form-control" type="password" placeholder="Password" aria-label="Password" id="input-pass">
                <button class="btn btn-outline-success d-flex align-items-center" type="submit" id="btn-login">
                    <i class="bi bi-door-open px-1"></i> Acceder
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- FORMULARIO DE INSERCIÓN -->
<form class="container" method="post" action="../../controllers/RestauranteController.php">
    <input type="hidden" id="type" name="type" value="create">
    <?php
        if (isset($_GET['error'])) {
            echo "<p>{$_GET['error']}</p>";
        }

    ?>
    <div class="row p-3">
        <label for="name" class="col-2 col-form-label">
            Nombre
        </label>
        <div class="col-10">
            <input type="text" class="form-control" name="name" id="name" placeholder="Nombre">
        </div>
    </div>
    <div class="row p-3">
        <label for="cover" class="col-2 col-form-label">URL Imagen</label>
        <div class="col-10">
            <input type="text" class="form-control" id="picture" name="picture" placeholder="Picture">
        </div>
    </div>
    <div class="row p-3">
        <label for="menu" class="col-2 col-form-label">Menu</label>
        <div class="col-10">
            <textarea class="form-control" id="menu" name="menu" style="height: 100px" placeholder="menu"></textarea>
        </div>
    </div>
    <div class="row p-3">
        <label for="minorprice" class="col-2 col-form-label">Precio Mínimo</label>
        <div class="col-10">
            <input type="text" class="form-control" id="minorprice" name="minorprice" placeholder="Minor Price">
        </div>
    </div>
    <div class="row p-3">
        <label for="mayorprice" class="col-2 col-form-label">Precio Máximo</label>
        <div class="col-10">
            <input type="text" class="form-control" id="mayorprice" name="mayorprice" placeholder="Mayor Price">
        </div>
    </div>
    <div class="row p-3">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success" id="boton_crear">Crear</button>
        </div>
    </div>
</form>
<!-- FIN DEL FORMULARIO  -->

<footer class="">
    Cuatrovientos
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>

</html>
