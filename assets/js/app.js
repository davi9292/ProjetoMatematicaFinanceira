// Davi de Assis Fabricio e Vinicius Queiroz
// ---------- Global Variables ----------
let currentExpenseChart = null;
let currentInvestmentChart = null;
let expenseModal = null;
let editingExpenseId = null;

// ---------- Initialize Application ----------
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap modal
    expenseModal = new bootstrap.Modal(document.getElementById('expenseModal'));

    // Load initial data
    loadExpenses();
    loadMonthlySummary();
    loadEducationTopics();

    // Set up form event listeners
    setupEventListeners();

    // Show home section by default
    showSection('home');
});

// ---------- Event Listeners Setup ----------
function setupEventListeners() {
    // Financing form
    document.getElementById('financing-form').addEventListener('submit', function(e) {
        e.preventDefault();
        simulateFinancing();
    });

    // Investment form
    document.getElementById('investment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        simulateInvestment();
    });

    // Expense form
    document.getElementById('expense-form').addEventListener('submit', function(e) {
        e.preventDefault();
        saveExpense();
    });

    // Set today's date as default in expense form
    document.querySelector('input[name="expense_date"]').value = new Date().toISOString().split('T')[0];
}

// ---------- Navigation Functions ----------
function showSection(sectionName) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));

    // Show selected section
    document.getElementById(sectionName + '-section').classList.add('active');

    // Update navbar active state
    document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
    event.target.classList.add('active');

    // Load section-specific data
    if (sectionName === 'expenses') {
        loadExpenses();
        loadMonthlySummary();
    }
}

// ---------- API Helper ----------
async function apiRequest(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: { 'Content-Type': 'application/json', ...options.headers },
            ...options
        });
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error('API Request Error:', error);
        showAlert('Erro de comunicação com o servidor', 'danger');
        throw error;
    }
}

// ==============================
// Expenses Functions
// ==============================
async function loadExpenses() {
    try {
        const response = await apiRequest('api/expenses.php');
        if (response.success) displayExpenses(response.data);
    } catch {
        showError(document.getElementById('expenses-list'), 'Erro ao carregar despesas');
    }
}

function displayExpenses(expenses) {
    const container = document.getElementById('expenses-list');

    if (!expenses || expenses.length === 0) {
        container.innerHTML = `
        <div class="empty-state">
            <i class="bi bi-wallet"></i>
            <h5>Nenhuma despesa cadastrada</h5>
            <p class="text-muted">Comece adicionando sua primeira despesa</p>
            <button class="btn btn-success" onclick="showExpenseModal()">
                <i class="bi bi-plus-circle me-2"></i>Adicionar Despesa
            </button>
        </div>`;
        return;
    }

    const expenseCards = expenses.map(expense => `
        <div class="expense-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="mb-0 fw-bold">${expense.name}</h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="editExpense(${expense.id})"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteExpense(${expense.id})"><i class="bi bi-trash me-2"></i>Excluir</a></li>
                    </ul>
                </div>
            </div>
            <p class="expense-category mb-1">${expense.category}</p>
            <p class="expense-amount mb-1">${formatCurrency(expense.amount)}</p>
            <p class="expense-date mb-0">${formatDate(expense.expense_date)}</p>
        </div>`).join('');

    container.innerHTML = expenseCards;
}

async function loadMonthlySummary() {
    try {
        const now = new Date();
        const response = await apiRequest(`api/expenses.php/summary/${now.getFullYear()}/${now.getMonth() + 1}`);
        if (response.success) {
            displayMonthlySummary(response.data);
            updateExpenseChart(response.data.category_totals);
        }
    } catch (error) {
        console.error('Error loading monthly summary:', error);
    }
}

function displayMonthlySummary(data) {
    const container = document.getElementById('expense-summary');
    container.innerHTML = `
        <div class="col-md-6">
            <div class="summary-card">
                <div class="summary-title">Total Gasto Este Mês</div>
                <div class="summary-value">${formatCurrency(data.total_spent)}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="summary-card">
                <div class="summary-title">Número de Despesas</div>
                <div class="summary-value">${data.expense_count}</div>
            </div>
        </div>`;
}

function updateExpenseChart(categoryTotals) {
    const ctx = document.getElementById('expenseChart').getContext('2d');

    if (currentExpenseChart) currentExpenseChart.destroy();

    if (!categoryTotals || Object.keys(categoryTotals).length === 0) {
        ctx.font = '16px Inter';
        ctx.fillStyle = '#6b7280';
        ctx.textAlign = 'center';
        ctx.fillText('Nenhum dado para exibir', ctx.canvas.width / 2, ctx.canvas.height / 2);
        return;
    }

    const labels = Object.keys(categoryTotals);
    const data = Object.values(categoryTotals);
    const colors = ['#2563eb', '#16a34a', '#dc2626', '#ea580c', '#7c3aed', '#db2777', '#0891b2', '#65a30d'];

    currentExpenseChart = new Chart(ctx, {
        type: 'pie',
        data: { labels, datasets: [{ data, backgroundColor: colors.slice(0, labels.length), borderWidth: 2, borderColor: '#ffffff' }] },
        options: {
            responsive: true,
            // maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } },
                tooltip: { callbacks: { label: ctx => `${ctx.label}: ${formatCurrency(ctx.parsed)}` } }
            }
        }
    });
}

