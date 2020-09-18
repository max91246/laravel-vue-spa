<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Project;
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

        $rules = [

            'big_id' => 'required',
            'name' => 'required',
        ];

        $messages = [
            'big_id.required' => '产品大类不能為空',
            'name.required' => '请填写产品大类名称',
        ];

        $result = Validator::make($post, $rules, $messages);

        if ($result->fails()) {
            $error = $result->errors()->first();
            return $this->jsonError($error);
        }

        $post['admin'] = $request->user()->id;

        $project = new Project();

        $project->fill($post)->save();

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
