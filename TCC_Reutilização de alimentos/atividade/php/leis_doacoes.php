<?php
session_start();
$isLogged = isset($_SESSION['nome']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leis sobre Doações | FomeOff</title>
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/leis.css" />
</head>
<body>
    <?php if ($isLogged): ?>
        <nav class="navbar">
            <div class="navbar-container">
                <div class="navbar-brand">
                    <span>🍽️</span>
                    <h1>FomeOff</h1>
                </div>
                <ul class="navbar-menu">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="leis_doacoes.php" class="active">Leis</a></li>
                    <li><a href="configuracoes.php">Configurações</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <div class="leis-page">
        <div class="leis-header">
            <div class="header-content">
                <h1>Legislação sobre Doações de Alimentos</h1>
                <p>Conheça as leis que regulamentam as doações de alimentos no Brasil</p>
            </div>
        </div>

        <div class="leis-container">
            <!-- Lei nº 14.016/2020 -->
            <section class="lei-card">
                <div class="lei-header">
                    <h2>Lei nº 14.016, de 23 de junho de 2020</h2>
                    <span class="lei-badge">Nacional</span>
                </div>
                <div class="lei-content">
                    <h3>Doações de Alimentos Durante Pandemia</h3>
                    <p>Esta lei autoriza a União a transferir recursos para estados, Distrito Federal e municípios, a fim de apoiar ações de enfrentamento à emergência de saúde pública de importância internacional decorrente do novo coronavírus.</p>
                    <div class="lei-details">
                        <h4>Principais Pontos:</h4>
                        <ul>
                            <li>✓ Autoriza doações de alimentos em situações de emergência</li>
                            <li>✓ Facilita a distribuição de alimentos em contextos de crise sanitária</li>
                            <li>✓ Protege doadores de responsabilidades legais em doações de boa fé</li>
                            <li>✓ Estimula a solidariedade alimentar</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Lei nº 9.249/1995 -->
            <section class="lei-card">
                <div class="lei-header">
                    <h2>Lei nº 9.249, de 26 de dezembro de 1995</h2>
                    <span class="lei-badge">Tributária</span>
                </div>
                <div class="lei-content">
                    <h3>Incentivos Fiscais para Doações</h3>
                    <p>Lei que estabelece incentivos fiscais para empresas que doam alimentos para instituições de caridade.</p>
                    <div class="lei-details">
                        <h4>Benefícios para Doadores:</h4>
                        <ul>
                            <li>✓ Dedução fiscal de até 1% do Imposto de Renda</li>
                            <li>✓ Dedução de doações de alimentos para instituições sociais</li>
                            <li>✓ Benefícios tributários para empresas que participam do programa</li>
                            <li>✓ Crédito fiscal para alimentos doados</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Lei nº 10.696/2003 -->
            <section class="lei-card">
                <div class="lei-header">
                    <h2>Lei nº 10.696, de 02 de julho de 2003</h2>
                    <span class="lei-badge">Segurança Alimentar</span>
                </div>
                <div class="lei-content">
                    <h3>Programa de Aquisição de Alimentos</h3>
                    <p>Institui o Programa de Aquisição de Alimentos com a finalidade de compatibilizar a melhor remuneração das atividades agropecuárias com a alimentação das pessoas com dificuldades de acesso.</p>
                    <div class="lei-details">
                        <h4>Principais Características:</h4>
                        <ul>
                            <li>✓ Compra de produtos da agricultura familiar</li>
                            <li>✓ Distribuição para entidades de assistência social</li>
                            <li>✓ Fortalece a segurança alimentar</li>
                            <li>✓ Promove a agricultura sustentável</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Lei nº 11.346/2006 -->
            <section class="lei-card">
                <div class="lei-header">
                    <h2>Lei nº 11.346, de 15 de setembro de 2006</h2>
                    <span class="lei-badge">Direito Humano</span>
                </div>
                <div class="lei-content">
                    <h3>Lei Orgânica de Segurança Alimentar e Nutricional (LOSAN)</h3>
                    <p>Cria o Sistema Nacional de Segurança Alimentar e Nutricional (SISAN) e estabelece princípios e diretrizes para a formulação e implementação de políticas e programas para assegurar o direito humano à alimentação adequada.</p>
                    <div class="lei-details">
                        <h4>Direitos e Responsabilidades:</h4>
                        <ul>
                            <li>✓ Reconhece a alimentação como direito fundamental</li>
                            <li>✓ Estabelece responsabilidade estatal e privada</li>
                            <li>✓ Promove participação da sociedade civil</li>
                            <li>✓ Define políticas de combate à fome</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Lei de Distribuição de Alimentos -->
            <section class="lei-card">
                <div class="lei-header">
                    <h2>Resoluções e Normas Complementares</h2>
                    <span class="lei-badge">Operacional</span>
                </div>
                <div class="lei-content">
                    <h3>Diretrizes para Operacionalização de Doações</h3>
                    <p>Conjunto de normas que regulamentam o processo de doação, armazenamento, transporte e distribuição de alimentos.</p>
                    <div class="lei-details">
                        <h4>Normas de Qualidade e Segurança:</h4>
                        <ul>
                            <li>✓ Alimentos devem estar em perfeitas condições de consumo</li>
                            <li>✓ Respeito à cadeia de frio quando necessário</li>
                            <li>✓ Documentação e rastreabilidade dos alimentos</li>
                            <li>✓ Conformidade com regulamentações sanitárias</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Estatuto de Responsabilidade Social -->
            <section class="lei-card">
                <div class="lei-header">
                    <h2>Legislação de Responsabilidade Social Corporativa</h2>
                    <span class="lei-badge">Corporativa</span>
                </div>
                <div class="lei-content">
                    <h3>Compromissos Sociais e Ambientais</h3>
                    <p>Legislação que incentiva empresas a desenvolverem programas de responsabilidade social e sustentabilidade.</p>
                    <div class="lei-details">
                        <h4>Engajamento Corporativo:</h4>
                        <ul>
                            <li>✓ Redução de desperdício de alimentos</li>
                            <li>✓ Contribuição para segurança alimentar da comunidade</li>
                            <li>✓ Reputação corporativa e branding positivo</li>
                            <li>✓ Impacto social mensurável</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <div class="leis-cta">
            <div class="cta-card">
                <h3>💡 Quer Fazer uma Doação?</h3>
                <p>Junte-se a empresas e ONGs que já estão fazendo a diferença através de doações de alimentos.</p>
                <?php if ($isLogged): ?>
                    <a href="home.php" class="cta-btn">Ir para Home</a>
                <?php else: ?>
                    <a href="../index.php" class="cta-btn">Fazer Login</a>
                <?php endif; ?>
            </div>
            <div class="cta-card">
                <h3>❓ Dúvidas Frequentes?</h3>
                <p>Entre em contato conosco para esclarecer dúvidas sobre legislação e processo de doação.</p>
                <a href="#" class="cta-btn secondary">Contatar Suporte</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 FomeOff - Conectando solidariedade em tempo real. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
