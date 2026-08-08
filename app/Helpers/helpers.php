<?php

if (!function_exists('clean_html')) {
    /**
     * Sanitize HTML content - allows safe formatting tags but strips dangerous elements.
     *
     * @param string $html
     * @return string
     */
    function clean_html($html)
    {
        if (empty($html)) {
            return '';
        }

        // Strip dangerous tags completely
        $dangerousTags = ['script', 'iframe', 'object', 'embed', 'form', 'input', 'textarea', 'button', 'select', 'link', 'meta', 'base'];
        foreach ($dangerousTags as $tag) {
            $html = preg_replace('/<' . $tag . '\b[^>]*>(.*?)<\/' . $tag . '>/is', '', $html);
            $html = preg_replace('/<' . $tag . '\b[^>]*\/?>/is', '', $html);
        }

        // Strip dangerous attributes
        $dangerousAttributes = ['onclick', 'ondblclick', 'onmousedown', 'onmouseup', 'onmouseover', 'onmousemove', 'onmouseout', 'onkeypress', 'onkeydown', 'onkeyup', 'onfocus', 'onblur', 'onsubmit', 'onreset', 'onselect', 'onchange', 'onload', 'onerror', 'onabort', 'onresize', 'onscroll', 'onunload', 'onbeforeunload', 'javascript:', 'vbscript:', 'data:'];
        foreach ($dangerousAttributes as $attr) {
            $html = preg_replace('/\s*' . preg_quote($attr, '/') . '\s*=\s*["\'][^"\']*["\']/is', '', $html);
            $html = preg_replace('/\s*' . preg_quote($attr, '/') . '\s*=\s*[^\s>]+/is', '', $html);
        }

        // Strip data: URIs (except images)
        $html = preg_replace('/data:(?!image\/)/i', 'data-blocked:', $html);

        return $html;
    }
}
