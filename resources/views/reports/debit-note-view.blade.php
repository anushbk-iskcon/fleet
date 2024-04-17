<div class="custom-border" style="border: 3px solid black;padding: 15px 0 100px 0;">
    <div class="row pl-3 pr-5" style="padding-left:10px;padding-right:10px;">
        <div class="col-md-12 text-center mb-5" style="text-align:center;margin-bottom:30px;">
            <p style="display: inline-block;border-bottom: 2px solid black;font-weight: 700;font-size:25px!important;margin-bottom: 0!important;">
                International Society for Krishna Consciousness</p>
            <p style="margin-bottom: 0;margin-top: 1px;font-weight: 500;font-size:13px!important;">
                Hare Krishna
                Hill, Chord Road, Rajaji Nagar, Bangalore
                -10</p>
            <span style="border-bottom: 1px solid black;font-weight: 700;font-size:14px!important;">Supplier
                Entity code:- FM 00</span>
        </div>
        <div class="col-md-6" style="width:100%;display:inline-block;">
            <p style="font-size:14px;">Date:- {{date('d-F-Y')}}</p>
        </div>
        <div class="col-md-6 text-right" style="width:100%;display:inline-block;text-align:right;">
            <p style="font-size:14px;">Interunit transfer No:- T pt/{{$data['displayMonthShortName'] . ' ' . $data['displayYear']}}</p>
        </div>
        <div class="col-md-6" style="width:100%;display:inline-block;">
            <p style="font-size:14px;">To,<br>
                <b>Entity:- {{$data['entityName']}}</b><br>
                Hare Krishna Hill, Bangalore- 10
            </p>
        </div>
        <div class="col-md-6 my-auto" style="width:100%;display:inline-block;text-align:right;">
            <p style="font-size:14px;">Entity Code:- {{$data['entityCode']}}</p>
        </div>
        <div class="col-md-12 mb-5 mt-5" style="text-align:left;padding-left:20px;padding-right:20px;">
            <h5 style="border-bottom:1px solid;display:inline-block;font-size:16px;font-weight:bold;">Sub:- Inter dept
                transfer for
                the month of {{$data['displayMonthFullName'] . ' '. $data['displayYear']}}</h5>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:center;">Sl
                            No</th>
                        <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:left;">
                            Details
                        </th>
                        <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:left;">UOM
                        </th>
                        <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">Qty
                        </th>
                        <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">
                            Rate</th>
                        <th style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">
                            Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['items'] as $line)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:center;">{{$line[0]}}</td>
                        <td style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:left;">{{$line[1]}}</td>
                        <td style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:left;">{{$line[2]}}</td>
                        <td style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">{{$line[3]}}</td>
                        <td style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">{{$line[4]}}</td>
                        <td style="border: 1px solid #ddd; padding: 4px;font-size:15px;text-align:right;">{{$line[5]}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 4px;text-align:center;">
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px;text-align:center;">
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px;text-align:center;">
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;" colspan="2"><b>Amount Debitable</b></td>
                        <td style="border: 1px solid #ddd; padding: 4px;text-align:right;font-size:14px;">
                            <b>{{$data['amountDebitable']}}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6" style="width:100%;display:inline-block;">
            <p style="font-size:14px;">
                Division Head<br>
                Supplier Dept
            </p>
        </div>
        <div class="col-md-6" style="width:100%;display:inline-block;text-align:right;">
            <p style="font-size:14px;">
                Division Head<br>
                User Dept
            </p>
        </div>
        <div class="col-md-12 text-center mb-5" style="text-align:center;margin-top:30px;padding-left:20px;padding-right:20px;">
            <span style="border-bottom: 1px solid black;font-weight: 700;font-size:14px!important;">Transfer
                Declaration</span>
            <p style="text-align:left;font-size:15px!important;">We acknowledge the receipt
                of the
                above mention
                materials and hereby request finance to transfer the sum of Rs. {{$data['amountDebitable']}}/-</p>
        </div>
    </div>
</div>