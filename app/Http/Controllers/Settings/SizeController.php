<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{


    public function list(Request $request)
    {
        $id = $request->post('id');
        if ($id){
            $list = Size::where('id', $id)->orderBy('created_at')->first()->toArray();
        }else{
            $list = Size::limit(10)->orderBy('created_at')->get()->keyBy('id')->toArray();
        }

        return $this->json('200' , '請求成功', [
            'list' => $list
        ]);
    }



    public function insert(Request $request)
    {

        $post = $request->post();

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => '尺寸名称不能為空',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $post['admin'] = $request->user()->id;

        $size = new Size();

        $size->fill($post)->save();

        return $this->json(200, '產品尺寸添加成功！');
    }

    public function update(Request $request)
    {
        $post = $request->post();

        $rules = [
            'id' => 'required',
            'name' => 'required',
        ];

        $messages = [
            'name.required' => '尺寸名称不能為空',
            'id.required' => 'id不能為空',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $size = Size::findOrFail($post['id']);
        unset($post['id']);
        $size->fill($post)->save();


        return $this->json(200, '產品尺寸更新成功！');
    }
}
