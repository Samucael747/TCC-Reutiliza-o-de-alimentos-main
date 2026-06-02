<?php
session_start();
$isLogged = isset($_SESSION['nome']);

$paginaAtiva = 'leis';
$pageTitle   = 'Leis sobre Doações | FomeOff';
$extra_head  = <<<'HTML'
    <link rel="stylesheet" href="../css/leis.css" />
HTML;
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
    <?php if ($isLogged): include __DIR__ . '/includes/navbar.php'; endif; ?>

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
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Autoriza doações de alimentos em situações de emergência</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Facilita a distribuição de alimentos em contextos de crise sanitária</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Protege doadores de responsabilidades legais em doações de boa fé</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Estimula a solidariedade alimentar</li>
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
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Dedução fiscal de até 1% do Imposto de Renda</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Dedução de doações de alimentos para instituições sociais</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Benefícios tributários para empresas que participam do programa</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Crédito fiscal para alimentos doados</li>
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
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Compra de produtos da agricultura familiar</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Distribuição para entidades de assistência social</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Fortalece a segurança alimentar</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Promove a agricultura sustentável</li>
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
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Reconhece a alimentação como direito fundamental</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Estabelece responsabilidade estatal e privada</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Promove participação da sociedade civil</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Define políticas de combate à fome</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Resoluções e Normas -->
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
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Alimentos devem estar em perfeitas condições de consumo</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Respeito à cadeia de frio quando necessário</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Documentação e rastreabilidade dos alimentos</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Conformidade com regulamentações sanitárias</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Responsabilidade Social -->
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
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Redução de desperdício de alimentos</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Contribuição para segurança alimentar da comunidade</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Reputação corporativa e branding positivo</li>
                            <li><i class="bi bi-check-circle-fill" style="color:#FF8C00;margin-right:6px;"></i>Impacto social mensurável</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <div class="leis-cta">
            <div class="cta-card">
                <h3><i class="bi bi-lightbulb"></i> Quer Fazer uma Doação?</h3>
                <p>Junte-se a empresas e ONGs que já estão fazendo a diferença através de doações de alimentos.</p>
                <?php if ($isLogged): ?>
                    <a href="dashboard.php" class="cta-btn">Ir para Home</a>
                <?php else: ?>
                    <a href="../entrar.php" class="cta-btn">Fazer Login</a>
                <?php endif; ?>
            </div>
            <div class="cta-card">
                <h3><i class="bi bi-question-circle"></i> Dúvidas Frequentes?</h3>
                <p>Entre em contato conosco para esclarecer dúvidas sobre legislação e processo de doação.</p>
                <a href="#" class="cta-btn secondary">Contatar Suporte</a>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <script src="../js/accessibility.js"></script>
</body>
</html>



