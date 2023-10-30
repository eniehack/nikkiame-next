<?php

namespace App\Enums;

enum PostScope : int{
    case Public = 0;
    case Private = 1;
    case Draft = 2;
}
