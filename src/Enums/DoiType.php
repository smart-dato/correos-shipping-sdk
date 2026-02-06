<?php

namespace SmartDato\CorreosShipping\Enums;

enum DoiType: string
{
    case European = '0';
    case DNI = '1';
    case NIE = '3';
    case Other = '4';
    case CIF = '10';
}
