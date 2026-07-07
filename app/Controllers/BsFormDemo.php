<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BsFormDemo extends BaseController
{
    public function index()
    {
        helper('bsform');
        return view('admin/dashboard/bsformdemo');
    }

    public function submit()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username'     => 'required|min_length[3]',
            'password'     => 'required|min_length[6]',
            'email'        => 'required|valid_email',
            'gender'       => 'required',
            'terms'        => 'required',
            'subscription' => 'required',
            'languages'    => 'required'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Success case
        return redirect()->to('/demoform')->with('success', 'Form submitted successfully!');
    }
}