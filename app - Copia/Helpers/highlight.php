<?php

if (!function_exists('highlight')) {
    /**
     * Destaca um termo de busca dentro de um texto, de forma segura e case-insensitive.
     *
     * @param string|null $text O texto original (ex: "Notebook Usado")
     * @param string|null $query O termo de busca (ex: "note")
     * @return string O HTML com o destaque (ex: "<mark>Note</mark>book Usado")
     */
    function highlight($text, $query)
    {
        // Se o texto ou a busca estiverem vazios, apenas retorne o texto escapado
        if (empty($query) || trim($query) === '' || empty($text)) {
            return e($text);
        }

        // Escapa o termo de busca para ser usado em uma RegEx de forma segura
        $pattern = '/(' . preg_quote(e($query), '/') . ')/i';

        // Define o "envelope" que usaremos. <mark> é a tag HTML semântica para isso.
        $replacement = "<mark>$1</mark>";

        // Escapa o texto original (para prevenir XSS) e DEPOIS aplica o highlight
        $subject = e($text);

        // Retorna o texto com o highlight aplicado
        return preg_replace($pattern, $replacement, $subject);
    }
}
