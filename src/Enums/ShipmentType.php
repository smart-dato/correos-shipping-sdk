<?php

namespace SmartDato\CorreosShipping\Enums;

enum ShipmentType: string
{
    case Documents = '1';
    case Goods = '2';
    case Gift = '3';
    case Samples = '4';
    case Returns = '5';
    case Other = '6';
    case Dangerous = '7';
}
