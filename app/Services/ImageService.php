<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * Handle all content logic
 */
class ImageService
{
    /**
     * @param UploadedFile $file
     * @param string|null  $dir
     * @param string|null  $id
     *
     * @return string
     */
    public function uploadFile(UploadedFile $file, string $dir = null, string $id = null)
    {
        if ($file->isValid()) {

            // 检查文件大小
            $size = $file->getSize();
            if ($size > 4194304) {
                return sprintf('error|文件不能大于%sM！', ceil(config('custom.upload.image.size') / (1024 * 1024)));
            }

            // 检查 mime type
            $mimeType = $file->getMimeType();
            $allowMimeType = config('custom.upload.image.mime_type');
            if (Arr::has($allowMimeType, $mimeType)) {
                return 'error|文件类型不支持！';
            }

            // 临时文件的绝对路径
            $realPath = $file->getRealPath();

            // 获取后缀名
            $ext = $file->getClientOriginalExtension();
            // Log::info($dir);
            // Log::info($id);

            // 生成文件路径
            $filename = '/uploads/' . uniqid() . '.' . $ext;

            // 上传文件
            $success = $this->storagePut($filename, file_get_contents($realPath));

            if ($success) {
                return 'success|' . $filename;
            }
        }

        return 'error|' . $file->getErrorMessage();
    }

    /**
     * Put content into storage, if given $path conflict, Storage facade will replace with new one
     *
     * @param $path
     * @param $content
     *
     * @return bool
     */
    public function storagePut($path, $content): bool
    {
        return Storage::put($path, $content);
    }

}
