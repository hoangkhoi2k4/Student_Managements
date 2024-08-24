<?php

if (!function_exists('upload_image')) {
    function upload_image($imageFile)
    {
        if ($imageFile) {
            $imageName = time() . '-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('uploads', $imageName, 'public');

            return 'storage/uploads/' . $imageName;
        }
        return null;
    }
}
