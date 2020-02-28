<?php

$app->route('', 'HomeController:index');
$app->route('home', 'HomeController:index');
$app->route('auth', 'AdminController:postLogin');
$app->route('logout', 'AdminController:logout');

$app->route('clean{/[type]}', 'HomeController:cache');

$app->route('players', 'PlayerController:players');
$app->route('player{/[id]}', 'PlayerController:player');
$app->route('delete/weapon', 'PlayerController:deleteWeapon');

//soon
$app->route('clans{/[page]}', 'ClanController:clanList');
$app->route('ranks', 'HomeController:soon');
$app->route('skins', 'SkinController:list');
$app->route('skin{/[type]/[name]}', 'SkinController:skin');

//cron jobs
$app->route('cron', 'HomeController:cron');
$app->route('redirect', 'HomeController:redirect');


