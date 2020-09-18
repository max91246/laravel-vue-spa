<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StyleController extends Controller
{

    public function list(Request $request)
    {
        $id = $request->post('id');
        if ($id){
            $list = Style::where('id', $id)->orderBy('created_at')->first()->toArray();
        }else{
            $list = Style::limit(10)->orderBy('created_at')->get()->toArray();
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
            'color' => 'required',
        ];

        $messages = [
            'name.required' => '色系名称不能為空',
            'color.required' => '色系色碼不能為空',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $post['admin'] = $request->user()->id;

        $size = new Style();

        $size->fill($post)->save();

        return $this->json(200, '產品色系添加成功！');
    }

    public function update(Request $request)
    {
        $post = $request->post();

        $rules = [
            'id' => 'required',
            'name' => 'required',
            'color' => 'required',
        ];

        $messages = [
            'name.required' => '色系名称不能為空',
            'color.required' => '色系色碼不能為空',
            'id.required' => 'id不能為空',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $size = Style::findOrFail($post['id']);
        unset($post['id']);
        $size->fill($post)->save();


        return $this->json(200, '產品色系更新成功！');
    }
}
