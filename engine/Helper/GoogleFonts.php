<?php

namespace Engine\Helper;

class GoogleFonts
{
    protected $fonts = [];

    /**
     * GoogleFonts constructor.
     * example: [
     *   'Roboto' => [
     *     'weight' => ['300'],
     *     'italic' => true
     *     'as' => 'roboto'
     *  ],
     *   'Open Sans' => [
     *     'weight' => ['400'],
     *     'as' => 'open-sans'
     * ]
     * ]
     * 
     * @param array $fonts
     */
    public function __construct(array $fonts)
    {
        $this->fonts = $fonts;
    }

    public function renderHtml()
    {
        $html = '';

        $html .= '<link rel="preconnect" href="https://fonts.googleapis.com">';
        $html .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
        $html .= '<link href="https://fonts.googleapis.com/css2?family=';
        $html .= $this->renderFonts();
        $html .= '" rel="stylesheet">';
        $html .= '<style>';
        $html .= $this->renderCss();
        $html .= '</style>';


        return $html;
    }

    public function renderFonts()
    {
        $fonts = '';

        foreach ($this->fonts as $font => $options) {
            $fonts .= $font . ':';

            if (isset($options['weight'])) {
                $fonts .= 'wght@' . implode(',', $options['weight']);
            }

            if (isset($options['italic']) && $options['italic']) {
                $fonts .= ';ital,1';
            }

            $fonts .= '&';
        }

        return $fonts;
    }

    public function renderCss()
    {
        $css = '';

        foreach ($this->fonts as $font => $options) {
            if (!isset($options['as'])) {
                continue;
            }

            $css .= $options['as'] . ' {';
            $css .= 'font-family: ' . $font . ';';

            if (isset($options['weight'])) {
                $css .= 'font-weight: ' . $options['weight'][0] . ';';
            }

            if (isset($options['italic']) && $options['italic']) {
                $css .= 'font-style: italic;';
            }

            $css .= '}';
        }

        return $css;
    }

    public function __toString()
    {
        return $this->renderHtml();
    }
}
