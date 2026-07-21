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
        
        if (preg_match('/public function index\(\s*\)/', $content)) {
            $content = preg_replace('/public function index\(\s*\)/', 'public function index(\Illuminate\Http\Request $request)', $content);
        }

        // We only care about adding 'when($request->filled('q'), ...)' if not present
        if (strpos($content, '$request->filled(\'q\')') === false) {
            $searchField = $config['searchField'];
            
            // For generic cases where it is `Model::` or `Model::with(...)` or `Model::latest()`
            // We just inject `->when($request->filled('q'), fn ($q) => $q->where('$searchField', 'like', '%' . $request->string('q') . '%'))`
            // right before `->paginate`
            
            if (preg_match('/(->paginate\(\d+\))/', $content, $m)) {
                $injection = "->when(\$request->filled('q'), fn (\$q) => \$q->where('{$searchField}', 'like', '%' . \$request->string('q') . '%'))\n            " . $m[1] . "->withQueryString()";
                
                // If it already has withQueryString, we just replace paginate
                if (strpos($content, '->withQueryString()') !== false) {
                    $injection = "->when(\$request->filled('q'), fn (\$q) => \$q->where('{$searchField}', 'like', '%' . \$request->string('q') . '%'))\n            " . $m[1];
                }
                
                $content = preg_replace('/->paginate\(\d+\)/', $injection, $content, 1);
                echo "Updated controller query: $model\n";
            }
        }
        
        file_put_contents($controllerPath, $content);
    }
    
    // 2. UPDATE VIEW
    $viewPath = $baseDir . '/resources/views/admin/' . $config['viewFolder'] . '/index.blade.php';
    if (file_exists($viewPath)) {
        $content = file_get_contents($viewPath);
        
        // Fix duplicate class from previous script
        $content = str_replace('<div class="overflow-x-auto"><table class="min-w-[800px]" class="w-full text-left border-collapse">', '<div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left border-collapse">', $content);
        
        // Wrap table if not wrapped yet
        if (strpos($content, '<div class="overflow-x-auto">') === false) {
            $content = str_replace('<table class="w-full text-left border-collapse">', '<div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left border-collapse">', $content);
            $content = str_replace('</table>', '</table></div>', $content);
        }
        
        // Add search form if not present
        if (strpos($content, 'name="q"') === false) {
            // Find the header div. It starts with <div class="flex justify-between items-center mb-6">
            // And ends with </div> before @if(session('success')) or <div class="bg-white...
            
            // Regex to extract h1 and everything else inside the header
            if (preg_match('/<div class="flex justify-between items-center mb-6">\s*(<h1.*?>.*?<\/h1>)\s*(.*?)<\/div>/s', $content, $matches)) {
                $h1 = $matches[1];
                $buttons = $matches[2]; // Might be a <div class="flex gap-3"> or just an <a>
                
                // If the buttons are not in a div, wrap them
                if (strpos($buttons, '<div') === false) {
                    $buttons = '<div class="flex gap-3 w-full sm:w-auto">' . trim($buttons) . '</div>';
                } else {
                    // It already has a div, just append responsive classes to it if possible
                    // Actually, simpler to just leave it as is and wrap in our own div
                    $buttons = '<div class="flex w-full sm:w-auto">' . trim($buttons) . '</div>';
                }

                $newHeader = <<<HTML
<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    {$h1}
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form method="GET" class="relative w-full sm:w-64">
            <!-- Preserve existing filters -->
            @foreach(request()->except(['q', 'page']) as $key => $value)
                <input type="hidden" name="{{ \$key }}" value="{{ \$value }}">
            @endforeach
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..." class="h-11 pl-10 pr-4 rounded-lg border border-brand-line focus:ring-brand-blue focus:border-brand-blue text-sm w-full">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
        {$buttons}
    </div>
</div>
HTML;
                $content = preg_replace('/<div class="flex justify-between items-center mb-6">.*?<\/div>/s', $newHeader, $content, 1);
                echo "Updated view header: {$config['viewFolder']}\n";
            }
        }
        
        file_put_contents($viewPath, $content);
    }
}
echo "Fix script completed.\n";
