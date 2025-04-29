<?php

namespace App\Enums;

enum Rolenum : string
{
    case ADMIN = 'Admin';
    case CHRISTIAN = 'User';
    case CASHIER = 'Caisse';
}
