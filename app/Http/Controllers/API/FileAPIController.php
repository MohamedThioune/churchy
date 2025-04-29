<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\UploadAPIRequest;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\FileResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\UploadFileToS3;
use Carbon\Carbon;

/**
 * Class FileController
 */

class FileAPIController extends AppBaseController
{

    /**
     * @OA\Post(
     *      path="/upload",
     *      summary="uploadFile",
     *      tags={"Document"},
     *      description="Upload file",
     *      @OA\RequestBody(
     *        @OA\MediaType(
     *          mediaType="multipart/form-data",
     *           @OA\Schema(
     *             @OA\Property(
     *                 property="file",
     *                 type="string",
     *                 format="binary"
     *             ),
     *             @OA\Property(
     *                 property="path",
     *                 type="string",
     *             ),
     *             @OA\Property(
     *                 property="meaning",
     *                 type="string",
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *             ),
     *              @OA\Property(
     *                 property="user_id",
     *                 type="integer",
     *             ),
     *           ),
     *        ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation !",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="Success",
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid file format"
     *      ),
     *  )
    */    
    public function upload(UploadAPIRequest $request): JsonResponse
    {
        $inputs = $request->all();
        $path = $inputs['path'] ?? null;
        $file = $request->file('file');
        $type = $file->getClientOriginalExtension();
        $name = basename($file->getClientOriginalName() , '.'. $type);
        $meaning = (isset($inputs['meaning'])) ? $inputs['meaning'] : null;
        $description = (isset($inputs['description'])) ? $inputs['description'] : null;
        $user_id = $inputs['user_id'] ?? null;

        //Generate a unique file name
        $fileName = $this->base_name($name, $type, $path, $meaning, $description, $user_id);

        //Store local temporary file
        $temp = $file->store('temp');

        UploadFileToS3::dispatch($temp, $fileName, $path, $meaning, $user_id);
        $file_id = array('file_id' => $fileName);

        return $this->sendResponse($file_id, 'File received, being processed...');
    }

    // Name of the file in database
    public function base_name($name, $type, $path, $meaning, $description, $user_id): string
    {        
        $genuine_name = Str::slug(Str::words($name, 10));
        do {
            $file_name = Str::random(5) . '-' . $genuine_name;
            $file_state = File::where('id', $file_name);
            File::firstOrCreate(
                [
                    'id' => $file_name,
                ],
                [
                    'type' => $type,
                    'path' => $path,
                    'meaning' => $meaning,
                    'description' => $description ?: $name,
                    'user_id' => $user_id,
                    'deleted_at' => Carbon::now()->format('Y-m-d H:i:s') //Set to deleted make it no-accessible till we upload to S3
                ]
            );

        } while (empty($file_state));

        return $file_name;
    }

    /**
     * @OA\Post(
     *      path="/retrieve",
     *      summary="ShowFile",
     *      tags={"Document"},
     *      description="Show the file",
     *      @OA\RequestBody(
     *        @OA\MediaType(
     *          mediaType="multipart/form-data",
     *           @OA\Schema(
     *             @OA\Property(
     *                 property="file_id",
     *                 type="string",
     *             ),
     *           ),
     *        ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/File"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
    */
    public function show(Request $request): JsonResponse
    {
        $inputs = $request->all();
        $id = $inputs['file_id'] ?? null;

        /** @var File $file */
        $file = File::find($id);

        if (empty($file)) 
            return $this->sendError('File not accessible or not found !');

        return $this->sendResponse(new FileResource($file), 'File retrieved successfully !');
    }


    /**
     * @OA\Delete(
     *      path="/files/{id}",
     *      summary="deleteFile",
     *      tags={"Document"},
     *      description="Delete File",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of File",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var File $file */
        $file = File::find($id);

        if (empty($file)) {
            return $this->sendError('File not found');
        }

        $path = $file->path;
        $fileName = $file->id;

        //Delete on database
        $file->delete();

        //Delete on storage
        Storage::disk('s3')->delete($file->path . $file->id);

        return $this->sendSuccess('File deleted successfully');
    }
}
