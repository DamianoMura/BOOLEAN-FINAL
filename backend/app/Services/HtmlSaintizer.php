<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
  private HTMLPurifier $purifier;

  public function __construct()
  {
    $config = HTMLPurifier_Config::createDefault();

    // Configurazione di sicurezza base
    $config->set(
      'HTML.Allowed',
      'p,br,h1,h2,h3,h4,h5,h6,strong,em,u,ul,ol,li,
a[href|target|title],img[src|alt|width|height|class],
blockquote,code,pre,table,thead,tbody,tr,td,th,
span[class],div[class],mark,del,ins'
    );


    // Altri settaggi di sicurezza
    $config->set('AutoFormat.RemoveEmpty', true);
    $config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
    $config->set('HTML.TargetBlank', true); // Apre link in nuova tab

    $this->purifier = new HTMLPurifier($config);
  }

  public function sanitize(string $dirtyHtml): string
  {
    return $this->purifier->purify($dirtyHtml);
  }
}
