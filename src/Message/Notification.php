<?php

namespace Omnipay\GPNDataEurope\Message;

use \SimpleXMLElement;
use \Omnipay\GPNDataEurope\Response\Data;


class Notification
{
    public Data $data;
    
    public function __construct(public SimpleXMLElement $xmlData)
    {
        if (!$xmlData instanceof SimpleXMLElement) {
            throw new InvalidResponseException();
        }

        $this->data = new Data();
        $this->bindData();
    }

    /**
     * Bind data in the Response data object
     *
     * @param $data
     */
    public function bindData()
    {
        $message = !empty($this->xmlData->errormessage) ? (string)$this->xmlData->errormessage : (string)$this->xmlData->description;

        if ($this->xmlData->getName() !== 'transaction') {
            throw new \Exception('Unknown notification');
        }

        $this->data
            ->setIsSuccess(
                Response::SUCCESS == $this->xmlData->status ||
                Response::AUTHORIZED == $this->xmlData->status ||
                Response::CANCELED == $this->xmlData->status ||
                Response::PENDING == $this->xmlData->status ||
                Response::OK == $this->xmlData->status ||
                Response::REQUEST_PENDING == $this->xmlData->status
            )
            ->setStatus((string)$this->xmlData->status)
            ->setStatusCode((string)($this->xmlData->errorcode ?: $this->xmlData->statuscode))
            ->setMessage($message)
            ->setRefer((integer)($this->xmlData->transref ?: null))
            ->setTransId((string)($this->xmlData->gatetransid ?: null))
            ->setMerchantTransId((string)($this->xmlData->merchanttransid ?: null));
    }
    
}
