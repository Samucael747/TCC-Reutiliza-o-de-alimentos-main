# 🍽️ FomeOff - Guia de Melhorias

## 📋 Resumo das Melhorias Implementadas

Este documento detalha as melhorias implementadas no site FomeOff para torná-lo mais organizado, atraente e acessível.

---

## ✨ 1. Nova Página de Leis sobre Doações

### Localização
- **Arquivo:** `php/leis_doacoes.php`
- **CSS:** `css/leis.css`

### Características
- 📚 Apresenta 6 leis e regulamentações importantes sobre doações de alimentos
- 🎨 Design moderno e responsivo com cards informativos
- 🔗 Navegação integrada com navbar
- ♿ Totalmente acessível
- 📱 Adaptado para mobile

### Como Acessar
1. Clique em "📋 Leis" na navbar (após fazer login)
2. Ou acesse a página sem login através de um link especial na página de login

---

## ♿ 2. Sistema Completo de Acessibilidade

### Arquivos Criados
- **JavaScript:** `js/accessibility.js`
- **CSS Acessibilidade:** `css/acessibilidade.css`
- **CSS Painel:** `css/accessibility-panel.css`

### Recursos de Acessibilidade Disponíveis

#### 🌙 Modo Escuro
- Aplicável em todo o site
- Salva em localStorage do navegador

#### 📝 Tamanho de Fonte
- Pequeno (12px)
- Normal (14px)
- Médio (16px)
- Grande (18px)

#### ⚪ Alto Contraste
- Aumenta o contraste entre elementos
- Ideal para pessoas com baixa visão

#### 📏 Espaçamento Aumentado
- Aumenta padding e margins
- Melhora legibilidade

#### 🔤 Fonte Legível
- Altera para fonte sem serifa otimizada
- Reduz fadiga visual

#### ⏸️ Reduzir Animações
- Remove/reduz animações da página
- Importante para pessoas com epilepsia ou sensibilidade a movimento

#### 🔘 Botões Maiores
- Aumenta tamanho dos botões
- Facilita navegação por toque

#### 📦 Campos de Entrada Maiores
- Inputs e textareas com tamanho aumentado
- Melhor acessibilidade

#### 🔗 Destacar Links
- Links ganham destaque visual
- Facilita identificação de links

#### 👁️ Foco Visível
- Melhora o outline de foco
- Navegação por teclado mais clara

#### 🎨 Modo Daltônico
- Suporte para Deuteranopia (Verde-Vermelho)
- Suporte para Protanopia (Vermelho-Verde)
- Suporte para Tritanopia (Azul-Amarelo)

### Como Usar
1. Procure pelo botão ♿ no canto inferior direito da página
2. Clique para abrir o painel de acessibilidade
3. Configure suas preferências
4. As configurações são salvas automaticamente

---

## 👤 3. Perfil de Usuário com Foto

### Funcionalidades
- ✅ Upload de foto de perfil
- ✅ Prévia da foto
- ✅ Suporte para JPG, PNG, GIF e WebP
- ✅ Limite de 5MB por imagem
- ✅ Foto exibida nas configurações

### Arquivos Envolvidos
- **PHP:** `php/salvarFoto.php`
- **Página:** `php/configuracoes.php`
- **Diretório:** `uploads/fotos/`

### Como Usar
1. Acesse "⚙️ Configurações"
2. Clique em "📷 Alterar Foto"
3. Selecione uma imagem (JPG, PNG, GIF ou WebP)
4. A foto será salva automaticamente

---

## 🎨 4. Design Melhorado

### Página Home (`php/home.php`)
- ✅ Nova navbar com navegação intuitiva
- ✅ Cards de produtos redesenhados
- ✅ Melhor organização de informações
- ✅ Ícones em cada seção
- ✅ Dark mode integrado
- ✅ Responsivo em todos os devices

### Página de Configurações (`php/configuracoes.php`)
- ✅ Seções organizadas (Perfil, Preferências, Acessibilidade)
- ✅ Upload de foto integrado
- ✅ Acesso fácil ao painel de acessibilidade
- ✅ Melhor visual com gradientes e shadows

### Página de Leis (`php/leis_doacoes.php`)
- ✅ Design limpo e informativo
- ✅ Cards descritivos para cada lei
- ✅ Badges de categoria
- ✅ CTA (Call-To-Action) cards
- ✅ Footer informativo

---

## 🗄️ 5. Alterações no Banco de Dados

### Arquivo SQL
- **Localização:** `bando_de_dados/atualizacoes.sql`

### Campos Adicionados

#### Tabela `usuarios`
```sql
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS foto_perfil VARCHAR(255) DEFAULT NULL;
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS acessibilidade_preferences JSON DEFAULT NULL;
```

