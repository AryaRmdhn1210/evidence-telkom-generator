<?php

namespace App\Policies;

use App\Models\Proyek;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProyekPolicy
{
  /**
   * Semua user login boleh melihat daftar dan isi proyek (mode lihat saja).
   */
  public function viewAny(User $user): bool
  {
    return true;
  }

  public function view(User $user, Proyek $proyek): bool
  {
    return true;
  }

  public function create(User $user): bool
  {
    return true;
  }

  /**
   * Mengubah proyek beserta isinya: item, foto, dan laporan.
   * Hanya pembuat proyek dan admin.
   */
  public function update(User $user, Proyek $proyek): Response
  {
    $diizinkan = $user->role === 'admin'
      || (int) $proyek->dibuat_oleh === (int) $user->id;

    return $diizinkan
      ? Response::allow()
      : Response::deny('Hanya pembuat proyek atau admin yang dapat mengubah proyek ini.');
  }

  public function delete(User $user, Proyek $proyek): Response
  {
    return $this->update($user, $proyek);
  }
}
