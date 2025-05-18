return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],  // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => [
        'http://localhost:3000', // your frontend local dev URL
        'https://your-production-frontend-domain.com', // your deployed frontend URL
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers (Authorization, Content-Type, etc.)

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Important for Sanctum auth cookies and Authorization headers

];

