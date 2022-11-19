<?php

namespace Elementcore\Faq;


class Controller
{

    public function generalDestroy($auditable_type, $array_where, $message, $image_source, $image_path, $sselet)
    {
        $result['status'] = false;
        $result['code'] = 400;
        $result['message'] = __('errorMessages.something_went_wrong');

        $model = app($auditable_type);

        $model = $model->select($sselet)->where($array_where)->first();

        // if ($model->image)
        //     $this->deleteImage($image_path, $model->image, $image_source, Auth::user()->User_ID);

        $model->delete();
        if ($model && $message) {
            $result['status'] = true;
            $result['code'] = 200;
            $result['message'] = $message;
            return response()->json($result);
        }
        if (!$message) {
            return $result['status'];
        }
    }
    public function changeStatus2($auditable_type, $name, $update_name)
    {

        $data = $auditable_type;
        if ($data) {
            $model_updated = $data->update([
                $update_name => ($data->$update_name == 1) ? 0 : 1,
            ]);
            if ($model_updated) {
                $message = ($data->$update_name == 1) ? __('successMessages.active_status_' . $name) : __('successMessages.deactive_status_' . $name);
                $result['status'] = true;
                $result['code'] = 200;
                $result['message'] = $message;
                return response()->json($result);
            }
        } else {
            $result['status'] = false;
            $result['code'] = 400;
            $result['message'] = __('errorMessages.something_went_wrong');
            return response()->json($result);
        }
    }
    public function generalUpdate($auditable_type, $array_where, $message, $update_array)
    {
        $result['status'] = false;
        $result['code'] = 400;
        $result['message'] = __('errorMessages.something_went_wrong');

        $model = class_basename($auditable_type);
        $model = new $auditable_type;
        $model = $model->where($array_where);

        $model->update($update_array);
        if ($model && $message) {
            $result['status'] = true;
            $result['code'] = 200;
            $result['message'] = $message;
            return response()->json($result);
        }
        if (!$message) {
            return $result['status'];
        }
    }
    public function generalCreate($auditable_type, $message, $update_array)
    {
        $result['status'] = false;
        $result['code'] = 400;
        $result['message'] = __('errorMessages.something_went_wrong');

        $model = app($auditable_type);

        $model->create($update_array);
        if ($model && $message) {
            $result['status'] = true;
            $result['code'] = 200;
            $result['message'] = $message;
            return response()->json($result);
        }
        if (!$message) {
            return $result['status'];
        }
    }

    public function customizedUpdateCreate($auditable_type, $where_array, $update_array)
    {
        $data = app($auditable_type);
        // this means that there is data we need to update it
        if (count($data->where($where_array)->get())) {
            $data = $data->where($where_array)->first();
            $data->where($where_array)->update($update_array);
        } else {
            $data = $data::create(
                array_merge($where_array, $update_array)
            );
        }
        return $data;
    }
    public function sendResponse($message, $code = 200, $data = null, $data_name = '')
    {
        $result['status'] = true;
        $result['code'] = $code;
        $result['message'] = $message;
        $result[$data_name] = $data;
        return response()->json($result);
    }

    public function sendError($message, $code = 400)
    {
        $result['status'] = false;
        $result['code'] = $code;
        $result['message'] = $message;
        return response()->json($result);
    }
}
