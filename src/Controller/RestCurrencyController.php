<?php

namespace App\Controller;

use App\Form\CurrencyExchangeRequestType;
use App\Util\CurrencyConverter;
use App\Util\CurrencyExchangeRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestCurrencyController extends Controller
{
    /**
     * @Route("/rest/currency", name="rest_currency", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, CurrencyConverter $currencyConverter)
    {
        $form = $this->createForm(CurrencyExchangeRequestType::class, null, ['method' => 'GET']);


        $form->handleRequest($request);
        $form->submit($request->query->all());
        if (!$form->isSubmitted()) {
            return $this->json([
                'success' => false,
                'error' => 'The request data must be submitted at first',
            ]);
        }

        if ($form->isValid()) {
            return $this->json([
                'success' => true,
                'result' => $currencyConverter->exchange($form->getData())
            ]);
        }

        return $this->json([
            'success' => false,
            'error' => 'One of provided fields contains invalid value',
        ]);
    }
}
