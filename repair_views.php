<?php
$baseDir = 'D:\Layang\maxinpro.com';

$modules = [
    'listings', 'projects', 'leads', 'agents', 'areas', 'developers', 'property-types', 'articles', 'testimonials', 'partner-banks', 'audit-logs'
];

foreach ($modules as $folder) {
    $viewPath = $baseDir . '/resources/views/admin/' . $folder . '/index.blade.php';
    if (file_exists($viewPath)) {
        $content = file_get_contents($viewPath);
        
        $content = str_replace('@foreach(request()->except([\'q\', \'page\']) as  => )', '@foreach(request()->except([\'q\', \'page\']) as $key => $value)', $content);
        
        file_put_contents($viewPath, $content);
        echo "Repaired view: $viewPath\n";
    }
}
echo "Repair completed.\n";
