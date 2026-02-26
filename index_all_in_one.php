<?php
/**
 * CLINICA PIZANE - VERSÃO SINGLE FILE (HTML + PHP + JS)
 * Este arquivo contém o site completo e a lógica de agendamento integrada.
 * Pode ser colado diretamente em hospedagens PHP ou usado como demonstração.
 */

// 1. CONFIGURAÇÕES E CONEXÃO (Lógica integrada do config.php)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'pizane_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

function get_db_connection()
{
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    catch (PDOException $e) {
        return null; // Retorna nulo se falhar, o script tratará abaixo
    }
}

// 2. LÓGICA DE PROCESSAMENTO DO AGENDAMENTO (Integrada do agendar.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_scheduling'])) {
    header('Content-Type: application/json');

    $nome = $_POST['nome'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $servico = $_POST['servico'] ?? 'Não informado';

    if (empty($nome) || empty($whatsapp)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, preencha nome e WhatsApp.']);
        exit;
    }

    $pdo = get_db_connection();
    if (!$pdo) {
        echo json_encode(['success' => false, 'message' => 'Erro técnico: Não foi possível conectar ao banco de dados MySQL. Verifique as credenciais.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO agendamentos (nome, whatsapp, servico) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $whatsapp, $servico]);
        echo json_encode(['success' => true, 'message' => 'Agendamento solicitado com sucesso! Entraremos em contato em breve.']);
    }
    catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar agendamento: ' . $e->getMessage()]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Pizane Estética e Saúde Avançada | Itaperuna e Região</title>
    <meta name="description"
        content="Especialistas em Estética Avançada Facial e Corporal em Itaperuna. Botox, Harmonização, Emagrecimento, Depilação a Laser e muito mais. Agende sua avaliação.">
    <meta name="color-scheme" content="light">
    <meta name="theme-color" content="#FFFFFF">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS INTEGRADO E MINIFICADO */
        html,body{margin:0!important;padding:0!important;width:100%!important;overflow-x:hidden!important;font-family:'Inter',sans-serif!important;scroll-behavior:smooth!important;background-color:#FFFFFF!important;color:#333333!important;-webkit-font-smoothing:antialiased!important}.elementor-section,.elementor-column,.elementor-widget-html{width:100%!important;max-width:100%!important;padding:0!important;margin:0!important;background:transparent!important}*,*::before,*::after{box-sizing:border-box!important}:root{--primary:#E31B23;--primary-light:#FF4D4D;--primary-dark:#B3141A;--gold:#D4AF37;--accent:#F2F2F2;--bg-light:#F9F9F9;--text-dark:#1A1A1A;--text-muted:#666666;--white:#FFFFFF}h1,h2,h3,.heading-serif{font-family:'Cinzel',serif!important;color:var(--primary)!important;margin:0!important;line-height:1.2!important}.pz-header{position:fixed!important;top:0!important;width:100%!important;background:rgba(255,255,255,0.95)!important;backdrop-filter:blur(10px)!important;box-shadow:0 4px 20px rgba(227,27,35,0.08)!important;z-index:9999!important;padding:15px 0!important;transition:all 0.3s ease!important}.pz-container{width:100%!important;max-width:1200px!important;margin:0 auto!important;padding:0 20px!important}.pz-nav-wrapper{display:flex!important;justify-content:space-between!important;align-items:center!important}.pz-logo{font-family:'Cinzel',serif!important;font-size:28px!important;font-weight:700!important;color:var(--primary)!important;text-decoration:none!important;display:flex!important;flex-direction:column!important;line-height:1!important;letter-spacing:2px!important}.pz-logo span{font-family:'Inter',sans-serif!important;font-size:11px!important;letter-spacing:1px!important;color:var(--gold)!important;font-weight:500!important;margin-top:4px!important}.pz-btn-primary{background:linear-gradient(135deg,var(--primary)0%,var(--primary-dark)100%)!important;color:var(--white)!important;padding:12px 28px!important;border-radius:50px!important;font-weight:600!important;font-size:15px!important;text-decoration:none!important;display:inline-flex!important;align-items:center!important;gap:8px!important;box-shadow:0 10px 20px rgba(227,27,35,0.2)!important;transition:transform 0.3s ease,box-shadow 0.3s ease!important;border:none!important;cursor:pointer!important}.pz-btn-primary:hover{transform:translateY(-2px)!important;box-shadow:0 15px 25px rgba(227,27,35,0.3)!important}.pz-hero{padding:180px 0 100px 0!important;background:radial-gradient(circle at 80% 50%,rgba(203,163,88,0.08)0%,rgba(253,251,249,1)50%)!important;position:relative!important;overflow:hidden!important}.pz-hero-grid{display:grid!important;grid-template-columns:1.1fr 0.9fr!important;gap:50px!important;align-items:center!important}.pz-hero-content h1{font-size:52px!important;margin-bottom:24px!important}.pz-hero-content p{font-size:18px!important;color:var(--text-muted)!important;line-height:1.7!important;margin-bottom:40px!important;max-width:90%0!important}.pz-hero-image-wrap{position:relative!important;border-radius:20px 20px 100px 20px!important;overflow:hidden!important;box-shadow:0 30px 60px rgba(42,28,31,0.1)!important;border:8px solid var(--white)!important}.pz-hero-image-wrap img{width:100%!important;height:auto!important;display:block!important;transform:scale(1.02)!important}.pz-services{padding:100px 0!important;background:var(--bg-light)!important}.pz-booking-grid{display:grid!important;grid-template-columns:1.3fr 0.9fr!important;gap:50px!important;align-items:flex-start!important}.pz-booking-form-box{background:var(--white)!important;padding:40px!important;border-radius:20px!important;box-shadow:0 20px 40px rgba(133,31,51,0.08)!important;position:sticky!important;top:100px!important;border-top:5px solid var(--primary)!important}.pz-form-control{width:100%!important;padding:14px 15px!important;border:1px solid#E0DADB!important;border-radius:8px!important;font-family:'Inter',sans-serif!important;font-size:15px!important;color:var(--text-dark)!important;background:#FAFAFA!important;transition:all 0.3s ease!important}.pz-fab-whatsapp{position:fixed!important;bottom:30px!important;right:30px!important;width:65px!important;height:65px!important;background-color:#25D366!important;border-radius:50%!important;display:flex!important;justify-content:center!important;align-items:center!important;color:white!important;font-size:34px!important;text-decoration:none!important;box-shadow:0 10px 25px rgba(37,211,102,0.4)!important;z-index:99999!important;animation:pz-pulse 2s infinite!important}@keyframes pz-pulse{0%{box-shadow:0 0 0 0 rgba(37,211,102,0.7)!important}70%{box-shadow:0 0 0 15px rgba(37,211,102,0)!important}100%{box-shadow:0 0 0 0 rgba(37,211,102,0)!important}}
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="pz-header">
        <div class="pz-container">
            <div class="pz-nav-wrapper">
                <a href="#" class="pz-logo">
                    PIZANE
                    <span>ESTÉTICA & SAÚDE AVANÇADA</span>
                </a>
                <a href="#agendar" class="pz-btn-primary">
                    <i class="fa-solid fa-calendar-check"></i>
                    AGENDAR AGORA
                </a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="pz-hero">
        <div class="pz-container">
            <div class="pz-hero-grid">
                <div class="pz-hero-content">
                    <h1>Realce sua beleza natural com quem é especialista</h1>
                    <p>Referência em Itaperuna e Região em Harmonização Facial, Botox e Protocolos de Emagrecimento de Alta Performance.</p>
                    <a href="#agendar" class="pz-btn-primary" style="padding: 18px 40px !important; font-size: 18px !important;">
                        QUERO MINHA AVALIAÇÃO
                    </a>
                </div>
                <div class="pz-hero-image">
                    <div class="pz-hero-image-wrap">
                        <img src="https://lh3.googleusercontent.com/p/AF1QipNvBAL4gCkVFwslCNBDt9yEj-YZ4hjskc9ONphS=s680-w680-h510-rw" alt="Clínica Pizane">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AGENDAMENTO -->
    <section id="agendar" class="pz-services">
        <div class="pz-container">
            <div class="pz-booking-grid">
                <div>
                    <h2>Nossos Protocolos</h2>
                    <p>Escolha o serviço desejado e reserve seu horário exclusivo.</p>
                    <!-- Conteúdo simplificado para o All-in-One -->
                </div>
                <div class="pz-booking-form-box">
                    <h3>Agende sua Visita</h3>
                    <form id="bookingForm">
                        <div class="pz-form-group">
                            <label>Seu Nome</label>
                            <input type="text" name="nome" class="pz-form-control" placeholder="Seu nome completo" required>
                        </div>
                        <div class="pz-form-group">
                            <label>WhatsApp</label>
                            <input type="tel" name="whatsapp" class="pz-form-control" placeholder="(22) 99999-9999" required>
                        </div>
                        <div class="pz-form-group">
                            <label>Procedimento de Interesse</label>
                            <select name="servico" class="pz-form-control">
                                <option value="Botox">Botox e Preenchimento</option>
                                <option value="Emagrecimento">Emagrecimento Avançado</option>
                                <option value="Limpeza de Pele">Limpeza de Pele Premium</option>
                                <option value="Outros">Outros Serviços</option>
                            </select>
                        </div>
                        <button type="submit" class="pz-btn-primary pz-form-submit">
                            SOLICITAR DISPONIBILIDADE
                        </button>
                        <div id="statusMessage" class="pz-form-status"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <a href="https://wa.me/5522992088446" target="_blank" class="pz-fab-whatsapp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            const status = document.getElementById('statusMessage');
            const formData = new FormData(this);
            formData.append('ajax_scheduling', '1');

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ENVIANDO...';

            fetch('', { // Envia para o próprio arquivo
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                status.innerHTML = data.message;
                status.className = 'pz-form-status ' + (data.success ? 'pz-status-success' : 'pz-status-error');
                status.style.display = 'block';
                if(data.success) {
                    this.reset();
                    setTimeout(() => {
                        window.location.href = "https://wa.me/5522992088446?text=Olá, acabei de solicitar um agendamento pelo site!";
                    }, 2000);
                }
            })
            .catch(error => {
                status.innerHTML = 'Erro ao processar solicitação.';
                status.className = 'pz-form-status pz-status-error';
                status.style.display = 'block';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'SOLICITAR DISPONIBILIDADE';
            });
        });
    </script>
</body>
</html>
