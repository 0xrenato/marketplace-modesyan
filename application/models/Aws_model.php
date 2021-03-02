<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Composer autoloader.
require APPPATH . 'third_party/aws-sdk/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Aws_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->key = $this->storage_settings->aws_key;
		$this->secret = $this->storage_settings->aws_secret;
		$this->bucket = $this->storage_settings->aws_bucket;
		$this->region = $this->storage_settings->aws_region;

		$credentials = new Aws\Credentials\Credentials($this->key, $this->secret);
		$this->s3 = new S3Client([
			'version' => 'latest',
			'region' => $this->region,
			'credentials' => $credentials
		]);
	}

	//put product object
	public function put_product_object($file_name, $temp_path)
	{
		$key = "uploads/images/" . $file_name;
		$this->put_object($key, $temp_path);
	}

	//put file manager image object
	public function put_file_manager_image_object($file_name, $temp_path)
	{
		$key = "uploads/images-file-manager/" . $file_name;
		$this->put_object($key, $temp_path);
	}

	//put video object
	public function put_video_object($file_name, $temp_path)
	{
		$key = "uploads/videos/" . $file_name;
		$this->put_object($key, $temp_path);
	}

	//put audio object
	public function put_audio_object($file_name, $temp_path)
	{
		$key = "uploads/audios/" . $file_name;
		$this->put_object($key, $temp_path);
	}

	//put blog object
	public function put_blog_object($key, $temp_path)
	{
		$this->put_object($key, $temp_path);
	}

	//put category object
	public function put_category_object($key, $temp_path)
	{
		$this->put_object($key, $temp_path);
	}

	//delete product object
	public function delete_product_object($file_name)
	{
		$key = "uploads/images/" . $file_name;
		$this->delete_object($key);
	}

	//delete file manager image object
	public function delete_file_manager_image_object($file_name)
	{
		$key = "uploads/images-file-manager/" . $file_name;
		$this->delete_object($key);
	}

	//delete video object
	public function delete_video_object($file_name)
	{
		$key = "uploads/videos/" . $file_name;
		$this->delete_object($key);
	}

	//delete audio object
	public function delete_audio_object($file_name)
	{
		$key = "uploads/audios/" . $file_name;
		$this->delete_object($key);
	}

	//delete blog object
	public function delete_blog_object($key)
	{
		$this->delete_object($key);
	}

	//delete category object
	public function delete_category_object($key)
	{
		$this->delete_object($key);
	}

	//put object
	public function put_object($key, $temp_path)
	{
		if (file_exists($temp_path)) {
			try {
				$file = fopen($temp_path, 'r');
				$this->s3->putObject([
					'Bucket' => $this->bucket,
					'Key' => $key,
					'Body' => $file,
					'ACL' => 'public-read'
				]);
				fclose($file);
				return true;
			} catch (S3Exception $e) {
				echo $e->getMessage() . PHP_EOL;
			}
		}
	}

	//delete object
	public function delete_object($key)
	{
		if (!empty($key)) {
			try {
				$this->s3->deleteObject([
					'Bucket' => $this->bucket,
					'Key' => $key
				]);
			} catch (S3Exception $e) {
				echo $e->getMessage() . PHP_EOL;
			}
		}
	}

}
