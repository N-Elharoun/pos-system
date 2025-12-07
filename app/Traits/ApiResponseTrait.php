<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function apiResponse($data = [], $message = " ", $status = true)
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message
        ]);
    }
    public function apiSuccessMessage($data, $message)
    {
        return $this->apiResponse($data, $message, true);
    }
    public function apiErrorMessage($message, $statusCode)
    {
        return $this->apiResponse([], $message, false)->setStatusCode($statusCode);
    }
    public function paginatedResponseApi($collection = [], $message = "")
    {
        return $this->apiResponse([
            'items' => $this->resourceName::collection($collection),
            'pagination' => [
                'total'          => $collection->total(),
                'count'          => $collection->count(),
                'per_page'       => $collection->perPage(),
                'current_page'   => $collection->currentPage(),
                'total_pages'    => $collection->lastPage(),

                // Added URL links
                'next_page_url'  => $collection->nextPageUrl(),
                'prev_page_url'  => $collection->previousPageUrl(),
                'first_page_url' => $collection->url(1),
                'last_page_url'  => $collection->url($collection->lastPage()),
            ]
        ], $message);
    }
}
