<?php

/*
|--------------------------------------------------------------------------
| Schedule Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Console\Scheduling\Schedule;

return function (Schedule $schedule) {
    $schedule->command('telescope:prune')->daily();
};
