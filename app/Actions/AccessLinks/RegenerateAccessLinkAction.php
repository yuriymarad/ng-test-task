<?php

namespace App\Actions\AccessLinks;

use App\Core\AccessLinks\AccessLinkIssuer;
use App\Models\AccessLink;
use Illuminate\Support\Facades\DB;

class RegenerateAccessLinkAction
{
    public function __construct(private AccessLinkIssuer $accessLinks) {}

    public function handle(AccessLink $link): AccessLink
    {
        return DB::transaction(fn (): AccessLink => $this->accessLinks->issueFor($link->participant));
    }
}
