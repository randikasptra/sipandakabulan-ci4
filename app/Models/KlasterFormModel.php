<?php

namespace App\Models;

use CodeIgniter\Model;

class KlasterFormModel extends Model
{
    protected $table = 'klasters';
    protected $primaryKey = 'id';
    protected $allowedFields = ['slug', 'title', 'nilai_em', 'nilai_maksimal', 'progres'];
}
