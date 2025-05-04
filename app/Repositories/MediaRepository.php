<?php


namespace App\Repositories;

use App\Models\Ads;
use App\Models\MediaTemp;
use App\Models\CustomMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaRepository
{
    const MINE_TYPES_EXTENSIONS_IMAGES = [
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        'image/bmp' => 'bmp',
        'image/svg+xml' => 'svg',
        'application/pdf' => 'pdf',
    ];

    public static function get_company_ads_banner_properties($company, $ads_classified_id): array
    {
        if ($company->company_ads_banner_status == 1 && $company->is_show_company_ads_banner == 1 && $company->hasMedia('company_ads_banner') && $ads_classified_id == 1) {
            return ['company_ads_banner_path' => $company->getFirstMediaPath('company_ads_banner')];
        }

        return [];
    }

    public static function get_first_media_by_ads($ads_id){
        return CustomMedia::query()
            ->where([
                'model_id' => $ads_id,
                'model_type' => Ads::class,
                'collection_name' => 'ads_images',
            ])
            ->orderBy('order_column')
            ->first();
    }

    public function add_media_with_convert_filename($model, string $collection_name, $file)
    {
        $filename = $collection_name . '_' . time();
        $full_filename = $filename . '.' . $file->getClientOriginalExtension();
        return $model
            ->addMedia($file)
            ->usingName($filename)
            ->usingFileName($full_filename)
            ->toMediaCollection($collection_name);
    }
    
    public function add_media($model, string $collection_name, $file)
    {
        return $model
            ->addMedia($file)
            ->toMediaCollection($collection_name);
    }

    public function add_media_banner_and_thumbnail($model, string $collection_name, $mediaFile)
    {
        // First, make sure to save the model before adding media
        $model->save();

        // Add media to the specified collection
        $media = $model->addMedia($mediaFile)
            ->toMediaCollection($collection_name);

        // Register media conversions
        $media->registerMediaConversions(function (Media $media) use ($model, $collection_name) {
            $model->clearMediaCollectionConversions($collection_name); // Clear existing conversions for this collection
            $model->addMediaConversion('full')
                ->format('jpg')
                ->apply();
            $model->addMediaConversion('thumb')
                ->crop('crop-center', 300, 300)
                ->format('jpg')
                ->apply();
        });

        // Save the model again to persist the media and conversions
        $model->save();
    }

    public function copy_media_with_convert_filename(int $media_id, $model, string $collection_name, bool $delete_original = false)
    {
        $media = CustomMedia::query()
            ->find($media_id);
        // dd($media);
        if ($media) {
            $filename = $collection_name . '_' . time();
            $extension = pathinfo($media->getUrl(), PATHINFO_EXTENSION);
            $full_filename = $filename . '.' . $extension;
            $new_media = $media->copy($model,$collection_name,'s3',$full_filename);
            $new_media->update([
                'name' => $filename
            ]);

            if($delete_original){
                $media->delete();
            }
            return $new_media;
        }
        return null;
    }

    public function add_media_with_convert_filename_base64($model, string $collection_name, string $file_base64)
    {
        $parts = explode(";base64,", $file_base64);
        $mime_type = substr($parts[0], 5);
        $extension = self::MINE_TYPES_EXTENSIONS_IMAGES[$mime_type];

        $filename = $collection_name . '_' . time();
        $full_filename = $filename . '.' . $extension;

        return $model
            ->addMediaFromBase64($file_base64)
            ->usingName($filename)
            ->usingFileName($full_filename)
            ->toMediaCollection($collection_name);
    }
}
