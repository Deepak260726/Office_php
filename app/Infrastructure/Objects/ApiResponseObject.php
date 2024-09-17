<?php

namespace App\Infrastructure\Objects;

class ApiResponseObject
{

  public $http_status;

  public $http_reason_phrase;

  public $data;

  public $content_range;

  public $content_range_start;

  public $content_range_end;

  public $content_total_records;

  public $status;

  public $error_reason;

  public $error_code;

  public $error_description;

}
