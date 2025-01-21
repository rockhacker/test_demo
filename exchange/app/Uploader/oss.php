<?php


namespace App\Uploader;


use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use OSS\Core\OssException;
use OSS\OssClient;

class oss extends Uploader
{

    /**
     * @param UploadedFile $file
     *
     * @return array|void
     * @throws Exception
     */
    public function upload($file): array
    {
        parent::upload($file);

        $filename = $this->filename;
        $ext = $this->ext;

        $path = "exchange/admin/" . date('Ymd') . '/';
        $filename = md5($filename . uniqid()) . ".{$ext}";
        $this->path = $path . $filename;

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录RAM控制台创建RAM账号。
        $accessKeyId = "LTAI5tMKKcTwAapomUNpVbiB";
        $accessKeySecret = "yj1FJl3buYdJ5sguP476m8d7klfGwE";
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = "http://oss-cn-hongkong.aliyuncs.com";
        $ossHost = "https://exchange-hk.oss-cn-hongkong.aliyuncs.com";
        // 设置存储空间名称。
        $bucket = "exchange-hk";
        // 设置文件路径拼上文件名。
        $filePath = $file->getPathname();
        $object = $this->path;

        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

            $ossClient->uploadFile($bucket, $object, $filePath);
        } catch (OssException $e) {

            exit($e->getMessage());
        }
        $this->url = $ossHost.'/'.$this->path;
        return $this->formatMsg();
    }
}
