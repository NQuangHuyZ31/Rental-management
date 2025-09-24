<?php

namespace App\Controllers;

use Helpers\Hash;
use Helpers\UploadClound;

class TestController
{
  public function index()
  {
    // $otp = Hash::encrypt('1234', 'iuh');
    // $opt_decrype = Hash::encrypt('1234', 'iuh');
    // $otpa = Hash::decrypt($otp, 'iuh');
    // $otpb = Hash::decrypt($opt_decrype, 'iuh');
    // echo $otpa . '\n' . $otpb;
    // UploadClound::upload();
    // $result = UploadClound::delete('whr_images/feedback_images/1746154076_c2656ee6c71caae7b7ac6c2c180679336a9d161b');
    // if ($result) {
    //   echo "Xóa thành công";
    // } else {
    //   echo "Có lỗi";
    // }
    // echo Hash::decrypt('mYp0dHQomSrLLow76U6ej1pR8XhLGICGmLAs71bmigbYnxVaC67tdhUlv2NiI8OXXplm3tdKO0shye0/vwnnLg==');
    // $result = UploadClound::extractPublicId('https://res.cloudinary.com/whr-clound/image/upload/v1745473515/whr_images/feedback_images/1745473513_f8717c2c6f76beb7e07819c35ab6505437528c20.jpg');
    // UploadClound::delete('whr_images/feedback_images/' . $result);
    $data = Hash::decrypt('Sz5eHv/6tWo5Sq06LSxId5JypqpjMHldQvNXYPGFAyljNTQ2cmopMs5CZx+nH3hoL15/UWLyjIYgJaGhs2ilHFIgMRgnwGEGSb+ySEhnfVGqO+71aaXKnZbKYFjKsyCvGaRXjXaVuJNj1kC3VWX6bXhynSoYwmA6nXFs94fqfto=');
    var_dump(json_decode($data, true));
  }
}
