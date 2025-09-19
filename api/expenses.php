<!-- Davi de Assis Fabricio e Vinicius Queiroz -->
<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$conn = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

switch ($method) {
    case 'GET':
        if (empty($request[0])) {
            // GET /api/expenses - Listar todas as despesas
            getAllExpenses($conn);
        } elseif ($request[0] === 'summary' && isset($request[1]) && isset($request[2])) {
            // GET /api/expenses/summary/{year}/{month}
            getMonthlySummary($conn, $request[1], $request[2]);
        } elseif (is_numeric($request[0])) {
            // GET /api/expenses/{id}
            getExpenseById($conn, $request[0]);
        }
        break;
        
    case 'POST':
        // POST /api/expenses - Criar nova despesa
        createExpense($conn);
        break;
        
    case 'PUT':
        if (isset($request[0]) && is_numeric($request[0])) {
            // PUT /api/expenses/{id}
            updateExpense($conn, $request[0]);
        }
        break;
        
    case 'DELETE':
        if (isset($request[0]) && is_numeric($request[0])) {
            // DELETE /api/expenses/{id}
            deleteExpense($conn, $request[0]);
        }
        break;
}

function getAllExpenses($conn) {
    try {
        $stmt = $conn->prepare("SELECT * FROM expenses ORDER BY expense_date DESC");
        $stmt->execute();
        $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        jsonResponse(true, $expenses);
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro ao buscar despesas: ' . $e->getMessage());
    }
}

function getExpenseById($conn, $id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
        $stmt->execute([$id]);
        $expense = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($expense) {
            jsonResponse(true, $expense);
        } else {
            jsonResponse(false, null, 'Despesa não encontrada');
        }
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro ao buscar despesa: ' . $e->getMessage());
    }
}

function createExpense($conn) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $name = sanitizeInput($data['name'] ?? '');
        $category = sanitizeInput($data['category'] ?? '');
        $amount = floatval($data['amount'] ?? 0);
        $expenseDate = sanitizeInput($data['expense_date'] ?? date('Y-m-d'));
        
        if (empty($name) || empty($category) || !validateNumber($amount)) {
            jsonResponse(false, null, 'Dados inválidos');
        }
        
        $stmt = $conn->prepare("INSERT INTO expenses (name, category, amount, expense_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category, $amount, $expenseDate]);
        
        $id = $conn->lastInsertId();
        $stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
        $stmt->execute([$id]);
        $expense = $stmt->fetch(PDO::FETCH_ASSOC);
        
        jsonResponse(true, $expense, 'Despesa criada com sucesso');
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro ao criar despesa: ' . $e->getMessage());
    }
}

function updateExpense($conn, $id) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $updateFields = [];
        $params = [];
        
        if (isset($data['name'])) {
            $updateFields[] = "name = ?";
            $params[] = sanitizeInput($data['name']);
        }
        if (isset($data['category'])) {
            $updateFields[] = "category = ?";
            $params[] = sanitizeInput($data['category']);
        }
        if (isset($data['amount'])) {
            $updateFields[] = "amount = ?";
            $params[] = floatval($data['amount']);
        }
        if (isset($data['expense_date'])) {
            $updateFields[] = "expense_date = ?";
            $params[] = sanitizeInput($data['expense_date']);
        }
        
        if (empty($updateFields)) {
            jsonResponse(false, null, 'Nenhum campo para atualizar');
        }
        
        $params[] = $id;
        $sql = "UPDATE expenses SET " . implode(', ', $updateFields) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        $stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
        $stmt->execute([$id]);
        $expense = $stmt->fetch(PDO::FETCH_ASSOC);
        
        jsonResponse(true, $expense, 'Despesa atualizada com sucesso');
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro ao atualizar despesa: ' . $e->getMessage());
    }
}

function deleteExpense($conn, $id) {
    try {
        $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            jsonResponse(true, null, 'Despesa excluída com sucesso');
        } else {
            jsonResponse(false, null, 'Despesa não encontrada');
        }
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro ao excluir despesa: ' . $e->getMessage());
    }
}

function getMonthlySummary($conn, $year, $month) {
    try {
        $stmt = $conn->prepare("
            SELECT 
                category,
                SUM(amount) as total,
                COUNT(*) as count
            FROM expenses 
            WHERE YEAR(expense_date) = ? AND MONTH(expense_date) = ?
            GROUP BY category
        ");
        $stmt->execute([$year, $month]);
        $categoryTotals = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = $conn->prepare("
            SELECT 
                SUM(amount) as total_spent,
                COUNT(*) as expense_count
            FROM expenses 
            WHERE YEAR(expense_date) = ? AND MONTH(expense_date) = ?
        ");
        $stmt->execute([$year, $month]);
        $summary = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $categoryData = [];
        foreach ($categoryTotals as $cat) {
            $categoryData[$cat['category']] = floatval($cat['total']);
        }
        
        $result = [
            'year' => intval($year),
            'month' => intval($month),
            'total_spent' => floatval($summary['total_spent'] ?? 0),
            'expense_count' => intval($summary['expense_count'] ?? 0),
            'category_totals' => $categoryData
        ];
        
        jsonResponse(true, $result);
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro ao buscar resumo mensal: ' . $e->getMessage());
    }
}
?>