<?php

namespace App\Http\Controllers\Cms\Settings\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadMultipleImages;
use App\Http\Resources\Cms\Settigns\SliderResource;
use App\Models\Configs\Slider;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Cms/Settings/General/Slider/Index', [
            'sliders' => new SliderResource(Slider::where('id', 1)->first()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UploadMultipleImages  $request
     * @param \App\Models\Configs\Slider $slider
     * @return \Illuminate\Http\Response
     */
    public function store(UploadMultipleImages $request, Slider $slider)
    {
        try {
            if (is_array($request->image)) {
                foreach ($request->file('image') as $image) {
                    $slider->addMedia($image)->toMediaCollection('slider');
                }
            } else {
                if ($request->has('image')) {
                    $slider->addMedia($request->file('image'))->toMediaCollection('slider');
                } else {
                    throw new \Exception('No image loaded');
                }
            }
        } catch (\Throwable$th) {
            throw $th;
            return redirect()->back()
                ->withErrors($th->getMessage())
                ->with(['toast' => ['type' => 'error', 'message' => $th->getMessage()]]);
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Imagen cargada exitosamente!']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'slides' => ['required', 'array'],
        ]);

        $i = 1;

        foreach ($request->slides as $slide) {
            $media = Media::findByUuid($slide['uuid']);
            $media->name = $slide['name'];
            $media->order_column = $i;

            if ($media->isDirty()) {
                $media->save();
            }

            $i++;
        }

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Imagen actualizada exitosamente!']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider, $uuid)
    {
        $media = Media::findByUuid($uuid);
        $slider->deleteMedia($media->id);

        return redirect()->back()->with(['toast' => ['type' => 'success', 'message' => 'Imagen eliminada exitosamente!']]);
    }
}
