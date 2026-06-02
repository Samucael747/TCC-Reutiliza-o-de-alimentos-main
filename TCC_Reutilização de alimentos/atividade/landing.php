<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FomeOff - Plataforma de Doação de Alimentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/acessibilidade.css" />
    <link rel="stylesheet" href="./css/accessibility-panel.css" />
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
    </style>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-b from-orange-50 to-white">

        <!-- Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-orange-500 fill-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span class="text-gray-800 text-2xl font-bold">FomeOff</span>
                </div>
                <div class="flex gap-4">
                    <a href="index.php" class="px-6 py-2 text-gray-700 hover:text-orange-600 rounded-lg transition">Entrar</a>
                    <a href="html/cadastroUsuario.php" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">Cadastre-se</a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="container mx-auto px-6 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block px-4 py-2 bg-orange-100 text-orange-600 rounded-full mb-6">
                        <span class="font-semibold">💚 Plataforma 100% Gratuita</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                        Conectando Doações,<br />
                        <span class="text-orange-500">Alimentando Esperança</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Plataforma que conecta empresas e ONGs que doam alimentos com pessoas que precisam. Em tempo real, com mapa interativo.
                    </p>
                    <div class="flex gap-4 flex-wrap">
                        <a href="html/cadastroUsuario.php" class="px-8 py-4 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition flex items-center gap-2 shadow-lg shadow-orange-200">
                            Quero Receber Doações
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                        <a href="html/cadastroEmpresas.html" class="px-8 py-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition shadow-lg shadow-green-200">
                            Quero Doar Alimentos
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                        <img src="https://images.unsplash.com/photo-1599059813005-11265ba4b4ce?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                             alt="Voluntários organizando doações de alimentos" class="w-full h-full object-cover" />
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-6 shadow-xl border-2 border-orange-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-full p-3">
                                <svg class="w-6 h-6 text-white fill-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-800">100%</p>
                                <p class="text-sm text-gray-600">Gratuito</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-8 text-center shadow-lg border-2 border-orange-100 hover:border-orange-300 transition">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Mapa em Tempo Real</h3>
                    <p class="text-gray-600">Veja doações próximas a você no mapa interativo</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center shadow-lg border-2 border-green-100 hover:border-green-300 transition">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Busca por CEP</h3>
                    <p class="text-gray-600">Encontre doações disponíveis na sua região</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center shadow-lg border-2 border-blue-100 hover:border-blue-300 transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">200% Gratuito</h3>
                    <p class="text-gray-600">Plataforma totalmente gratuita para todos</p>
                </div>
            </div>
        </section>

        <!-- How it Works -->
        <section class="container mx-auto px-6 py-20">
            <h2 class="text-4xl font-bold text-gray-900 text-center mb-4">Como Funciona?</h2>
            <p class="text-gray-600 text-center mb-16 max-w-2xl mx-auto">Processo simples e rápido para conectar quem precisa com quem pode ajudar</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-white rounded-3xl p-10 shadow-xl border-t-4 border-orange-500 hover:shadow-2xl transition">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-orange-100 p-3 rounded-xl">
                            <svg class="w-10 h-10 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800">Para Usuários</h3>
                    </div>
                    <div class="space-y-6">
                        <?php foreach([['Cadastre-se Gratuitamente','Crie sua conta em segundos'],['Busque por CEP','Encontre doações próximas a você'],['Solicite a Doação','Escolha retirada ou entrega em casa'],['Avalie a Experiência','Dê sua nota de 1 a 5 estrelas']] as $i => $s): ?>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold"><?php echo $i+1; ?></div>
                            <div><h4 class="font-semibold text-gray-800 mb-1"><?php echo $s[0]; ?></h4><p class="text-gray-600"><?php echo $s[1]; ?></p></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-10 shadow-xl border-t-4 border-green-500 hover:shadow-2xl transition">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-10 h-10 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path>
                                <path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path>
                                <path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path>
                                <path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800">Para Empresas/ONGs</h3>
                    </div>
                    <div class="space-y-6">
                        <?php foreach([['Cadastre sua Organização','Informe CNPJ e dados da empresa'],['Cadastre o Produto','Nome, quantidade, validade e CEP'],['Aparece no Mapa','Localização automática pelo CEP'],['Receba Solicitações','Gerencie as doações facilmente']] as $i => $s): ?>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold"><?php echo $i+1; ?></div>
                            <div><h4 class="font-semibold text-gray-800 mb-1"><?php echo $s[0]; ?></h4><p class="text-gray-600"><?php echo $s[1]; ?></p></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Impact Section -->
        <section class="container mx-auto px-6 py-20">
            <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-12 flex flex-col justify-center">
                        <h2 class="text-4xl font-bold text-gray-800 mb-6">Juntos Contra o Desperdício</h2>
                        <p class="text-lg text-gray-600 mb-8">Milhões de toneladas de alimentos são desperdiçadas enquanto pessoas passam fome. O FomeOff conecta quem pode doar com quem precisa, de forma simples e transparente.</p>
                        <div class="space-y-4">
                            <?php foreach([
                                ['Localização em Tempo Real','Veja no mapa onde estão as doações mais próximas','M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z'],
                                ['Comunidade Solidária','Empresas, ONGs e pessoas unidas por uma causa','M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2'],
                                ['Processo Transparente','Acompanhe todo o histórico de doações','M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z']
                            ] as $item): ?>
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-100 rounded-full p-2 mt-1">
                                    <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="<?php echo $item[2]; ?>"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800"><?php echo $item[0]; ?></h4>
                                    <p class="text-gray-600"><?php echo $item[1]; ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="h-full min-h-[400px]">
                        <img src="https://images.unsplash.com/photo-1593113646773-028c64a8f1b8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                             alt="Pessoas recebendo doações" class="w-full h-full object-cover" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Legal Protection -->
        <section class="container mx-auto px-6 py-20">
            <div class="bg-white rounded-3xl p-12 text-center shadow-lg">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Protegido por Lei</h2>
                <p class="text-gray-600 mb-8 max-w-3xl mx-auto">Todas as doações são amparadas pelas seguintes legislações brasileiras:</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <?php foreach(['Lei 14.016/2020','Lei 9.249/1995','Lei 10.696/2003','LOSAN 11.346/2006'] as $lei): ?>
                    <a href="php/leis_doacoes.php" class="p-4 bg-orange-50 rounded-xl border border-orange-200 hover:bg-orange-100 transition">
                        <p class="font-semibold text-orange-600"><?php echo $lei; ?></p>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-orange-500 to-orange-600 py-20">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-white mb-6">Pronto para Fazer a Diferença?</h2>
                <p class="text-xl text-white/90 mb-12">Junte-se a nós na luta contra o desperdício de alimentos</p>
                <div class="flex gap-4 justify-center flex-wrap">
                    <a href="html/cadastroUsuario.php" class="px-12 py-5 bg-white text-orange-600 rounded-lg text-lg font-semibold hover:bg-gray-50 transition shadow-xl">Começar Agora</a>
                    <a href="html/cadastroEmpresas.html" class="px-12 py-5 bg-green-500 text-white rounded-lg text-lg font-semibold hover:bg-green-600 transition shadow-xl">Quero Doar</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 py-12">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-orange-500 fill-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        <span class="text-white text-xl font-bold">FomeOff</span>
                    </div>
                    <div class="flex gap-6 text-gray-400">
                        <a href="#" class="hover:text-orange-500 transition">Sobre</a>
                        <a href="php/leis_doacoes.php" class="hover:text-orange-500 transition">Leis</a>
                        <a href="index.php" class="hover:text-orange-500 transition">Entrar</a>
                        <a href="html/cadastroUsuario.php" class="hover:text-orange-500 transition">Cadastre-se</a>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-center">
                    <p class="text-gray-400">&copy; 2026 FomeOff. Todos os direitos reservados. Plataforma de doação de alimentos 100% gratuita.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="./js/accessibility.js"></script>
</body>
</html>
