<?php
class Alerts_contoller extends Controller
{
    public $appErr;
    function __construct($appErr)
    {
        $this->appErr = $appErr;
        $this->model = new Alerts_model();
        $this->view = new View();
    }
    function action_index()
    {
        $data = $this->model->get_data($this->appErr);
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}