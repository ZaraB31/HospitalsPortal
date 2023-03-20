<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drawing;
use App\Models\Location;
use File;

use Validator;

class DrawingController extends Controller
{
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required'],
            'file' => ['required','file'],
        ])->validateWithBag('newDrawing');

        $drawing = $request->file('file');
        $drawingName = date('Y-m-d').'-'.$request['name'].'.'.$drawing->getClientOriginalExtension();
        $target_path = public_path('/drawings');
        $drawing->move($target_path, $drawingName);

        $id = $request['location_id'];

        $drawing = Drawing::create(['name' => $request['name'],
                                    'file' => $drawingName,
                                    'version' => $request['version'],
                                    'location_id' => $id]);
        
        return redirect()->route('viewLocation', $id)->with('success', 'Drawing Uploaded!');
    }

    public function download($id) {
        $drawing = Drawing::findOrFail($id);

        $file = $drawing['file'];
        $filePath = public_path('/drawings/'.$file);

        return response()->download($filePath);
    }

    public function delete($id) {
        $drawing = Drawing::findOrFail($id);
        $location = Location::find($drawing['location_id']);

        $deletedFile = File::delete(public_path().'/drawings/'.$drawing['file']);
        $drawing->delete();

        return redirect()->route('viewLocation', $location['id']);
    }
}
