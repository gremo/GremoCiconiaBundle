<?php

namespace Gremo\CiconiaBundle\Twig;

use Ciconia\Ciconia;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class CiconiaExtension extends \Twig_Extension
{
    /**
     * @var Ciconia
     */
    private $ciconia;

    /**
     * @param Ciconia $ciconia
     */
    public function __construct(Ciconia $ciconia)
    {
        $this->ciconia = $ciconia;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdown', [$this, 'markdown'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param string $text
     * @param array $options
     * @return string
     */
    public function markdown($text, array $options = array())
    {
        return $this->ciconia->render($text, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ciconia';
    }
}