<?php 
    function validateFile ($file, $type, $maxsize = 5000000) {
        $file = array_values($_FILES);
        $file = $file[0];

        $fileName = explode(".", $file['name']);
        $fileType = $file['type'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileTmp = $file['tmp_name'];

        $allowed_Ext = getAllowedExt($type);
        $fileExt = strtolower(end($fileName));

        if (in_array($fileExt, $allowed_Ext)) {
            if ($fileError === 0) {
                if ($fileSize < $maxsize) {
                    return moveFile ($fileName, $fileExt, $fileTmp);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function moveFile ($fileName, $fileExt, $fileTmp) {
        $new_FileName = $fileName[0] . '_' . uniqid('', false) . '.' . $fileExt;
        $file_Dest = 'images/' . $new_FileName;
        if (move_uploaded_file($fileTmp, $file_Dest)) {
            return $file_Dest;
        } else {
            return false;
        }
    }

    function getAllowedExt ($type) {
        if ($type === "img") {
            return ['png', 'jpg', 'jpeg', 'gif'];
        } elseif ($type = "video") {
            return ['mp4'];
        }
    }
?>