<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Map; 

class MapController extends Controller
{
    public function index()
    {
        $maps = Map::paginate(2);
        return $maps;
    }

    public function store(Request $request)
    {
      $request->validate([
        'title' => 'required|string|max:150',
        'description' => 'required',
        'imageName' => 'required',
        'price' => 'required',
      ]);
      // take from base64 picture img extension, .png or .jpg and merge with time
      $name = time().'.' . explode('/', explode(':', substr($request->imageName, 0, strpos($request->imageName, ';')))[1])[1];
      // save base64 picture in public folder with image intervention: \Image::make(..)
      \Image::make($request->imageName)->save('/Users/georgiospappas/pap.www/sundance-berlin-vue-drived/admin-sundance-berlin/public/img/maps/'.$name);
      // push new photo name in $request array
      $request->merge(['imageName' => $name]);
      $map = new Map;
      $map->title = $request->title;
      $map->description = $request->description;
      $map->imageName = $request->imageName;
      $map->price = $request->price;
      $map->save();
      return $map;
    }

    public function show($id)
    {
      $map = Map::findOrFail($id);
      return $map;
    }
    
    public function update(Request $request, $id)
    {
      $map = Map::findOrFail($id);
      $request->validate([
        'title' => 'required|string|max:80',
        'description' => 'required',
        'imageName' => 'required',
        'price' => 'required',
      ]);
      // $currentPhoto is the rezent photo from database
      $currentPhoto = $map->imageName;
      // pick image format (png or jpg ...) and merge it to new image date name
      if($request->imageName != $currentPhoto) {
        // take from base64 picture img extension, .png or .jpg and merge with time name
        $name = time().'.' . explode('/', explode(':', substr($request->imageName, 0, strpos($request->imageName, ';')))[1])[1];
        // save base64 picture in pablic folder with image intervention: \Image::make(..)
        \Image::make($request->imageName)->save('/Users/georgiospappas/pap.www/sundance-berlin-vue-drived/admin-sundance-berlin/public/img/maps/'.$name);
        // delete old photo if new photo entry
        $mapPhoto = '/Users/georgiospappas/pap.www/sundance-berlin-vue-drived/admin-sundance-berlin/public/img/maps/'.$currentPhoto;
        if(file_exists($mapPhoto)){
            @unlink($mapPhoto);
        }
        // push new photo name in $request array
        $request->merge(['imageName' => $name]);
      };
      $map->title = $request->title;
      $map->description = $request->description;
      $map->imageName = $request->imageName;
      $map->price = $request->price;
      $map->save();
    }

    public function destroy($id)
    {
      $map = Map::findOrFail($id);
      $map->delete();
      $currentPhoto = $map->imageName;
      $mapPhoto = '/Users/georgiospappas/pap.www/sundance-berlin-vue-drived/admin-sundance-berlin/public/img/maps/'.$currentPhoto;
      if(file_exists($mapPhoto)){
          @unlink($mapPhoto);
      }
    }
}

