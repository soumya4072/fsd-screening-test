<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once 'config.php';

/**
 * Validate input
 */
$bookingId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$siteId    = filter_input(INPUT_GET, 'site_id', FILTER_VALIDATE_INT) ?? 1;

if (!$bookingId || $bookingId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid booking ID']);
    exit;
}

try {
    // Main DB
    $mainDb = getMainDbConnection();

    // Fetch booking
    $stmt = $mainDb->prepare(
        "SELECT * FROM bookings WHERE id = :id LIMIT 1"
    );
    $stmt->execute(['id' => $bookingId]);
    $booking = $stmt->fetch();

    if (!$booking) {
        http_response_code(404);
        echo json_encode(['error' => 'Booking not found']);
        exit;
    }

    $customer = null;

    // Site DB
    $siteConfig = getSiteDbConfig($siteId);
    if ($siteConfig) {
        $siteDb = getSiteDbConnection($siteConfig);

        // Fetch customer
        $stmt2 = $siteDb->prepare(
            "SELECT * FROM customers WHERE email = :email LIMIT 1"
        );
        $stmt2->execute(['email' => $booking['email']]);
        $customer = $stmt2->fetch();

        // Update booking status
        $updateStmt = $mainDb->prepare(
            "UPDATE bookings 
             SET status = 'confirmed', updated_at = NOW()
             WHERE id = :id"
        );
        $updateStmt->execute(['id' => $bookingId]);
    }

    echo json_encode([
        'booking'  => $booking,
        'customer' => $customer
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
    ]);
}
