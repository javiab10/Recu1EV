<?php
require_once '../../model/Restaurant.php';
require_once '../../controllers/RestaurantController.php';
require_once '../../controllers/UserController.php';
require_once '../../../utils/SessionUtils.php';

$categoryRestaurantes = null;
$restaurantController = new RestaurantController();

SessionUtils::startSessionIfNotStarted();
$isLogged = $isLogged = SessionUtils::loggedIn();
$type = $isLogged ? $_SESSION['user_type'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["type"] == "login"){
    $email = $_POST["inputEmail"];
    $password = $_POST["inputPass"];    
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (isset($_GET["buscador"])) {
        $categoryRestaurantes = $restaurantController->fetchCategoryByName($_GET["buscador"]);
        if ($categoryRestaurantes == null) {
            echo "no hay resultados";
        }
    }
}
    
$restaurants = $restaurantController->readAction();

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
    <style>
    .custom-hover {
        transition: transform 0.1s ease, color 0.1s ease;
    }

    .custom-hover:hover {
        transform: scale(1.05);
    }
    </style>

</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand ms-1 custom-hover" href="index.php">El Tenedor 4V</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php 
                        if($isLogged){
                            echo '<a class="nav-link" aria-current="page" href="../private/insert.php" id="nuevo_restaurante">Nuevo Restaurante</a>';
                        }
                    ?>
                </li>
            </ul>
            
            <?php 
                if (!$isLogged){
                    echo 
                    '<div class="col-6 d-flex" id="form-login">'.
                        '<form class="d-flex" method="post" action="../../controllers/UserController.php">'.
                            '<input type="hidden" name="type" value="login">'.
                            '<input class="form-control" type="text" placeholder="Email" name="inputEmail" id="inputEmail">'.
                            '<input class="form-control" type="password" placeholder="Password" name="inputPass" id="inputPass">'.
                            '<button class="btn btn-outline-success d-flex align-items-center" type="submit" id="btn-login">'.
                                '<i class="bi bi-door-open px-1"></i> Acceder'.
                            '</button>'.
                        '</form>'.
                    '</div>';
                }else{
                    echo
                    '<div class="col-2 d-flex" id="form-login">'.
                        '<form class="d-flex justify-cotent-around" method="post" action="../../controllers/UserController.php">'.
                            '<label for="type" class="col-form-label me-2">Bienvenido</label>'. 
                            '<input type="hidden" name="type" value="logout">'.
                            '<button class="btn btn-outline-danger d-flex align-items-center" type="submit" id="btn-login">'.
                                '<i class="bi bi-door-open px-1"></i> Salir'.
                            '</button>'.
                        '</form>'.
                    '</div>';
                }                    
                    
            ?>
            
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
            <p class="lead mb-5">Una aplicación de Cuatrovientos</p>
            <form class="input-group" method="get">
                <input id="buscador" name="buscador" class="form-control" placeholder="Categorías: Italiano, Chino, Navarro"/>
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
                foreach ($categoryRestaurantes as $restaurant){
                    echo $restaurant->drawRestaurant($isLogged, $type);
                }
            }else{
                foreach ($restaurants as $restaurant){
                    echo $restaurant->drawRestaurant($isLogged,$type);
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



