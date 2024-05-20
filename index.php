<?php
include 'qrcode.php';

header('Content-Type: application/json');

// Função para enviar resposta JSON
function sendResponse($status, $message, $qrcode = null) {
    $response = [
        'status' => $status,
        'message' => $message
    ];
    if ($qrcode) {
        $response['qrcode'] = $qrcode;
    }
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lê o conteúdo do corpo da requisição
    $data = file_get_contents('php://input');
    $json = json_decode($data, true);

    if (isset($json['value'])) {
        $value = $json['value'];

        // Gera o QR Code
        $tempDir = sys_get_temp_dir();
        $fileName = tempnam($tempDir, 'qrcode') . '.png';

        try {
            // Verifique se o diretório temporário está acessível
            if (!is_writable($tempDir)) {
                sendResponse('error', 'Diretório temporário não é gravável');
            }

            $options = array(
                'w' => 90,
                'h' => 90
            );
            $generator = new QRCode($value, $options);
            $image = $generator->render_image();
            imagepng($image, $fileName);
            imagedestroy($image);

            if (file_exists($fileName)) {
                // Lê o conteúdo da imagem gerada
                $qrImage = file_get_contents($fileName);
                $base64Image = base64_encode($qrImage);

                // Remove o arquivo temporário
                unlink($fileName);

                // Retorna a imagem como base64
                sendResponse('success', 'QR Code gerado com sucesso', $base64Image);
            } else {
                sendResponse('error', 'Falha ao gerar o QR Code');
            }
        } catch (Exception $e) {
            sendResponse('error', 'Erro ao gerar o QR Code: ' . $e->getMessage());
        }
    } else {
        sendResponse('error', 'Valor não fornecido');
    }
} else {
    sendResponse('error', 'Metodo nao suportado');
}


$options = array(
    'w' => 90,
    'h' => 90
);
$generator = new QRCode($value, $options);