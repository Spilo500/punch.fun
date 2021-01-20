<?php

class View
{
    // Name of the file associated with the view
    private $file;
    // View title (defined in the view file)
    private $title;
    // View css (defined in the view file)
    private $css;
    // View js (defined in the view file)
    private $js;

    public function __construct($action)
    {
        // Determining the name of the view file from the action
        $this->file = 'views/' . $action . '.php';
    }

    // Generate and display the view
    public function generate($data)
    {
        // Generation of the specific part of the view
        $data = $this->generateFile($this->file, $data, 'file');

        $player = new Player();

        // Generation of the common template using the specific part
        if (!empty($this->css)) {
            $header = $this->generateFile('elements/header.php', array('title' => $this->title, 'css' => $this->css, 'connected' => $player->isConnected()), 'header');
        } else {
            $header = $this->generateFile('elements/header.php', array('title' => $this->title, 'connected' => $player->isConnected()), 'header');
        }

        $core = $this->generateFile('elements/core.php', array('data' => $data), 'core');

        if (!empty($this->js)) {
            $footer = $this->generateFile('elements/footer.php', array('js' => $this->js), 'footer');
        } else {
            $footer = $this->generateFile('elements/footer.php', null, 'footer');
        }
        echo ($header . $core . $footer);
    }

    // Generate a view file and return the produced result
    private function generateFile($file, $data, $type)
    {
        if (file_exists($file)) {
            // Makes the items in the $data table accessible in the view
            if (!empty($data)) {
                extract($data);
            }
            ob_start();
            require $file;

            if ($type == 'file') {
                $this->title = $title;
                if (isset($css) and !empty($css)) {
                    $this->css = $css;
                }
                if (isset($js) and !empty($js)) {
                    $this->js = $js;
                }
            }
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }
}
