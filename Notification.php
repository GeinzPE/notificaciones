<?php
class Notification {
    private $apiKey;
    private $projectId;

    public function __construct($apiKey, $projectId) {
        $this->apiKey = $apiKey;
        $this->projectId = $projectId;
    }

    public function sendNotificationByTopic($title, $message, $token) {
        // Construye la URL del punto final de la nueva API
        $path_to_firebase_cm = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        // Datos de la notificación
        $fields = array(
            'message' => array(
                'token' => $token,
                'notification' => array('title' => $title, 'body' => $message),
                'android' => array(
                    'ttl' => '604800s' // Tiempo de vida (en segundos)
                )
            )
        );

        // Encabezados
        $headers = array(
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        );

        // Inicializa cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Ejecuta la solicitud
        $result = curl_exec($ch);

        // Maneja la respuesta
        if (!$result) {
            $response["success"] = 100;
            $response["error"] = 'Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch);
        } else {
            $response["success"] = 3;
            $response["statusCode"] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response["message"] = 'Notificación enviada correctamente.';
            $response["response HTTP Body"] = " - " . $result . " -";
        }

        // Cierra la conexión cURL
        curl_close($ch);

        return $response;
    }
}

// Uso del código
$apiKey = 'AIzaSyDO-dk7LQE8BdF-JXjgNhaN6_GJkXhPu80'; // Clave de API
$projectId = 'geinzworkapp'; // ID del proyecto

$notification = new Notification($apiKey, $projectId);
$response = $notification->sendNotificationByTopic("Título", "Mensaje", "TOKEN_DEL_DISPOSITIVO");
print_r($response);
?>
