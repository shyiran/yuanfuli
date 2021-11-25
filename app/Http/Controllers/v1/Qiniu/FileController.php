<?php
/**
 * Notes:
 * User: shyir
 * DateTime: 2021/11/6 16:50
 */

namespace App\Http\Controllers\v1\Qiniu;

use App\Http\Controllers\BaseController;

class FileController extends BaseController
{
    private $disk;
    public function __construct ()
    {
        $this->disk = \Storage::disk('qiniu');
    }

    // 创建一个文件（包含路径）create a file
    public function createFile ()
    {

        $fileContents=fopen ('C:\Users\shyir\Desktop\简谱\歌唱祖国.jpg', 'r');
        $f=$this->disk->put('avatars/d/n/filename.jpg', $fileContents);
        return $f;
    }

    // 检查文件是否存在 check if a file exists
    public function fileExists ()
    {
        $exists = $this->disk ->has('eeeee.jpg');
        if($exists){
            return "D";
        }
        return "T";
    }

    // 获取文档的最后修改时间 get timestamp
    public function lastModified ()
    {
        $time = $this->disk->lastModified('avatars/filename.jpg');
        return $time;
    }

    // 获取文档的创建时间 get timestamp
    public function createTimestamp ()
    {
        $time = $this->disk->getTimestamp('avatars/filename.jpg');
        return $time;
    }

    // 文件复制 copy a file
    public function copyFile ()
    {
    }

    // 移动文件move a file
    public function moveFile ()
    {
    }

    // 获取文件 get file contents   ?????
    public function getFileContents ()
    {
        $contents = $this->disk->read('avatars/filename.jpg');
        return $contents;
    }

    // fetch url content  ?????
    public function fetchUrlContent ()
    {
        $fromUrl="https://bkimg.cdn.bcebos.com/pic/18d8bc3eb13533faac70d13da2d3fd1f40345bda?x-bce-process=image/resize,m_lfit,w_536,limit_1/format,f_jpg";
        $file = $this->disk->fetch('folder/save_as.txt', $fromUrl);
        return $file;
    }

    // get file url
    public function getFileUrl ()
    {
        $url = $this->disk->getUrl('avatars/filename.jpg');
        return $url;
    }

    // get file upload token
    public function getfileUpLoadToken ()
    {
        $token = $this->disk->getUploadToken('avatars/filename.jpg');
        return $token;
    }

    // get private url
    public function getPrivateUrl ()
    {
        $url = $this->disk->privateDownloadUrl('avatars/filename.jpg');
        return $url;
    }


    public function getList ()
    {
       // 、、$files = $this->disk->allFiles('avatars');
        //return $files;
        $d = \Storage::disk ('qiniu')->files ('avatars');
        return $d;
    }

    public function getToken ()
    {
        //$d=\Storage::disk('qiniu')->list();
        $result = \Storage::disk ('qiniu')->writeStream ('eeeee.jpg', fopen ('C:\Users\shyir\Desktop\简谱\20211110190103.jpg', 'r'));
        return $result;
    }
}
