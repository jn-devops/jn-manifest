<?php

namespace App\Notifications;

use LBHurtado\EngageSpark\Notifications\Adhoc as BaseAdhoc;

class ForApprovalNotification extends BaseAdhoc
{
    public function __construct()
    {
        $message = 'For Approval';

        parent::__construct($message);
    }
}

