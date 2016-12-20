<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Dashboard
     |--------------------------------------------------------------------------
     |
     | By default /lucid/dashboard is avilable on when env('APP_DEBUG') is true.
     | If you set this value to "true" it will be always accessable even on
     | production environment.
     |
     */
    'dashboard'     => null,

    /*
     |--------------------------------------------------------------------------
     | Microservice
     |--------------------------------------------------------------------------
     |
     | By default Lucid Architecture is setup as microservice. Microservice
     | means that you will have only one service and all features / jobs / data
     | etc. will be generated into /app/ directory.
     |
     | When you set this value to "false" it means you application have multiple
     | services and all classes will be generated into /src/ directrory. After
     | changing that value all "lucid" classes should be moved from /app/ to
     | /src/.
     */
     //'microservice'  => true,

];