<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/../includes/conexao.php';

    if (!$pdo) {
        header('Location: ../../auth/cadastroEmpresas.html?error=Erro+de+conexao+com+banco');
        exit;
    }

    $nome            = trim($_POST['nome'] ?? '');
    $cnpj            = trim($_POST['cnpj'] ?? '');
    $cep             = trim($_POST['cep'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $senha           = trim($_POST['senha'] ?? '');
    $voluntario_nome = trim($_POST['voluntario_nome'] ?? '') ?: null;
    $voluntario_info = trim($_POST['voluntario_info'] ?? '') ?: null;

    if (!$nome || !$email || !$senha) {
        header('Location: ../../auth/cadastroEmpresas.html?error=Dados+incompletos');
        exit;
    }

    // Converter CEP em coordenadas via ViaCEP + Nominatim
    $lat = null; $lon = null;
    $cepLimpo = preg_replace('/\D/', '', $cep);
    if (strlen($cepLimpo) === 8) {
        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $viaCep = @file_get_contents("https://viacep.com.br/ws/{$cepLimpo}/json/", false, $ctx);
        if ($viaCep) {
            $addr = json_decode($viaCep, true);
            if (!empty($addr['localidade']) && !empty($addr['uf'])) {
                $query = urlencode($addr['logradouro'] . ', ' . $addr['localidade'] . ', ' . $addr['uf'] . ', Brasil');
                $nom = @file_get_contents("https://nominatim.openstreetmap.org/search?q={$query}&format=json&limit=1", false,
                    stream_context_create(['http' => ['timeout' => 5, 'header' => "User-Agent: FomeOff/1.0\r\n"]]));
                if ($nom) {
                    $coords = json_decode($nom, true);
                    if (!empty($coords[0])) {
                        $lat = (float)$coords[0]['lat'];
                        $lon = (float)$coords[0]['lon'];
                    }
                }
            }
        }
    }

    try {
        $stmt = $pdo->prepare('SELECT id FROM empresas WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);

        if ($stmt->fetch()) {
            header('Location: ../../auth/cadastroEmpresas.html?error=Email+ja+cadastrado');
            exit;
        }

        $stmt = $pdo->prepare('INSERT INTO empresas (nome, cnpj, cep, email, senha, voluntario_nome, voluntario_info, latitude, longitude) VALUES (:nome, :cnpj, :cep, :email, :senha, :vnome, :vinfo, :lat, :lon)');
        $stmt->execute([
            ':nome'  => $nome,
            ':cnpj'  => $cnpj,
            ':cep'   => $cep,
            ':email' => $email,
            ':senha' => $senha,
            ':vnome' => $voluntario_nome,
            ':vinfo' => $voluntario_info,
            ':lat'   => $lat,
            ':lon'   => $lon,
        ]);

        header('Location: ../../entrar.php?success=Empresa+cadastrada+com+sucesso');
        exit;
    } catch (PDOException $e) {
        header('Location: ../../auth/cadastroEmpresas.html?error=Erro+ao+cadastrar+empresa');
        exit;
    }
}

header('Location: ../../auth/cadastroEmpresas.html');
exit;



