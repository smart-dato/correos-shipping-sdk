<?php

namespace SmartDato\CorreosShipping\Enums;

enum LabelOrderType: int
{
    case InternationalPoBox = 1;
    case Company = 2;
    case LastName = 3;
    case PackageId = 4;
    case ClientReference = 5;
}
