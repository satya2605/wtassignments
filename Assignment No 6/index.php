<?php
$units = isset($_POST['units']) ? (float) $_POST['units'] : '';
$total_bill = 0.0;
$calculated = false;

$breakdown = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && $units !== '') {
    $remaining_units = $units;

    if ($remaining_units > 0) {
        if ($remaining_units <= 50) {
            $cost = $remaining_units * 3.50;
            $breakdown[] = ["units" => $remaining_units, "rate" => 3.50, "cost" => $cost];
            $total_bill += $cost;
            $remaining_units = 0;
        } else {
            $cost = 50 * 3.50;
            $breakdown[] = ["units" => 50, "rate" => 3.50, "cost" => $cost];
            $total_bill += $cost;
            $remaining_units -= 50;
            
            if ($remaining_units <= 100) {
                $cost = $remaining_units * 4.00;
                $breakdown[] = ["units" => $remaining_units, "rate" => 4.00, "cost" => $cost];
                $total_bill += $cost;
                $remaining_units = 0;
            } else {
                $cost = 100 * 4.00;
                $breakdown[] = ["units" => 100, "rate" => 4.00, "cost" => $cost];
                $total_bill += $cost;
                $remaining_units -= 100;
                
                if ($remaining_units <= 100) {
                    $cost = $remaining_units * 5.20;
                    $breakdown[] = ["units" => $remaining_units, "rate" => 5.20, "cost" => $cost];
                    $total_bill += $cost;
                    $remaining_units = 0;
                } else {
                    $cost = 100 * 5.20;
                    $breakdown[] = ["units" => 100, "rate" => 5.20, "cost" => $cost];
                    $total_bill += $cost;
                    $remaining_units -= 100;
                    
                    if ($remaining_units > 0) {
                        $cost = $remaining_units * 6.50;
                        $breakdown[] = ["units" => $remaining_units, "rate" => 6.50, "cost" => $cost];
                        $total_bill += $cost;
                    }
                }
            }
        }
    }
    
    $calculated = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bill Calculator</title>
    <meta name="description" content="A premium responsive application to calculate electricity bills based on standard unit slabs.">
    <!-- Load modern font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Electricity Bill</h1>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="input-group">
                <label for="units">Number of Units Consumed</label>
                <input type="number" id="units" name="units" min="0" step="any" required placeholder="e.g. 120" value="<?php echo htmlspecialchars((string)$units); ?>">
            </div>
            
            <button type="submit">Calculate Bill</button>
        </form>

        <?php if ($calculated): ?>
            <div class="result-card">
                <div class="result-title">Total Amount Due</div>
                <div class="result-amount">Rs. <?php echo number_format($total_bill, 2); ?></div>
                
                <?php if (!empty($breakdown)): ?>
                <div class="result-details">
                    <?php foreach ($breakdown as $item): ?>
                    <div class="result-details-row">
                        <span><?php echo $item['units']; ?> units @ Rs. <?php echo number_format($item['rate'], 2); ?></span>
                        <span>Rs. <?php echo number_format($item['cost'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="result-details-row">
                        <span>Total Units: <?php echo htmlspecialchars((string)$units); ?></span>
                        <span>Rs. <?php echo number_format($total_bill, 2); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
