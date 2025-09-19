<!-- Davi de Assis Fabricio e Vinicius Queiroz -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOUSEFinanças - Plataforma de Educação Financeira</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#" onclick="showSection('home')">
                <i class="bi bi-currency-dollar text-success me-2" style="font-size: 2rem;"></i>
                <span class="fw-bold text-primary">MOUSEFinanças</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#" onclick="showSection('home')">
                            <i class="bi bi-house me-1"></i> Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#" onclick="showSection('expenses')">
                            <i class="bi bi-wallet me-1"></i> Despesas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#" onclick="showSection('financing')">
                            <i class="bi bi-graph-up me-1"></i> Financiamento
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#" onclick="showSection('investment')">
                            <i class="bi bi-safe me-1  align-middle"></i> Investimento
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#" onclick="showSection('education')">
                            <i class="bi bi-book me-1"></i> Educação
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Home Section -->
        <section id="home-section" class="section active">
            <div class="container">
                <!-- Hero Section -->
                <div class="row align-items-center min-vh-100 py-5">
                    <div class="col-lg-6 order-lg-1 order-2">
                        <h1 class="display-4 fw-bold text-primary mb-4">
                            Transforme sua relação com o dinheiro
                        </h1>
                        <p class="lead text-muted mb-4">
                            MOUSEFinanças é sua plataforma completa para educação financeira, simulações e gestão de
                            despesas.
                            Aprenda, simule e controle suas finanças de forma inteligente.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <button class="btn btn-primary btn-lg px-4" onclick="showSection('expenses')">
                                <i class="bi bi-play-fill me-2"></i>Começar Agora
                            </button>
                            <button class="btn btn-outline-primary btn-lg px-4" onclick="showSection('education')">
                                <i class="bi bi-book me-2"></i>Aprender Mais
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-2 order-1 text-center mb-5 mb-lg-0">
                        <div class="hero-illustration">
                            <i class="bi bi-graph-up-arrow text-success" style="font-size: 8rem; opacity: 0.8;"></i>
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="row g-4 py-5">
                    <div class="col-12">
                        <h2 class="text-center fw-bold text-primary mb-5">Funcionalidades Principais</h2>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card h-100 text-center p-4 rounded-4 shadow-sm"
                            onclick="showSection('expenses')">
                            <i class="bi bi-wallet text-success mb-3" style="font-size: 3rem;"></i>
                            <h5 class="fw-bold text-primary">Gerenciador de Despesas</h5>
                            <p class="text-muted">Controle suas despesas por categoria e visualize relatórios mensais
                                com gráficos interativos.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card h-100 text-center p-4 rounded-4 shadow-sm"
                            onclick="showSection('financing')">
                            <i class="bi bi-house-door text-success mb-3" style="font-size: 3rem;"></i>
                            <h5 class="fw-bold text-primary">Simulador de Financiamento</h5>
                            <p class="text-muted">Simule financiamentos imobiliários, veiculares e pessoais com sistemas
                                SAC e PRICE.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card h-100 text-center p-4 rounded-4 shadow-sm"
                            onclick="showSection('investment')">
                            <i class="bi bi-graph-up text-success mb-3" style="font-size: 3rem;"></i>
                            <h5 class="fw-bold text-primary">Simulador de Investimento</h5>
                            <p class="text-muted">Projete seus investimentos com juros compostos e visualize o
                                crescimento ao longo do tempo.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card h-100 text-center p-4 rounded-4 shadow-sm"
                            onclick="showSection('education')">
                            <i class="bi bi-book text-success mb-3" style="font-size: 3rem;"></i>
                            <h5 class="fw-bold text-primary">Educação Financeira</h5>
                            <p class="text-muted">Aprenda conceitos fundamentais através de vídeos educativos e resumos
                                práticos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Expenses Section -->
        <section id="expenses-section" class="section">
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary">Gerenciador de Despesas</h2>
                    <button class="btn btn-success" onclick="showExpenseModal()">
                        <i class="bi bi-plus-circle me-2"></i>Nova Despesa
                    </button>
                </div>

                <!-- Summary Cards -->
                <div id="expense-summary" class="row g-3 mb-4">
                    <!-- Cards serão carregados dinamicamente -->
                </div>

                <!-- Chart -->
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Gastos por Categoria</h5>
                                <canvas id="expenseChart" width="400" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expenses List -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Suas Despesas</h5>
                    </div>
                    <div class="card-body">
                        <div id="expenses-list">
                            <!-- Lista será carregada dinamicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Financing Section -->
        <section id="financing-section" class="section">
            <div class="container py-5">
                <h2 class="fw-bold text-primary mb-4">Simulador de Financiamento</h2>

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card sticky-top">
                            <div class="card-header">
                                <h5 class="mb-0">Dados do Financiamento</h5>
                            </div>
                            <div class="card-body">
                                <form id="financing-form">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de Financiamento</label>
                                        <select class="form-select" name="financing_type" required>
                                            <option value="imobiliario">Imobiliário</option>
                                            <option value="veicular">Veicular</option>
                                            <option value="pessoal">Pessoal</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Valor do Financiamento (R$)</label>
                                        <input type="number" class="form-control" name="amount" step="0.01" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Prazo (meses)</label>
                                        <input type="number" class="form-control" name="term_months" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Taxa de Juros Anual (%)</label>
                                        <input type="number" class="form-control" name="interest_rate" step="0.01"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sistema de Amortização</label>
                                        <select class="form-select" name="system" required>
                                            <option value="PRICE">PRICE (Parcelas Fixas)</option>
                                            <option value="SAC">SAC (Amortização Constante)</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-calculator me-2"></i>Simular
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div id="financing-results" style="display: none;">
                            <!-- Resultados serão carregados dinamicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Investment Section -->
        <section id="investment-section" class="section">
            <div class="container py-5">
                <h2 class="fw-bold text-primary mb-4">Simulador de Investimento</h2>

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card sticky-top">
                            <div class="card-header">
                                <h5 class="mb-0">Dados do Investimento</h5>
                            </div>
                            <div class="card-body">
                                <form id="investment-form">
                                    <div class="mb-3">
                                        <label class="form-label">Valor Inicial (R$)</label>
                                        <input type="number" class="form-control" name="initial_amount" step="0.01"
                                            placeholder="0">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Aporte Mensal (R$)</label>
                                        <input type="number" class="form-control" name="monthly_contribution"
                                            step="0.01" placeholder="0">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Taxa de Retorno Anual (%)</label>
                                        <input type="number" class="form-control" name="annual_return_rate" step="0.01"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Período (meses)</label>
                                        <input type="number" class="form-control" name="term_months" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-calculator me-2"></i>Simular
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div id="investment-results" style="display: none;">
                            <!-- Resultados serão carregados dinamicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education Section -->
        <section id="education-section" class="section">
            <div class="container py-5">
                <h2 class="fw-bold text-primary mb-4">Educação Financeira</h2>

                <div class="row g-4" id="education-topics">
                    <div class="col-lg-6">
                        <div class="education-card">
                            <div class="video-container">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/hC-Bt9N1PW8?si=oCplvGWo-_BmeWt8"
                                    title="Juros Simples vs Compostos" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                            <div class="p-4">
                                <h5 class="fw-bold text-primary">Juros Simples vs Compostos<h5>
                                <p class="text-muted mb-3">Entenda a diferença entre juros simples e compostos e como eles impactam seus investimentos.</p>

                                <div class="education-summary">
                                    <h6 class="fw-bold mb-2">Resumo:</h6>
                                    <p class="mb-0">Juros simples são calculados apenas sobre o valor principal, enquanto juros compostos incidem sobre o principal + juros acumulados. Os juros compostos são fundamentais para o crescimento de investimentos a longo prazo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="education-card">
                            <div class="video-container">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/Qm6HdD7sY1c?si=-NUcow6ici6uYvMu"
                                    title="Como Sair das Dívidas" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                            <div class="p-4">
                                <h5 class="fw-bold text-primary">Como Sair das Dívidas</h5>
                                <p class="text-muted mb-3">Estratégias práticas para quitar dívidas e organizar suas finanças.</p>

                                <div class="education-summary">
                                    <h6 class="fw-bold mb-2">Resumo:</h6>
                                    <p class="mb-0">Métodos como 'bola de neve' (quitar dívidas menores primeiro) e 'avalanche' (quitar dívidas com maiores juros primeiro) ajudam a priorizar e quitar dívidas de forma eficiente.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="education-card">
                            <div class="video-container">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/qBgK1tRAPzA?si=wW8-OTRKWitdgVJ4"
                                    title="Primeiros Passos no Investimento" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                            <div class="p-4">
                                <h5 class="fw-bold text-primary">Primeiros Passos no Investimento</h5>
                                <p class="text-muted mb-3">"Guia básico para começar a investir com segurança.</p>

                                <div class="education-summary">
                                    <h6 class="fw-bold mb-2">Resumo:</h6>
                                    <p class="mb-0">Comece com reserva de emergência (6 meses de gastos), depois explore renda fixa (CDB, Tesouro Direto) e gradualmente renda variável (ações, fundos) conforme seu perfil de risco.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="education-card">
                            <div class="video-container">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/in0XbfQEm2A?si=j5LYaw8_pZXSLMt9"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>

                            <div class="p-4">
                                <h5 class="fw-bold text-primary">Planejamento Financeiro Pessoal</h5>
                                <p class="text-muted mb-3">Como criar e manter um orçamento eficiente.</p>

                                <div class="education-summary">
                                    <h6 class="fw-bold mb-2">Resumo:</h6>
                                    <p class="mb-0">Use a regra 50-30-20: 50% para necessidades (moradia, alimentação),
                                        30% para desejos (lazer, compras), 20% para poupança e investimentos. Controle
                                        regular é essencial.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalTitle">Nova Despesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="expense-form">
                        <input type="hidden" id="expense-id" name="id">

                        <div class="mb-3">
                            <label class="form-label">Nome da Despesa</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoria</label>
                            <select class="form-select" name="category" required>
                                <option value="Moradia">Moradia</option>
                                <option value="Alimentação">Alimentação</option>
                                <option value="Transporte">Transporte</option>
                                <option value="Lazer">Lazer</option>
                                <option value="Saúde">Saúde</option>
                                <option value="Educação">Educação</option>
                                <option value="Vestuário">Vestuário</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Valor (R$)</label>
                            <input type="number" class="form-control" name="amount" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data</label>
                            <input type="date" class="form-control" name="expense_date" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveExpense()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold text-success">MOUSESFinanças</h5>
                    <p>Sua plataforma completa de educação financeira</p>
                </div>
                <div class="col-md-4">
                    <h5>Contato</h5>
                    <p>contato@financai.com.br<br>(12) 98711-0093</p>
                </div>
                <div class="col-md-4">
                    <h5>Redes Sociais</h5>
                    <p>@financai</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 MOUSEFinanças. Todos os direitos reservados. Davi Fabricio</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

    <!-- Correção do scroll infinito no gráfico -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chartCanvas = document.getElementById('expenseChart');

            if (chartCanvas) {
                // Impede que a roda do mouse faça scroll infinito
                chartCanvas.addEventListener('wheel', function (e) {
                    e.preventDefault();
                }, { passive: false });

                // Impede comportamento estranho no clique
                chartCanvas.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>

</html>