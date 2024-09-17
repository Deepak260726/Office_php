<?php

namespace App\Infrastructure\Constants;

class HttpConstant
{
  // HTTP STATUS
  const HTTP_STATUS_200 = 200;
  const HTTP_STATUS_201 = 201;
  const HTTP_STATUS_204 = 204;
  const HTTP_STATUS_400 = 400;
  const HTTP_STATUS_401 = 401;
  const HTTP_STATUS_404 = 404;
  const HTTP_STATUS_500 = 500;

  const HTTP_REASON_PHRASE_OK = 'OK';
  const HTTP_REASON_PHRASE_PARTIAL_CONTENT = 'Partial Content';
  const HTTP_REASON_PHRASE_KO = 'KO';
  const HTTP_REASON_PHRASE_NO_CONTENT = 'No Content';
  const HTTP_REASON_PHRASE_CREATED = 'Created';


  // METHODS
  const HTTP_METHOD_GET = 'GET';
  const HTTP_METHOD_POST = 'POST';
  const HTTP_METHOD_PUT = 'PUT';
  const HTTP_METHOD_DELETE = 'DELETE';
  const HTTP_METHOD_PATCH = 'PATCH';


  // Exclude exception notification for below errors
  const exclude_exception_notification = ['ORA-12541', 'ORA-01035', 'ORA-12537', 'ORA-01034'];
}
