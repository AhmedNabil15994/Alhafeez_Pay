<?php

namespace Modules\Transaction\Services;

use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TapPaymentService
{

    const API_KEY    = "sk_test_eoIW8Dm6XyTuUdk0qsf71cj9";
    // const API_KEY    = "sk_live_sjKcG27dHLW6XuJEZeUk3OtP";

    /**
     * @param $order
     * @return array|mixed
     */
    public function send($order,$type,$payment)
    {
        $fields = $this->getRequestFields($order,$type,$payment);

        $client = new Client();

        try {

            $res = $client->post('https://api.tap.company/v2/charges/', [

                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . self::API_KEY
                ],

                RequestOptions::JSON    => $fields
            ]);

            return json_decode($res->getBody(), true);

        } catch (\Exception $e) {

            return [
                'server_response' => 'error',
                'order_id'        => $order->id
            ];
        }

    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function getTransactionDetails($request)
    {
        $client = new Client();

        try {

            $res = $client->get('https://api.tap.company/v2/charges/' . $request->tap_id, [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . self::API_KEY
                ]
            ]);

            return json_decode($res->getBody(), true);

        } catch (\Exception $e) {

            return [
                'server_response' => 'error',
            ];

        }
    }

    /**
     * @param $order_id
     * @param $order
     * @return array
     */
    private function getRequestFields($order,$type,$payment)
    {
		$url = $this->paymentUrls($type);

		return [
            'amount'               => $order['total'],
            'currency'             => 'KWD',
            'threeDSecure'         => true,
            'save_card'            => false,
            'description'          => 'Order Fees',
            'statement_descriptor' => 'Sample',
            'receipt'              => [
                'email' => true,
                'sms'   => false
            ],
            'metadata' => [
  				'udf4' => $payment,
                'udf5' => $order->id,
            ],
            'customer' => [
                'first_name' => $order->email,
                'email'      => $order->email,
                'phone'      => [
                    'country_code' => '00',
                    'number'       => $order->mobile
                ]
            ],
            'source'               => ['id' => 'src_all'],
            'redirect'             => [
                'url' => $url['status'],
            ],
            'post'             => [
                'url' => $url['status'],
            ]
        ];
    }

	public function paymentUrls($type)
    {
        if ($type == 'orders')
	        $url['status'] = url(route('frontend.orders.status'));

		if ($type == 'api-order')
            $url['status'] = url(route('api.orders.status'));

		return $url;
    }
}
