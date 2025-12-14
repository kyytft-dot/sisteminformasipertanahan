<?php

return [
    App\Providers\AppServiceProvider::class,
    // ... provider lain yang sudah ada

    // Tambahkan ini untuk middleware Spatie
    \Spatie\Permission\PermissionServiceProvider::class,
];