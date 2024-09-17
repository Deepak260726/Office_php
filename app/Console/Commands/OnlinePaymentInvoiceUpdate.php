<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use DB;

use App\Models\OnlinePayments\OnlinePaymentTransactionInvoice;

class OnlinePaymentInvoiceUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'OnlinePaymentInvoice:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update invoice domain';

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

        //Retrieve invoice numbers empty domain
        $invoice_list = OnlinePaymentTransactionInvoice::select('inv_number')->where('inv_domain','')->distinct()->limit(10000)->get();
        
        if($invoice_list->count() <= 0) {
            $this->info('No invoices found without Domain');
        } else {

            $i = 0;
            foreach ($invoice_list->chunk(500) as $invoice) {
                $invoice_array = $invoice->pluck('inv_number')->toArray();
                
                $lara_invoice_data = $this->get_lara_invoice_data($invoice_array);
                
                
                // Update Invoice Data
                if ($lara_invoice_data->count() > 0) {
                    
                    foreach ($lara_invoice_data as $inv) {
                        OnlinePaymentTransactionInvoice::where('inv_number', $inv->inv_number)
                            ->where('inv_domain','')
                            ->update([
                            'inv_domain' => $inv->application_id
                            ]);

                        $i++;
                    }

                } else {
                    $this->info('Unable to retreive invoice information from LARA');
                }
    
            }

            $this->info($i.' invoices updated with domain!');

        }
        
        
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch end');
        
        return 1;
    }


    /**
   * Get LARA Invoice Data
   *
   * @return collection
   */
    private function get_lara_invoice_data($inv_numbers)
    {
        $select = [
        'inv.inv_number',
        'inv.application_id'
        ];

        // Select
        $invoices = DB::connection('aral')->table('sales_inv_headers as inv')->select($select);
        // Where
        $invoices->whereIn('inv.inv_number', $inv_numbers);

        return $invoices->get();
    }
}

?>
