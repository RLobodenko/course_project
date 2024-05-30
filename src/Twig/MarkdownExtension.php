<?php
// src/Twig/MarkdownExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Parsedown;

class MarkdownExtension extends AbstractExtension
{
    private $parsedown;

    public function __construct()
    {
        $this->parsedown = new Parsedown();
    }

    public function getFilters()
    {
        return [
            new TwigFilter('markdown', [$this, 'parseMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function parseMarkdown($content)
    {
        return $this->parsedown->text($content);
    }
}
