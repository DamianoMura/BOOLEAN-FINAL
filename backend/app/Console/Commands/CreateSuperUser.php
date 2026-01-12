<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CreateSuperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create first dev user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('creation of first dev user....');
        //inserting user name
        $name = $this->ask('Insert Name', 'dev');
        //inserting password with validation
        do {
            $email = $this->ask('Insert email', 'email@*.*');
            $validator = Validator::make(['email' => $email], [
                'email' => 'required|email|unique:users,email'
            ]);

            if ($validator->fails()) {
                $this->error($validator->errors()->first('email'));
                $email = null;
            }
        } while ($email === null);
        // password with validation
        do {
            $password = $this->secret('Insert password');
            $passwordConfirm = $this->secret('Confirm password');

            if ($password !== $passwordConfirm) {
                $this->error('The two passwords don\'t match, please insert again.');
                continue;
            }

            if (strlen($password) < 8) {
                $this->error('Password must be at least 8 characters long.');
                $password = null;
                continue;
            }

            break;
        } while (true);
        // Conferma
        $this->table(['field', 'value'], [
            ['name', $name],
            ['email', $email],
        ]);

        if (!$this->confirm('do you wish to proceed?')) {
            $this->info('Aborting dev user creation.');
            return 0;
        }

        // Creazione utente
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $user->assignRole('dev');
            $this->info('User created!', $email);
        } catch (\Exception $e) {
            $this->error('Something went wrong while creating dev User: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
