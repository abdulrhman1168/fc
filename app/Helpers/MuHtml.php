<?php
namespace App\Helpers;

use Illuminate\Support\HtmlString;
use Form;

class MuHtml {


    /**
     * @param $attributes array of attributes
     *
     * @return html div
     */
    public static function div($attributes, $content = null ) {
      $result =

      '<div '. self::getAttributes($attributes) .'>'.
          call_user_func($content)
       .'</div>';


       return self::toHtmlString($result);
    }

    /**
     * @param $attributes array of attributes
     *
     * @return html label
     */
    public static function label($attributes, $content = null ) {
      $result =

      '<label'. self::getAttributes($attributes) .'>'.
          (is_callable( $content ) ? call_user_func($content) : $content)
       .'</label>';


       return self::toHtmlString($result);
    }

    public static function fullInput($attributeName, $translationKey, $errors) {
      $result = self::div(['class' => 'row'], function() use ($errors, $attributeName, $translationKey ) {
        return self::div(['class' => ['form-group',  $errors->has($attributeName) ? ' has-error' : '' ]], function() use ($attributeName, $translationKey) {
          $result = self::label(['for' => $attributeName , 'class' => ['col-md-4', 'control-label']], __($translationKey));

          return $result;

        });
      });

      return self::toHtmlString($result);
    }

    /**
    * Transform the string to an Html serializable object
    *
    * @param $html
    *
    * @return \Illuminate\Support\HtmlString
    */
   protected static function toHtmlString($html)
   {
       return new HtmlString($html);
   }

   protected static function getAttributes($attributes)
   {
       return join(' ',
        array_map(function($key) use ($attributes)
        {
           if(is_bool($attributes[$key]))
           {
              return $attributes[$key] ? $key : '';
           } else {
             return $key.'="'.
             (is_array($attributes[$key]) ? join(" ", $attributes[$key]) : $attributes[$key])
             .'"';
           }

        }, array_keys($attributes)));
   }


}
