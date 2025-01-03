<?php
require_once '../../model/Restaurante.php';
require_once '../../controllers/RestauranteController.php';

$categoryRestaurantes = null;

if (isset($_GET["buscador"])) {
    $categoryRestaurantes = $restauranteController->fetchCategoryByName($_GET["buscador"]);
    if($categoryRestaurantes == null){
        echo "no hay resultados";
    }
}
    
$restauranteController = new RestauranteController();
$restaurantes = $restauranteController->readAction();

?>

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
                    <a class="nav-link" aria-current="page" href="../private/insertar.php" id="nuevo_restaurante">Nuevo Restaurante</a>
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

<!-- Page Content -->
<div class="container-fluid bg-info">
    <div class="row py-2">
        <div class="col-md-3">
            <img class="img-fluid rounded" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3-amGm2gh_xVI1MX5PrKVbpUN_mxFim5RoA&s" alt="">
        </div>
        <div class="col">
            <h1 class="display-3">Descubra y reserva el mejor restaurante</h1>
            <p class="lead mb-5">una aplicación de 4Vientos.</p>
            <form class="input-group" method="get">
                <input id="buscador" name="buscador" class="form-control"/>
                <button class="btn btn-primary" type="submit" >Buscar</button>
            </form>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="container">
    <div class="row">
        
        <?php
            
            if($categoryRestaurantes != null){
                foreach ($categoryRestaurantes as $restaurante){
                    echo $restaurante->pintarRestaurante();
                }
            }else{
                foreach ($restaurantes as $restaurante){
                    echo $restaurante->pintarRestaurante();
                }
            }
            
        ?> 
    </div>
</div>

<footer class="footer">
    <div class="">
        <span class=""> Cuatrovientos </span>
    </div>
</footer>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>

</html>



