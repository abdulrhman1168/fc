<?php

namespace Modules\Core\Traits;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait StoreFile
{
    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @param string $fieldName
     * @param string $directory
     * @return $this|false|string
     */
    public function verifyAndStoreFile(Request $request, $fieldName = 'image', $directory = '')
    {
        if ($request->hasFile($fieldName)) {

            $file = $request->file($fieldName);

            if (!$file->isValid()) {

                session()->flash(__('messages.error_uploading_file'), 'danger');
                return redirect()->back()->withInput();
            }
            
            $path     = empty($directory) ? 'uploads' : 'uploads/' . $directory;
            $fileName = Str::random(20) . time() . '.' . $file->extension();
            $file->move(public_path($path), $fileName);

            $path = $path .'/'. $fileName;
            return $path;
        }
    }
}
