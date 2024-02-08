<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function importFile(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        $testArray = [];

        foreach ($fileContents as $line) {
            array_push($testArray, $line);
        }
        $newTest = json_encode($testArray);

        return response()->json($newTest);
    }

    public function importTwo(Request $request)
    {
        $file = $request->file('file');

        $collection = (new UsersImport)->toCollection($file);
        return response()->json($collection);
    }
}