function showExpenseModal(expense = null) {
    const modal = document.getElementById('expenseModal');
    const form = document.getElementById('expense-form');
    const title = document.getElementById('expenseModalTitle');

    form.reset();
    editingExpenseId = null;

    if (expense) {
        title.textContent = 'Editar Despesa';
        editingExpenseId = expense.id;
        form.elements.name.value = expense.name;
        form.elements.category.value = expense.category;
        form.elements.amount.value = expense.amount;
        form.elements.expense_date.value = expense.expense_date;
    } else {
        title.textContent = 'Nova Despesa';
        form.elements.expense_date.value = new Date().toISOString().split('T')[0];
    }

    expenseModal.show();
}

async function saveExpense() {
    const form = document.getElementById('expense-form');
    const formData = new FormData(form);
    const expenseData = {
        name: formData.get('name'),
        category: formData.get('category'),
        amount: parseFloat(formData.get('amount')),
        expense_date: formData.get('expense_date')
    };

    try {
        let response;
        if (editingExpenseId) {
            response = await apiRequest(`api/expenses.php/${editingExpenseId}`, { method: 'PUT', body: JSON.stringify(expenseData) });
        } else {
            response = await apiRequest('api/expenses.php', { method: 'POST', body: JSON.stringify(expenseData) });
        }

        if (response.success) {
            expenseModal.hide();
            loadExpenses();
            loadMonthlySummary();
            showAlert(response.message, 'success');
        } else {
            showAlert(response.message, 'danger');
        }
    } catch {
        showAlert('Erro ao salvar despesa', 'danger');
    }
}

async function editExpense(id) {
    try {
        const response = await apiRequest(`api/expenses.php/${id}`);
        if (response.success) showExpenseModal(response.data);
    } catch {
        showAlert('Erro ao carregar dados da despesa', 'danger');
    }
}

async function deleteExpense(id) {
    if (!confirm('Tem certeza que deseja excluir esta despesa?')) return;

    try {
        const response = await apiRequest(`api/expenses.php/${id}`, { method: 'DELETE' });
        if (response.success) {
            loadExpenses();
            loadMonthlySummary();
            showAlert(response.message, 'success');
        } else showAlert(response.message, 'danger');
    } catch {
        showAlert('Erro ao excluir despesa', 'danger');
    }
}

