<?php

namespace Places\Utility;

use Exception;

class GeneralUtility
{
    /**
     * @return string
     */
    public static function generateRandomToken()
    {
        try {
            $token = bin2hex(random_bytes(50));
        } catch (Exception $e) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = '';
            for ($i = 0; $i < strlen($characters); $i++) {
                $index = rand(0, strlen($characters) - 1);
                $token .= $characters[$index];
            }
        }
        return $token;
    }
}