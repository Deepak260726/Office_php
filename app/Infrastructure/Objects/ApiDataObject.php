<?php

namespace App\Infrastructure\Objects;

use App\Infrastructure\Constants\HttpConstant;

class ApiDataObject
{

  public $path = null;

  public $access_token;

  public $headers = [];

  public $http_method = HttpConstant::HTTP_METHOD_GET;

  public $query = [];

  public $form_params = [];

  public $json_params = [];

  public $body = null;

  public $header_range = null;

  public $content_type = null;

}
