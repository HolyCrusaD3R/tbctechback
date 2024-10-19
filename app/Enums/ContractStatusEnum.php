<?php

namespace App\Enums;

enum ContractStatusEnum: int
{
    case Sent = 0;
    case InProgress = 1;
    case Successful = 2;
    case Disputed = 3;
    case Deleted = 4;
}
