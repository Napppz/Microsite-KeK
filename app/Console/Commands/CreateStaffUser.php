<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateStaffUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staff:create 
                            {email : Alamat email staf} 
                            {--name=Staf Meja Registrasi : Nama lengkap staf} 
                            {--role=staff : Peran akun (staff/admin)} 
                            {--password= : Kata sandi akun (opsional, dibuat otomatis jika kosong)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat akun staf atau admin lokal untuk pemindai kehadiran';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = trim(strtolower($this->argument('email')));
        $name = (string) $this->option('name');
        $role = strtolower((string) $this->option('role'));
        $rawPassword = $this->option('password') ?: Str::random(12);

        if (! in_array($role, ['staff', 'admin'], true)) {
            $this->error('Peran tidak valid. Gunakan "staff" atau "admin".');
            return Command::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'role' => $role,
                'password' => Hash::make($rawPassword),
                'email_verified_at' => now(),
            ]
        );

        $this->info(sprintf('Akun %s berhasil dipersiapkan:', $role));
        $this->table(
            ['Nama', 'Email', 'Peran', 'Kata Sandi'],
            [[$user->name, $user->email, $user->role, $rawPassword]]
        );

        return Command::SUCCESS;
    }
}
