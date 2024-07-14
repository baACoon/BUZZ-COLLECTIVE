<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];
    $name = $data['name'];
    $with = $data['with'];
    $price_terms = $data['price_terms'];
    $fee = $data['fee'];

    $services = json_decode(file_get_contents('../data/services.json'), true);

    $services[] = [
        'id' => $id,
        'name' => $name,
        'with' => $with,
        'price_terms' => $price_terms,
        'fee' => $fee
    ];

    if (file_put_contents('../data/services.json', json_encode($services, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