// ==============================
// Financing Simulation Functions
// ==============================
async function simulateFinancing() {
    const form = document.getElementById('financing-form');
    const formData = new FormData(form);
    const simulationData = {
        financing_type: formData.get('financing_type'),
        amount: parseFloat(formData.get('amount')),
        term_months: parseInt(formData.get('term_months')),
        interest_rate: parseFloat(formData.get('interest_rate')),
        system: formData.get('system')
    };

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Calculando...';
    submitBtn.disabled = true;

    try {
        const response = await apiRequest('api/simulations.php/financing', { method: 'POST', body: JSON.stringify(simulationData) });
        if (response.success) displayFinancingResults(response.data);
        else showAlert(response.message, 'danger');
    } catch {
        showAlert('Erro na simulação de financiamento', 'danger');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

function displayFinancingResults(data) {
    const container = document.getElementById('financing-results');
    const scheduleTable = data.schedule ? `
        <div class="card mt-4">
            <div class="card-header"><h6 class="mb-0">Tabela de Amortização (Primeiros 12 meses)</h6></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mês</th><th>Amortização</th><th>Juros</th><th>Parcela</th><th>Saldo Devedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.schedule.map(row => `
                                <tr>
                                    <td>${row.month}</td>
                                    <td>${formatCurrency(row.principal)}</td>
                                    <td>${formatCurrency(row.interest)}</td>
                                    <td>${formatCurrency(row.total_payment)}</td>
                                    <td>${formatCurrency(row.remaining_balance)}</td>
                                </tr>`).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>` : '';

    container.innerHTML = `
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Resultado da Simulação - ${data.system}</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Valor Financiado</h6><div class="value">${formatCurrency(data.principal)}</div></div></div>
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Parcela Mensal</h6><div class="value">${formatCurrency(data.monthly_payment)}</div></div></div>
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Total Pago</h6><div class="value">${formatCurrency(data.total_paid)}</div></div></div>
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Total de Juros</h6><div class="value">${formatCurrency(data.total_interest)}</div></div></div>
                </div>
            </div>
        </div>
        ${scheduleTable}`;
    container.style.display = 'block';
}

// ==============================
// Investment Simulation Functions
// ==============================
async function simulateInvestment() {
    const form = document.getElementById('investment-form');
    const formData = new FormData(form);
    const simulationData = {
        initial_amount: parseFloat(formData.get('initial_amount')) || 0,
        monthly_contribution: parseFloat(formData.get('monthly_contribution')) || 0,
        annual_return_rate: parseFloat(formData.get('annual_return_rate')),
        term_months: parseInt(formData.get('term_months'))
    };

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Calculando...';
    submitBtn.disabled = true;

    try {
        const response = await apiRequest('api/simulations.php/investment', { method: 'POST', body: JSON.stringify(simulationData) });
        if (response.success) displayInvestmentResults(response.data);
        else showAlert(response.message, 'danger');
    } catch {
        showAlert('Erro na simulação de investimento', 'danger');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

function displayInvestmentResults(data) {
    const container = document.getElementById('investment-results');
    const rentability = ((data.total_earnings / data.total_invested) * 100).toFixed(2);

    container.innerHTML = `
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Projeção do Investimento</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Valor Final</h6><div class="value">${formatCurrency(data.final_amount)}</div></div></div>
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Total Investido</h6><div class="value">${formatCurrency(data.total_invested)}</div></div></div>
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Rendimento</h6><div class="value">${formatCurrency(data.total_earnings)}</div></div></div>
                    <div class="col-md-6 col-lg-3"><div class="result-card"><h6>Rentabilidade</h6><div class="value">${rentability}%</div></div></div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header"><h6 class="mb-0">Evolução do Investimento</h6></div>
            <div class="card-body"><canvas id="investmentChart" width="400" height="200"></canvas></div>
        </div>`;
    container.style.display = 'block';

    // Create investment chart
    setTimeout(() => createInvestmentChart(data.projections), 100);
}

function createInvestmentChart(projections) {
    const ctx = document.getElementById('investmentChart').getContext('2d');
    if (currentInvestmentChart) currentInvestmentChart.destroy();

    const labels = projections.map(p => `Mês ${p.month}`);
    const totalAmounts = projections.map(p => p.total_amount);
    const investedAmounts = projections.map(p => p.invested);

    currentInvestmentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                { label: 'Valor Total', data: totalAmounts, borderColor: '#2563eb', backgroundColor: 'rgba(37, 99, 235, 0.1)', borderWidth: 3, fill: true, tension: 0.4 },
                { label: 'Valor Investido', data: investedAmounts, borderColor: '#16a34a', backgroundColor: 'rgba(22, 163, 74, 0.1)', borderWidth: 3, fill: false, tension: 0.4 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${formatCurrency(ctx.parsed.y)}` } }
            },
            scales: { y: { beginAtZero: true, ticks: { callback: value => formatCurrency(value) } } }
        }
    });
}

// Education Functions
// function loadEducationTopics() {
//     const topics = [
//         {
//             id: 1,
//             title: "Juros Simples vs Compostos",
//             description: "Entenda a diferença entre juros simples e compostos e como eles impactam seus investimentos.",
//             video_url: "",
//             summary: "Juros simples são calculados apenas sobre o valor principal, enquanto juros compostos incidem sobre o principal + juros acumulados. Os juros compostos são fundamentais para o crescimento de investimentos a longo prazo."
//         },
//         {
//             id: 2,
//             title: "Como Sair das Dívidas",
//             description: "Estratégias práticas para quitar dívidas e organizar suas finanças.",
//             video_url: "",
//             summary: "Métodos como 'bola de neve' (quitar dívidas menores primeiro) e 'avalanche' (quitar dívidas com maiores juros primeiro) ajudam a priorizar e quitar dívidas de forma eficiente."
//         },
//         {
//             id: 3,
//             title: "Primeiros Passos no Investimento",
//             description: "Guia básico para começar a investir com segurança.",
//             video_url: "",
//             summary: "Comece com reserva de emergência (6 meses de gastos), depois explore renda fixa (CDB, Tesouro Direto) e gradualmente renda variável (ações, fundos) conforme seu perfil de risco."
//         },
//         {
//             id: 4,
//             title: "",
//             description: "",
//             video_url: "",
//             summary: ""
//         }
//     ];
    
//     displayEducationTopics(topics);
// }



// Utility Functions
function formatCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('pt-BR');
}

function showAlert(message, type = 'info') {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 90px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Loading indicator
function showLoading(element) {
    element.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-primary"></div></div>';
}

// Error display
function showError(element, message) {
    element.innerHTML = `<div class="alert alert-danger">${message}</div>`;
}