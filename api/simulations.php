<!-- Davi de Assis Fabricio e Vinicius Queiroz -->
<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$conn = getDBConnection();
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

if ($method === 'POST') {
    if ($request[0] === 'financing') {
        simulateFinancing($conn);
    } elseif ($request[0] === 'investment') {
        simulateInvestment($conn);
    }
}

function simulateFinancing($conn) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $financingType = sanitizeInput($data['financing_type'] ?? '');
        $amount = floatval($data['amount'] ?? 0);
        $termMonths = intval($data['term_months'] ?? 0);
        $interestRate = floatval($data['interest_rate'] ?? 0);
        $system = strtoupper(sanitizeInput($data['system'] ?? 'PRICE'));
        
        if (!validateNumber($amount) || $termMonths <= 0 || $interestRate < 0) {
            jsonResponse(false, null, 'Dados inválidos para simulação');
        }
        
        $monthlyRate = $interestRate / 12 / 100;
        
        if ($system === 'PRICE') {
            $monthlyPayment = calculatePrice($amount, $termMonths, $monthlyRate);
            $schedule = calculatePriceSchedule($amount, $termMonths, $monthlyRate);
            $totalPaid = $monthlyPayment * $termMonths;
        } else { // SAC
            $schedule = calculateSAC($amount, $termMonths, $monthlyRate);
            $totalPaid = array_sum(array_column($schedule, 'total_payment'));
            $monthlyPayment = $schedule[0]['total_payment']; // Primeira parcela
        }
        
        $totalInterest = $totalPaid - $amount;
        
        // Salvar simulação no banco (opcional)
        try {
            $stmt = $conn->prepare("
                INSERT INTO financing_simulations 
                (financing_type, amount, term_months, interest_rate, system_type, monthly_payment, total_paid, total_interest) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $financingType, $amount, $termMonths, $interestRate, 
                $system, $monthlyPayment, $totalPaid, $totalInterest
            ]);
        } catch (Exception $e) {
            // Continua mesmo se não conseguir salvar
        }
        
        $result = [
            'financing_type' => $financingType,
            'system' => $system,
            'principal' => $amount,
            'monthly_payment' => round($monthlyPayment, 2),
            'total_paid' => round($totalPaid, 2),
            'total_interest' => round($totalInterest, 2),
            'term_months' => $termMonths,
            'interest_rate' => $interestRate,
            'schedule' => array_slice($schedule, 0, 12) // Primeiros 12 meses
        ];
        
        jsonResponse(true, $result);
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro na simulação de financiamento: ' . $e->getMessage());
    }
}

function simulateInvestment($conn) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $initialAmount = floatval($data['initial_amount'] ?? 0);
        $monthlyContribution = floatval($data['monthly_contribution'] ?? 0);
        $annualReturnRate = floatval($data['annual_return_rate'] ?? 0);
        $termMonths = intval($data['term_months'] ?? 0);
        
        if (($initialAmount <= 0 && $monthlyContribution <= 0) || $termMonths <= 0 || $annualReturnRate < 0) {
            jsonResponse(false, null, 'Dados inválidos para simulação');
        }
        
        $projections = calculateCompoundInterest($initialAmount, $monthlyContribution, $annualReturnRate, $termMonths);
        
        $finalAmount = end($projections)['total_amount'];
        $totalInvested = end($projections)['invested'];
        $totalEarnings = $finalAmount - $totalInvested;
        
        // Salvar simulação no banco (opcional)
        try {
            $stmt = $conn->prepare("
                INSERT INTO investment_simulations 
                (initial_amount, monthly_contribution, annual_return_rate, term_months, final_amount, total_invested, total_earnings) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $initialAmount, $monthlyContribution, $annualReturnRate, 
                $termMonths, $finalAmount, $totalInvested, $totalEarnings
            ]);
        } catch (Exception $e) {
            // Continua mesmo se não conseguir salvar
        }
        
        $result = [
            'initial_amount' => $initialAmount,
            'monthly_contribution' => $monthlyContribution,
            'annual_return_rate' => $annualReturnRate,
            'term_months' => $termMonths,
            'final_amount' => round($finalAmount, 2),
            'total_invested' => round($totalInvested, 2),
            'total_earnings' => round($totalEarnings, 2),
            'projections' => $projections
        ];
        
        jsonResponse(true, $result);
    } catch (Exception $e) {
        jsonResponse(false, null, 'Erro na simulação de investimento: ' . $e->getMessage());
    }
}
?>