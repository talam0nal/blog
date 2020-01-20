<?php
use Illuminate\Support\Str;

function module()
{
	$routeName = Route::currentRouteName();
	if (Str::startsWith($routeName, 'categories')) {
		return 'categories';
	} else if (Str::startsWith($routeName, 'post')) {
		return 'posts';
	} else if (Str::startsWith($routeName, 'comment')) {
		return 'comments';
	}
}