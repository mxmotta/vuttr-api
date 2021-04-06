<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToolRequest;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ToolsController extends Controller
{
 
    /**
     * @OA\Get(
     *     tags={"Tools"},
     *     summary="Returns a list of tools",
     *     description="Returns a object of tool",
     *     path="/api/v1/tools",
     *     @OA\Parameter(
     *          name="per_page",
     *          description="Page size",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page",
     *          description="Page to show",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="tag",
     *          description="Filter by tag",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(response="200", description="A list with tool"),
     * ),
     * 
    */
    public function list(Request $request)
    {
        try{
            return ToolResource::collection(
                Tool::hasTag($request->tag)->paginate($request->per_page ?? 5)
            );
        } catch(\Exception $e) {
            return response()->json([
                'error' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Tools"},
     *     summary="Returns a especified tool",
     *     description="Returns a object of tool",
     *     path="/api/v1/tools/{id}",
     *     @OA\Parameter(
     *          name="id",
     *          description="Tool id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="200", description="A object with tool"),
     * ),
     * 
    */
    public function get(Request $request)
    {
        try{
            $tool = Tool::find($request->id);
            if(!$tool) return response()->json(['error'=>'Resource not found.'], 404);

            return new ToolResource(
                $tool
            );
        } catch(\Exception $e){
            return response()->json([
                'error' =>  $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * @OA\Post(
     *     tags={"Tools"},
     *     summary="Create a tool",
     *     description="Returns a object of tool",
     *     path="/api/v1/tools",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Tool"
     *          )
     *     ),
     *     @OA\Response(response="201", description="Created a tool"),
     * ),
     * 
    */
    public function add(ToolRequest $request)
    {
        try {
            $tool = Tool::create($request->all());
            
            $tool->tags()->createMany(
                collect($request->tags)->map(function($tag){ 
                    return ['name' => $tag ];
                })
            );

            return new ToolResource($tool);
        } catch(\Exception $e){
            return response()->json([
                'error' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     tags={"Tools"},
     *     summary="Edit a tool",
     *     description="Returns a object of tool",
     *     path="/api/v1/tools/{id}",
     *     @OA\Parameter(
     *          name="id",
     *          description="Tool id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Tool"
     *          )
     *     ),
     *     @OA\Response(response="200", description="Updated a tool"),
     * ),
     * 
    */
    public function edit(ToolRequest $request)
    {
        try {
            $tool = Tool::find($request->id);
            if(!$tool) return response()->json(['error'=>'Resource not found.'], 404);
            $tool->fill($request->all())->save();
            $tool->tags()->delete();
            $tool->tags()->createMany(
                collect($request->tags)->map(function($tag){ 
                    return ['name' => $tag ];
                })
            );

            return new ToolResource($tool);
        } catch(\Exception $e){
            return response()->json([
                'error' =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     tags={"Tools"},
     *     summary="Delete a tool",
     *     description="Returns no content",
     *     path="/api/v1/tools/{id}",
     *     @OA\Parameter(
     *          name="id",
     *          description="Tool id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response="204", description="No content"),
     * ),
     * 
    */
    public function delete(Request $request)
    {
        try {
            $tool = Tool::find($request->id);
            if(!$tool) return response()->json(['error'=>'Resource not found.'], 404);
            $tool->delete();

            return response('', 204);
        } catch(\Exception $e){
            return response()->json([
                'error' =>  $e->getMessage()
            ], 500);
        }
    }
}
