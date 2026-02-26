<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['pz_logged'])) {
    header("Location: login.php");
    exit;
}

$db = get_db_connection();

// Lógica de Atualização de Status
if (isset($_POST['update_status'])) {
    $stmt = $db->prepare("UPDATE agendamentos SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $_POST['status'], 'id' => $_POST['id']]);
}

// Buscar Agendamentos
$query = $db->query("SELECT * FROM agendamentos ORDER BY id DESC");
$leads = $query->fetchAll();

$totalLeads = count($leads);
$pendentes = count(array_filter($leads, fn($l) => $l['status'] == 'Pendente'));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel MySQL | Clínica Pizane</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #E31B23;
            --sidebar-bg: #1A1A1A;
            --bg-light: #F9F9F9;
            --gold: #D4AF37;
            --text-dark: #333;
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg-light); margin: 0; display: flex; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar-bg); height: 100vh; color: white; padding: 30px 20px; position: fixed; }
        .logo { font-family: 'Cinzel', serif; color: var(--gold); font-size: 22px; margin-bottom: 50px; text-align: center; }
        .nav-link { display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.7); text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 10px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: var(--primary); color: white; }

        /* Main Content */
        .content { margin-left: 260px; width: calc(100% - 260px); padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        h1 { font-family: 'Cinzel', serif; color: var(--primary); margin: 0; }

        /* Dashboard Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 10px 30px rgba(227, 27, 35, 0.05); }
        .stat-card h3 { font-size: 13px; color: #6B5E62; text-transform: uppercase; margin: 0 0 10px 0; }
        .stat-card p { font-size: 32px; font-weight: 700; color: var(--primary); margin: 0; }

        /* Table leads */
        .table-container { background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #fdfafb; padding: 15px 20px; text-align: left; font-size: 12px; color: #6B5E62; text-transform: uppercase; border-bottom: 1px solid #eee; }
        td { padding: 18px 20px; border-bottom: 1px solid #f9f9f9; font-size: 14px; color: var(--text-dark); }
        
        .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .status-Pendente { background: #fff3cd; color: #856404; }
        .status-Atendido { background: #d4edda; color: #155724; }
        .status-Cancelado { background: #f8d7da; color: #721c24; }

        .btn-zap { background: #25D366; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; transition: 0.3s; }
        .btn-zap:hover { opacity: 0.8; }

        select { padding: 5px; border-radius: 4px; border: 1px solid #ddd; font-size: 12px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">PIZANE MySQL</div>
        <a href="#" class="nav-link active"><i class="fas fa-calendar-check"></i> Agendamentos</a>
        <a href="#" class="nav-link"><i class="fas fa-users"></i> Pacientes</a>
        <div style="position: absolute; bottom: 30px; width: calc(100% - 40px);">
            <a href="logout.php" class="nav-link" style="color: #e74c3c;"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </div>
    </div>

    <div class="content">
        <div class="header">
            <div>
                <h1>Gestão MySQL</h1>
                <p style="color: #6B5E62; margin-top: 5px;">Sistema otimizado para Banco de Dados MySQL.</p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Leads Totais</h3>
                <p><?php echo $totalLeads; ?></p>
            </div>
            <div class="stat-card">
                <h3>Pendentes</h3>
                <p><?php echo $pendentes; ?></p>
            </div>
            <div class="stat-card">
                <h3>Taxa de Resposta</h3>
                <p><?php echo $totalLeads > 0 ? round((($totalLeads - $pendentes) / $totalLeads) * 100) : 0; ?>%</p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Nome</th>
                        <th>WhatsApp</th>
                        <th>Serviço</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($leads)): ?>
                        <tr><td colspan="6" style="text-align: center; color: #999;">Nenhum agendamento (MySQL).</td></tr>
                    <?php
endif; ?>
                    <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td><?php echo date('d/m/H:i', strtotime($lead['data_criacao'])); ?></td>
                        <td style="font-weight: 600;"><?php echo $lead['nome']; ?></td>
                        <td><?php echo $lead['whatsapp']; ?></td>
                        <td><span style="color: var(--primary); font-weight: 500;"><?php echo $lead['servico']; ?></span></td>
                        <td>
                            <form method="POST" style="display: flex; gap: 5px; align-items: center;">
                                <input type="hidden" name="id" value="<?php echo $lead['id']; ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="Pendente" <?php if ($lead['status'] == 'Pendente')
        echo 'selected'; ?>>Pendente</option>
                                    <option value="Atendido" <?php if ($lead['status'] == 'Atendido')
        echo 'selected'; ?>>Atendido</option>
                                    <option value="Cancelado" <?php if ($lead['status'] == 'Cancelado')
        echo 'selected'; ?>>Cancelado</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                        <td>
                            <?php
    $zapNum = preg_replace('/\D/', '', $lead['whatsapp']);
    if (strlen($zapNum) < 11)
        $zapNum = "22" . $zapNum;
?>
                            <a href="https://wa.me/55<?php echo $zapNum; ?>" target="_blank" class="btn-zap">
                                <i class="fab fa-whatsapp"></i> Chamar
                            </a>
                        </td>
                    </tr>
                    <?php
endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
