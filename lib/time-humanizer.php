<?php

function pluralise($count, $single, $plural = null) {
    if ($count == 1 || $count == -1)  {
        return $single;
    }
    if ($plural == null) {
        $plural = $single . 's';
    }
    return $plural;
}

function humanize_datetime($then) {
    $now = new DateTime('now');
    $timespan = $now->diff($then);
    $message = array();

    if ($timespan->y)
        $message[] = $timespan->y.' '.pluralise($timespan->y, 'year');
    if ($timespan->m)
        $message[] = $timespan->m.' '.pluralise($timespan->m, 'month');
    if ($timespan->d)
        $message[] = $timespan->d.' '.pluralise($timespan->d, 'day');
    if ($timespan->h)
        $message[] = $timespan->h.' '.pluralise($timespan->h, 'hour');
    if ($timespan->i)
        $message[] = $timespan->i.' '.pluralise($timespan->i, 'minute');
    if ($timespan->s)
        $message[] = $timespan->s.' '.pluralise($timespan->s, 'second');

    if (count($message) == 0) {
        return 'just now';
    }
    $output = array_shift($message);

    if ($message) {
        $output .= ' and '.array_shift($message);
    }

    if ($timespan->invert == 1) {
        $output .= ' ago';
    } else {
        $output = 'in ' . $output;
    }

    return $output;
}