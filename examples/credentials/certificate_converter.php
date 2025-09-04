<?php
// Inicia a sessão para armazenar o conteúdo dos certificados para download.
session_start();

// Silencia os avisos do OpenSSL para não poluir a saída em caso de senha errada.
error_reporting(E_ALL & ~E_WARNING);

// Bloco de código para tratar a solicitação de download.
if (isset($_GET['download'])) {
    $type = $_GET['download'];
    if (isset($_SESSION[$type . '_content']) && isset($_SESSION[$type . '_filename'])) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($_SESSION[$type . '_filename']) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($_SESSION[$type . '_content']));

        echo $_SESSION[$type . '_content'];

        // Limpa as variáveis de sessão após o download.
        unset($_SESSION[$type . '_content']);
        unset($_SESSION[$type . '_filename']);
        exit;
    }
}

$base64_output = '';
$pem_output = '';
$error_message = '';
$success_message = '';
$show_pem_download = false;
$show_p12_download = false;
$conversion_done = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['p12_file'])) {
    $conversion_done = true;
    // Limpa dados de sessões anteriores a cada nova submissão.
    unset($_SESSION['pem_content'], $_SESSION['pem_filename'], $_SESSION['p12_content'], $_SESSION['p12_filename']);

    $p12_file = $_FILES['p12_file'];
    $p12_password = $_POST['p12_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($p12_file['error'] === UPLOAD_ERR_OK) {
        $p12_content = file_get_contents($p12_file['tmp_name']);
        $original_filename = pathinfo($p12_file['name'], PATHINFO_FILENAME);
        $cert_info = [];

        // Para qualquer ação, primeiro tentamos ler o certificado para validar o arquivo e a senha.
        if (openssl_pkcs12_read($p12_content, $cert_info, $p12_password)) {
            // Se a leitura foi bem-sucedida, executa a ação escolhida.
            if ($action === 'get_base64') {
                $content_to_encode = $p12_content;
                // Se uma nova senha for fornecida, o certificado deve ser re-exportado com ela antes de codificar.
                if (!empty($new_password)) {
                    $new_p12_content_with_new_pass = '';
                    if (openssl_pkcs12_export($cert_info['cert'], $new_p12_content_with_new_pass, $cert_info['pkey'], $new_password)) {
                        $content_to_encode = $new_p12_content_with_new_pass;
                        $success_message = 'Certificado validado, re-criptografado com a nova senha e convertido para base64 com sucesso!';
                    } else {
                        $error_message = 'Erro ao aplicar a nova senha ao certificado antes de converter para base64.';
                    }
                } else {
                    $success_message = 'Certificado validado e convertido para base64 com sucesso!';
                }

                if (empty($error_message)) {
                    $base64_output = rtrim(chunk_split(base64_encode($content_to_encode), 64, "\n"));
                }
            } elseif ($action === 'convert_pem') {
                $pem_output = $cert_info['cert'];
                $private_key_pem = '';
                $export_success = false;
                $filename_suffix = '';

                if (!empty($new_password)) {
                    if (openssl_pkey_export($cert_info['pkey'], $private_key_pem, $new_password)) {
                        $pem_output .= $private_key_pem;
                        $success_message = 'Certificado .p12 convertido para .pem com nova senha com sucesso!';
                        $filename_suffix = '_nova_senha';
                        $export_success = true;
                    } else {
                        $error_message = 'Erro ao aplicar a nova senha na chave privada do certificado PEM.';
                    }
                } else {
                    $pem_output .= $cert_info['pkey'];
                    $success_message = 'Certificado .p12 convertido para .pem com sucesso!';
                    $export_success = true;
                }

                if ($export_success) {
                    $_SESSION['pem_content'] = $pem_output;
                    $_SESSION['pem_filename'] = $original_filename . $filename_suffix . '.pem';
                    $show_pem_download = true;
                }
            } elseif ($action === 'change_p12_password') {
                $new_p12_content = '';
                if (openssl_pkcs12_export($cert_info['cert'], $new_p12_content, $cert_info['pkey'], $new_password)) {
                    $_SESSION['p12_content'] = $new_p12_content;
                    $_SESSION['p12_filename'] = $original_filename . '_nova_senha.p12';
                    $show_p12_download = true;
                    $success_message = 'Senha do certificado .p12 alterada com sucesso! Clique em "Download .P12" para baixar.';
                } else {
                    $error_message = 'Erro ao gerar o novo arquivo .p12 com a nova senha.';
                }
            }
        } else {
            $error_message = 'Não foi possível ler o certificado .p12. Verifique se o arquivo está correto e se a senha está correta.';
        }
    } else {
        $error_message = 'Erro no upload do arquivo. Código de erro: ' . $p12_file['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Certificados P12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .container {
            max-width: 800px;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
        }

        .btn-primary {
            background-color: #f37021;
            border-color: #f37021;
        }

        .btn-primary:hover {
            background-color: #d9601a;
            border-color: #d9601a;
        }

        .btn-secondary {
            background-color: #00809d;
            border-color: #00809d;
        }

        .btn-secondary:hover {
            background-color: #006177;
            border-color: #006177;
        }

        .btn-info {
            background-color: #0dcaf0;
            border-color: #0dcaf0;
        }

        .btn-info:hover {
            background-color: #0baccc;
            border-color: #0baccc;
        }

        .form-label {
            font-weight: 500;
        }

        textarea {
            font-family: monospace;
            font-size: 0.85rem;
        }

        .step-card {
            border-left: 4px solid #f37021;
        }

        .action-buttons button {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="text-center mb-5">
            <img src="https://dev.efipay.com.br/img/logo-efi-pay.svg" alt="Logo Efí Bank" style="height: 50px;">
            <h1 class="h3 mt-3">Ferramenta de Certificados</h1>
            <p class="text-muted">Faça upload de um certificado .p12 para convertê-lo ou alterar sua senha.</p>
        </div>

        <?php if (!$conversion_done): ?>
            <form action="certificate_converter.php" method="post" enctype="multipart/form-data">
                <div class="card shadow-sm p-4 mb-4 step-card">
                    <h5 class="mb-3"><i class="bi bi-file-earmark-arrow-up-fill me-2"></i>Passo 1: Envie seu certificado
                    </h5>
                    <div class="mb-3">
                        <label for="p12_file" class="form-label">Arquivo de Certificado (.p12)</label>
                        <input class="form-control" type="file" id="p12_file" name="p12_file" accept=".p12" required>
                    </div>
                    <div class="mb-3">
                        <label for="p12_password" class="form-label">Senha Atual do Certificado (se houver)</label>
                        <input type="password" class="form-control" id="p12_password" name="p12_password"
                            placeholder="Deixe em branco se não houver senha">
                    </div>
                </div>

                <div class="card shadow-sm p-4 step-card">
                    <h5 class="mb-3"><i class="bi bi-gear-fill me-2"></i>Passo 2: Escolha uma Ação</h5>
                    <div class="row align-items-end">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="new_password" class="form-label">Nova Senha (Opcional)</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Para .p12, .pem ou base64">
                            <div class="form-text">Use este campo para definir uma nova senha.</div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-2 action-buttons">
                                <button type="submit" name="action" value="get_base64" class="btn btn-secondary"><i
                                        class="bi bi-braces me-2"></i>Extrair para Base64</button>
                                <button type="submit" name="action" value="convert_pem" class="btn btn-primary"><i
                                        class="bi bi-filetype-pem me-2"></i>Converter para .PEM</button>
                                <button type="submit" name="action" value="change_p12_password"
                                    class="btn btn-info text-white"><i class="bi bi-key-fill me-2"></i>Alterar Senha do
                                    .p12</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="card shadow-sm p-4">
                <h5 class="mb-3">Resultado da Operação</h5>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Erro:</strong>
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success_message): ?>
                    <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
                        <span><i
                                class="bi bi-check-circle-fill me-2"></i><?php echo htmlspecialchars($success_message); ?></span>
                        <?php if ($show_p12_download): ?>
                            <a href="certificate_converter.php?download=p12" class="btn btn-light btn-sm fw-bold">Download .P12</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($base64_output): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6><i class="bi bi-file-earmark-code me-2"></i>Certificado em Base64</h6>
                            <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('base64_output', this)">
                                <i class="bi bi-clipboard me-2"></i>Copiar
                            </button>
                        </div>
                        <textarea class="form-control" id="base64_output" rows="8"
                            readonly><?php echo htmlspecialchars($base64_output); ?></textarea>
                    </div>
                <?php endif; ?>

                <?php if ($pem_output): ?>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6><i class="bi bi-file-earmark-text me-2"></i>Certificado em formato .PEM</h6>
                            <?php if ($show_pem_download): ?>
                                <a href="certificate_converter.php?download=pem" class="btn btn-success">
                                    <i class="bi bi-download me-2"></i>Download
                                </a>
                            <?php endif; ?>
                        </div>
                        <textarea class="form-control" rows="15"
                            readonly><?php echo htmlspecialchars($pem_output); ?></textarea>
                    </div>
                <?php endif; ?>

                <hr>
                <div class="text-center">
                    <a href="certificate_converter.php" class="btn btn-primary"><i
                            class="bi bi-arrow-repeat me-2"></i>Converter Novo Certificado</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function copyToClipboard(elementId, button) {
            const textarea = document.getElementById(elementId);
            textarea.select();
            document.execCommand('copy');

            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check-lg me-2"></i>Copiado!';

            setTimeout(() => {
                button.innerHTML = originalText;
            }, 2000);
        }
    </script>
</body>

</html>