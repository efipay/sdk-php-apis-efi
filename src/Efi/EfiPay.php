<?php

namespace Efi;

/**
 * Class EfiPay
 * @package EfiPay
 * 
 * API COBRANÇAS
 * @method mixed createCharge(array $params = [], array $body)
 * @method mixed createOneStepCharge(array $params = [], array $body)
 * @method mixed oneStepPartner(array $params = [], array $body)
 * @method mixed detailCharge(array $params)
 * @method mixed listCharges(array $params)
 * @method mixed updateChargeMetadata(array $params, array $body)
 * @method mixed updateBillet(array $params, array $body)
 * @method mixed definePayMethod(array $params, array $body)
 * @method mixed definePayMethodPartner(array $params, array $body)
 * @method mixed cancelCharge(array $params)
 * @method mixed cardPaymentRetry(array $params, array $body)
 * @method mixed refundCard(array $params, array $body)
 * @method mixed createCarnet(array $params = [], array $body)
 * @method mixed detailCarnet(array $params)
 * @method mixed updateCarnetParcel(array $params, array $body)
 * @method mixed updateCarnetParcels(array $params, array $body)
 * @method mixed updateCarnetMetadata(array $params, array $body)
 * @method mixed getNotification(array $params)
 * @method mixed listPlans(array $params)
 * @method mixed createPlan(array $params = [], array $body)
 * @method mixed deletePlan(array $params)
 * @method mixed createSubscription(array $params, array $body)
 * @method mixed createOneStepSubscription(array $params, array $body)
 * @method mixed createOneStepSubscriptionLink(array $params, array $body)
 * @method mixed detailSubscription(array $params)
 * @method mixed defineSubscriptionPayMethod(array $params, array $body)
 * @method mixed cancelSubscription(array $params)
 * @method mixed updateSubscriptionMetadata(array $params, array $body)
 * @method mixed createSubscriptionHistory(array $params, array $body)
 * @method mixed sendSubscriptionLinkEmail(array $params, array $body)
 * @method mixed getInstallments(array $params)
 * @method mixed sendBilletEmail(array $params, array $body)
 * @method mixed createChargeHistory(array $params, array $body)
 * @method mixed sendCarnetEmail(array $params, array $body)
 * @method mixed sendCarnetParcelEmail(array $params, array $body)
 * @method mixed createCarnetHistory(array $params, array $body)
 * @method mixed cancelCarnet(array $params)
 * @method mixed cancelCarnetParcel(array $params)
 * @method mixed createOneStepLink(array $params = [], array $body)
 * @method mixed defineLinkPayMethod(array $params, array $body)
 * @method mixed updateChargeLink(array $params, array $body)
 * @method mixed sendLinkEmail(array $params, array $body)
 * @method mixed updatePlan(array $params, array $body)
 * @method mixed defineBalanceSheetBillet(array $params, array $body)
 * @method mixed settleCharge(array $params)
 * @method mixed settleCarnetParcel(array $params)
 * 
 * API PIX
 * @method mixed pixConfigWebhook(array $params, array $body)
 * @method mixed pixDetailWebhook(array $params)
 * @method mixed pixListWebhook(array $params)
 * @method mixed pixDeleteWebhook(array $params)
 * @method mixed pixResendWebhook(array $params = [], array $body)
 * @method mixed pixCreateCharge(array $params, array $body)
 * @method mixed pixCreateImmediateCharge(array $params = [], array $body)
 * @method mixed pixDetailCharge(array $params)
 * @method mixed pixUpdateCharge(array $params, array $body)
 * @method mixed pixListCharges(array $params)
 * @method mixed pixGenerateQRCode(array $params)
 * @method mixed pixDevolution(array $params, array $body)
 * @method mixed pixDetailDevolution(array $params)
 * @method mixed pixSend(array $params, array $body)
 * @method mixed pixSendSameOwnership(array $params, array $body)
 * @method mixed pixSendDetail(array $params)
 * @method mixed pixSendDetailId(array $params)
 * @method mixed pixSendList(array $params)
 * @method mixed pixDetail(array $params)
 * @method mixed pixReceivedList(array $params)
 * @method mixed pixDetailReceived(array $params)
 * @method mixed pixCreateLocation(array $params = [], array $body)
 * @method mixed pixLocationList(array $params)
 * @method mixed pixDetailLocation(array $params)
 * @method mixed pixUnlinkTxidLocation(array $params)
 * @method mixed pixCreateEvp()
 * @method mixed pixListEvp()
 * @method mixed pixDeleteEvp(array $params)
 * @method mixed getAccountBalance(array $params)
 * @method mixed updateAccountConfig(array $params = [], array $body)
 * @method mixed listAccountConfig()
 * @method mixed medList(array $params)
 * @method mixed medDefense(array $params, array $body)
 * @method mixed pixGetReceipt(array $params)
 * @method mixed pixKeysBucket()
 * @method mixed pixCreateDueCharge(array $params, array $body)
 * @method mixed pixUpdateDueCharge(array $params, array $body)
 * @method mixed pixDetailDueCharge(array $params)
 * @method mixed pixListDueCharges(array $params)
 * @method mixed createReport(array $params = [], array $body)
 * @method mixed detailReport(array $params)
 * @method mixed pixSplitDetailCharge(array $params)
 * @method mixed pixSplitLinkCharge(array $params)
 * @method mixed pixSplitUnlinkCharge(array $params)
 * @method mixed pixSplitDetailDueCharge(array $params)
 * @method mixed pixSplitLinkDueCharge(array $params)
 * @method mixed pixSplitUnlinkDueCharge(array $params)
 * @method mixed pixSplitConfig(array $params = [], array $body)
 * @method mixed pixSplitConfigId(array $params, array $body)
 * @method mixed pixSplitDetailConfig(array $params)
 * @method mixed pixCreateDueChargeBatch(array $params, array $body)
 * @method mixed pixUpdateDueChargeBatch(array $params, array $body)
 * @method mixed pixDetailDueChargeBatch(array $params)
 * @method mixed pixListDueChargeBatch(array $params)
 * @method mixed pixQrCodeDetail(array $params = [], array $body)
 * @method mixed pixQrCodePay(array $params, array $body)
 * @method mixed pixConfigWebhookRecurrenceAutomatic(array $params = [], array $body)
 * @method mixed pixListWebhookRecurrenceAutomatic()
 * @method mixed pixDeleteWebhookRecurrenceAutomatic()
 * @method mixed pixConfigWebhookAutomaticCharge(array $params = [], array $body)
 * @method mixed pixListWebhookAutomaticCharge()
 * @method mixed pixDeleteWebhookAutomaticCharge()
 * @method mixed pixCreateLocationRecurrenceAutomatic()
 * @method mixed pixListLocationRecurrenceAutomatic($params)
 * @method mixed pixDetailLocationRecurrenceAutomatic($params)
 * @method mixed pixUnlinkLocationRecurrenceAutomatic($params)
 * @method mixed pixDetailRecurrenceAutomatic($params)
 * @method mixed pixUpdateRecurrenceAutomatic($params, $body)
 * @method mixed pixListRecurrenceAutomatic($params, $body)
 * @method mixed pixCreateRecurrenceAutomatic($params = [], $body)
 * @method mixed pixCreateRequestRecurrenceAutomatic($params = [], $body)
 * @method mixed pixDetailRequestRecurrenceAutomatic($params)
 * @method mixed pixUpdateRequestRecurrenceAutomatic($params, $body)
 * @method mixed pixCreateAutomaticChargeTxid($params, $body)
 * @method mixed pixUpdateAutomaticCharge($params, $body)
 * @method mixed pixDetailAutomaticCharge($params)
 * @method mixed pixCreateAutomaticCharge($params = [], $body)
 * @method mixed pixListAutomaticCharge($params)
 * @method mixed pixRetryRequestAutomatic($params)
 * 
 * API OPEN FINANCE
 * @method mixed ofConfigUpdate(array $params = [], array $body)
 * @method mixed ofConfigDetail()
 * @method mixed ofListParticipants(array $params)
 * @method mixed ofStartPixPayment(array $params = [], array $body)
 * @method mixed ofDevolutionPix(array $params, array $body)
 * @method mixed ofListPixPayment(array $params)
 * @method mixed ofCancelSchedulePix(array $params)
 * @method mixed ofListSchedulePixPayment(array $params)
 * @method mixed ofStartSchedulePixPayment(array $params = [], array $body)
 * @method mixed ofDevolutionSchedulePix(array $params, array $body)
 * @method mixed ofStartRecurrencyPixPayment(array $params = [], array $body)
 * @method mixed ofListRecurrencyPixPayment(array $params)
 * @method mixed ofCancelRecurrencyPix(array $params, array $body)
 * @method mixed ofDevolutionRecurrencyPix(array $params, array $body)
 * @method mixed ofCreateBiometricEnrollment(array $params = [], array $body)
 * @method mixed ofListBiometricEnrollment(array $params)
 * @method mixed ofCreateBiometricPixPayment(array $params = [], array $body)
 * @method mixed ofListBiometricPixPayment(array $params)
 * @method mixed ofRevokeBiometricEnrollment(array $params = [], array $body)
 * @method mixed ofCreateAutomaticEnrollment(array $params = [], array $body)
 * @method mixed ofListAutomaticEnrollment(array $params)
 * @method mixed ofUpdateAutomaticEnrollment(array $params = [], array $body)
 * @method mixed ofCreateAutomaticPixPayment(array $params = [], array $body)
 * @method mixed ofListAutomaticPixPayment(array $params)
 * @method mixed ofCancelAutomaticPixPayment(array $params)
 * 
 * API PAYMENTS
 * @method mixed payDetailBarCode(array $params)
 * @method mixed payRequestBarCode(array $params, array $body)
 * @method mixed payDetailPayment(array $params)
 * @method mixed payListPayments(array $params)
 * @method mixed payConfigWebhook(array $params = [], array $body)
 * @method mixed payDeleteWebhook(array $params = [], array $body)
 * @method mixed payListWebhook(array $params)
 * 
 * API ABERTURA DE CONTAS
 * @method mixed createAccount(array $params = [], array $body)
 * @method mixed createAccountCertificate(array $params)
 * @method mixed getAccountCredentials(array $params)
 * @method mixed accountConfigWebhook(array $params = [], array $body)
 * @method mixed accountDeleteWebhook(array $params)
 * @method mixed accountDetailWebhook(array $params)
 * @method mixed accountListWebhook(array $params)
 * 
 * API EXTRATOS
 * @method mixed listStatementFiles()
 * @method mixed getStatementFile(array $params)
 * @method mixed listStatementRecurrences()
 * @method mixed createStatementRecurrency(array $params = [], array $body)
 * @method mixed updateStatementRecurrency(array $params, array $body)
 * @method mixed createSftpKey()
 */

class EfiPay extends Endpoints
{
    /**
     * Constructor of the EfiPay.
     *
     * @param array $options               Array with configuration options and credentials.
     * @param mixed|null $requester       mixed with request settings.
     * @param string|null $endpointsConfigFile   Endpoint list file name.
     */
    public function __construct(array $options, ?object $requester = null, ?string $endpointsConfigFile = null)
    {
        if ($endpointsConfigFile) {
            Config::setEndpointsConfigFile($endpointsConfigFile);
        }

        // If $options is an instance of Endpoints, use it directly.
        if ($options instanceof Endpoints) {
            parent::__construct([], $requester);
            $this->setEndpoints($options->getEndpoints());
        } else {
            parent::__construct($options, $requester);
        }
    }
}
