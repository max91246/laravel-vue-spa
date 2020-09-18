<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\BigprojectRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\BigProject;
use Illuminate\Support\Facades\Validator;

class BigprojectController extends Controller
{


    public function list(Request $request)
    {
        $id = $request->post('id');
        if ($id){
            $list = BigProject::where('id', $id)->orderBy('created_at')->first()->toArray();
        }else{
            $list = BigProject::limit(10)->orderBy('created_at')->get()->toArray();
        }


        return $this->json('200' , '請求成功', [
            'list' => $list
        ]);
    }

    /**
     * @param BigprojectRequest $request
     *
     * @return JsonResponse
     */
    public function insert(Request $request)
    {

        $post = $request->post();

        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => '产品名称不能為空',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $post['admin'] = $request->user()->id;

        $bigproject = new Bigproject();

        $bigproject->fill($post)->save();

        return $this->json(200, '產品大類添加成功！');
    }

    public function update(Request $request)
    {
        $post = $request->post();

        $rules = [
            'id' => 'required',
            'name' => 'required',
        ];

        $messages = [
            'name.required' => '产品名称不能為空',
            'id.required' => 'id不能為空',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $bigproject_data = Bigproject::findOrFail($post['id']);
        unset($post['id']);
        $bigproject_data->fill($post)->save();


        return $this->json(200, '產品大類更新成功！');
    }
}
