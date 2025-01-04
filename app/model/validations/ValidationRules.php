<?php

class ValidationRules {
    
    public static function test_input($data) {
        // Verifica si el dato está vacío
        if (empty(trim($data))) {
            return null; // Retorna null si el dato está vacío
        }
        //Removes whitespace and other predefined characters from both sides of a string
        $data = trim($data);
        //This PHP function returns a string with backslashes in front of each character that needs to be quoted in a database query
        $data = addslashes($data);
        //The htmlspecialchars() function converts some predefined characters to HTML entities.
        $data = htmlspecialchars($data);
        return $data;
    }
    
    public static function validate_url($data) {
        // Valida si $data es una URL y retorna true o false
        return filter_var($data, FILTER_VALIDATE_URL) !== false;
    }
    
}
