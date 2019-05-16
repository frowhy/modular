<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

use Modules\Core\Console\{
    ApiMakeCommand,
    PresenterMakeCommand,
    ResourceMakeCommand,
    RepositoryMakeCommand,
    ServiceMakeCommand
};

return [
    ResourceMakeCommand::class,
    RepositoryMakeCommand::class,
    PresenterMakeCommand::class,
    ApiMakeCommand::class,
    ServiceMakeCommand::class,
];
