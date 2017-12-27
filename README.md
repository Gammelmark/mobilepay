# MobilePay
- **7th July** 
    - Initial Luxplus implementation of MobilePay Subscription API 1.1.1.

- **10th August:** 
    - Implementation of MobilePay Subscription API 1.2.6 - Refunds. 2 new methods: getRefunds() and postRefunds().

- **11th August:** 
    - Fixed bug in path from _/recurringpayments-restapi/api/_ to _/subscriptions/api/_ for Refunds.

- **14th August:** 
    - Fixed bug in the CreateRefundRequest toJSON() method.
    - Implemented links-parameter in CreateOnOffPaymentRequest.
    
- **23rd August:**
    - Changed path from _/recurringpayments-restapi/api/_ to _/subscriptions/api/_ across the board.

- **18th September:**
    - Updated MobilePay Subscription API to use 2.0.0
    - Implemented postPaymentRequestsBatch() method, which takes an array of CreatePaymentRequest instances.
    - Changed the postPaymentRequests() method to accept an instance of CreatePaymentRequest OR an array of CreatePaymentRequest (it calls postPaymentRequestsBatch() regardless).
    - Removed the abstract method toJSON() in the abstract class Request and replaced it with the JsonSerializable interface. The jsonSerialize() method returns an array instead of a json encoded string. 
    - Added the following exception classes: 
        - MobilePayException extends Exception
        - PreconditionFailedException extends MobilePayException
        - NotFoundException extends MobilePayException
        - InternalServerErrorException extends MobilePayException
        - IdNotProvidedException extends MobilePayException
        - BadRequestException extends MobilePayException
        - CurlException Extends Exception
    - Rewrote the error handling code with proper exceptions and error messages in the MobilePayConnection class connect() method and a few other places.
    - Added ErrorResponse class to better handle the HTTP code response errors.
    - Added possibility to supply correlation id with a call.
    - Added a createGUID() method in MobilePaySubscriptionClient to use for the correlation id.
    
- **27th December:**
    - Fixed bug in MobilePayConnection post()-method introduced in the update from the 18th September. Introduced by postPaymentRequestsBatch.