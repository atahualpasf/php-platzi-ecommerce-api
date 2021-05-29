<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\VerificationReminderNotification;
use Illuminate\Console\Command;

class SendEmailVerificationReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:verify-your-email {emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar notificación a los usuarios que no han verificado su cuenta y tienen más de una semana';

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

        $builder = User::query();

        if ($emails) {
            $builder->whereIn('email', $emails);
        }

        $builder
            ->whereNull('email_verified_at')
            ->whereDate('created_at', '<', date('Y-m-d', strtotime('-7  days')));;
        $count = $builder->count();

        if ($count) {
            $this->output->progressStart();

            $builder->each(function (User $user) {
                   $user->notify(new VerificationReminderNotification());
                   $this->output->progressAdvance();
                });

            $this->info("\nSe enviaron {$count} correos");
            $this->output->progressFinish();
        }

        $this->info('No se envió ningún correo');
    }
}
