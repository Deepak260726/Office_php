<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helpers\MailMan;

class PurgeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge old emails sent history';


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
     * @return mixed
     */
    public function handle()
    {
        $mail = new MailMan();

        do {
            $return = $mail->purgeOldEmails(config('mail.batch_purge_email_size'));
        } while ($return >= config('mail.batch_purge_email_size'));

        do {
            $return = $mail->purgeEmailBody(config('mail.batch_purge_email_size'));
        } while ($return >= config('mail.batch_purge_email_size'));

        return 1;
    }
}
