<?php

class RapidPrestAPI {
    private $baseUrl = "http://149.202.12.81/rapidprest_i2/public/api";
    private $apiToken = "sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w";

    private function callAPI($endpoint, $postFields = []) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "authorization: Bearer " . $this->apiToken
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function checkAvailability($cod_maq) {
        $endpoint = "/maq/comprueba_disponibilidad/{$cod_maq}";
        return $this->callAPI($endpoint);
    }

    public function generateQR($cod_maq, $amount, $authorizationNumber) {
        $endpoint = "/maq1/generarqr/{$cod_maq}";
        $postFields = [
            "cantidad" => $amount,
            "numeroautorizacion" => $authorizationNumber
        ];
        return $this->callAPI($endpoint, $postFields);
    }
}

// Uso de la clase
$api = new RapidPrestAPI();

// Comprobar disponibilidad para la máquina 1
$response = $api->checkAvailability("123456789");
if ($response['state'] == 200) {
    echo "Consulta Correcta";
    print_r($response['data']);
} else {
    echo "Error: " . $response['message'];
}

// Generar QR para la máquina 1 con una cantidad de 100 y un número de autorización
$response = $api->generateQR("123456789", 100, "someAuthNumber");
if ($response['state'] == 200) {
    echo "Consulta Correcta";
    print_r($response['data']);
} else {
    echo "Error: " . $response['message'];
}

?>