#### Tabela `empresas`
```sql
ALTER TABLE empresas ADD COLUMN IF NOT EXISTS foto_perfil VARCHAR(255) DEFAULT NULL;
ALTER TABLE empresas ADD COLUMN IF NOT EXISTS acessibilidade_preferences JSON DEFAULT NULL;
```

#### Nova Tabela `acessibilidade_logs`
- Rastreia mudanças de preferências de acessibilidade
- Registra data/hora e IP
- Útil para análise de uso

### Como Aplicar
Execute o arquivo SQL no seu banco de dados:
```bash
mysql -u root banco < bando_de_dados/atualizacoes.sql
```

---

## 📂 Estrutura de Diretórios

```
atividade/
├── php/
│   ├── home.php                      # ✨ Melhorado
│   ├── configuracoes.php             # ✨ Melhorado
│   ├── leis_doacoes.php              # ✨ Novo
│   ├── salvarFoto.php                # ✨ Novo
│   ├── salvarAcessibilidade.php      # ✨ Novo
│   └── ...
├── js/
│   ├── accessibility.js              # ✨ Novo - Sistema de acessibilidade
│   └── ...
├── css/
│   ├── index.css                     # CSS principal
│   ├── leis.css                      # ✨ Novo - Estilos página leis
│   ├── acessibilidade.css            # ✨ Novo - Estilos de acessibilidade
│   ├── accessibility-panel.css       # ✨ Novo - Estilos do painel
│   └── ...
├── uploads/
│   └── fotos/                        # ✨ Novo - Armazena fotos de perfil
├── index.php                         # ✨ Atualizado com link para leis
└── ...
```

---

## 🚀 Como Começar

### 1. Criar Diretório para Uploads
```bash
mkdir -p atividade/uploads/fotos
chmod 755 atividade/uploads/fotos
```

### 2. Atualizar Banco de Dados
```bash
mysql -u root banco < bando_de_dados/atualizacoes.sql
```

### 3. Verificar Permissões
- Certifique-se de que o diretório `uploads/fotos/` tem permissões de escrita

### 4. Testar
- Faça login no site
- Acesse Configurações
- Teste upload de foto
- Abra o painel de acessibilidade
- Acesse a página de Leis

---

## 💡 Recursos Adicionais

### Para Desenvolvedores

#### Incluir Acessibilidade em Novas Páginas
```html
<link rel="stylesheet" href="../css/acessibilidade.css" />
<link rel="stylesheet" href="../css/accessibility-panel.css" />
<script src="../js/accessibility.js"></script>
```

#### Salvar Preferências de Acessibilidade
```javascript
// As preferências são salvas automaticamente em localStorage
// E também podem ser sincronizadas com o servidor via AJAX
```

#### Estrutura de Foto de Perfil
```php
// Na página, use:
$fotoPerfil = $conta['foto_perfil'] ?? null;
$fotoPlaceholder = '../images/user-placeholder.png';
// Use como src da imagem
```

---

## 🐛 Troubleshooting

### Fotos não estão sendo salvas
1. Verifique permissões do diretório `uploads/fotos/`
2. Verifique se o arquivo `salvarFoto.php` tem permissões de execução
3. Verifique o espaço em disco disponível

### Acessibilidade não funciona
1. Verifique se o JavaScript `accessibility.js` está sendo carregado
2. Verifique a console do navegador para erros
3. Limpe o cache do navegador

### Preferências não salvam
1. Verifique se o localStorage está ativado no navegador
2. Verifique se há espaço em disco
3. Verifique se o arquivo `salvarAcessibilidade.php` existe

---

## 📊 Estatísticas de Código

- **Novos arquivos PHP:** 3
- **Novos arquivos CSS:** 3
- **Novos arquivos JS:** 1
- **Arquivos modificados:** 3
- **Linhas de código adicionadas:** ~1500+

---

## 🎯 Próximas Melhorias Sugeridas

- [ ] Autenticação de dois fatores
- [ ] Sistema de notificações em tempo real
- [ ] Chat entre doadores e recebedores
- [ ] Sistema de ratings/avaliações
- [ ] Histórico de doações
- [ ] Relatórios e análises
- [ ] Integração com WhatsApp
- [ ] Aplicativo mobile

---

## 👨‍💻 Suporte

Para dúvidas ou problemas, consulte:
1. Este documento
2. Arquivos comentados no código
3. Comentários nas funções JavaScript

---

## 📝 Notas Importantes

- ✅ Todas as novas funcionalidades são totalmente responsivas
- ✅ Compatível com navegadores modernos (Chrome, Firefox, Safari, Edge)
- ✅ Acessível conforme WCAG 2.1
- ✅ Otimizado para performance
- ✅ Seguem boas práticas de segurança

---

**Versão:** 2.0  
**Data:** 2024  
**Status:** ✅ Pronto para produção
