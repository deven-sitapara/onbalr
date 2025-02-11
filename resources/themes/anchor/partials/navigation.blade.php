<?php
use App\Models\WebsitePages;

$pages = WebsitePages::all();
?>

<ul>
    @foreach($pages as $page)
        <li><a href="{{ url('/website/' . $page->slug) }}">{{ $page->title ?? $page->slug }}</a></li>
    @endforeach
</ul>