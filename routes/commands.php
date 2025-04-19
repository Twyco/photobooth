<?php

use App\Console\Commands\DeleteUnverifiedUsersCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(DeleteUnverifiedUsersCommand::class)->everyTwoMinutes();