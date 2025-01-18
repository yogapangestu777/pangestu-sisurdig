<?php

use Carbon\Carbon;

function formatDate($date): string
{
    return Carbon::parse($date)->format('d M Y');
}

function formatDateTime($dateTime): string
{
    return Carbon::parse($dateTime)->format('d M Y H:i:s');
}

function timeAgo($dateTime): string
{
    return Carbon::parse($dateTime)->diffForHumans();
}
