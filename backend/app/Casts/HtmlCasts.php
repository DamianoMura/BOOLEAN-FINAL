<?php
// app/Casts/HtmlCast.php
namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class HtmlCast implements CastsAttributes
{
  // Lista di tag HTML sicuri permessi
  private array $allowedTags = [
    'p',
    'br',
    'h1',
    'h2',
    'h3',
    'h4',
    'h5',
    'h6',
    'strong',
    'em',
    'u',
    'b',
    'i',
    'ul',
    'ol',
    'li',
    'a[href|target|title]',
    'img[src|alt|width|height|class]',
    'blockquote',
    'code',
    'pre',
    'table',
    'thead',
    'tbody',
    'tr',
    'td',
    'th',
    'span[class]',
    'div[class]'
  ];

  public function get($model, string $key, $value, array $attributes): mixed
  {
    // Decodifica quando leggi dal DB
    return $value ? htmlspecialchars_decode($value, ENT_QUOTES) : '';
  }

  public function set($model, string $key, $value, array $attributes): mixed
  {
    if (empty($value)) {
      return null;
    }

    // Sanitizzazione di base
    $cleanValue = $this->sanitizeHtml($value);

    // Codifica per il database
    return htmlspecialchars($cleanValue, ENT_QUOTES, 'UTF-8');
  }

  private function sanitizeHtml(string $html): string
  {
    // 1. Rimuovi tag PHP
    $html = preg_replace('/<\?.*?\?>/s', '', $html);

    // 2. Usa strip_tags con tag permessi
    $html = strip_tags($html, '<' . implode('><', array_map(function ($tag) {
      return preg_replace('/\[.*\]/', '', $tag);
    }, $this->allowedTags)) . '>');

    // 3. Rimuovi attributi pericolosi
    $html = preg_replace_callback('/<(\w+)([^>]*)>/', function ($matches) {
      $tag = $matches[1];
      $attrs = $matches[2];

      // Permetti solo attributi sicuri
      $safeAttrs = '';
      if (preg_match_all('/(\w+)=["\']([^"\']*)["\']/', $attrs, $attrMatches)) {
        foreach ($attrMatches[1] as $index => $attrName) {
          if ($this->isSafeAttribute($tag, $attrName)) {
            $safeAttrs .= sprintf(
              ' %s="%s"',
              $attrName,
              htmlspecialchars($attrMatches[2][$index])
            );
          }
        }
      }

      return "<{$tag}{$safeAttrs}>";
    }, $html);

    // 4. Rimuovi event handlers (onclick, onload, ecc.)
    $html = preg_replace('/\s+on\w+=\s*["\'][^"\']*["\']/i', '', $html);

    // 5. Rimuovi javascript: negli href
    $html = preg_replace('/href=["\']javascript:[^"\']*["\']/i', 'href="#"', $html);

    return $html;
  }

  private function isSafeAttribute(string $tag, string $attribute): bool
  {
    $safeAttributes = [
      'a' => ['href', 'target', 'title', 'rel'],
      'img' => ['src', 'alt', 'width', 'height', 'class', 'title'],
      'span' => ['class'],
      'div' => ['class'],
      '*' => ['class', 'id', 'style', 'data-*'] // Attributi globali sicuri
    ];

    // Controlla attributi specifici del tag
    if (isset($safeAttributes[$tag])) {
      foreach ($safeAttributes[$tag] as $safeAttr) {
        if (
          $safeAttr === $attribute ||
          (str_ends_with($safeAttr, '-*') && str_starts_with($attribute, substr($safeAttr, 0, -2)))
        ) {
          return true;
        }
      }
    }

    // Controlla attributi globali
    foreach ($safeAttributes['*'] as $safeAttr) {
      if (
        $safeAttr === $attribute ||
        (str_ends_with($safeAttr, '-*') && str_starts_with($attribute, substr($safeAttr, 0, -2)))
      ) {
        return true;
      }
    }

    return false;
  }
}
