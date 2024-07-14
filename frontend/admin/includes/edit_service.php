<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $with = $_POST['with'];
    $price_terms = $_POST['price_terms'];
    $fee = $_POST['fee'];

    $services = json_decode(file_get_contents('../data/services.json'), true);

    foreach ($services as &$service) {
        if ($service['id'] === $id) {
            $service['name'] = $name;
            $service['with'] = $with;
            $service['price_terms'] = $price_terms;
            $service['fee'] = $fee;
            break;
        }
    }

    if (file_put_contents('../data/services.json', json_encode($services, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
