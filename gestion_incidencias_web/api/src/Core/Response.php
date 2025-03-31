<?php
    #Llamamos al namespace
    namespace App\Core;

    #Creamos la clase y la propiedad estática
    class Response{
        #Creamos un método estático JSON cuya funcionalidad
        #es convertir el dato a formato JSON y mostrarlo
        public static function json($data, int $code = 200): void
        {
            http_response_code($code);
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }

        #Creamos un método estático Error que llama al método JSON
        #para enviar la respuesta en caso de haber un error
        public static function error(string $message, int $code = 400): void
        {
            self::json([
                'success' => false,
                'message' => $message
            ], $code);
        }
        
        #Creamos un método estático Success
        public static function success($data = [], string $message = '', int $code = 200): void
        {
            $response = ['success' => true];
            if (!empty($message)) $response['message'] = $message;
            if (!empty($data)) $response['data'] = $data;
    
            self::json($response, $code);
        }
    }
?>