<?php

namespace Helpers;

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

require 'vendor/autoload.php';
class UploadClound
{
  public static function upload($file, $folder, $path)
  {
    try {
      // Kiểm tra file có tồn tại không
      if (!file_exists($file)) {
        Log::server("UploadClound: File not found: " . $file);
        return false;
      }

      // Kiểm tra cấu hình Cloudinary
      if (!defined('CLOUD_NAME') || !defined('CLOUD_API_KEY') || !defined('CLOUD_API_SECRET')) {
        Log::server("UploadClound: Cloudinary configuration missing");
        return false;
      }

      Configuration::instance([
        'cloud' => [
          'cloud_name' => CLOUD_NAME,
          'api_key' => CLOUD_API_KEY,
          'api_secret' => CLOUD_API_SECRET
        ],
        'url' => [
          'secure' => true
        ]
      ]);

      self::delete($path);

      $data = (new UploadApi())->upload($file, [
        'public_id' => $path,
        'folder' => 'rental_management/' . $folder
      ]);

      if (isset($data['secure_url'])) {
        Log::server("UploadClound: Successfully uploaded to: " . $data['secure_url']);
        return $data['secure_url'];
      } else {
        Log::server("UploadClound: No secure_url in response: " . json_encode($data));
        return false;
      }

    } catch (\Exception $e) {
      Log::server("UploadClound: Exception during upload: " . $e->getMessage());
      return false;
    }
  }

  public static function getPublicIdFromUrl($url)
  {
    // Tách đường dẫn từ URL
    $parts = explode('/', parse_url($url, PHP_URL_PATH));

    // Tìm vị trí 'upload' trong mảng
    $uploadIndex = array_search('upload', $parts);

    if ($uploadIndex === false || !isset($parts[$uploadIndex + 1])) {
      return null;
    }

    // Lấy phần còn lại sau 'upload'
    $publicIdParts = array_slice($parts, $uploadIndex + 1);

    // Nếu có phiên bản dạng v12345 → loại bỏ
    if (preg_match('/^v\d+$/', $publicIdParts[0])) {
      array_shift($publicIdParts);
    }

    // Ghép lại path đầy đủ
    $fullPath = implode('/', $publicIdParts);

    // Tách tên file và phần mở rộng
    $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
    $filename = pathinfo($fullPath, PATHINFO_FILENAME);

    // Nếu có folder → lấy lại phần folder
    $folder = dirname($fullPath);
    if ($folder === '.' || $folder === '') {
      return $filename;
    } else {
      return $folder . '/' . $filename;
    }
  }


  public static function extractPublicId($url)
  {
    $path = parse_url($url, PHP_URL_PATH); // Lấy phần đường dẫn
    $parts = explode('/', $path);
    $filename = end($parts); // Lấy tên file: zq7l7bhy1o6xruk5qfuu.webp
    return pathinfo($filename, PATHINFO_FILENAME); // Trả về tên không có đuôi
  }

  public static function delete($publicId)
  {
    // Cấu hình Cloudinary
    $config = Configuration::instance([
      'cloud' => [
        'cloud_name' => CLOUD_NAME,
        'api_key' => CLOUD_API_KEY,
        'api_secret' => CLOUD_API_SECRET
      ],
      'url' => [
        'secure' => true
      ]
    ]);

    // Truyền cấu hình khi tạo Cloudinary
    $cloudinary = new Cloudinary($config);

    // Gọi hàm destroy
    $result = $cloudinary->uploadApi()->destroy($publicId);

    return $result;
  }
}
