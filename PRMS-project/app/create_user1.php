<?php
// php artisan tinker
use App\Models\User;
$user = new User();
$user->first_name = 'Dennis';
$user->last_name = 'Kim'; 
$user->national_id = '123456789';
$user->work_id = 'W123';
$user->email = 'dennis@hhg.com'; 
$user->phone = '1234567890';
$user->role = 'admin'; 
$user->password = bcrypt('12345678'); 

$user->save();
