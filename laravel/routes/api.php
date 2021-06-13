<?php

foreach (File::glob(__DIR__ . '/../app/Domain/*/Http/*Routes.php') as $routeProvider) {
    require $routeProvider;
}
