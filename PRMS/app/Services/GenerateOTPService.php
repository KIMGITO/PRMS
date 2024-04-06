<?php

namespace App\Services;

class GenerateOTPService{

      public function getOTP(){
         return mt_rand(123456, 987654);
      }
}