<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\User;
use App\Notifications\NewsletterNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendNewsLetterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter
                            {emails?*}
                            {--s|schedule : Si debe ser ejecutado directamente o no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electronico a todos los usuarios que hayan verificado su cuenta';

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
        $emails = $this->argument('emails');
        $schedule = $this->option('schedule');

        $builder = User::query();

        if ($emails) {
            $builder->whereIn('email', $emails);
        }

        $builder->whereNotNull('email_verified_at');
        $count = $builder->count();

        if ($count) {
            $this->info("\nSe enviaran {$count} correos");

            if ($this->confirm('¿Estás de acuerdo?') || $schedule) {
                $productQuery = Product::query();
                $productQuery->withCount(['qualifiers as average_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(score),0)'));
                }])->orderByDesc('average_rating');

                $products = $productQuery->take(6)->get();
                $this->output->progressStart($count);

                $builder->each(function (User $user) use ($products) {
                    $user->notify(new NewsletterNotification($products->toArray()));
                    $this->output->progressAdvance();
                });

                $this->output->progressFinish();
                $this->info("\nCorreos enviados");
                return;
            }
        }

        $this->info('No se envió nungún correo');
    }
}
