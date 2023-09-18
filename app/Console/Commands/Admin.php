<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ulid\Ulid;



class Admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'adminを追加します';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = array('name' => '', 'uid' => '', 'password' => '');
        echo "Enter your screen name:";
        $admin['name'] = trim(fgets(STDIN));
        echo "Enter your user id:";
        $admin['uid'] = trim(fgets(STDIN));
        echo "Enter your password:";
        $admin['password'] = trim(fgets(STDIN));

        $validator = Validator::make($admin, [
            "name" => ["required","max:20"],
            "uid" => ["required","max:15","min:1","regex:/^[0-9a-z._]+$/","unique:App\Models\User,user_id"],
            "password" => ["required","min:8"]
        ]);

        if ($validator->fails()) {
            echo "入力が不正です\n";
            return Command::FAILURE;
        }
        $user = new User;
        $user->name = $admin["name"];
        $user->password = Hash::make($admin['password']);
        $user->user_id = $admin['uid'];
        $user->ulid = (string) Ulid::generate();
        $user->is_admin = true;
        $user->save();
        echo "Admin {$admin["name"]} を追加しました\n";
        return Command::SUCCESS;
    }
}
