<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    function myQuote()
    {
        return response()->json([
            'quotes' => [],
        ]);
    }

    function index()
    {
        return response()->json([
            'quotes' => [],
        ]);
    }

    function store(Request $request)
    {
        //Generate a new quote
        $quote = [];
        if ($request->has('tariff') && $request->tariff == 'PDBT') {
            $consumoIntermedio = 0;
            $kWAnioMovil = 0;
            $suministro = 0;
            $distribucion = 0;
            $transmision = 0;
            $cenace = 0;
            $generacionI = 0;
            $capacidad = 0;
            $SCnMEM = 0;
            $aPublico = 0;

            $subtotal = 0;
            $iva = 0;
            $total = 0;

            $monthly = [
                'primero' => [],
                'segundo' => [],
                'tercero' => [],
                'cuarto' => [],
                'quinto' => [],
                'sexto' => [],
            ];

            for ($i=1; $i <= 6; $i++) {
                $name = $this->getSelection($i);

                $consumoIntermedio += floatval($request->input('consumoIntermedia' . $i));
                $kWAnioMovil += floatval($request->input('kwaniomovil' . $i));
                $suministro += floatval($request->input('suministro' . $i));
                $distribucion += floatval($request->input('distribucion' . $i));
                $transmision += floatval($request->input('transmision' . $i));
                $cenace += floatval($request->input('cenace' . $i));
                $generacionI += floatval($request->input('genI' . $i));
                $capacidad += floatval($request->input('capacidad' . $i));
                $SCnMEM += floatval($request->input('sCnMEM' . $i));
                $aPublico += floatval($request->input('aPublico' . $i));

                $subtotalM = floatval($request->input('suministro' . $i)) +
                            floatval($request->input('distribucion' . $i)) +
                            floatval($request->input('transmision' . $i)) +
                            floatval($request->input('cenace' . $i)) +
                            floatval($request->input('genI' . $i)) +
                            floatval($request->input('capacidad' . $i)) +
                            floatval($request->input('sCnMEM' . $i));


                $ivaM = $subtotal * 0.16;

                $totalM = $subtotal + $iva;

                $subtotal += $subtotalM;
                $iva += $ivaM;
                $total += $totalM;

                $monthly[$name] = [
                    'consumoIntermedio' => floatval($request->input('consumoIntermedia' . $i)),
                    'kWAnioMovil' => floatval($request->input('kwaniomovil' . $i)),
                    'suministro' => floatval($request->input('suministro' . $i)),
                    'distribucion' => floatval($request->input('distribucion' . $i)),
                    'transmision' => floatval($request->input('transmision' . $i)),
                    'cenace' => floatval($request->input('cenace' . $i)),
                    'generacionI' => floatval($request->input('genI' . $i)),
                    'capacidad' => floatval($request->input('capacidad' . $i)),
                    'SCnMEM' => floatval($request->input('sCnMEM' . $i)),
                    'subtotal' => $subtotalM,
                    'iva' => $ivaM,
                    'total' => $totalM,
                ];
            }

            $annual = [
                'consumoIntermedio' => $consumoIntermedio,
                'kWAnioMovil' => $kWAnioMovil,
                'suministro' => $suministro,
                'distribucion' => $distribucion,
                'transmision' => $transmision,
                'cenace' => $cenace,
                'generacionI' => $generacionI,
                'capacidad' => $capacidad,
                'SCnMEM' => $SCnMEM,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
            ];

            $quote = Quote::create([
                'name' => $request->clientName,
                'location' => $request->clientUbication,
                'noService' => $request->noService,
                'tariff' => $request->tariff,
                'connectedPower' => $request->connectedPower,
                'contractedPower' => $request->contractedPower,
                'monthlyConsumption' => json_encode($monthly),
                'annualConsumption' => json_encode($annual),
                'user_id' => Auth::user()->id,
            ]);

        } else {
            $consumoBase = 0;
            $consumoIntermedio = 0;
            $consumoPunta = 0;

            $kWAnioMovil = 0;
            $kVrah = 0;
            $fPotencia = 0;

            $demandaBase = 0;
            $demandaIntermedia = 0;
            $demandaPunta = 0;

            $suministro = 0;
            $distribucion = 0;
            $transmision = 0;
            $cenace = 0;
            $generacionP = 0;
            $generacionI = 0;
            $generacionB = 0;
            $capacidad = 0;
            $SCnMEM = 0;


            $subtotal = 0;
            $iva = 0;
            $total = 0;

            $monthly = [
                'primero' => [],
                'segundo' => [],
                'tercero' => [],
                'cuarto' => [],
                'quinto' => [],
                'sexto' => [],
            ];
        }

        return response()->json([
            'quote' => $quote,
        ]);
    }

    private function getSelection($i) {
        switch ($i) {
            case 1:
                return 'primero';
                break;
            case 2:
                return 'segundo';
                break;
            case 3:
                return 'tercero';
                break;
            case 4:
                return 'cuarto';
                break;
            case 5:
                return 'quinto';
                break;
            case 6:
                return 'sexto';
                break;
            case 7:
                return 'septimo';
                break;
            case 8:
                return 'octavo';
                break;
            case 9:
                return 'noveno';
                break;
            case 10:
                return 'decimo';
                break;
            case 11:
                return 'onceavo';
                break;
            case 12:
                return 'doceavo';
                break;
        }
    }
}
