<?php


namespace App\Services;


use App\Exceptions\InvalidRequestException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function officalBindPhone($openid, $phone)
    {
        $bindUser = User::query()->where('weixin_openid', $openid)->first();
        $phoneUser = User::where('phone', $phone)->first();
        if($bindUser->phone) {
            throw new InvalidRequestException('你已经绑定过手机了!', 500);
        }
        if(!$phoneUser) {
            $bindUser->phone = $phone;
            $bindUser->save();
        }
        $phoneUser->delete();
        $bindUser->update([
            'phone' => $phone,
            'password' => $phoneUser->password ?? ""
        ]);
        foreach($phoneUser->orders as $order) {
            $order->update([
                'userid' => $bindUser->id,
            ]);
        }
    }

    public function miniprogramBindPhone($request, $phone)
    {
        $mini_program_user = auth()->user(); // A:微信用户
        if($mini_program_user->phone && $mini_program_user->phone == $phone) {
            throw new \Exception('已经绑定过手机号了');
        }
        $phone_user = User::where('phone', $phone)->first(); // B:用户
        if(!$phone_user) {
            $mini_program_user->update([
                'phone' => $phone,
            ]);
            return $mini_program_user;
        }
        $mini_program_user = DB::transaction(function() use ($request, $mini_program_user, $phone_user, $phone) {
            $mini_program_user->update([
                'phone' => $phone,
                'password' => $phone_user->password ?? "",
            ]);
            DB::table('orders')->where('userid', $phone_user->id)->update([
                'userid' => $mini_program_user->id
            ]);// 把B的订单改成A
            
            $phone_user->delete();
            return $mini_program_user;
        });
        return $mini_program_user;
    }
}
