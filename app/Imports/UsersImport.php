<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class UsersImport implements ToCollection, WithHeadingRow, WithProgressBar, WithChunkReading, WithBatchInserts
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $phone = '+520000000000';

            if (empty($row['phone']) || is_null($row['phone'])) {
                if (!empty($row['cellphone']) || !is_null($row['cellphone'])) {
                    $phone = $row['cellphone'];
                }
            } else {
                $phone = $row['phone'];
            }

            $user = new User();
            $user->firstname = $row['firstname'];
            $user->lastname = $row['lastname'];
            $user->email = $row['email'];
            $user->password = $row['password'];
            $user->email_verified_at = now();
            $user->suscribed = $row['suscribed'];
            $user->acepted_terms_conditions = now();
            $user->phone = $phone;
            $user->created_at = now();
            $user->updated_at = now();

            if ($user->isDirty()) {
                $user->save();
            }
        }
    }

    /**
     * Chunk Reading Function
     *
     * @return integer
     */
    public function chunkSize(): int
    {
        return 10;
    }

    /**
     * Batch Inserts funciont
     *
     * @return integer
     */
    public function batchSize(): int
    {
        return 10;
    }
}
