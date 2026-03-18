<?php

namespace App\Http\Controllers;

use App\Imports\RouteFile;
use App\Models\Route;
use App\Models\RoutePackage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{


    public function store(Request $request)
    {
        //$file = $request->file('file');


        // $import = new RouteFile;
        // $import->import($file);

        $file = public_path('api/routes/efren.xlsx');

        // Crear instancia de la clase de importación
        $import = new RouteFile;

        // Importar los datos
        Excel::import($import, $file);

        // Obtener los datos de la importación
        $data = $import->getData();
        $i = 0;
        $data2 = [];
        $total = 0;
        foreach ($data as $row) {
            if ($i > 0 && trim($row[0]) != '') {
                //7
                //22
                $data2[] = [
                    $this->cleanPrice($row[22]),
                    $row[22]
                ];
                $total += $this->cleanPrice($row[22]);
            }
            $i++;
        }

        return response()->json([
            'message' => 'success',
            'total' => $total,
            'res' => $data2
        ]);
    }
    private function cleanPrice($text)
    {
        $text = trim($text);
        $text = str_replace('$', "", $text);
        $text = str_replace(',', '', $text);
        $text = (float) $text;
        return $text;
    }


    public function upload(Request $request)
    {

        //$mimeType = $request->file('file')->getMimeType();
        //return response()->json(['message'=>'success','res'=>Route::find($request->id)],500);
        $validatedData = $request->validate([
            //'file' => 'required|file|mimes:csv,xls,xlsx|max:4048',
            //'file' => 'required|file|mimes:xls,xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:4048',
            'file' => 'required|file|max:4048',
            'id' => 'required'
        ]);

        $file = $request->file('file');
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('api/routes/');


        $file->move($destinationPath, $name);

        $route = Route::find($request->id);
        if ($route->file != '') {
            if (file_exists(public_path('api/routes/' . $route->file))) {
                unlink(public_path('api/routes/' . $route->file));
            }
        }
        $route->file = $name;
        $route->status='Terminada';
        $route->save();
        $packages = RoutePackage::with('package')->where('id_route', $request->id)->get();
        $file = public_path('api/routes/' . $name);
        $import = new RouteFile();
        Excel::import($import, $file);
        $data = $import->getData();

        $columnIndexes = [];
        $i = 0;
        if (isset($data[0])) {
            $headers = array_keys($data[0]->toArray());
             
            foreach ($headers as $key) {
                $key_normalized = strtolower(trim(preg_replace('/\s+/', ' ', $key)));
              
                switch ($key_normalized) {
                    case 'real_llego_a_la_hora':
                        $columnIndexes['hour'] = $key;
                        break;
                    case 'direccion':
                        $columnIndexes['address'] = $key;
                        break;
                    case 'imagen_de_caja':
                        $columnIndexes['box_image'] = $key;
                        break;
                    case 'nota':
                        $columnIndexes['notes'] = $key;
                        break;
                    case 'detener_el_progreso':
                        $columnIndexes['progress'] = $key;
                        break;
                    case 'razon_para_detener_el_progreso':
                        $columnIndexes['delivery_note'] = $key;
                        break;
                    case 'prueba_de_entrega':
                        $columnIndexes['delivery_evidence'] = $key;
                        break;
                    case 'campo_personalizado1':
                        $columnIndexes['note1'] = $key;
                    case 'campo_personalizado2':
                        $columnIndexes['note2'] = $key;
                    case 'campo_personalizado3':
                        $columnIndexes['note3'] = $key;
                    case 'campo_personalizado4':
                        $columnIndexes['note4'] = $key;
                    case 'campo_personalizado5':
                        $columnIndexes['note5'] = $key;
                        break;
                }

            }
        }
        
        // Recorrer paquetes y buscar coincidencia por track_number
        foreach ($packages as $p) {
            $track_number = strtolower($p->package->track_number);

            foreach ($data as $index => $row) {
                $rowArray = $row->toArray();

                if ($index === 0) continue; // Saltar encabezados

                // Buscar coincidencia en columna 'nota' (si está)
                $nota_col = $columnIndexes['notes'] ?? null;

                if ($nota_col && isset($rowArray[$nota_col]) && str_contains(strtolower($rowArray[$nota_col]), $track_number)) {
                    $p->hour = $columnIndexes['hour'] ? ($rowArray[$columnIndexes['hour']] ?? '') : '';
                    $p->address = $columnIndexes['address'] ? ($rowArray[$columnIndexes['address']] ?? '') : '';
                    $p->box_image = $columnIndexes['box_image'] ? ($rowArray[$columnIndexes['box_image']] ?? '') : '';
                    $p->notes = $columnIndexes['notes'] ? ($rowArray[$columnIndexes['notes']] ?? '') : '';
                    $p->progress = $columnIndexes['progress'] ? ($rowArray[$columnIndexes['progress']] ?? '') : '';
                    $p->delivery_note = $columnIndexes['delivery_note'] ? ($rowArray[$columnIndexes['delivery_note']] ?? '') : '';
                    $p->delivery_evidence = $columnIndexes['delivery_evidence'] ? ($rowArray[$columnIndexes['delivery_evidence']] ?? '') : '';
                    $p->note1 = $columnIndexes['note1'] ? ($rowArray[$columnIndexes['note1']] ?? '') : '';
                    $p->note2 = $columnIndexes['note2'] ? ($rowArray[$columnIndexes['note2']] ?? '') : '';
                    $p->note3 = $columnIndexes['note3'] ? ($rowArray[$columnIndexes['note3']] ?? '') : '';
                    $p->note4 = $columnIndexes['note4'] ? ($rowArray[$columnIndexes['note4']] ?? '') : '';
                    $p->note5 = $columnIndexes['note5'] ? ($rowArray[$columnIndexes['note5']] ?? '') : '';
                    break; // Si ya encontró el paquete, salta al siguiente
                }
            }

            $p->save();
        }
        return response()->json([
            'message' => 'success',
            'res' => [
                'headers'=>$headers,
                'cols' => $columnIndexes,
                'paquetes' => $packages,
                'EXCEL'=>$data
            ]
        ], 422);
        return response()->json([
            'message' => 'success',
            'res' => []
        ]);
    }
}
