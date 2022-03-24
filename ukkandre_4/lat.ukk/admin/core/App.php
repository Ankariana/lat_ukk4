<?php 

class App{
    protected $ctrl = 'Home';
    protected $mtd  = 'index';
    protected $prm  = [];

    public function __construct()
    {
        $url = $this->parsURL();
        
        if (file_exists('../admin/controllers/' . $url[0] .'.php')) {
            $this->ctrl = $url[0];
            unset ($url[0]);
        }
        require_once '../admin/controllers/'.$this->ctrl.'.php';
        $this->ctrl = new $this->ctrl;

        if (isset($url[1])) {
            if (method_exists($this->ctrl, $url[1])) {
                $this->mtd = $url[1];
                unset($url[1]);
            }
        }

        if (!empty($url)) {
            $this->prm = array_values($url);
        }

        call_user_func_array([$this->ctrl,$this->mtd],$this->prm);

    }

    public function  parsURL()
    {
        if (isset($_GET['url'])) {
            
            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }

    }
}