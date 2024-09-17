<?php

namespace App\Helpers;

use App\Constants\SupportConstant;


use Carbon\Carbon;

class SupportHelper
{

    /**
   * Get Priority HTML
   *
   * @param  string priority, string priority_name
   * @return string html
   */
  public static function getPriorityHtml($priority, $priority_name)
  {
    $html = '';

    if ($priority == '30') {
      $html = '<span class="text-danger"><i class="fas fa-fire"></i> ' . $priority_name . '</span>';
    } else if ($priority == '31') {
      $html = '<span class="text-danger"><i class="fas fa-chevron-circle-up"></i> ' . $priority_name . '</span>';
    } else if ($priority == '32') {
      $html = '<span class="text-warning"><i class="fas fa-chevron-circle-right"></i> ' . $priority_name . '</span>';
    } else {
      $html = '<span class="text-primary"><i class="fas fa-chevron-circle-down"></i> ' . $priority_name . '</span>';
    }

    return $html;
  }


  /**
   * Get Status HTML
   *
   * @param  string status, string status_name
   * @return string html
   */
  public static function getStatusHtml($status, $status_name)
  {
    $html = '';

    if ($status == SupportConstant::CASE_OPEN) {
      $html = '<span class="text-primary"><i class="fas fa-envelope-open"></i> ' . $status_name . '</span>';
    }  else if ($status == SupportConstant::CASE_CLOSED) {
      $html = '<span class="text-success"><i class="fas fa-trophy"></i> ' . $status_name . '</span>';
    } else {
      $html = '<span class="text-danger"><i class="fas fa-exclamation"></i> ' . $status_name . '</span>';
    }

    return $html;
  }


  /**
   * Get Impact
   *
   * @param  string Impact
   * @return string html
   */
  public static function getImpactHtml($region)
  {
    $html = '';

    if (strlen($region) == 2) {
      $html = '<span class="flag-icon flag-icon-' . strtolower($region) . ' border" data-toggle="tooltip" data-placement="top" title="' . ProjectsHelper::translateRegion($region) . '"></span> ' . $region;
    } else if (strtoupper($region) == 'WWW') {
      $html = '<span data-toggle="tooltip" data-placement="top" title="' . ProjectsHelper::translateRegion($region) . '"><i class="fas fa-globe"></i></span>';
    } else {
      $content = '';
      foreach (explode(",", $region) as $item) {
        $content .= ProjectsHelper::translateRegion($item) . '<br/>';
      }
      $html = '<a data-container="body" data-toggle="popover" data-placement="top" data-html="true" data-trigger="focus" data-content="' . $content . '" href="#"><i class="fas fa-ellipsis-h"></i></a>';
    }

    return $html;
  }


  /**
   * Get Comment type HTML
   *
   * @param  string comment_type
   * @return string html
   */
  public static function getCommentTypeHtml($comment_type)
  {
    $html = '';

    if ($comment_type == SupportConstant::FIRST_ANALYSIS) {
        $html = '<span class="badge badge-pill badge-primary ml-3">'.$comment_type.'</span>';
    }  else if ($comment_type == SupportConstant::CLOSURE_COMMENT) {
        $html = '<span class="badge badge-pill badge-success ml-3">'.$comment_type.'</span>';
    } else {
        $html = '<span class="badge badge-pill badge-warning ml-3">'.$comment_type.'</span>';
    }

    return $html;
  }


}