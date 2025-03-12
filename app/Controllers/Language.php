<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Language extends BaseController
{
    public function index()
    {
        helper("cookie");

        $session = session();
        $locale = $this->request->getLocale();
        $session->set('lang', $locale);
        $language = \Config\Services::language();
        $language->setLocale($locale);
        $url = base_url();

        $name   = 'lang';
        $value  = $locale;
        $expire = time() + 86400;
        $path  = '/';
        setcookie($name, $value, $expire, $path);


        return redirect()->back();
    }

    public function setLang($lang = 'en')
    {
        $session = session();
        $locale = $this->request->getLocale();
        $session->set('lang', $locale);
        $language = \Config\Services::language();
        $language->setLocale($locale);
    }
}
