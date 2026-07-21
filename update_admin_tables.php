<?php
$baseDir = 'D:\Layang\maxinpro.com';

$modules = [
    'Listing' => ['viewFolder' => 'listings', 'searchField' => 'title'],
    'Project' => ['viewFolder' => 'projects', 'searchField' => 'name'],
    'Lead' => ['viewFolder' => 'leads', 'searchField' => 'name'],
    'Agent' => ['viewFolder' => 'agents', 'searchField' => 'name'],
    'Area' => ['viewFolder' => 'areas', 'searchField' => 'name'],
    'Developer' => ['viewFolder' => 'developers', 'searchField' => 'name'],
    'PropertyType' => ['viewFolder' => 'property-types', 'searchField' => 'name'],
    'Article' => ['viewFolder' => 'articles', 'searchField' => 'title'],
    'Testimonial' => ['viewFolder' => 'testimonials', 'searchField' => 'author_name'],
    'PartnerBank' => ['viewFolder' => 'partner-banks', 'searchField' => 'name'],
    'AuditLog' => ['viewFolder' => 'audit-logs', 'searchField' => 'action'],
];

foreach ($modules as $model => $config) {
    // 1. UPDATE CONTROLLER
    $controllerPath = $baseDir . '/app/Http/Controllers/Admin/' . $model . 'Controller.php';
    if (file_exists($controllerPath)) {
        $content = file_get_contents($controllerPath);
        
        // Make sure index has Request $request
        if (preg_match('/public function index\(\s*\)/', $content)) {
            $content = preg_replace('/public function index\(\s*\)/', 'public function index(\Illuminate\Http\Request $request)', $content);
        }

        // Add search query and ensure pagination is correctly chained
        // A bit tricky via regex, so we do a simple replace on the query building part
        $modelVar = lcfirst($model);
        if ($model === 'PropertyType') $modelVar = 'propertyTypes';
        if ($model === 'PartnerBank') $modelVar = 'partnerBanks';
        if ($model === 'AuditLog') $modelVar = 'auditLogs';
        else $modelVar = $modelVar . 's';

        // Add search logic if not present
        if (strpos($content, '$request->filled(\'q\')') === false) {
            $searchField = $config['searchField'];
            
            // Typical structure: $areas = Area::orderBy... ->paginate...
            // Let's replace '::orderBy' with '::query()->when($request->filled(\'q\'), fn($q) => $q->where(\''.$searchField.'\', \'like\', \'%\' . $request->string(\'q\') . \'%\'))->orderBy'
            // OR replace '::latest()' with '::query()->when(...)->latest()'
            
            // Regex to find the assignment `$modelVar = ModelName::`
            $pattern = '/\$' . $modelVar . '\s*=\s*' . $model . '::(.*?)(paginate\(\d+\));/s';
            if (preg_match($pattern, $content, $matches)) {
                $middle = $matches[1];
                $paginate = $matches[2];
                // Insert query()->when(...)
                $newMiddle = 'query()->when($request->filled(\'q\'), fn($q) => $q->where(\'' . $searchField . '\', \'like\', \'%\' . $request->string(\'q\') . \'%\'))->' . ltrim($middle, 'query()->');
                $replacement = '$' . $modelVar . ' = ' . $model . '::' . $newMiddle . $paginate . '->withQueryString();';
                
                // For Lead, we might have with(...)
                $content = str_replace($matches[0], $replacement, $content);
                echo "Updated controller: $controllerPath\n";
            } else {
                echo "Could not parse query for $model\n";
            }
        }
        
        file_put_contents($controllerPath, $content);
    }
    
    // 2. UPDATE VIEW
    $viewPath = $baseDir . '/resources/views/admin/' . $config['viewFolder'] . '/index.blade.php';
    if (file_exists($viewPath)) {
        $content = file_get_contents($viewPath);
        
        // Wrap table in overflow-x-auto
        if (strpos($content, '<div class="overflow-x-auto">') === false) {
            $content = str_replace('<table', '<div class="overflow-x-auto"><table class="min-w-[800px]"', $content);
            $content = str_replace('</table>', '</table></div>', $content);
        }
        
        // Make the top header responsive and add search bar
        // Usually it looks like:
        // <div class="flex justify-between items-center mb-6">
        //     <h1 class="...">Kelola ...</h1>
        //     <div class="flex gap-3">... buttons ...</div>
        // </div>
        
        $headerPattern = '/<div class="flex justify-between items-center mb-6">(.*?)<div class="flex gap-3">(.*?)<\/div>\s*<\/div>/s';
        if (preg_match($headerPattern, $content, $matches)) {
            $h1 = $matches[1];
            $buttons = $matches[2];
            
            $newHeader = <<<HTML
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    {$h1}<div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        <div class="flex gap-3 w-full sm:w-auto">
            {$buttons}
        </div>
    </div>
</div>
HTML;
            $content = preg_replace($headerPattern, $newHeader, $content);
            echo "Updated view: $viewPath\n";
        }
        
        file_put_contents($viewPath, $content);
    }
}
echo "Migration completed.\n";
