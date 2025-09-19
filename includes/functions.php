<!-- Davi de Assis Fabricio e Vinicius Queiroz -->
<?php
// Funções de Cálculos Financeiros

/**
 * Calcula financiamento pelo Sistema PRICE (parcelas fixas)
 */
function calculatePrice($amount, $termMonths, $monthlyRate) {
    if ($monthlyRate == 0) {
        return $amount / $termMonths;
    }
    
    $monthlyPayment = $amount * ($monthlyRate * pow(1 + $monthlyRate, $termMonths)) / (pow(1 + $monthlyRate, $termMonths) - 1);
    return $monthlyPayment;
}

/**
 * Calcula financiamento pelo Sistema SAC (amortização constante)
 */
function calculateSAC($amount, $termMonths, $monthlyRate) {
    $principalPayment = $amount / $termMonths;
    $schedule = [];
    $remainingBalance = $amount;
    
    for ($month = 1; $month <= $termMonths; $month++) {
        $interestPayment = $remainingBalance * $monthlyRate;
        $totalPayment = $principalPayment + $interestPayment;
        $remainingBalance -= $principalPayment;
        
        $schedule[] = [
            'month' => $month,
            'principal' => round($principalPayment, 2),
            'interest' => round($interestPayment, 2),
            'total_payment' => round($totalPayment, 2),
            'remaining_balance' => round(max(0, $remainingBalance), 2)
        ];
    }
    
    return $schedule;
}

/**
 * Calcula tabela de amortização para Sistema PRICE
 */
function calculatePriceSchedule($amount, $termMonths, $monthlyRate) {
    $monthlyPayment = calculatePrice($amount, $termMonths, $monthlyRate);
    $schedule = [];
    $remainingBalance = $amount;
    
    for ($month = 1; $month <= $termMonths; $month++) {
        $interestPayment = $remainingBalance * $monthlyRate;
        $principalPayment = $monthlyPayment - $interestPayment;
        $remainingBalance -= $principalPayment;
        
        $schedule[] = [
            'month' => $month,
            'principal' => round($principalPayment, 2),
            'interest' => round($interestPayment, 2),
            'total_payment' => round($monthlyPayment, 2),
            'remaining_balance' => round(max(0, $remainingBalance), 2)
        ];
    }
    
    return $schedule;
}

/**
 * Calcula investimento com juros compostos
 */
function calculateCompoundInterest($principal, $monthlyContribution, $annualRate, $months) {
    $monthlyRate = $annualRate / 12 / 100;
    $totalInvested = $principal;
    $projections = [];
    $currentAmount = $principal;
    
    for ($month = 1; $month <= $months; $month++) {
        // Adiciona rendimento
        $currentAmount = $currentAmount * (1 + $monthlyRate);
        
        // Adiciona aporte mensal (exceto no primeiro mês se já há valor inicial)
        if ($month > 1 || $principal == 0) {
            $currentAmount += $monthlyContribution;
            $totalInvested += $monthlyContribution;
        }
        
        $projections[] = [
            'month' => $month,
            'invested' => round($totalInvested, 2),
            'total_amount' => round($currentAmount, 2),
            'earnings' => round($currentAmount - $totalInvested, 2)
        ];
    }
    
    return $projections;
}

/**
 * Formata valor para moeda brasileira
 */
function formatCurrency($value) {
    return 'R$ ' . number_format($value, 2, ',', '.');
}

/**
 * Formata data brasileira
 */
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

/**
 * Sanitiza input para evitar XSS
 */
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

/**
 * Valida se é um número válido
 */
function validateNumber($value) {
    return is_numeric($value) && $value > 0;
}

/**
 * Resposta JSON padronizada
 */
function jsonResponse($success, $data = null, $message = '') {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'message' => $message
    ]);
    exit;
}
?>