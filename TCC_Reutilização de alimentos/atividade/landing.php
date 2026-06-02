<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FomeOff - Plataforma de Doação de Alimentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-orange-500 via-orange-400 to-amber-300">

        <!-- Header -->
        <header class="container mx-auto px-6 py-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-white fill-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="text-white text-2xl font-bold">FomeOff</span>
            </div>
            <div class="flex gap-4">
                <a href="index.php" class="px-6 py-2 text-white hover:bg-white/20 rounded-lg transition">
                    Entrar
                </a>
                <a href="html/cadastroUsuario.php" class="px-6 py-2 bg-white text-orange-600 rounded-lg hover:bg-orange-50 transition">
                    Cadastre-se
                </a>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="container mx-auto px-6 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                        Conectando Doações,
                        <br />
                        Alimentando Esperança
                    </h1>
                    <p class="text-xl text-white/90 mb-8">
                        Plataforma gratuita que conecta empresas e ONGs que doam alimentos
                        com pessoas que precisam. Em tempo real, com mapa interativo.
                    </p>
                    <div class="flex gap-4 flex-wrap">
                        <a href="html/cadastroUsuario.php" class="px-8 py-4 bg-white text-orange-600 rounded-lg font-semibold hover:bg-orange-50 transition flex items-center gap-2">
                            Quero Receber Doações
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                        <a href="html/cadastroEmpresas.html" class="px-8 py-4 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition">
                            Quero Doar Alimentos
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-3xl overflow-hidden shadow-2xl">
                        <img
                            src="https://images.unsplash.com/photo-1599059813005-11265ba4b4ce?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                            alt="Voluntários organizando doações de alimentos"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-6 shadow-xl">
                        <div class="flex items-center gap-3">
                            <div class="bg-orange-500 rounded-full p-3">
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
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-8 text-center">
                    <svg class="w-12 h-12 text-white mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <h3 class="text-3xl font-bold text-white mb-2">Mapa em Tempo Real</h3>
                    <p class="text-white/90">Veja doações próximas a você no mapa interativo</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-8 text-center">
                    <svg class="w-12 h-12 text-white mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <h3 class="text-3xl font-bold text-white mb-2">Busca por CEP</h3>
                    <p class="text-white/90">Encontre doações disponíveis na sua região</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-8 text-center">
                    <svg class="w-12 h-12 text-white mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                    <h3 class="text-3xl font-bold text-white mb-2">100% Gratuito</h3>
                    <p class="text-white/90">Plataforma totalmente gratuita para todos</p>
                </div>
            </div>
        </section>

        <!-- How it Works -->
        <section class="container mx-auto px-6 py-20">
            <h2 class="text-4xl font-bold text-white text-center mb-16">Como Funciona?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Para Usuários -->
                <div class="bg-white rounded-3xl p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-10 h-10 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <h3 class="text-3xl font-bold text-gray-800">Para Usuários</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">1</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Cadastre-se Gratuitamente</h4><p class="text-gray-600">Crie sua conta em segundos</p></div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">2</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Busque por CEP</h4><p class="text-gray-600">Encontre doações próximas a você</p></div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">3</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Solicite a Doação</h4><p class="text-gray-600">Escolha retirada ou entrega em casa</p></div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">4</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Avalie a Experiência</h4><p class="text-gray-600">Dê sua nota de 1 a 5 estrelas</p></div>
                        </div>
                    </div>
                </div>

                <!-- Para Empresas/ONGs -->
                <div class="bg-white rounded-3xl p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-10 h-10 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                            <path d="M9 22v-4h6v4"></path>
                            <path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path>
                            <path d="M12 10h.01"></path><path d="M12 14h.01"></path>
                            <path d="M16 10h.01"></path><path d="M16 14h.01"></path>
                            <path d="M8 10h.01"></path><path d="M8 14h.01"></path>
                        </svg>
                        <h3 class="text-3xl font-bold text-gray-800">Para Empresas/ONGs</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">1</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Cadastre sua Organização</h4><p class="text-gray-600">Informe CNPJ e dados da empresa</p></div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">2</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Cadastre o Produto</h4><p class="text-gray-600">Nome, quantidade, validade e CEP</p></div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">3</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Aparece no Mapa</h4><p class="text-gray-600">Localização automática pelo CEP</p></div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">4</div>
                            <div><h4 class="font-semibold text-gray-800 mb-1">Receba Solicitações</h4><p class="text-gray-600">Gerencie as doações facilmente</p></div>
                        </div>
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
                        <p class="text-lg text-gray-600 mb-8">
                            Milhões de toneladas de alimentos são desperdiçadas enquanto pessoas passam fome.
                            O FomeOff conecta quem pode doar com quem precisa, de forma simples e transparente.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-100 rounded-full p-2 mt-1">
                                    <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Localização em Tempo Real</h4>
                                    <p class="text-gray-600">Veja no mapa onde estão as doações mais próximas</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-100 rounded-full p-2 mt-1">
                                    <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Comunidade Solidária</h4>
                                    <p class="text-gray-600">Empresas, ONGs e pessoas unidas por uma causa</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="bg-orange-100 rounded-full p-2 mt-1">
                                    <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Processo Transparente</h4>
                                    <p class="text-gray-600">Acompanhe todo o histórico de doações</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-full min-h-[400px]">
                        <img
                            src="https://images.unsplash.com/photo-1593113646773-028c64a8f1b8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                            alt="Pessoas recebendo doações de alimentos"
                            class="w-full h-full object-cover"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Legal Protection -->
        <section class="container mx-auto px-6 py-20">
            <div class="bg-white rounded-3xl p-12 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Protegido por Lei</h2>
                <p class="text-gray-600 mb-8 max-w-3xl mx-auto">
                    Todas as doações são amparadas pelas seguintes legislações brasileiras:
                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <a href="php/leis_doacoes.php" class="p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition"><p class="font-semibold text-orange-600">Lei 14.016/2020</p></a>
                    <a href="php/leis_doacoes.php" class="p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition"><p class="font-semibold text-orange-600">Lei 9.249/1995</p></a>
                    <a href="php/leis_doacoes.php" class="p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition"><p class="font-semibold text-orange-600">Lei 10.696/2003</p></a>
                    <a href="php/leis_doacoes.php" class="p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition"><p class="font-semibold text-orange-600">LOSAN 11.346/2006</p></a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="container mx-auto px-6 py-20 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Pronto para Fazer a Diferença?</h2>
            <p class="text-xl text-white/90 mb-12">Junte-se a nós na luta contra o desperdício de alimentos</p>
            <a href="html/cadastroUsuario.php" class="inline-block px-12 py-5 bg-white text-orange-600 rounded-lg text-lg font-semibold hover:bg-orange-50 transition">
                Começar Agora
            </a>
        </section>

        <!-- Footer -->
        <footer class="container mx-auto px-6 py-8 border-t border-white/20">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-white/80">&copy; 2026 FomeOff. Todos os direitos reservados.</p>
                <div class="flex gap-6 text-white/80">
                    <a href="#" class="hover:text-white transition">Sobre</a>
                    <a href="php/leis_doacoes.php" class="hover:text-white transition">Leis</a>
                    <a href="index.php" class="hover:text-white transition">Entrar</a>
                    <a href="html/cadastroUsuario.php" class="hover:text-white transition">Cadastre-se</a>
                </div>
            </div>
        </footer>
    </div>
    <link rel="stylesheet" href="./css/acessibilidade.css" />
    <link rel="stylesheet" href="./css/accessibility-panel.css" />
    <script src="./js/accessibility.js"></script>
</body>
</html>
