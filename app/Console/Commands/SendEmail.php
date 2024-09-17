<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\Helpers\MailMan;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {priority?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all pendings emails to send';

    private $batch_run_id;
    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->batch_run_id = uniqid();
    }
    

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Launching batch...');

        $mail = new MailMan();

        try {
            do{
                $return = $mail->processQueue(config('mail.batch_email_size'), ($this->argument('priority') ?? null));
              }while($return >= config('mail.batch_email_size'));     
        }
        catch(\Exception $e) {
            report($e);
        }
        
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch end');
        
        return 1;
    }
}
