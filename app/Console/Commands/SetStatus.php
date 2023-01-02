<?php

namespace App\Console\Commands;

use App\Console\SetStatusDetail\SetStatusDetail;
use Illuminate\Console\Command;

class SetStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Для моделей, в яких статус 'не робочий | робочий за розкладом'\n міняється статус в залежності від графіку \n(врахосуючи підпорядкування)";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SetStatusDetail::makeProvider();
        $this->info('makeProvider was successful!');
        SetStatusDetail::makeFood();
        $this->info('makeFood was successful!');
        SetStatusDetail::makeIngredient();
        $this->info('makeIngredient was successful!');
        return 0;
    }
}
