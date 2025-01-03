<?php

require_once(dirname(__FILE__) . '/../controllers/RestauranteController.php');
require_once(dirname(__FILE__) . '/../../persistence/DAO/ReservaDAO.php');
require_once(dirname(__FILE__) . '/../model/validations/ValidationRules.php');
require_once(dirname(__FILE__) . '/../model/Reserva.php');

$reserveController = new ReservaController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["type"] == "reservar") {
    $reserveController->createReserve();
}

class ReservaController {
    const toMainPage = "Location: ../views/public/index.php";
    const toReservar = "Location: ../views/public/reservar.php";
    const msgCamposVacios = "?error=Debes rellenar todos los campos para realizar la reserva&id=";
    const msgFechaNoValida = "?error=La fecha no puede ser anterior a hoy&id=";
    const msgHoraNoValida = "?error=Ya no se puede reservar a esta hora&id=";
    const msgIPNoAceptada = "?error=Debes aceptar el uso de tu IP&id=";
    
    public function __construct() {
        
    }
    
    function createReserve(){
        date_default_timezone_set('Europe/Madrid');
        $fecha = new DateTime();        
        
        $reserveDAO = new ReservaDAO();
        $restauranteController = new RestauranteController();
        $id_restaurant = $restauranteController->checkID();
        $dia = $_POST["fecha"];
        $hora = $_POST["hora"];
        $date = $dia." ". $hora;
        $persons = $_POST["comensales"];
        $IP = $_SERVER['REMOTE_ADDR'];        
        
        if($dia==null||$hora==null||$persons==null){
            $restauranteController->redirectWithError(self::toReservar, self::msgCamposVacios.$id_restaurant);
        }
        
        if($IP==null){
            $restauranteController->redirectWithError(self::toReservar, self::msgIPNoAceptada.$id_restaurant);
        }
        
        if($dia < $fecha->format("Y-m-d")){
            $restauranteController->redirectWithError(self::toReservar, self::msgFechaNoValida.$id_restaurant);
        }
        
        if($dia == $fecha->format("Y-m-d") && $hora <= $fecha->format("H:i:s")){
            $restauranteController->redirectWithError(self::toReservar, self::msgHoraNoValida.$id_restaurant);
        }
        
        $reserve = new Reserva();
        $reserve->setId_restaurant($id_restaurant);
        $reserve->setDate($date);
        $reserve->setPersons($persons);
        $reserve->setIP($IP);
        $reserveDAO->reserve($reserve);
        
        header(self::toMainPage);
    }

}
