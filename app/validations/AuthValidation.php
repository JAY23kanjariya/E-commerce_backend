<?php

namespace App\Validations;

class AuthValidation
{
    public static function register($data)
    {
        $errors = [];

        // Name Validation
        $name = trim($data['name'] ?? '');

        if (empty($name)) {
            $errors['name'] = 'Name is required';
        } elseif (strlen($name) > 100) {
            $errors['name'] = 'Name must be at most 100 characters';
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors['name'] = 'Name can only contain alphabets';
        }

        // Email Validation
        $email = trim($data['email'] ?? '');

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (strlen($email) > 100) {
            $errors['email'] = 'Email must be at most 100 characters';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }

        // Password Validation
        $password = $data['password'] ?? '';

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($password) > 20) {
            $errors['password'] = 'Password must be at most 20 characters';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }

        return $errors;
    }

    public static function login($data)
    {
        $errors = [];

        $email = trim($data['email'] ?? '');

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }

        $password = trim($data['password'] ?? '');

        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }

    public static function verifyOtp($data)
    {
        $errors = [];

        // Email Validation
        $email = trim($data['email'] ?? '');

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }

        // OTP Validation
        $otp = trim($data['otp'] ?? '');

        if (empty($otp)) {
            $errors['otp'] = 'OTP is required';
        } elseif (!is_numeric($otp)) {
            $errors['otp'] = 'OTP must be a number';
        } elseif (strlen($otp) != 8) {
            $errors['otp'] = 'OTP must be 8 digits';
        }

        return $errors;
    }

    public static function forgotpassword($data)
    {
        $errors = [];

        // Email Validation
        $email = trim($data['email'] ?? '');

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }

        return $errors;
    }
}
