<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectInfoController extends Controller
{
    public function list(Request $request)
    {

        $id = $request->post('id');
        if ($id){
            $list = Project::where('id', $id)->orderBy('created_at')->first()->toArray();
        }else{
            $list = Project::limit(10)->orderBy('created_at')->get()->toArray();
        }

        return $this->json('200' , '請求成功', [
            'list' => $list
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function insert(Request $request)
    {

        $post = $request->post();
        if (is_array($post)){
            foreach ($post as $key => $row) {
                $rules = [
                    'big_project_id' => 'required',
                    'project_id' => 'required',
                    'size_id' => 'required',
                    'style_id' => 'required',
                    'num' => 'required|numeric|min:0|not_in:0',
                ];

                $messages = [
                    'big_project_id.required' => '产品大类不能為空',
                    'project_id.required' => '产品對應不能為空',
                    'size_id.required' => '產品size不能為空',
                    'style_id.required' => '產品style不能為空',
                    'num.required' => '產品數量不能為空',
                    'num.numeric' => '產品數量必須為數字',
                    'num.min' => '產品數量不能小於1',
                    'num.not_in' => '產品數量不能為0',
                ];

                $result = Validator::make($row, $rules, $messages);

                if ($result->fails()) {
                    $error = $result->errors()->first();
                    return $this->jsonError($error);
                }
                $post[$key]['admin'] = $request->user()->id;
                $post[$key]['created_at'] = date('Y-m-d H:i:s');

            }
        }


        $projectInfp = new ProjectInfo();

        $projectInfp->insert($post);

        return $this->json(200, '產品添加成功！');
    }

    public function update(Request $request)
    {
        $post = $request->post();

        $rules = [
            'id' => 'required',
            'big_id' => 'required',
            'name' => 'required',
        ];

        $messages = [
            'name.required' => '产品名称不能為空',
            'id.required' => 'id不能為空',
            'big_id.required' => 'big_id不能為空',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $project_data = Project::findOrFail($post['id']);
        unset($post['id']);
        $project_data->fill($post)->save();


        return $this->json(200, '產品更新成功！');
    }
}
