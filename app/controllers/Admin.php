<?php

class Admin extends Controller
{
    public function dashboard()
    {
        $this->view('layout/header');
        $this->view('admin/dashboard');
    }

    public function order()
    {
        $this->view('layout/header');
        $this->view('admin/order');
    }
}
