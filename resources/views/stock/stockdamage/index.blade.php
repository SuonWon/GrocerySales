<x-layout title="stock damage">
    <h1>Hello Stock Damage</h1>

    <button class="btn btn-sm btn-primary" onclick="postdata()">post data</button>
    
    <script type="text/javascript">

        function postdata(){
            let data = {};
            let stockdamageDetailsArr = [];

            let stockdamageDetailsObject = {
                    LineNo: 0,
                    ItemCode: "SI-0001",
                    Quantity: "100",
                    PackedUnit: "kg",
                    QtyPerUnit: "20",
                    TotalViss: "50",
                    UnitPrice: "10000",
                    Amount: "1000000",
                    
            }

            stockdamageDetailsArr.push(stockdamageDetailsObject);

            data.DamageDate = '2023-08-11';
            data.WarehouseNo = "WH-0001";
            data.Remark = "hello";
            data.Status = "O";

            

            data.stockdamagedetails = stockdamageDetailsArr;

            data = JSON.stringify(data);

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            $.ajax({
            url: '/stockdamage/add',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {

                console.log(response);

                if (response.message == "good") {

                    console.log(response.message);
                    
                }

            },
            error: function(error) {
                console.log('no');
                console.log(error.responseText);
                res = JSON.parse(error.responseText);
                console.log(res);
            }
        });

        }
    </script>
</x-layout>