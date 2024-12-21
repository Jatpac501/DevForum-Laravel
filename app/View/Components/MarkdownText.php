<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MarkdownText extends Component
{
    public string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function render()
    {
        $html = nl2br(htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8'));

        // Замена заголовков # text
        $html = preg_replace('/^# (.*)$/m', '<h1>$1</h1>', $html);
        $html = preg_replace('/^## (.*)$/m', '<h2>$1</h2>', $html);
        $html = preg_replace('/^### (.*)$/m', '<h3>$1</h3>', $html);

        // Замена жирного и курсива **text** и *text* и __text__ и _text_
        $html = preg_replace('/\*\*(.+?)\*\*/', '<b>$1</b>', $html);
        $html = preg_replace('/\*(.+?)\*/', '<i>$1</i>', $html);
        $html = preg_replace('/__(.+?)__/', '<b>$1</b>', $html);
        $html = preg_replace('/_(.+?)_/', '<i>$1</i>', $html);

        // Замена ссылок \[text\](url)
        $html = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a class="underline" href="$2">$1</a>', $html);

        // Замена маркированных списков
        $html = preg_replace('/^(\s*)\* (.*)$/m', '$1<li>$2</li>', $html);
       
        $html = preg_replace_callback('/(\s*)(<li>.*?<\/li>(\s*))+/m', function ($matches) {
          
            $level = strlen($matches[1]);
            $result = '<ul style="margin-left: ' . ($level * 20) . 'px">';
             $result .= trim($matches[0]);
            $result .= '</ul>';
                
            return $result;
        }, $html);


        // Замена нумерованных списков
        $html = preg_replace('/^(\s*)\d+\. (.*)$/m', '$1<li>$2</li>', $html);

         $html = preg_replace_callback('/(\s*)(<li>.*?<\/li>(\s*))+/m', function ($matches) {
             $level = strlen($matches[1]);
             $result = '<ol style="margin-left: ' . ($level * 20) . 'px">';
             $result .= trim($matches[0]);
             $result .= '</ol>';
                 
             return $result;
         }, $html);


        return view('components.markdown-text', ['convertedContent' => $html]);
    }
}