<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Para reglas de unicidad excluyendo el propio ID

use App\Models\Cuenta;
use App\Models\Tarjeta;
use App\Models\Stake;
use App\Models\StakeUsuario;
use App\Models\TransaccionUsuario;

class SystemController extends Controller {}
