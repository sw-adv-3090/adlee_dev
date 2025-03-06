<?php

if (!function_exists('busines_types')) {
    function busines_types()
    {
        return [
            'company' => 'Company',
            'government_entity' => 'Government Entity (US only)',
            'individual' => 'Individual',
            'non_profit' => 'Non Profit',
        ];
    }
}

if (!function_exists('countries')) {
    function countries()
    {
        return [
            'US' => 'United States',
            'CA' => 'Canada',
        ];
    }
}


