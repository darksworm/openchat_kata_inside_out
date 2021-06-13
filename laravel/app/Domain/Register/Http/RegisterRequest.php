<?php


namespace App\Domain\Register\Http;


use App\Framework\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function getUsername(): string
    {
        return $this->get('username');
    }

    public function getPassword(): string
    {
        return $this->get('password');
    }

    public function getAbout(): string
    {
        return $this->get('about');
    }

    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
            'about' => 'required'
        ];
    }
}
