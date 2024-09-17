<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunReport extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'report:run {report_type} {ro?} {id_group?}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Run Specific Report Type';

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
    $data['report_type'] = $this->argument('report_type');
    $data['ro'] = strtoupper($this->argument('ro'));
    $data['id_group'] = strtoupper($this->argument('id_group'));

    if ($data['report_type'] == null | $data['report_type'] == '') {
      Log::error('Invalid Report Type Passed - App\Console\Commands@RunReport');
      $this->error('Invalid Report Type Passed - App\Console\Commands@RunReport');
    }

    $this->info('Launching reports - ' . $data['report_type']);
    $this->info('RO - ' . $this->argument('ro'));
    $this->info('ID Group - ' . $this->argument('id_group'));

    switch ($data['report_type']) {

      case 'BKG-CONF-NOT-PUBLISHED':
        $report = new \App\Reports\Booking\MissingWebPublications\MissingWebPublications();
        $report->run();
        break;

      case 'BKG-EDI-PENDING-REQUESTS':
        $report = new \App\Reports\Booking\PendingBooking\PendingBookingRequests();
        $report->run();
        break;

      case 'BKG-EDI-NEW-REQUESTS':
        $report = new \App\Reports\Booking\NewBookingRequests\NewBookingRequests();
        $report->run();
        break;

      case 'BKG-TRANSACTIONS-LIST':
        $report = new \App\Reports\Booking\DailyTransactionsList\DailyTransactionsList();
        $report->run();
        break;

      case 'BL-DRAFT-NOT-PUBLISHED':
        $report = new \App\Reports\BL\DraftBLNotPublished\DraftBLNotPublished();
        $report->run();
        break;

      case 'BL-DRAFT-NOT-PUBLISHED-SSC':
        $report = new \App\Reports\BL\DraftBLNotPublished\DraftBLNotPublished($ssc_flag = 'Y');
        $report->run();
        break;

      case 'BL-WAYBILL-NOT-PUBLISHED':
        $report = new \App\Reports\BL\WaybillNotPublished\WaybillNotPublished();
        $report->run();
        break;

      case 'BL-RELEASE-STATUS-REPORT':
        $report = new \App\Reports\BL\BLReleaseStatus\BLReleaseStatusReport();
        $report->run($data['ro']);
        break;

      case 'DOCUMENTS-CUSTOMER-UPLOADS-IMPORT':
        $report = new \App\Reports\Documents\CustomerDocumentsImport();
        $report->run();
        break;

      case 'INV-EDICOM-EU-COPY-INVOICE-NOTIFICATION':
        $report = new \App\Reports\Invoice\EDICOM\CopyInvoiceNotification\ExctractInvoicePDF();
        $report->run();
        break;

      case 'INV-EDICOM-EU-EMAIL-NOTIFICATION':
        $report = new \App\Reports\Invoice\EDICOM\CopyInvoiceNotification\ExctractInvoiceEmailNotification();
        $report->run();
        break;

      case 'INV-EDICOM-EU-COPY-INVOICE-NOTIFICATION-SEND-REPORT':
        $report = new \App\Reports\Invoice\EDICOM\CopyInvoiceNotification\GenerateReport();
        $report->run();
        break;

      case 'INV-EDICOM-EU-MISSING-WEB-PUBLICATION':
        $report = new \App\Reports\Invoice\EDICOM\MissingWebPublication\MissingWebPublication();
        $report->run();
        break;

      case 'INV-EDICOM-EU-MISSING-WEB-NOTIFICATION':
        $report = new \App\Reports\Invoice\EDICOM\MissingWebNotification\MissingWebNotification();
        $report->run();
        break;

      case 'INV-EDICOM-EU-MISSING-WEB-NOTIFICATION-EXCTRACT':
        $report = new \App\Reports\Invoice\EDICOM\MissingWebNotificationV2\ExctractWebInvoicePublished();
        $report->run();
        break;

      case 'INV-EDICOM-EU-MISSING-WEB-NOTIFICATION-SEND-REPORT':
        $report = new \App\Reports\Invoice\EDICOM\MissingWebNotificationV2\GenerateReport();
        $report->run();
        break;

      case 'INV-EDICOM-INVOICE-TO-CUSTOMER-LOAD-EXCEL-DATA':
        $report = new \App\Reports\Invoice\EDICOM\InvoicePDF2Customer\LoadExcelData();
        $report->run();
        break;

      case 'INV-EDICOM-INVOICE-TO-CUSTOMER-SEND-TO-CUSTOMER':
        $report = new \App\Reports\Invoice\EDICOM\InvoicePDF2Customer\SendToCustomer();
        $report->run($data['ro']);
        break;

      case 'PAY-ONLINE-PAYMENT-TRANSACTION-LIST':
        $report = app()->make(\App\Reports\OnlinePayment\OnlinePaymentReportV2::class);
        $report->run();
        break;

      case 'PAY-ONLINE-PAYMENT-EXTRACTION':
        $report = app()->make(\App\Reports\OnlinePayment\OnlinePaymentExtraction::class);
        $report->run();
        break;

      case 'CMS-LOCAL-NEWS-SUBSCRIPTION':
        $report = new \App\Reports\LocalOffice\LocalNewsSubscription();
        $report->run();
        break;

      case 'BL-DRAFT-FAILED-PDF':
        $report = new \App\Reports\BL\BLFailedPDF\BLFailedPDF('BL-DRAFT-FAILED-PDF');
        $report->run();
        break;

      case 'BL-FINAL-FAILED-PDF':
        $report = new \App\Reports\BL\BLFailedPDF\BLFailedPDF('BL-FINAL-FAILED-PDF');
        $report->run();
        break;

      case 'DATA-EXCTRACTION-LARA':
      case 'DATA-EXCTRACTION-ECOM':
      case 'DATA-EXCTRACTION-LARA-MONTHLY':
        $report = new \App\Reports\DataExctraction\RunDataExctraction($data['report_type']);
        $report->run($data['ro'], $data['id_group']);
        break;

      case 'PRICING-ODI-BATCH-STATUS':
        $report = app()->make(\App\Reports\Pricing\QUOBatchStatusReport::class);
        $report->run();
        break;

      case 'PRICING-ODI-SURCHARGE-UPDATE':
        $report = app()->make(\App\Reports\Pricing\Surcharges\SurchargeUpdateReport::class);
        $report->run();
        break;

      case 'PROJECTS-REMINDER-TO-UPDATE':
        $report = new \App\Reports\Projects\ReminderToUpdateProjectStatus();
        $report->run();
        break;

      case 'PROJECTS-WEEKLY-DASHBOARD':
        $report = new \App\Reports\Projects\WeeklyDashboardToProjectLead();
        $report->run();
        break;

      case 'WEB-EBL-NEW-VAS-SUBSCRIPTION':
        $report = new \App\Reports\WebCustomers\eBLOnboarding\NewVASSubcription();
        $report->run();
        break;

      case 'PARTNER-EDI-API-PARTNERCODE-EXTRACTION':
        $report = new \App\Batch\UpdateEdiPartners\UpdateEdiPartner();
        $report->run();
        break;

      case 'PARTNER-PRODUCT-USAGE-EXTRACTION':
        $report = new \App\Batch\UpdatePartnerProductUsage\UpdatePartnerProductUsage();
        $report->run();
        break;

      default:
        Log::error('Invalid Report Type Passed ' . $data['report_type'] . ' - App\Console\Commands@RunReport');
        $this->error('Invalid Report Type Passed - App\Console\Commands@RunReport');
    }

		return 1;
  }
}
