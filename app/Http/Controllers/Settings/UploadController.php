<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $imageService;

    /**
     * @param ImageService $imageSer
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * 图片上传
     *
     * @param Request $request
     * @param string|null $dir
     * @param string|null $id
     * @return mixed
     */
    public function upload(Request $request, string $dir = null, string $id = null)
    {
        $file = $request->file('image');

        $result = $this->imageService->uploadFile($file, $dir, $id);

        $result = explode('|', $result);

        $status = ($result[0] == 'error') ? 500 : 200;

        $message = $result[1];

        if ($status === 200) {
            return $this->json($status, '上传成功', [
                // 'filename' => '/uploads/' . $message
                'filename' => $message
            ]);
        }

        return $this->json($status, $message);
    }
}
