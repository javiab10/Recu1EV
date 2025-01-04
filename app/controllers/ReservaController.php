<?php

require_once(dirname(__FILE__) . '/../controllers/RestaurantController.php');
require_once(dirname(__FILE__) . '/../../persistence/DAO/ReservaDAO.php');
require_once(dirname(__FILE__) . '/../model/validations/ValidationRules.php');
require_once(dirname(__FILE__) . '/../model/Book.php');

$bookController = new ReservaController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["type"] == "booking") {
    $bookController->createBook();
}

class ReservaController {
    const toMainPage = "Location: ../views/public/index.php";
    const toBooking = "Location: ../views/public/booking.php";
    const msgEmptyFields = "?error=Debes rellenar todos los campos para realizar la reserva&id=";
    const msgInvalidDate = "?error=La fecha no puede ser anterior a hoy&id=";
    const msgInvalidTime = "?error=Ya no se puede reservar a esta hora&id=";
    const msgUncheckedIP = "?error=Debes aceptar el uso de tu IP&id=";
    
    public function __construct() {
        
    }
    
    function createBook(){
        date_default_timezone_set('Europe/Madrid');
        $dateTime = new DateTime();        
        
        $bookDAO = new ReservaDAO();
        $restaurantController = new RestaurantController();
        $id_restaurant = $restaurantController->checkID();
        $date = $_POST["fecha"];
        $time = $_POST["hora"];
        $dateAndTime = $date." ". $time;
        $persons = $_POST["comensales"];
        $IP = $_SERVER['REMOTE_ADDR'];        
        
        if($date==null||$time==null||$persons==null){
            $restaurantController->redirectWithError(self::toBooking, self::msgEmptyFields.$id_restaurant);
        }
        
        if($IP==null){
            $restaurantController->redirectWithError(self::toBooking, self::msgUncheckedIP.$id_restaurant);
        }
        
        if($date < $dateTime->format("Y-m-d")){
            $restaurantController->redirectWithError(self::toBooking, self::msgInvalidDate.$id_restaurant);
        }
        
        if($date == $dateTime->format("Y-m-d") && $time <= $dateime->format("H:i:s")){
            $restaurantController->redirectWithError(self::toBooking, self::msgInvalidTime.$id_restaurant);
        }
        
        $reserve = new Book();
        $reserve->setId_restaurant($id_restaurant);
        $reserve->setDate($dateAndTime);
        $reserve->setPersons($persons);
        $reserve->setIP($IP);
        $bookDAO->book($reserve);
        
        header(self::toMainPage);
    }

}
