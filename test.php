<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$schemas = [];
foreach(['encounters', 'lab_results', 'medical_documents', 'immunizations', 'patient_allergies', 'dpri_records', 'medications', 'prescriptions'] as $t) {
    $schemas[$t] = Illuminate\Support\Facades\Schema::getColumnListing($t);
}
echo json_encode($schemas, JSON_PRETTY_PRINT);
