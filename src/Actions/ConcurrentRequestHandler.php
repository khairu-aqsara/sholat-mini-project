<?php

namespace Khairu\Sholat\Actions;

use CurlMultiHandle;

class ConcurrentRequestHandler
{
    private array $requests = [];
    private array $responses = [];

    /**
     * Add a request to the handler.
     * @param string $url The URL for the request.
     * @param callable $callback The callback function to handle the response.
     */
    public function addRequest(string $url, callable $callback): void
    {
        $this->requests[] = [
            'url' => $url,
            'callback' => $callback,
        ];
    }

    /**
     * Execute the requests concurrently and handle responses.
     */
    public function execute(): void
    {
        // Initialize curl multi handler
        $mh = curl_multi_init();

        // Initialize array to store curl handles
        $handles = [];

        foreach ($this->requests as $request) {
            $ch = curl_init($request['url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $ch);
            $handles[] = $ch;
        }

        // Execute the multi handle
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        // Handle responses
        foreach ($handles as $index => $ch) {
            $response = curl_multi_getcontent($ch);
            $callback = $this->requests[$index]['callback'];
            if (is_callable($callback)) {
                call_user_func($callback, $response);
            }
            curl_multi_remove_handle($mh, $ch);
        }

        curl_multi_close($mh);
    }
}
