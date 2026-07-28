<?php

namespace App\Actions\AccessLinks;

use App\Models\AccessLink;

class DeactivateAccessLinkAction
{
    public function handle(AccessLink $link): void
    {
        $link->deactivate();
    }
}
