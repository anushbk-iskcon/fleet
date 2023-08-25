<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrApi extends Model
{
    use HasFactory;

    private $accessKey;
    private $apiBaseURL;

    public function __construct()
    {
        $this->accessKey = '729!#kc@nHKRKkbngsppnsg@491';
        $this->apiBaseURL = 'https://hr.iskconbangalore.net/v1/api';
    }

    /**
     * Get Trust List
     */
    public function getTrusts()
    {
        $client = new Client();
        // Get list of all trusts
        $url = $this->apiBaseURL . '/admin/get-trust-list';
        $request = $client->post($url, [
            'json' => [
                'accessKey' => $this->accessKey
            ],
            'http_errors' => false
        ]);
        $response = $request->getBody();
        $responseData = json_decode($response, true);
        return $responseData;
    }

    /**
     * Get Department List
     */
    public function getDepartments()
    {
        $client = new Client();
        // Get List of All Departments
        $url = $this->apiBaseURL . '/admin/get-dept-list';
        $request = $client->post($url, [
            'json' => [
                'accessKey' => $this->accessKey
            ],
            'http_errors' => false
        ]);
        $response = $request->getBody();
        $responseData = json_decode($response, true);
        return $responseData;
    }

    /**
     * Get Employee Names Filtered by Department
     */
    public function getEmployeeList($data)
    {
        $department = $data->department ?? "";

        $client = new Client();
        // Get Employee Names by Department
        $url = $this->apiBaseURL . '/admin/get-employee-info';
        $request = $client->post($url, [
            'json' => [
                'accessKey' => $this->accessKey,
                'departmentName' => $department
            ],
            'http_errors' => false
        ]);

        $response = $request->getBody();
        $responseData = json_decode($response, true);
        return $responseData;
    }
}
