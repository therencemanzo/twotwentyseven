<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FizzBuzzCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fizzbuzz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print numbers from 1 to 100 with FizzBuzz rules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 1; $i <= 100; $i++) {
            if ($i % 3 === 0 && $i % 5 === 0) {
                $this->line('FizzBuzz');
            } elseif ($i % 3 === 0) {
                $this->line('Fizz');
            } elseif ($i % 5 === 0) {
                $this->line('Buzz');
            } else {
                $this->line($i);
            }
        }

        return 0; // Command executed successfully
    }
}
