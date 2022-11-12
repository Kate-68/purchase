<?php

class View {
    private Model $model;
    private Controller $controller;
    private $data;

    function __construct(Model $m, Controller $c) {
        $this->model = $m;
        $this->controller = $c;
    }

    public function show() {
        include $this->controller->viewName . ".php";
    }
}