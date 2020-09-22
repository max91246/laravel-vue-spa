<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    //取得當前project 的數據
    public function list(Request $request)
    {
        $id = $request->post('id');
        $big_id = $request->post('big_id');


        $list = Project::with('project_info' , 'project_info.size' , 'project_info.style')->when($id, function (Builder $query, $id) {
            return $query->where('id', $id);
        })->when($big_id, function (Builder $query, $big_id) {
            return $query->where('big_id', $big_id)->orderByDesc('created_at');
        })->get();

        return $this->json('200' , '請求成功', [
            'list' => $list
        ]);

    }

    //取得big_project 底下的project對應
    public function list_for_bigid(Request $request)
    {

        $id = $request->post('big_id');
        if ($id){
            $list = Project::where('id', $id)->orderBy('created_at')->first()->toArray();
        }else{
            $list = Project::limit(10)->orderBy('created_at')->get()->toArray();
        }

        return $this->json('200' , '請求成功', [
            'list' => $list
        ]);
    }


    //取得project 底下的info對應
    public function list_for_info(Request $request)
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
            'amount' => 'required|numeric|min:0|not_in:0',
        ];

        $messages = [
            'big_id.required' => '产品大类不能為空',
            'name.required' => '请填写产品大类名称',
            'amount.required' => '產品金額不能為空',
            'amount.numeric' => '產品金額必須為數字',
            'amount.min' => '產品金額不能小於1',
            'amount.not_in' => '產品金額不能為0',

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
            'big_id' => 'required',
            'name' => 'required',
            'amount' => 'required|numeric|min:0|not_in:0',
        ];

        $messages = [
            'big_id.required' => '产品大类不能為空',
            'name.required' => '请填写产品大类名称',
            'amount.required' => '產品金額不能為空',
            'amount.numeric' => '產品金額必須為數字',
            'amount.min' => '產品金額不能小於1',
            'amount.not_in' => '產品金額不能為0',

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
