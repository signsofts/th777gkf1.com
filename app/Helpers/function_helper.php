<?php

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

function formatDate($stringDate)
{
    $BlCreated_at = (new Time($stringDate))->format("D, d M Y H:i:s");

    return $BlCreated_at;
}

function formatDateDDMMYYYY($stringDate)
{
    $BlCreated_at = (new Time($stringDate))->format("d/m/Y H:i");

    return $BlCreated_at;
}

function currency($number)
{

    return "฿" . number_format($number, 2);
    // return number_to_currency($number, "th_TH", "th_TH", 2);
}
