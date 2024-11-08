<?php

namespace App\Notifications;

use LBHurtado\EngageSpark\Notifications\Adhoc as BaseAdhoc;

class RejectedNotification extends BaseAdhoc
{
    public function __construct()
    {
        $message = 'Rejected';

        parent::__construct($message);
    }
}

