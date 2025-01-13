<?php
require_once (dirname(__FILE__).'../../../controllers/RestaurantController.php');
require_once (dirname(__FILE__).'../../../model/Restaurant.php');
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
            <a class="navbar-brand ms-1 custom-hover" href="../public/index.php">El Tenedor 4V</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="../public/index.php" id="inicio">Inicio</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- FORMULARIO DE INSERCIÓN -->
<form class="container" method="post" action="../../controllers/RestaurantController.php">
    <input type="hidden" id="type" name="type" value="edit">
    <?php
        $restaurantController = new RestaurantController;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["type"] == "modify") {
            //Llamada que hace la edición en la BD
            $id=$_POST["id"];
            $restaurant = $restaurantController->fetchFullRestaurantById($id);
            echo '<input type="hidden" name="id" value="'.$restaurant->getId().'">';
        }
        
        if (isset($_GET['error'])) {
            echo "<p>{$_GET['error']}</p>";
            $id = $_GET['id'];
            $restaurant = $restaurantController->fetchFullRestaurantById($id);
            echo '<input type="hidden" name="id" value="'.$restaurant->getId().'">';
        }
    ?>
    <div class="row p-3">
        <label for="name" class="col-2 col-form-label">
            Nombre
        </label>
        <div class="col-10">
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $restaurant->getName();?>">
        </div>
    </div>
    <div class="row p-3">
        <label for="cover" class="col-2 col-form-label">URL Imagen</label>
        <div class="col-10">
            <input type="text" class="form-control" id="picture" name="picture" value="<?php echo $restaurant->getImage();?>">
        </div>
    </div>
    <div class="row p-3">
        <label for="menu" class="col-2 col-form-label">Menu</label>
        <div class="col-10">
            <textarea class="form-control" id="menu" name="menu" style="height: 100px"><?php echo $restaurant->getMenu();?></textarea>
        </div>
    </div>
    <div class="row p-3">
        <label for="minorprice" class="col-2 col-form-label">Precio Mínimo</label>
        <div class="col-10">
            <input type="text" class="form-control" id="minorprice" name="minorprice" value="<?php echo $restaurant->getMinorprice();?>">
        </div>
    </div>
    <div class="row p-3">
        <label for="mayorprice" class="col-2 col-form-label">Precio Máximo</label>
        <div class="col-10">
            <input type="text" class="form-control" id="mayorprice" name="mayorprice" value="<?php echo $restaurant->getMayorprice();?>">
        </div>
    </div>
    <div class="row p-3">
        <label for="category" class="col-2 col-form-label">Categoría</label>
        <div class="col-10">
            <select class="form-select" id="category" name="category" >
                <?php 
                    $idCategory = $restaurant->getIdCategory();
                    $restaurantCategory = $restaurantController->fetchCategoryNameById($idCategory);
                    if($restaurantCategory == 'Italiano'){
                        echo '<option value="Italiano" selected>Italiano</option>';
                        echo '<option value="Chino">Chino</option>';
                        echo '<option value="Navarro">Navarro</option>';
                    }else if($restaurantCategory == 'Chino'){
                        echo '<option value="Italiano">Italiano</option>';
                        echo '<option value="Chino" selected>Chino</option>';
                        echo '<option value="Navarro">Navarro</option>';
                    }else if($restaurantCategory == 'Navarro'){
                        echo '<option value="Italiano">Italiano</option>';
                        echo '<option value="Chino">Chino</option>';
                        echo '<option value="Navarro" selected>Navarro</option>';
                    }else{
                        echo '<option selected>Selecciona una Categoría</option>';
                        echo '<option value="Italiano">Italiano</option>';
                        echo '<option value="Chino">Chino</option>';
                        echo '<option value="Navarro">Navarro</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row p-3">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success" id="btn_modificar">Modificar</button>
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