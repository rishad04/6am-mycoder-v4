<?php

namespace App\Repositories\SubscriptionPlan;


use App\Enums\Status;
use Illuminate\Support\Str;
use App\Models\SubscriptionPlan;
use App\Traits\ReturnFormatTrait;
use App\Classes\MyCoder\FileManager;
use App\Repositories\SubscriptionPlan\SubscriptionPlanInterface;


class SubscriptionPlanRepository implements SubscriptionPlanInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(SubscriptionPlan $model)
    {
        $this->model = $model;
    }

    public function all(?bool $status = null, ?int $paginate = null, string $orderBy = 'id', $sortBy = 'desc')
    {
        $query = $this->model::query();

        if ($status != null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function first($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $row                =  new $this->model();

            $row->title         = $request->title;

            $row->slug          = Str::slug($request->slug);

            $row->price         = $request->price;

            $row->description   = $request->description;

            $row->billing_cycle = $request->billing_cycle;

            $row->is_popular    = $request->is_popular ? 1 : 0;

            if ($request->hasfile('banner')) {
                $file_response  = FileManager::saveFile(
                    $request->file('banner'),
                    'storage/Subscription-Plans',
                    ['png', 'jpg', 'jpeg', 'gif']
                );

                if (isset($file_response['result']) && !$file_response['result']) {

                    return $this->responseWithError(___('alert.invalid_upload'), []);
                }

                $row->banner    = $file_response['filename'];
            }
            $row->save();

            return $this->responseWithSuccess(___('alert.successfully_created'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {

        try {
            $row                = $this->model::findOrFail($id);

            $row->title         = $request->title;

            $row->slug          = $request->slug;

            $row->price         = $request->price;

            $row->description   = $request->description;

            $row->billing_cycle = $request->billing_cycle;

            $row->is_popular    = $request->is_popular ? 1 : 0;

            if ($request->hasfile('banner')) {
                $file_response = FileManager::saveFile(
                    $request->file('banner'),
                    'storage/Subscription-Plans',
                    ['png', 'jpg', 'jpeg', 'gif']
                );
                if (isset($file_response['result']) && !$file_response['result']) {

                    return back()->with('warning', $file_response['message']);
                }

                $old_file = $row->banner;

                FileManager::deleteFile($old_file);

                $row->banner = $file_response['filename'];
            }

            $row->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {

        $row = $this->model::where('id', $id)->first();

        if ($row == null || $row == '') {
            return $this->responseWithError(___('Id not Found'), []);
        }

        if ($row['banner'] != '') {
            FileManager::deleteFile($row['banner']);
        }

        $row->delete();

        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }
}
