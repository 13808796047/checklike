<?php


namespace App\Services;


class CategoryService
{
    public function getPrice()
    {
        $user = auth()->user();
        switch ($user->user_group) {
            case 3:
                return $data['user'][0]['pivot']['price'];
                break;
            case 2:
                return $data['agent_price2'];
                break;
            case 1:
                return $data['agent_price1'];
                break;
            default:
                return $data['price'];
        }
    }
}
