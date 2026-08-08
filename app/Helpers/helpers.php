<?php

if (!function_exists('clean_html')) {
    /**
     * Sanitize HTML content - allows safe formatting tags but strips dangerous elements.
     * Allows Google Maps iframes from trusted sources.
     *
     * @param string $html
     * @return string
     */
    function clean_html($html)
    {
        if (empty($html)) {
            return '';
        }

        // Temporarily protect safe iframes (Google Maps and trusted sources)
        $safeIframes = [];
        $html = preg_replace_callback('/<iframe\b[^>]*>.*?<\/iframe>/is', function ($matches) use (&$safeIframes) {
            $iframe = $matches[0];
            // Check if this is a safe iframe (Google Maps)
            if (preg_match('/src=["\'][^"\']*(?:google\.com\/maps|maps\.google\.com|maps\.app\.goo\.gl|www\.google\.com\/maps)[^"\']*["\']/i', $iframe)) {
                $safeIframes[] = $iframe;
                return '{{SAFE_IFRAME_' . (count($safeIframes) - 1) . '}}';
            }
            return '';
        }, $html);

        // Also protect iframes without closing tag (self-closing or malformed)
        $html = preg_replace_callback('/<iframe\b[^>]*(?:google\.com\/maps|maps\.google\.com|maps\.app\.goo\.gl|www\.google\.com\/maps)[^>]*>/i', function ($matches) use (&$safeIframes) {
            $safeIframes[] = $matches[0];
            return '{{SAFE_IFRAME_' . (count($safeIframes) - 1) . '}}';
        }, $html);

        // Strip remaining dangerous tags completely
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

        // Restore safe iframes
        foreach ($safeIframes as $index => $iframe) {
            $html = str_replace('{{SAFE_IFRAME_' . $index . '}}', $iframe, $html);
        }

        return $html;
    }
}
