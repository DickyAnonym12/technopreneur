<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$schema = DB::select('SHOW CREATE TABLE payments');
var_export($schema);
echo PHP_EOL . '---' . PHP_EOL;
$counts = DB::table('payments')->select(DB::raw('COUNT(*) as total, COUNT(DISTINCT id) as distinct_id'))->first();
var_export($counts);
echo PHP_EOL;
