<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="../crmHTMLS/refundForm.css">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
    </head>

    <body>
    @php
    $current = $data['current'];
@endphp
        

        <div class="offset-1 col-md-10">

            <div class="mt-4 mb-4">

                <u><b>{{ $current->nm_customer->name }}</b></u>&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                <b>Reg No. &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; {{ $current->product->code }}</b>

            </div>

            <div class="mt-4 mb-4">

                <u><b>{{ $current->nm_customer->cnic_no }}</b></u>&nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;
                &nbsp;
                <b>Form No. &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;{{$current->code}}</b>

            </div>

            <div class="mt-4 mb-4">

                <u><b>House. No. 28 Spring Block</b></u>&nbsp; &nbsp; &nbsp;
                &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                &nbsp;
                <b>Plot/Unit/Villa:  &nbsp;&nbsp;&nbsp;{{ $current->product->external_item_id }}</b>

            </div>

            <div class="mt-4 mb-4">

                <u><b>Bahria Town Lahore</b></u>&nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp;&nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                <b>Size: &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;3 Marla</b>

            </div>
            <div class="text-center">
                <h5><u><b>Subject: Transfer Intimation Letter- Palm Villas (Pvt)
                            Ltd.
                            Lahore.</b></u></h5>
            </div>

            <p>Dear Member,</p>
           <p> <b>1. </b> Above property was transferred by {{ $current->om_customer->name }} S/D/W {{ $current->om_customer->father_name }},
                having CNIC {{ $current->om_customer->cnic_no }} In your name and the Palm Villas
                (Pvt)
                Ltd. Management has approved the transfer on 29-April-23.</p>

            <p> <b>2. </b> Amendment is made in the record of Palm Villas (Pvt) LTD. Based
                on
                the request of {{ $current->om_customer->name }} S/D/W {{ $current->om_customer->father_name }} after fulfilling
                all
                necessary requirements.</p>

            <p> <b>3. </b> Palm Villas (Pvt) LTD. reserves the rights to make adjustments
                and
                relocate the plot, if need arises due to site constraints or
                change
                in town planning.</p>

            <p> <b>4. </b> The transferee agrees to pay development charges as and when
                demanded
                by the Authority on account of any additional
                development/upgradation of services or infrastructure.</p>

            <p> <b>5. </b> Security & Maintenance charges as prescribed by Palm Villas (Pvt)
                LTD. will be levied per month with effect from the date of
                transfer.</p>

            <p><b>Note: </b> Any discrepancy in papers of payment of dues, installments
                and
                additional charges etc., subsequently notices by Palm Villas
                Lahore
                administration shall be made good by the transferee or his / her
                heir(s).</p>

            <p>Assuring you the best service and co-operation.</p>

            <p>Regards,</p>
            <h4>Manager Transfer</h4>
        </div>

    </body>
</html>