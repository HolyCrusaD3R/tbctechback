<?php

namespace App\Enums;

enum ContractStatusEnum: int
{
    case Sent = 0;
    case InProgress = 1;
    case Rejected = 2;
    case Successful = 3;
    case Disputed = 4;
    case Deleted = 5;
}
