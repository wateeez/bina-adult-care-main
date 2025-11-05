<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        return $this->handlePhpFile('index.php', $request);
    }

    public function services(Request $request)
    {
        return $this->handlePhpFile('services.php', $request);
    }

    public function about(Request $request)
    {
        return $this->handlePhpFile('about.php', $request);
    }

    public function contact(Request $request)
    {
        return $this->handlePhpFile('contact.php', $request);
    }

    protected function handlePhpFile($filename, Request $request)
    {
        // Set up the basic server variables
        $_SERVER['REQUEST_URI'] = $request->getRequestUri();
        $_SERVER['REQUEST_METHOD'] = $request->method();
        $_SERVER['HTTP_HOST'] = $request->getHost();
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['PHP_SELF'] = '/index.php';
        $_SERVER['SCRIPT_FILENAME'] = base_path($filename);
        $_SERVER['DOCUMENT_ROOT'] = public_path();
        
        // Set up request data
        $_GET = $request->query();
        $_POST = $request->post();
        $_FILES = $request->allFiles();
        $_COOKIE = $request->cookie(); // Fixed: Using cookie() method instead of cookies property
        
        // Handle request headers
        foreach ($request->headers->all() as $key => $value) {
            $headerKey = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
            $_SERVER[$headerKey] = $value[0];
        }
        
        // Start output buffering to capture the PHP file output
        ob_start();
        include base_path($filename);
        $content = ob_get_clean();
        
        return response($content);
    }
}