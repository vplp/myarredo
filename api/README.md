API
=============

1. Add to Headers: `Authorization: 770000018E75BC14`

2. https://www.myarredo.ru/api/shop/order/accept/

3. https://www.myarredo.ru/api/shop/order/status/

4. curl -X POST \
     https://www.myarredo.ru/api/shop/order/accept \
     -H 'Authorization: 770000018E75BC14' \
     -H 'Content-Type: application/json' \
     -d '{"order": {
       "currency": "EUR",
       "paymentMethod": null,
       "delivery": {
         "price": null
       },
       "user": [
         {
          "id": 1865441,
          "phone": "+7 916 111-11-111",
          "email": "test@yandex.ru",
          "name": "test test"
         }
       ],
       "fake": true,
       "items": [
         {
           "count": 1,
           "price": 5498,
           "offerId": "47758",
           "offerName": "Консоль ZANABONI T 76/Con"
         }
       ],
       "notes": "test",
       "paymentType": "POSTPAID",
       "id": 123456
     }
   }'
