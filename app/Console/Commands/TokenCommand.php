<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\ConsoleOutput;

class TokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:generate {id}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id =  $this->argument('id');

        $user = User::find($id);
        Auth::setUser($user);

        $console = new ConsoleOutput();
//        $console->writeLine($user->createToken('admin')->accessToken);
        $console->writeLine($user->createToken('admin')->plainTextToken);
    }
}
