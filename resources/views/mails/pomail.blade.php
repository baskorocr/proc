@component('mail::message')
Subject : Purchase Order from PT Dharma Polimetal {{$po['created_at']}} NO REPLY

# Dear {{$user['nm_user']}}

You have new puchase order.

Our Purchase Order document now available online, just download it. 

Download link will be temporary and active for 3 months from the document date. 

Visit our website on the link below the list to get our Purchase Order(s), here's the list :

Purchase Order from PT. DHARMA POLIMETAL

@component('mail::table')
| No       | PO Number         | Rev  | Plant | Doc Date | File | Vendor Name | PGr | Total Amount with Tax | Curr
| ------------- |:-------------:|:-----------:|:-----------:|:----------:|:-------------:|:-----------:|:---------:|:---------:|--------:|
| 1      | {{$po['po_num']}}      | {{$po['revno']}}   | {{$po['plant']}}    | {{$po['doc_date']}}     | {{$po['file_name']}}   | {{$user['username']}}   | {{$po['pgr']}}    | {{$po['tot_val']}}  | {{$po['curr']}}  |
@endcomponent

Use your user access to login. If you can't, please contact our adminstrator to activate your account.

This message is sent by system, please don't reply.

Thanks,

Best regards,

eProc Center<br>
Procurement Division<br>
PT. Dharma Polimetal<br>
Kawasan Delta Silikon 1, Jalan Angsana Raya Blok A9 No 8<br>
Lippo Cikarang, 17550<br>
Tlp. : (021) 8974559<br>
Ext. : 811/812<br>
Email : eproc.center@dac.dharmap.com<br>
Web : http://eproc.dharmap.com:7777/
@endcomponent