<?php
namespace Controllers;

use \Core\Controller;

use \Models\Company;

class PaymentController extends Controller {

    public function index()
    {
        $data = array();

		$data['titulo'] = 'Descomplica Zap';
		$data['menu'] = 'home';

        $this->loadView('payment/index', $data); 
    }

    public function pay_action()
    {
        \MercadoPago\SDK::setAccessToken("TEST-1243572144737678-030319-d8e7782ec928b425d5730900994fd2e2-57888185");
        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = (float)$_POST['transactionAmount'];
        $payment->token = $_POST['token'];
        $payment->description = $_POST['description'];
        $payment->installments = (int)$_POST['installments'];
        $payment->payment_method_id = $_POST['paymentMethodId'];
        // $payment->issuer_id = (int)$_POST['issuer'];

        $payer = new \MercadoPago\Payer();
        $payer->email = $_POST['email'];
        $payer->identification = array( 
            "type" => $_POST['docType'],
            "number" => $_POST['docNumber']
        );
        $payment->payer = $payer;

        $payment->save(); 

        $response = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );

        if($response['status'] === "approved") {
            $company = new Company();
            $company->updateSubscribe('ACTIVE', $_SESSION['company_register']);
        }

        header("Location: " .BASE_URL."/portal");
        exit;

        echo json_encode($response);
        exit;
    }
}