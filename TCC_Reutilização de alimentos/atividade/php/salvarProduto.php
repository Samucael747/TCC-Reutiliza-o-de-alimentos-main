<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexao.php';

    if (!$pdo) {
        header('Location: ../html/cadastroProduto.php?error=Erro+de+conexao+com+banco');
        exit;
    }

    $empresa = trim($_POST['empresa'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $nome_produto = trim($_POST['nome_produto'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);

    $latitude = (isset($_POST['latitude']) && $_POST['latitude'] !== '') ? trim($_POST['latitude']) : null;
    $longitude = (isset($_POST['longitude']) && $_POST['longitude'] !== '') ? trim($_POST['longitude']) : null;

    function httpGet($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FomeOff/1.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res ?: null;
    }

    function geocodificar($query) {
        $geo = httpGet('https://nominatim.openstreetmap.org/search?q=' . urlencode($query) . '&format=json&limit=1&countrycodes=br');
        if ($geo) {
            $geoData = json_decode($geo, true);
            if (isset($geoData[0]['lat']) && isset($geoData[0]['lon'])) {
                return [$geoData[0]['lat'], $geoData[0]['lon']];
            }
        }
        return null;
    }

    // Se latitude/longitude não vieram do formulário, buscar pelo CEP
    if (($latitude === null || $longitude === null) && $cep) {
        $cepLimpo = preg_replace('/\D/', '', $cep);
        $viacep = httpGet("https://viacep.com.br/ws/{$cepLimpo}/json/");
        if ($viacep) {
            $data = json_decode($viacep, true);
            if (!isset($data['erro'])) {
                $logradouro = $data['logradouro'] ?? '';
                $bairro     = $data['bairro']     ?? '';
                $cidade     = $data['localidade']  ?? '';
                $uf         = $data['uf']          ?? '';

                // Tenta do mais específico para o mais genérico
                $tentativasGeo = array_filter([
                    $logradouro ? "$logradouro, $bairro, $cidade, $uf, Brasil" : null,
                    $bairro     ? "$bairro, $cidade, $uf, Brasil"               : null,
                    $cidade     ? "$cidade, $uf, Brasil"                        : null,
                ]);

                foreach ($tentativasGeo as $query) {
                    $coords = geocodificar($query);
                    if ($coords) {
                        [$latitude, $longitude] = $coords;
                        break;
                    }
                    usleep(300000); // 0.3s entre tentativas para respeitar rate limit
                }
            }
        }

        if ($latitude === null || $longitude === null) {
            header('Location: ../html/cadastroProduto.php?error=Não+foi+possível+obter+localização+para+o+CEP+informado.+Verifique+o+CEP+e+tente+novamente.');
            exit;
        }
    }

    if (!$empresa || !$cep || !$nome_produto || !$descricao || $quantidade <= 0) {
        header('Location: ../html/cadastroProduto.php?error=Preencha+todos+os+campos+corretamente');
        exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO produtos (empresa, cnpj, cep, nome_produto, descricao, quantidade, latitude, longitude) VALUES (:empresa, :cnpj, :cep, :nome_produto, :descricao, :quantidade, :latitude, :longitude)');
        $stmt->bindValue(':empresa', $empresa);
        $stmt->bindValue(':cnpj', $cnpj);
        $stmt->bindValue(':cep', $cep);
        $stmt->bindValue(':nome_produto', $nome_produto);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':latitude', $latitude ?: null);
        $stmt->bindValue(':longitude', $longitude ?: null);
        $stmt->execute();

        header('Location: ../html/cadastroProduto.php?success=Produto+registrado+com+sucesso');
        exit;
    } catch (PDOException $e) {
        header('Location: ../html/cadastroProduto.php?error=Erro+ao+registrar+produto');
        exit;
    }
}

header('Location: ../html/cadastroProduto.php?error=Metodo+nao+permitido');
exit;
