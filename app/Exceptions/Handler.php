<?php

namespace App\Exceptions;

//use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Illuminate\Support\Facades\View;
use App\Helpers\MailMan;
use App\Helpers\SecretManagerHelper;
use App\Infrastructure\Constants\HttpConstant;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report(Throwable  $exception)
	{
		// DB Exceptions are thrown back to refresh the secrets 
		if(strpos(" " . $exception->getMessage(), "Access denied for user") > 0) {
			Log::error("Database Exception - Access denied for user");
			SecretManagerHelper::clearSecretsCache();
			SecretManagerHelper::setDatabaseConnectionDetails(false);
			parent::report($exception);
		}

		if ($this->shouldReport($exception) && strtolower(config('app.env')) === 'production') {

			try {
				
				//exclude exception notification if exception with in the excluded list 
				$exclude_array = HttpConstant::exclude_exception_notification;

				foreach($exclude_array as $error_code) {
					if(strpos($exception->getMessage(), $error_code) !== false) {
						parent::report($exception);
						return;
					}	
				}

				$mail = new \stdClass();
				$mail->queue = 'EXCEPTION';
				$mail->module = 'EXCEPTION';
				$mail->priority = 1;
				$mail->email_to = config('mail.exception_alert_email');
				$mail->attachments  = null;
				$mail->subject = 'NIYA [' . config('app.env') . '] - Exception Report - ' . date('Y-m-d_H-i-s');

				$e = FlattenException::createFromThrowable($exception);
				$handler = new HtmlErrorRenderer(true); // boolean, true raises debug flag..
				$css = $handler->getStylesheet();
				$content = $handler->getBody($e);

				$mail->body_html = substr(view::make(
					'emails.exceptions.exception_report',
					compact('css', 'content')
				)->render(), 0, 65000);

				MailMan::queue($mail->queue, $mail);
			} catch (Throwable $ex) {
				Log::error($ex);
			}
		}

		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Throwable  $exception)
	{
		// Exception for spatie - Role Failure
		if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {

			if ($request->ajax()) {
				return response()->json(['message' => 'We are afraid! You do not have the required authorization.'], 403)
				->header('X-Validation-Error', 'We are afraid! You do not have the required authorization');
			}

			return Redirect('/')->withErrors(['We are afraid! You do not have permission to access the requested module.']);
		}

		return parent::render($request, $exception);
	}
}
