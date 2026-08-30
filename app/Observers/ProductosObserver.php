<?php

namespace App\Observers;

use App\Models\Productos;
use App\Models\UnidadesMedidas;

class ProductosObserver
{
    /**
     * Se ejecuta ANTES de insertar un nuevo producto.
     * Genera automáticamente:
     *   - codigoProducto → "PROD-00001" (secuencial)
     *   - estadoProductos → 'activo' por defecto
     */
    public function creating(Productos $producto): void
    {
        // Si no se proporcionó un código (por escáner o frontend), generamos uno interno EAN-13.
        if (empty($producto->codigoProducto)) {
            $siguiente = (Productos::max('idProductos') ?? 0) + 1;        
            $code = '200' . str_pad($siguiente, 9, '0', STR_PAD_LEFT);
            
            // Cálculo del Checksum (dígito de control EAN-13)
            $sum = 0;
            $weightflag = true;
            for ($i = 11; $i >= 0; $i--) {
                $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
                $weightflag = !$weightflag;
            }
            $checksum = (10 - ($sum % 10)) % 10;
            
            $producto->codigoProducto = $code . $checksum;
        }
        if (empty($producto->estadoProductos)) {
            $producto->estadoProductos = 'activo';
        }

        if (empty($producto->unidadesmedidasid)) {
            $ninguno = UnidadesMedidas::firstOrCreate(
                ['nameUnidadesMedidas' => 'Ninguno'],
                [
                    'simboloUnMedidas' => 'N/A',
                    'permiteDecimalesUnMedidas' => false
                ]
            );
            $producto->unidadesmedidasid = $ninguno->idUnidadesMedidas;
        }
    }
}
