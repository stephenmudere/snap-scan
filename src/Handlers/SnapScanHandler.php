<?php namespace Stephenmudere\SnapScan\Handlers;

class SnapScanHandler
{
    protected $requestHandler;
    protected $merchant;

    /**
     * SnapScanHandler constructor.
     * @param $requestHandler
     */
    public function __construct(RequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
        $this->merchant = config('snap_scan.merchant_code');
    }

    public function generateUrl($json_ret)
    {
        return $this->requestHandler->doRequest('GET','/qr/' . $this->merchant . '.png', [], $json_ret);
    }

    /**
     * @param $data
     * @param $json_ret
     * [
     *    snapCode => ''
     *    id => ''
     *    amount => ''
     *    strict => true - To prevent customer from successfully paying same twice or editing the amount
     * ]
     *
     * @return String
     */
    public function generateQRCodeImage($data, $json_ret)
    {
        return $this->requestHandler->doRequest('GET','/qr/' . $this->merchant . '.png', [$data], $json_ret);
    }
    
    public function fetchAllPayments($json_ret)
    {
        return $this->requestHandler->doRequest('GET','/merchant/api/v1/payments', [], $json_ret);
    }
    
    public function fetchSinglePayment($payment_id, $json_ret)
    {
        return $this->requestHandler->doRequest('GET', '/merchant/api/v1/payments/' . $payment_id, [], $json_ret);
    }
    
    public function fetchAllCashPayments($reference, $json_ret)
    {
        return $this->requestHandler->doRequest('GET', '/merchant/api/v1/payments/cash_ups/' . $reference, [], $json_ret);
    }
}