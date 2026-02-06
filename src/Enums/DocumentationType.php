<?php

namespace SmartDato\CorreosShipping\Enums;

enum DocumentationType: int
{
    case All = 0;
    case Label = 1;
    case CN22_CN23 = 2;
    case DCAF = 5;
    case DDP = 6;
}
