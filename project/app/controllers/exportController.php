<?php

// Função para executar o script Python e retornar o caminho do arquivo CSV
function executePythonScript() {
    return shell_exec('python3 ../../public/py/exportRegister.py');
}

// Função para enviar o arquivo CSV como download
function sendCsvFile($csv_file) {
    if (file_exists($csv_file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . basename($csv_file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($csv_file));
        readfile($csv_file);
        exit;
    } else {
        echo "Erro: Arquivo CSV não encontrado.";
    }
}

// Executar o script Python
$output = executePythonScript();

// Verificar se o script foi executado com sucesso
if (strpos($output, 'work_sessions_last_7_days.csv') !== false) {
    $csv_file = trim($output);
    sendCsvFile($csv_file);
} else {
    echo "Erro na exportação: " . $output;
}
?>