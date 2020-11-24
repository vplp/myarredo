API
=============

1. Add to Headers: `Authorization: 770000018E75BC14`

2. https://www.myarredo.ru/api/shop/order/accept/

3. https://www.myarredo.ru/api/shop/order/status/

4. curl -X POST \
     http://www.myarredo.test/api/shop/order/accept \
     -H 'Authorization: Token' \
     -H 'Content-Type: application/json' \
     -d '{"order": {
       "currency": "RUB",
       "paymentMethod": null,
       "delivery": {
         "price": 123
       },
       "fake": true,
       "items": [
         {
           "count": 1,
           "price": 1,
           "offerId": "123456",
           "offerName": "offer name"
         }
       ],
       "notes": "hello",
       "paymentType": "POSTPAID",
       "id": 123456
     }
   }'
