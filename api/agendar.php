<?php
require_once 'config.php';

header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['nome']) || !isset($data['whatsapp'])) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit;
}

$nome = $data['nome'];
$whatsapp = $data['whatsapp'];
$servico = $data['servico'] ?? 'Não informado';

try {
    $db = get_db_connection();

    $stmt = $db->prepare("INSERT INTO agendamentos (nome, whatsapp, servico) VALUES (:nome, :whatsapp, :servico)");
    $stmt->execute([
        ':nome' => $nome,
        ':whatsapp' => $whatsapp,
        ':servico' => $servico
    ]);

    echo json_encode(['success' => true, 'message' => 'Agendamento salvo com sucesso no painel!']);

}
catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar: ' . $e->getMessage()]);
}
?>
