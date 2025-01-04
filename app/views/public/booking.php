<?php
require_once (dirname(__FILE__).'../../../controllers/RestaurantController.php');

$restaurantController = new RestaurantController();

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
<form class="container" method="post" action="../../controllers/ReservaController.php">
    <input type="hidden" id="type" name="type" value="booking">
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["type"] == "book") {
            //Llamada que hace la edición en la BD
            $id=$_POST["id"];
            echo '<input type="hidden" name="id" value="'.$id.'">';
            echo '<h1 class="mt-4 display 2 text-center">Reservar en '.$restaurantController->fetchRestaurantById($id).'</h1>';
        }
        
        if (isset($_GET['error'])) {
            $id = $_GET['id'];
            echo "<p>{$_GET['error']}</p>";
            echo '<input type="hidden" name="id" value="'.$id.'">';
            echo '<h1 class="mt-4 display 2 text-center">Reservar en '.$restaurantController->fetchRestaurantById($id).'</h1>';
        }
    ?>
    <div class="row p-3 justify-content-center">
        <label for="comensales" class="col-2 col-form-label">Comensales</label>
        <div class="col-2">
            <select class="form-select" id="comensales" name="comensales" >
                <?php
                    for($i = 1; $i <= 10; $i++){
                        echo "<option value=".$i.">".$i."</option>";
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row p-3 justify-content-center">
        <label for="fecha" class="col-2 col-form-label">Fecha</label>
        <div class="col-2">
            <input type="date" class="form-control" id="fecha" name="fecha">
        </div>
    </div>
    <div class="row p-3 justify-content-center">
        <label for="hora" class="col-2 col-form-label">Hora</label>
        <div class="col-2">    
            <select class="form-select" id="hora" name="hora">
                <<option value="14:00:00">14:00</option>
                <<option value="21:00:00">21:00</option>
            </select>
        </div>
    </div>
    <!-- Casilla de verificación para obtener consentimiento de la IP -->
    <div class="row p-3 justify-content-center">
        <div class="col-12 text-center">
            <input type="checkbox" class="form-check-input" id="consentimiento_ip" name="consentimiento_ip" value="1" required="true">
            <label for="consentimiento_ip">Acepto que se use mi dirección IP para realizar la reserva</label>
        </div>
    </div>
    <div class="row p-3">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success" id="btn_reservar">Reservar</button>
        </div>
    </div>
</form>
<!-- FIN DEL FORMULARIO  -->