<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('uploadURL'))
{
    function uploadURL()
    {
        
        $CI =& get_instance();

        return base_url() . $CI->config->item('uploadPath');
    }


}