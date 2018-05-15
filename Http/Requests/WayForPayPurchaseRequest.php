<?php

namespace EFrame\Payment\Http\Requests;

use EFrame\Foundation\Http\FormRequest;
use EFrame\Payment\Validation\Rules\WayForPayMerchantSignature;

/**
 * Class WayForPayPurchaseRequest
 * @package EFrame\Payment\Http\Requests
 */
class WayForPayPurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the sanitation rules for this form request.
     *
     * @return array
     */
    public function sanitize()
    {
        return [
            'merchantAccount'   => 'trim',
            'orderReference'    => 'trim',
            'merchantSignature' => 'trim',
            'currency'          => 'trim',
            'email'             => 'trim',
            'phone'             => 'trim',
            'cardPan'           => 'trim',
            'cardType'          => 'trim',
            'issuerBankCountry' => 'trim',
            'issuerBankName'    => 'trim',
            'recToken'          => 'trim',
            'transactionStatus' => 'trim',
            'reason'            => 'trim',
            'paymentSystem'     => 'trim',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'merchantAccount'   => 'required|string',
            'orderReference'    => 'required|string|exists:orders,id',
            'merchantSignature' => [
                'required',
                'string',
                new WayForPayMerchantSignature($this->all())
            ],
            'amount'            => 'required|numeric',
            'currency'          => 'required|string',
            'authCode'          => 'required|integer',
            'email'             => 'required|email',
            'phone'             => 'required|regex:/^\+?[\d]{12}$/',
            'createdDate'       => 'required|date_format:U',
            'processingDate'    => 'required|date_format:U',
            'cardPan'           => 'required|string',
            'cardType'          => 'required|string',
            'issuerBankCountry' => 'required|string',
            'issuerBankName'    => 'required|string',
            'recToken'          => 'required|string',
            'transactionStatus' => 'required|string',
            'reason'            => 'required|string',
            'reasonCode'        => 'required|integer|in:1100',
            'fee'               => 'required|numeric',
            'paymentSystem'     => 'required|string',
        ];
    }
}