<?php
/**
 * Secure Database Configuration
 */

function getMainDbConnection(): PDO
{
    try {
        return new PDO(
            "mysql:host=localhost;dbname=main_db;charset=utf8mb4",
            "root",
            "",
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Main DB connection failed']);
        exit;
    }
}

/**
 * Site-specific DB config
 */
function getSiteDbConfig(int $siteId): array|false
{
    $configs = [
        1 => [
            'dsn' => 'mysql:host=localhost;dbname=site1_db;charset=utf8mb4',
            'user' => 'site1_user',
            'pass' => 'site1_pass',
        ],
        2 => [
            'dsn' => 'mysql:host=localhost;dbname=site2_db;charset=utf8mb4',
            'user' => 'site2_user',
            'pass' => 'site2_pass',
        ],
    ];

    return $configs[$siteId] ?? false;
}

function getSiteDbConnection(array $config): PDO
{
    return new PDO(
        $config['dsn'],
        $config['user'],
        $config['pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}


